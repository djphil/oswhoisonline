<?php if (isset($_SESSION['valid'])): ?>
    <h1>Home<i class="glyphicon glyphicon-home pull-right"></i></h1>
<?php endif; ?>

<!-- Fash Message -->
<?php if(isset($_SESSION['flash'])): ?>
    <?php foreach($_SESSION['flash'] as $type => $message): ?>
        <div class="alert alert-<?php echo $type; ?> alert-anim">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <?php echo $message; ?>
        </div>
    <?php endforeach; ?>
    <?php unset($_SESSION['flash']); ?>
<?php endif; ?>

<?php
if (isset($_POST['search']))
{
    echo '<div class="alert alert-success alert-anim">Search engine is disabled on this website ...';
    echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
    echo '</div>';
}
?>

<!-- Login Form -->
<?php if (!isset($_SESSION['valid'])): ?>
<form class="form-signin" role="form" action="?login" method="post" >
<h2 class="form-signin-heading">Please login</h2>
    <label for="username" class="sr-only">User name</label>
    <input type="text" name="username" class="form-control" placeholder="Username" required autofocus>
    <label for="password" class="sr-only">Password</label>
    <input type="password" name="password" class="form-control" placeholder="Password" required>
    <div class="checkbox">
        <label>
            <input type="checkbox" value="remember-me"> Remember me
        </label>
    </div>        
    <button class="btn btn-lg btn-primary btn-block" type="submit" name="login">
        <i class="glyphicon glyphicon-log-in"></i> Log-in
    </button>
</form>
<?php endif; ?>

<?php
if (isset($_SESSION['valid']))
{
    $user_uuid = $_SESSION['useruuid'];
    $visible = get_visibility($db, $tbmodu, $user_uuid);
    $friends_only = get_friends_only($db, $tbmodu, $user_uuid);
    unset($user_uuid);

    if ($visible == "" || $friends_only == "")
    {
        echo '<div class="alert alert-info alert-">';
        echo '<i class="glyphicon glyphicon-info-sign"></i> ';
        echo 'Set your user settings <a class="" href="./?settings"><strong>here</strong></a> please ...';
        echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
        echo '</div>';
    }

    $query = $db->prepare("
        SELECT *
        FROM ".$tbname." 
    ");

    $query->execute();
    $counter = $query->rowCount();

    if ($counter > 0)
    {
        echo '<div class="table-responsive">';
        echo '<table class="table table-hover">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>#</th>';
        echo '<th>Avatar</th>';
        echo '<th>Region</th>';
        echo '<th>Last Seen</th>';
        echo '<th class="text-right">Teleports</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        $i = 0;

        while ($row = $query->fetch(PDO::FETCH_ASSOC))
        {
            $UserID = $row['UserID'];
            $RegionID = $row['RegionID'];
            $LastSeen = $row['LastSeen'];

            $visibility = get_visibility($db, $tbmodu, $UserID);

            if ($visibility == "yes") // return;
            {
                $orderby = 'regionName';
                
                $sql = $db->prepare("
                    SELECT regionName
                    FROM regions
                    WHERE uuid = '".$RegionID."'
                    ORDER BY regionName
                ");

                $sql->execute();
                $counter = $sql->rowCount();

                while ($region = $sql->fetch(PDO::FETCH_ASSOC))
                {
                    $regionName = $region['regionName'];
                }

                $sql = $db->prepare("
                    SELECT FirstName, LastName
                    FROM useraccounts
                    WHERE PrincipalID = '".$UserID."'
                ");

                $sql->execute();           
                $counter = $sql->rowCount();

                if ($counter > 0)
                {
                    while ($rows = $sql->fetch(PDO::FETCH_ASSOC))
                    {
                        $firstname = $rows['FirstName'];
                        $lastname = $rows['LastName'];

                        if (!empty($firstname) && !empty($lastname))
                        $username = $firstname.' '.$lastname;
                        else $username = 'Username Missing';

                        if ($friends_only == "yes" && is_friends($db, $tbmodu, $UserID) <> 0)
                        {
                            echo '<tr>';
                            echo '<td><span class="badge">'.++$i.'</span></td>';
                            echo '<td><span class="glyphicon glyphicon-user"></span> '.$username.'</td>';
                            echo '<td>'.$regionName.'</td>';
                            echo '<td>'.$LastSeen.'</td>';
                            echo '<td class="text-right">';
                            echo '<a class="btn btn-primary btn-xs" href="secondlife://'.$regionName.'/128/128/128">';
                            echo '<i class="glyphicon glyphicon-plane"></i> Local</a> ';
                            echo '<a class="btn btn-info btn-xs" href="secondlife://'.$robustHOST.':'.$robustPORT.'/'.$regionName.'/128/128/128">';
                            echo '<i class="glyphicon glyphicon-plane"></i> HG</a> ';
                            echo '<a class="btn btn-warning btn-xs" href="secondlife://http|!!'.$robustHOST.'|'.$robustPORT.'+'.$regionName.'">';
                            echo '<i class="glyphicon glyphicon-plane"></i> HG V3</a> ';
                            echo '<a class="btn btn-danger btn-xs" href="hop://'.$robustHOST.':'.$robustPORT.'/'.$regionName.'/128/128/128">';
                            echo '<i class="glyphicon glyphicon-plane"></i> Hop</a> ';
                            echo '</td>';
                            echo '</tr>';
                        }

                        else if ($friends_only == "no" && in_array($_SESSION['useruuid'], $admins))
                        {
                            echo '<tr>';
                            echo '<td><span class="badge">'.++$i.'</span></td>';
                            echo '<td><span class="glyphicon glyphicon-user"></span> '.$username.'</td>';
                            echo '<td>'.$regionName.'</td>';
                            echo '<td>'.$LastSeen.'</td>';
                            echo '<td class="text-right">';
                            echo '<a class="btn btn-primary btn-xs" href="secondlife://'.$regionName.'/128/128/128">';
                            echo '<i class="glyphicon glyphicon-plane"></i> Local</a> ';
                            echo '<a class="btn btn-info btn-xs" href="secondlife://'.$robustHOST.':'.$robustPORT.'/'.$regionName.'/128/128/128">';
                            echo '<i class="glyphicon glyphicon-plane"></i> HG</a> ';
                            echo '<a class="btn btn-warning btn-xs" href="secondlife://http|!!'.$robustHOST.'|'.$robustPORT.'+'.$regionName.'">';
                            echo '<i class="glyphicon glyphicon-plane"></i> HG V3</a> ';
                            echo '<a class="btn btn-danger btn-xs" href="hop://'.$robustHOST.':'.$robustPORT.'/'.$regionName.'/128/128/128">';
                            echo '<i class="glyphicon glyphicon-plane"></i> Hop</a> ';
                            echo '</td>';
                            echo '</tr>';
                        }
                    }

                    unset($folderName);
                    unset($folderID);
                    unset($parentFolderID);
                }

                else
                {
                    echo '<div class="alert alert-danger alert-anim">Username no found ...';
                    echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
                    echo '</div>';
                }
            }
        }

        echo '</tbody>';
        echo '</table>';
        echo '</div>';

        $sql = null;
    }

    else
    {
        echo '<div class="alert alert-info"><span class="badge">0</span> avatar online at this time ...';
        echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
        echo '</div>';
    }

    $query = null;
    unset($counter);
}
?>