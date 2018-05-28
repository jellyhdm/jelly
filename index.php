<?php
session_start();
include ('connect.php');
if(isset($_GET['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $statement = $db->prepare("SELECT * FROM testdb WHERE email = :email");
    $result = $statement->execute(array('email' => $email));
    $user = $statement->fetch();

    //Überprüfung des Passworts
    if ($user !== false && password_verify($password, $user['password'])) {
        $_SESSION['userid'] = $user['id'];
        die('Login erfolgreich. Weiter zu <a href="geheim.php">internen Bereich</a>');
    } else {
        $errorMessage = "E-Mail oder Passwort war ungültig<br>";
    }

}

                $showFormular = true; //Variable ob das Registrierungsformular anezeigt werden soll

                if(isset($_GET['register'])) {
                    $error = false;
                    $email = $_POST['email'];
                    $password = $_POST['password'];
                    $password2 = $_POST['password2'];

                    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        echo 'Bitte eine gültige E-Mail-Adresse eingeben<br>';
                        $error = true;
                    }
                    if(strlen($password) == 0) {
                        echo 'Bitte ein Passwort angeben<br>';
                        $error = true;
                    }
                    if($password != $password2) {
                        echo 'Die Passwörter müssen übereinstimmen<br>';
                        $error = true;
                    }

                    //Überprüfe, dass die E-Mail-Adresse noch nicht registriert wurde
                    if(!$error) {
                        $statement = $db->prepare("SELECT * FROM testdb WHERE email = :email");
                        $result = $statement->execute(array('email' => $email));
                        $user = $statement->fetch();

                        if($user !== false) {
                            echo 'Diese E-Mail-Adresse ist bereits vergeben<br>';
                            $error = true;
                        }
                    }

                    //Keine Fehler, wir können den Nutzer registrieren
                    if(!$error) {
                        $password_hash = password_hash($password, PASSWORD_DEFAULT);

                        $statement = $db->prepare("INSERT INTO testdb (email, password) VALUES (:email, :password)");
                        $result = $statement->execute(array('email' => $email, 'password' => $password_hash));

                        if($result) {
                            echo 'Du wurdest erfolgreich registriert. <a href="login.php">Zum Login</a>';
                            $showFormular = false;
                        } else {
                            echo 'Beim Abspeichern ist leider ein Fehler aufgetreten<br>';
                        }
                    }
                }

                if($showFormular) {
                    ?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="jelly, maria barbulovic, steffi dinies, carina gierth">

    <title>jelly</title>

    <!-- Bootstrap core CSS -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Cabin:700' rel='stylesheet' type='text/css'>

    <!-- Stylesheet für jelly-->
    <link href="css/style.css" rel="stylesheet">

</head>

<body id="page-top">

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
    <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="#page-top">jelly</a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            Menu
            <i class="fa fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="#about">Über jelly</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="#feature">Features</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="#register">Registrieren</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="modal" data-target="#exampleModal">
                        <i class="fa fa-fw fa-sign-out"></i>Login</a>
                </li>


            </ul>
        </div>
    </div>
</nav>

<!--Header -->
<header class="masthead">
    <div class="intro-body">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <h1 class="brand-heading">jelly</h1>
                    <p class="intro-text">Das etwas andere File-Sharing.</p>
                    <a href="#about" class="btn btn-circle js-scroll-trigger">
                        <i class="fa fa-angle-double-down animated"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- About Section -->
<section id="about" class="content-section text-center">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <h2>Was ist jelly?</h2>
                <p>Grayscale is a free Bootstrap theme created by Start Bootstrap. It can be yours right now, simply download the template on
                    <a href="http://startbootstrap.com/template-overviews/grayscale/">the preview page</a>. The theme is open source, and you can use it for any purpose, personal or commercial.</p>
                <p>This theme features stock photos by
                    <a href="http://gratisography.com/">Gratisography</a>
                    along with a custom Google Maps skin courtesy of
                    <a href="http://snazzymaps.com/">Snazzy Maps</a>.</p>
                <p>Grayscale includes full HTML, CSS, and custom JavaScript files along with SASS and LESS files for easy customization!</p>
            </div>
        </div>
    </div>
</section>

<!-- Was kann jelly/features Section -->
<section id="feature" class="download-section content-section text-center">
    <div class="container">
        <div class="col-lg-8 mx-auto">
            <h2>Was kann jelly?</h2>
            <p>jelly ist deine Plattform auf der DU deine Datein ganz bequem und sicher hochladen kannst.</p>

        </div>
    </div>
</section>

<!-- Registrieren Section -->
<section id="register" class="content-section text-center">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <h2>Registriere dich jetzt!</h2>

<form>
                    <form action="?register=1" method="post">
                        E-Mail:<br>
                        <input type="email" size="40" maxlength="250" name="email" placeholder="max.mustermann@jelly.de"><br><br>

                        Dein Passwort:<br>
                        <input type="password" size="40"  maxlength="250" name="password"><br>

                        Passwort wiederholen:<br>
                        <input type="password" size="40" maxlength="250" name="password2"><br><br>

                        <input type="submit" class="btn btn-default btn-lg" value="Jetzt loslegen!">
                    </form>
</form>
                    <?php
                } //Ende von if($showFormular)
                ?>

            </div>
        </div>
    </div>
</section>


<!-- Footer mit Social Media -->
<footer>
    <div class="container text-center">
        <ul class="list-inline banner-social-buttons">
            <li class="list-inline-item">
                <a href="#" class="btn btn-default btn-lg">
                    <i class="fa fa-facebook fa-fw"></i>
                    <span class="network-name">Facebook</span>
                </a>
            </li>
            <li class="list-inline-item">
                <a href="#" class="btn btn-default btn-lg">
                    <i class="fa fa-instagram fa-fw"></i>
                    <span class="network-name">Instagram</span>
                </a>
            </li>
            <li class="list-inline-item">
                <a href="#" class="btn btn-default btn-lg">
                    <i class="fa fa-twitter fa-fw"></i>
                    <span class="network-name">Twitter</span>
                </a>
            </li>
        </ul>
        <p>Copyright &copy; jelly 2018</p>
    </div>
</footer>

<!-- Logout Modal-->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Login</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <?php
                if(isset($errorMessage)) {
                    echo $errorMessage;
                }
                ?>

                <form action="?login=1" method="post">
                    E-Mail:<br>
                    <input type="email" size="40" maxlength="250" name="email"><br><br>

                    Dein Passwort:<br>
                    <input type="password" size="40"  maxlength="250" name="password"><br>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Abbrechen</button>
                <input type="submit" class="btn btn-default" value="Einloggen">
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript -->
<script src="jquery/jquery.min.js"></script>
<script src="bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Plugin JavaScript -->
<script src="jquery-easing/jquery.easing.min.js"></script>



<!-- Extra JavaScript -->
<script src="js/jelly.js"></script>

</body>

</html>
>>>>>>> Stashed changes
