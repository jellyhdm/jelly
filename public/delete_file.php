<?php
include_once '../private/includes/dbconfig.php';
include_once '../private/includes/session.php';


$_GET["file_id"];


if(file_exists($_GET["file_id"]))
{
    if (unlink($_GET["file_id"])){
        $stmt = $DB_con->prepare("DELETE FROM `files` WHERE file_id=:file_id");
        $stmt->bindParam(':file_id', $_GET["file_id"]);
        $stmt->execute();
        $file_id=$stmt->fetch(PDO::FETCH_ASSOC);
        echo 'Datei gelöscht';

    }
    else
    {echo 'Datei konnte nicht gelöscht werden!';

    }

}

