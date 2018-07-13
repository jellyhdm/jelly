<?php
include ('../private/includes/dbconfig.php');
if(!$user->is_loggedin()==false)
{
    $user->redirect('start.php');
}
$id = $_SESSION['user_session'];
$stmt = $DB_con->prepare("SELECT * FROM users WHERE id=:id");
$stmt->execute(array(":id"=>$id));
$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
if(isset($_POST['btn-login']))
{
    $email = $_POST['txt_email'];
    $upass = $_POST['txt_password'];
    if($user->login($email,$upass))
    {
        $user->redirect('start.php');
    }
    else
    {
        $error = "Wrong Details !";
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
                <p> Jelly ist ein kostenloses Filehosting-System für deine Dateien. Du kannst Jelly immer und überall nutzen, egal von welchem Gerät. Nutze Jelly um deine Dateien schnell und einfach hochzuladen. Registiere dich einfach mit deiner E-Mailadresse bei Jelly und schon kann du loslegen und deine Dateien bequem speichern. Die Bedienung von Jelly ist ganz einfach also registriere dich schnell.</p>
                <!-- Text über was Jelly ist -->
            </div>
        </div>
    </div>
</section>

<!-- Was kann jelly/features Section -->
<section id="feature" class="download-section content-section text-center">
    <div class="container">
        <div class="col-lg-8 mx-auto">
            <h2>Was kann jelly?</h2>
            <p>Du kannst deine Dateien ganz einfach hochladen und online speichern. Lege dir verschiedene Ordner an und verschiebe deine Dateien leicht in deinem eigenen System. Du kannst die Dateien mit anderen Nutzern oder auch Nicht-Nutzern teilen und das Beste ist, du kannst auf deine Dateien jederzeit und von allen Geräten zugreifen.</p>

        </div>
    </div>
</section>

<!-- Registrieren Section -->
<?php
if(isset($_POST['btn-register']))
{
    $email = trim($_POST['txt_email']);
    $upass = trim($_POST['txt_upass']);
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error= 'Please enter a valid email address !';
    }
    else if($upass=="") {
        $error = "provide password !";
    }
    else if(strlen($upass) < 8){
        $error= "Password must be atleast 8 characters";
    }
    else
    {
        try
        {
            $stmt = $DB_con->prepare("SELECT email FROM users WHERE email=:email");
            $stmt->execute(array(':email'=>$email));
            $row=$stmt->fetch(PDO::FETCH_ASSOC);
            if($row['email']==$email) {
                $error = "sorry email id already taken !";
            }
            else
            {
                if($user->register($email,$upass))
                {
                    $user->redirect('index.php?joined');
                }
            }
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }
}
?>


<section id="register" class="content-section text-center">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <form action="index.php?btn-register" method="post">
                    <h2>Registriere dich jetzt!</h2>
                    <?php
                    if(isset($error))
                    {
                        foreach($error as $errorelement)
                        {
                            ?>
                            <div class="alert alert-danger">
                                <i class="glyphicon glyphicon-warning-sign"></i> &nbsp; <?php echo $errorelement; ?>
                            </div>
                            <?php
                        }
                    }
                    else if(isset($_GET['joined']))
                    {
                        ?>
                        <div class="alert alert-info">
                            <i class="glyphicon glyphicon-log-in"></i> &nbsp; Successfully registered <a href='index.php'>login</a> here
                        </div>
                        <?php
                    }
                    ?>


                    <form >
                        E-Mail:<br>
                        <input type="email" class="form-control" size="40" maxlength="250" name="txt_email" placeholder="max.mustermann@jelly.de" value="<?php if(isset($error)){echo $email;}?>"><br><br>

                        Dein Passwort:<br>
                        <input type="password" class="form-control" size="40"  maxlength="250" name="txt_upass" placeholder="Bitte gebee ein Passwort ein"><br>

                        <br><br>

                        <input type="submit" class="btn btn-default btn-lg" name="btn-register" value="Jetzt loslegen!">
                    </form>
                    <label>Ich habe einen Account <a href="index.php">Einloggen</a></label>
                </form>



            </div>
        </div>
    </div>
</section>
<!--Ende Registrieren -->

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
<!-- Ende Footer -->

<!-- Login Modal - Öffnet sich im Fenster-->


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

                <form method="post">
                    <?php
                    if(isset($error))
                    {
                        ?>
                        <div class="alert alert-danger">
                            <i class="glyphicon glyphicon-warning-sign"></i> &nbsp; <?php echo $error; ?> !
                        </div>
                        <?php
                    }
                    ?>
                    <div class="form-group">
                        <input type="text" class="form-control" name="txt_email" placeholder="E-Mail" required />
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="txt_password" placeholder="Your Password" required />
                    </div>
                    <div class="clearfix"></div><hr />
                    <div class="form-group">
                        <button type="submit" name="btn-login" class="btn btn-block btn-primary">
                            <i class="glyphicon glyphicon-log-in"></i>&nbsp;SIGN IN
                        </button>
                    </div>
                    <br />
                    <label>Ich bin noch nicht registriert <a href="#register">Registrieren</a></label>
                </form>


                <div class="modal-footer">
                </div>

            </div>

        </div>
    </div>
</div>
<!-- Modal Ende - Ende von Login -->
<!-- Bootstrap core JavaScript -->
<script src="jquery/jquery.min.js"></script>
<script src="bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Plugin JavaScript -->
<script src="jquery-easing/jquery.easing.min.js"></script>



<!-- Extra JavaScript -->
<script src="js/jelly.js"></script>

</body>

</html>