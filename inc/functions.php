<?php
function debug($variable)
{
    echo '<pre>' . print_r($variable, true) . '</pre>';
}

/* VISIBILITY */
function get_visibility($db, $tbmodu, $user_uuid)
{
    $query = $db->prepare("
        SELECT * 
        FROM $tbmodu 
        WHERE user_uuid = ?
    ");

    $query->bindValue(1, $user_uuid, PDO::PARAM_STR);
    $query->execute();

    $row = $query->fetch(PDO::FETCH_NUM);
    return $row[1];
}

function set_visibility($db, $tbmodu, $user_uuid, $visible)
{
    $query = $db->prepare("
        SELECT * 
        FROM $tbmodu 
        WHERE user_uuid = ?
    ");

    $query->bindValue(1, $user_uuid, PDO::PARAM_STR);
    $query->execute();

    $counter = $query->rowCount();

    // INSERT
    if ($counter == 0)
    {
        try {
            $sql = $db->prepare("
                INSERT INTO $tbmodu (user_uuid, visible)
                VALUES (:user_uuid, :visible)
            ");

            $sql->bindValue(':user_uuid', $user_uuid, PDO::PARAM_STR);
            $sql->bindValue(':visible', $visible, PDO::PARAM_INT);

            $sql->execute();
            $sql->closeCursor();
            $db = NULL;
        }

        catch(PDOException $e) {
            $message = '
                <pre>
                    Unable to query database ...
                    Error code: '.$e->getCode().'
                    Error file: '.$e->getFile().'
                    Error line: '.$e->getLine().'
                    Error data: '.$e->getMessage().'
                </pre>
            ';
            die($message);
        }

        $_SESSION['flash']['success'] = "Visibility saved succefully ...";
    }

    // UPDATE
    else if ($counter == 1)
    {
        try {
            $sql = $db->prepare("
                UPDATE $tbmodu
                SET visible = :visible
                WHERE user_uuid = :user_uuid
            ");

            $sql->bindValue(':user_uuid', $user_uuid, PDO::PARAM_STR);
            $sql->bindValue(':visible', $visible, PDO::PARAM_INT);

            $sql->execute();
            $sql->closeCursor();
            $db = NULL;
        }

        catch(PDOException $e) {
            $message = '
                <pre>
                    Unable to query database ...
                    Error code: '.$e->getCode().'
                    Error file: '.$e->getFile().'
                    Error line: '.$e->getLine().'
                    Error data: '.$e->getMessage().'
                </pre>
            ';
            die($message);
        }

        $_SESSION['flash']['success'] = "Visibility updated succefully ...";
    }

    else {$_SESSION['flash']['success'] = "Visibility error for user uuid ".$user_uuid." ...";}

    unset($counter);
    $sql = NULL;
    $db = NULL;
}

/* FRIENDS ONLY */
function get_friends_only($db, $tbmodu, $user_uuid)
{
    $query = $db->prepare("
        SELECT * 
        FROM $tbmodu 
        WHERE user_uuid = ?
    ");

    $query->bindValue(1, $user_uuid, PDO::PARAM_STR);
    $query->execute();

    $row = $query->fetch(PDO::FETCH_NUM);
    return $row[2];
}

function set_friends_only($db, $tbmodu, $user_uuid, $friends_only)
{
    $query = $db->prepare("
        SELECT * 
        FROM $tbmodu 
        WHERE user_uuid = ?
    ");

    $query->bindValue(1, $user_uuid, PDO::PARAM_STR);
    $query->execute();

    $counter = $query->rowCount();

    // INSERT
    if ($counter == 0)
    {
        try {
            $sql = $db->prepare("
                INSERT INTO $tbmodu (user_uuid, friends)
                VALUES (:user_uuid, :friends_only)
            ");

            $sql->bindValue(':user_uuid', $user_uuid, PDO::PARAM_STR);
            $sql->bindValue(':friends_only', $friends_only, PDO::PARAM_STR);

            $sql->execute();
            $sql->closeCursor();
            $db = NULL;
        }

        catch(PDOException $e) {
            $message = '
                <pre>
                    Unable to query database ...
                    Error code: '.$e->getCode().'
                    Error file: '.$e->getFile().'
                    Error line: '.$e->getLine().'
                    Error data: '.$e->getMessage().'
                </pre>
            ';
            die($message);
        }

        $_SESSION['flash']['success'] = "Friends only saved succefully ...";
    }

    // UPDATE
    else if ($counter == 1)
    {
        try {
            $sql = $db->prepare("
                UPDATE $tbmodu
                SET friends = :friends_only
                WHERE user_uuid = :user_uuid
            ");

            $sql->bindValue(':user_uuid', $user_uuid, PDO::PARAM_STR);
            $sql->bindValue(':friends_only', $friends_only, PDO::PARAM_STR);

            $sql->execute();
            $sql->closeCursor();
            $db = NULL;
        }

        catch(PDOException $e) {
            $message = '
                <pre>
                    Unable to query database ...
                    Error code: '.$e->getCode().'
                    Error file: '.$e->getFile().'
                    Error line: '.$e->getLine().'
                    Error data: '.$e->getMessage().'
                </pre>
            ';
            die($message);
        }

        $_SESSION['flash']['success'] = "Friends only updated succefully ...";
    }

    else {$_SESSION['flash']['success'] = "Friends only error for user uuid ".$user_uuid." ...";}

    unset($counter);
    $query->closeCursor();
    $sql->closeCursor();
    $db = NULL;
}

function is_friends($db, $tbmodu, $user_uuid)
{
    $query = $db->prepare("
        SELECT * 
        FROM friends 
        WHERE PrincipalID = ?
        AND Friend = ?
        AND Offered = 0
    ");

    $query->bindValue(1, $user_uuid , PDO::PARAM_STR);
    $query->bindValue(2, $_SESSION['useruuid'] , PDO::PARAM_STR);
    $query->execute();

    $counter = $query->rowCount();

    if ($counter > 0)
    {
        $query = $db->prepare("
            SELECT * 
            FROM $tbmodu 
            WHERE user_uuid = ?
            AND visible = ?
            AND friends = ?
        ");

        $query->bindValue(1, $user_uuid, PDO::PARAM_STR);
        $query->bindValue(2, "yes", PDO::PARAM_STR);
        $query->bindValue(3, "yes", PDO::PARAM_STR);
        $query->execute();
        
        $counter = $query->rowCount();
        $query->closeCursor();
        $db = NULL;
        return $counter;
    }
    
    else
    {
        $query->closeCursor();
        $db = NULL;
        return $counter;
    }
}

function get_region_name($db, $region_uuid)
{
    $sql = $db->prepare("
        SELECT regionName
        FROM regions
        WHERE uuid = '".$region_uuid."'
        ORDER BY regionName
    ");

    $sql->execute();

    if ($sql->rowCount() > 0)
    {
        while ($regions = $sql->fetch(PDO::FETCH_ASSOC))
        {
            $sql->closeCursor();
            $db = NULL;
            return $regions['regionName'];
        }
    }

    $sql->closeCursor();
    $db = NULL;
    return "Region name no found ...";
}

function get_user_name($db, $user_uuid)
{
    $sql = $db->prepare("
        SELECT FirstName, LastName
        FROM useraccounts
        WHERE PrincipalID = '".$user_uuid."'
    ");

    $sql->execute();           

    if ($sql->rowCount() > 0)
    {
        while ($rows = $sql->fetch(PDO::FETCH_ASSOC))
        {
            $firstname = $rows['FirstName'];
            $lastname = $rows['LastName'];

            if (!empty($firstname) && !empty($lastname))
            $username = $firstname.' '.$lastname;
            else $username = 'Username Missing';
            
            $sql->closeCursor();
            $db = NULL;
            return $username;
        }
    }

    $sql->closeCursor();
    $db = NULL;
    return "User name no found ...";
}

function get_this_user($i, $username, $LastSeen, $regionName, $robustHOST, $robustPORT, $options)
{
    $region_name = $options[0];
    $last_seen = $options[1];
    $tp_local = $options[2];
    $tp_hg = $options[3];
    $tp_hgv3 = $options[4];
    $tp_hop = $options[5];
    $tp_hide = $options[6];

    echo '<tr>';
    echo '<td><span class="badge">'.$i.'</span></td>';
    echo '<td><span class="glyphicon glyphicon-user"></span> '.$username.'</td>';

    if ($region_name === TRUE) echo '<td>'.$regionName.'</td>';
    if ($last_seen === TRUE) echo '<td>'.$LastSeen.'</td>';
    
    if ($tp_hide === FALSE)
    {
        echo '<td class="text-right">';

        if ($tp_local === TRUE) 
        {
            echo '<a class="btn btn-primary btn-xs" href="secondlife://'.$regionName.'/128/128/128">';
            echo '<i class="glyphicon glyphicon-plane"></i> Local</a> ';
        }

        if ($tp_hg === TRUE) {
            echo '<a class="btn btn-info btn-xs" href="secondlife://'.$robustHOST.':'.$robustPORT.'/'.$regionName.'/128/128/128">';
            echo '<i class="glyphicon glyphicon-plane"></i> HG</a> ';
        }

        if ($tp_hgv3 === TRUE) {
            echo '<a class="btn btn-warning btn-xs" href="secondlife://http|!!'.$robustHOST.'|'.$robustPORT.'+'.$regionName.'">';
            echo '<i class="glyphicon glyphicon-plane"></i> HG V3</a> ';
        }

        if ($tp_hop === TRUE) {
            echo '<a class="btn btn-danger btn-xs" href="hop://'.$robustHOST.':'.$robustPORT.'/'.$regionName.'/128/128/128">';
            echo '<i class="glyphicon glyphicon-plane"></i> Hop</a> ';
        }

        echo '</td>';
    }
    echo '</tr>';
}

?>
