<?php
include_once ('../private/includes/dbconfig.php');
if (!$user->is_loggedin()) {
    $user->redirect('index.php');
}
$id= $_SESSION['user_session'];
$stmt= $DB_con->prepare("SELECT * FROM users WHERE id=:id");
$stmt->bindParam(":email", $email);
$stmt->execute(array(":id"=>$id));
$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
$owner_id= $_SESSION['user_session'];
$file_id = $_POST["file_id"];
$user_to_share_id = $_POST["user_share_id"];
$is_public_share = $_POST["public_share"];
$email=$_POST["email"];

try {
    $stmt2 = $DB_con->prepare("SELECT `file_id`, `owner_id` FROM `files` WHERE file_id=:file_id ");
    $stmt2->execute(array(":file_id"=>$file_id));
    $userRow=$stmt2->fetch(PDO::FETCH_ASSOC);
    //echo "OWNER ID: " . $owner_id . "<br>";

    // Check if the current user owns the file (we can't create shares for file which we don't own!)
    if ($userRow["owner_id"] != $owner_id)
    {
        die("Current logged in user does not own file: " . $file_id );
    }

} catch (PDOException $e) {
    echo $e->getMessage() . "<br>";
    die();
}

// Get the sha1 hash from the file_id
$share_id=sha1($file_id);
//echo "FILE HASH: " +  $share;

try{

    if ($is_public_share == 1)
    {
        $public = TRUE;
    }
    else
    {
        $public = FALSE;
    }
    $active = TRUE;

    // Insert the share into the table. Notice that the entry is added again even if it already exists

    $stmt3 = $DB_con->prepare ("INSERT INTO `share`(`share_id`, `file_id`, `public`, `rep_id`, `active`) 
	VALUES (:share_id, :file_id, :public, :owner_id,:active)");
    $stmt3->bindParam(':share_id', $share_id);
    $stmt3->bindParam(':file_id', $file_id);
    $stmt3->bindParam (':public', $public);
    $stmt3->bindParam (':owner_id', $user_to_share_id);
    $stmt3->bindParam (':active', $active);
    $stmt3->execute();

} catch (PDOException $e) {
    echo $e->getMessage() . "<br>";
    die();
}

$empfaenger = "$email";
$betreff = "Ein jelly-Link wurde mit Ihnen geteilt!";
$from = "From: jelly <mb291@hdm-stuttgart.de>\n";
$from .= "Reply-To: mb291@hdm-stuttgart.de\n";
$from .= "Content-Type: text/html\n";
$text = "Folgender Link wurde mit Ihnen geteilt:\". $link";

$link="https://mars.iuk.hdm-stuttgart.de/~sd105/upload/getshare.php?share_id='.$share_id.'";
echo ('<html><body><a href="getshare.php?share_id='.$share_id.'">SHARED LINK :)</a></body></html>');


mail("marjia@hotmail.de", $betreff, $text, "From: Absender <mb291@hdm-stuttgart.de>");

