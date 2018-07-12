<?php
include_once ('../private/includes/dbconfig.php');
if (!$user->is_loggedin()) {
    $user->redirect('index.php');
}
$id= $_SESSION['user_session'];
$stmt= $DB_con->prepare("SELECT * FROM users WHERE id=:id");
$stmt->execute(array(":id"=>$id));
$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
$owner_id= $_SESSION['user_session'];
try {
    $stmt2 = $DB_con->prepare("SELECT `file_id`, `owner_id`, `file_path`, `file_name` FROM `files` WHERE file_id=:file_id ");
    $stmt2->bindParam(':owner_id', $owner_id);
    $stmt2->bindParam(':file_path', $file_path);
    $stmt2->bindParam(':file_name', $file_name);
    $stmt2->execute(array(":file_id"=>$file_id));
    $userRow=$stmt2->fetch(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo $e->getMessage() . "<br>";
    die();
}
$sharename= $owner_id.'/'.$file_id;
$share=sha1($sharename);

try{
$stmt3 = $DB_con->prepare ("INSERT INTO `share`(`share_id`, `file_id`, `public`, `rep_id`, `active`) 
VALUES ($share,$file_id, TRUE, $owner_id,TRUE)");
$stmt3->bindParam(':share_id', $share);
$stmt3->bindParam(':file_id', $file_id);
$stmt3->bindParam (':public', TRUE);
$stmt3->bindParam (':rep_id', $owner_id);
$stmt3->bindParam (':active', TRUE);
$userRow=$stmt2->fetch(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo $e->getMessage() . "<br>";
    die();
}
echo ('<a href="https://mars.iuk.hdm-stuttgart.de/~sd105/wmp/upload/uploaded/'.$share.'"></a>');