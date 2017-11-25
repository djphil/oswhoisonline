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
    $my_uuid = $_SESSION['useruuid'];
    $my_visibility = get_visibility($db, $tbmodu, $my_uuid);
    $my_friends_only = get_friends_only($db, $tbmodu, $my_uuid);

    if ($my_visibility == "" || $my_friends_only == "")
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
        $tp_hide = FALSE;
        if ($tp_local === FALSE && $tp_hg === FALSE && $tp_hgv3 === FALSE && $tp_hop === FALSE) {$tp_hide = TRUE;}
        $options = array($region_name, $last_seen, $tp_local, $tp_hg, $tp_hgv3, $tp_hop, $tp_hide);

        echo '<div class="table-responsive">';
        echo '<table class="table table-hover">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>#</th>';
        echo '<th>Avatar</th>';
        if ($region_name === TRUE) echo '<th>Region</th>';
        if ($last_seen === TRUE) echo '<th>Last Seen</th>';
        if ($tp_hide === FALSE) echo '<th class="text-right">Teleports</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        $i = 0;

        while ($row = $query->fetch(PDO::FETCH_ASSOC))
        {
            ++$i;

            $UserID = $row['UserID'];
            $RegionID = $row['RegionID'];
            $LastSeen = $row['LastSeen'];

            $user_visibility = get_visibility($db, $tbmodu, $UserID);
            $user_friends_only = get_friends_only($db, $tbmodu, $UserID);

            // FOR ME ONLY
            if ($UserID == $my_uuid)
            {
                if ($my_visibility == "yes")
                {
                    $regionName = get_region_name($db, $RegionID);
                    $username = get_user_name($db, $UserID);

                    get_this_user($i, $username, $LastSeen, $regionName, $robustHOST, $robustPORT, $options);
                }
            }

            // FOR ALL OTHERS
            else
            {
                $user_visibility = get_visibility($db, $tbmodu, $UserID);
                $user_friends_only = get_friends_only($db, $tbmodu, $UserID);
                $regionName = get_region_name($db, $RegionID);
                $username = get_user_name($db, $UserID);

                if ($user_visibility == "yes")
                {
                    if ($user_friends_only == "yes")
                    {
                        if (is_friends($db, $tbmodu, $UserID))
                        {
                           get_this_user($i, $username, $LastSeen, $regionName, $robustHOST, $robustPORT, $options);
                        }
                    }

                    else
                    {
                        get_this_user($i, $username, $LastSeen, $regionName, $robustHOST, $robustPORT, $options);
                    }
                }

                else if (in_array($my_uuid, $admins))
                {
                    get_this_user($i, $username, $LastSeen, $regionName, $robustHOST, $robustPORT, $options);
                }
            }
        }

        echo '</tbody>';
        echo '</table>';
        echo '</div>';
    }

    else
    {
        echo '<div class="alert alert-info"><span class="badge">0</span> avatar online at this time ...';
        echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
        echo '</div>';
    }

    unset($my_uuid);
    unset($my_visibility);
    unset($my_friends_only);
    unset($user_visibility);
    unset($user_friends_only);  
    unset($counter);
    $query = null;
    $db = null;
}
?>
