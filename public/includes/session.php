<?php

if(!$user->is_loggedin())
{
    $user->redirect('index.php');
}
$id = $_SESSION['user_session'];
$stmt = $DB_con->prepare("SELECT * FROM users WHERE id=:id");
$stmt->execute(array(":id"=>$id));
$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
$owner_id= $_SESSION['user_session'];