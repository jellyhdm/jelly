<?php
use foundationphp\UploadFile2;
include_once('../private/includes/dbconfig.php');
require_once '../upload/src/foundationphp/UploadFile2.php';

if (!$user->is_loggedin()) {
    $user->redirect('index.php');
}
$id= $_SESSION['user_session'];
$stmt= $DB_con->prepare("SELECT * FROM users WHERE id=:id");
$stmt->execute(array(":id"=>$id));
$userRow=$stmt->fetch(PDO::FETCH_ASSOC);

if (!isset($_SESSION['maxfiles'])) {
    $_SESSION['maxfiles'] = ini_get('max_file_uploads');
    $_SESSION['postmax'] = UploadFile2::convertToBytes(ini_get('post_max_size'));
    $_SESSION['displaymax'] = UploadFile2::convertFromBytes($_SESSION['postmax']);
}


$max = 2048 * 1024;
$result = array();
$owner_id= $_SESSION["user_session"];
if (isset($_POST['upload'])) {

    $destination = __DIR__ . '/uploaded/'. $owner_id. '/up';
    try {
        $upload = new UploadFile2 ($destination, $DB_con);
        $upload->setMaxSize($max);
        $upload->allowAllTypes();
        $upload->upload();
        $result = $upload->getMessages();
    } catch (Exception $e) {
        $result[] = $e->getMessage();
    }
}
$error = error_get_last();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>File Uploads</title>
    <link href="css/form.css" rel="stylesheet" type="text/css">
</head>
<body>
<h1>Dein Profil bearbeiten</h1>
<?php if ($result || $error) { ?>
    <ul class="result">
        <?php
        if ($error) {
            echo "<li>{$error['message']}</li>";
        }
        if ($result) {
            foreach ($result as $message) {
                echo "<li>$message</li>";
            }

        } ?>
    </ul>
<?php } ?>
<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" enctype="multipart/form-data">
    <p>
        <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $max;?>">
        <input type="file" name="filename[]" id="filename" multiple
               data-maxfiles="<?php echo $_SESSION['maxfiles'];?>"
               data-postmax="<?php echo $_SESSION['postmax'];?>"
               data-displaymax="<?php echo $_SESSION['displaymax'];?>">

            <input type="submit" name="upload" value="Profilbild ändern">
    </p>
</form>
<script src="js/checkmultiple.js"></script>
</body>
</html>