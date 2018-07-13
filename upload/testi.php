<?php
include_once '../private/includes/dbconfig.php';
include_once '../private/includes/session.php';

?>
<form action="share.php" method="post" >
    File ID<input type="text" name="file_id" value="3"><br>
    User id to has access to this share:<input type="text" name="user_share_id" value="3"><br>
    Public share? :<input type="text" name="public_share" value="1"><br>
    <input type="submit" value="test"> </form>