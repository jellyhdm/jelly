<?php
include_once '../private/includes/dbconfig.php';
include_once '../private/includes/session.php';
require_once '../upload/src/foundationphp/UploadFile2.php'
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="jelly, maria barbulovic, steffi dinies, carina gierth">
    <title>jelly</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
    <!-- BootstrapCSS-->
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
    <!-- FontAwesome-->
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css">
    <!-- Stylesheet für jelly-->
    <link href="css/style2.css" rel="stylesheet">
</head>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">
<!-- Navigation-->
<?php
include_once 'nav.php';
?>

<div class="content-wrapper">
    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="#">Übersicht</a>
            </li>
            <li class="breadcrumb-item active">Aktive Seite</li>
        </ol>
        <h1>Übersicht</h1>
        <hr>
        <p>Hallo <?php echo $_SESSION['user_session'] ?><br>Dies ist die Übersichtsseite, mit der der Nutzer starten wird. </p>
        <div>
            <img src="../upload/uploaded/ <?php $owner_id ?> /up/userpic.PNG" class="rounded-circle" alt="Nutzer" width="200" height="200">
        </div>
        <div>
            <?php
            include_once '../upload/form2.php';
            ?>
        </div>
    </div>
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
    <footer class="sticky-footer">
        <div class="container">
            <div class="text-center">
                <small>Copyright © jelly 2018</small>
            </div>
        </div>
    </footer>
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fa fa-angle-up"></i>
    </a>
    <!-- Logout Modal-->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ist es Zeit zu gehen?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Möchtest du dich wirklich ausloggen? Dann klicke auf Logout.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Abbrechen</button>
                    <a class="btn btn-primary" href="logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="jquery/jquery.js"></script>
    <script src="bootstrap/js/bootstrap.bundle.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="jquery-easing/jquery.easing.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="js/jelly2.js"></script>
    <!-- Custom scripts for this page-->



</div>
</body>

</html>