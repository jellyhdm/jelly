<?php
include_once ('../private/includes/dbconfig.php');

// Current logged in user
$id= $_SESSION['user_session'];
$stmt= $DB_con->prepare("SELECT * FROM users WHERE id=:id");
$stmt->execute(array(":id"=>$id));
$userRow=$stmt->fetch(PDO::FETCH_ASSOC);

// Current logged in user
$owner_id= $_SESSION['user_session'];

// The share id which the user wants to retrieve
$share_id = $_GET["share_id"];

try {
    // Retrieve the share info for this share id
    $stmt2 = $DB_con->prepare("SELECT * FROM `share` WHERE share_id=:share_id");
    $stmt2->execute(array(":share_id"=>$share_id));
    $userRow=$stmt2->fetch(PDO::FETCH_ASSOC);

    // if the share is not active => abort
    if ($userRow["active"] == 0)
    {
        die("Share is not active!" );
    }
    // If the share is active => read the file_id from the share info and print the file (TODO: set the right mime type to its downloaded, there are such tutorials :) )
    if ($userRow["public"] == 1)
    {
        $stmt3 = $DB_con->prepare("SELECT * FROM `files` WHERE file_id=:file_id");
        $stmt3->execute(array(":file_id"=>$userRow["file_id"]));
        $userRowFile=$stmt3->fetch(PDO::FETCH_ASSOC);
        // file_get_contents reads the file content and returns it
        $down=file_get_contents('uploaded/'.$userRowFile["owner_id"].'/'. $userRowFile["file_name"]);

    if (file_exists($down)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.basename($down).'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($down));
        readfile($down);
        exit;
    }}
    // No public file => check access
    else
    {
        // if the current logged in user id is not equal to the user id which has access to this share => abort !
        if ($owner_id != $userRow["rep_id"])
        {
            die("You don't have access to this share! (you are user $owner_id, but access is restricted to " . $userRow["rep_id"] . " only!)");
        }
        else
        {
            // Same as above: read the file and return it
            $stmt3 = $DB_con->prepare("SELECT * FROM `files` WHERE file_id=:file_id");
            $stmt3->execute(array(":file_id"=>$userRow["file_id"]));
            $userRowFile=$stmt3->fetch(PDO::FETCH_ASSOC);
            $down=file_get_contents('uploaded/'.$userRowFile["owner_id"].'/'. $userRowFile["file_name"]);

        if (file_exists($down)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($down).'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($down));
            readfile($down);
            exit;
        }}

    }

} catch (PDOException $e) {
    echo $e->getMessage() . "<br>";
    die();
}
