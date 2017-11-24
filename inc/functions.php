<?php
function debug($variable)
{
    echo '<pre>' . print_r($variable, true) . '</pre>';
}

function get_user_settings($db, $tbmodu, $user_uuid)
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

function set_user_settings($db, $tbmodu, $user_uuid, $visible)
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
}

?>
