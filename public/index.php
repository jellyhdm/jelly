<?php
require_once('../private/initialize.php');

$errors = [];
$username = '';
$password = '';

if(is_post_request()) {

    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Validations
    if(is_blank($username)) {
        $errors[] = "Der Username muss ausgefüllt werden.";
    }
    if(is_blank($password)) {
        $errors[] = "Das Passwort muss ausgefüllt werden.";
    }

    // if there were no errors, try to login
    if(empty($errors)) {
        $user = User::find_by_username($username);
        // test if user found and password is correct
        if($user != false && $user->verify_password($password)) {
            // Mark user as logged in
            $session->login($user);
            redirect_to(url_for('/index.php'));
        } else {
            // username not found or password does not match
            $errors[] = "Der Login hat nicht funktioniert.";
        }

    }

}

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

                <form action="?index=1" method="post">
                    E-Mail:<br>
                    <input type="text" name="username" value="<?php echo h($username); ?>"><br><br>

                    Dein Passwort:<br>
                    <input type="password" name="password" value="" /><br>
                    <input type="submit" name="submit" value="Einloggen" />
                </form>
                <div class="modal-footer">
                     <?php echo display_errors($errors); ?>
                </div>

            </div>

        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript -->
<script src="jquery/jquery.js"></script>
<script src="bootstrap/js/bootstrap.bundle.js"></script>

<!-- Plugin JavaScript -->
<script src="jquery-easing/jquery.easing.js"></script>



<!-- Extra JavaScript -->
<script src="js/jelly.js"></script>

</body>

</html>
>>>>>>> Stashed changes
