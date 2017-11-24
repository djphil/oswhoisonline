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
        FROM $tbmodu 
        WHERE user_uuid = ?
        AND visible = ?
        AND friends = ?
    ");

    $query->bindValue(1, $_SESSION['useruuid'], PDO::PARAM_STR);
    $query->bindValue(2, "yes", PDO::PARAM_STR);
    $query->bindValue(3, "yes", PDO::PARAM_STR);
    $query->execute();

    $counter = $query->rowCount();

    if ($counter <> 0)
    {
        $query = $db->prepare("
            SELECT * 
            FROM friends 
            WHERE PrincipalID = ?
            AND Friend = ?
            AND Offered = 0
        ");

        $query->bindValue(1, $_SESSION['useruuid'], PDO::PARAM_STR);
        $query->bindValue(2, $user_uuid, PDO::PARAM_STR);
        $query->execute();
    }

    $query->closeCursor();
    $db = NULL;
    return $counter;
}

?>
