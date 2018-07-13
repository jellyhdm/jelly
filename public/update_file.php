<?php
include_once '../private/includes/dbconfig.php';
include_once '../private/includes/session.php';


$_GET["file_id"];

try {
    $stmt =$DB_con->prepare('
            UPDATE files
            SET file_name = :file_name, file_path = :file_path, owner_id = :owner_id
            WHERE file_id = :file_id
            ');
    $stmt->bindParam(':file_name', $file_name);
    $stmt->bindParam(':file_path', $file_path);
    $stmt->bindParam(':owner_id', $owner_id);
    $stmt->bindParam(':file_id', $file_id);
    $stmt->execute();

    header ('location: files.php');
} catch (PDOException $e) {
    echo("Fehler! Bitten wenden Sie sich an den Administrator...<br>" . $e->getMessage() . "<br>");
    die();
}

