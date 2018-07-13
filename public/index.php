<?php
include 'language.class.php';

?>

<!DOCTYPE html>
<html lang="de">

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

    <!-- roberts cooler test-->
</head>

<body id="page-top"">
<?php
$language = new language( 'de');
$lang = $language->translate();
?>
<div   style="display: none"> </div>
<!-- Navigation -->
<nav  class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
    <div class="container">

        <a class="navbar-brand js-scroll-trigger" href="#page-top">jelly</a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            Menu
            <i class="fa fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="#about"><?php echo $lang->index->aboutjelly?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="#feature">Features</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="#register"><?php echo $lang->index->registernav?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="modal" data-target="#exampleModal">
                        <i class="fa fa-fw fa-sign-out"></i>Login</a>
                </li>
            </ul>
            <form action="" method="post">
                <input type="submit" name="en" value="english"/>
                <input type="submit" name="de" value="deutsch"/>
            </form>
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
                    <p class="intro-text"><?php echo $lang->index->jelly?></p>
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
            <div  class="col-lg-8 mx-auto">
                <h2><?php echo $lang->index->isjelly1?></h2>
                <p> <?php echo $lang->index->isjelly?></p>
                <!-- Text über was ist Jelly ist -->
            </div>
        </div>
    </div>
</section>

<!-- Was kann jelly/features Section -->
<section id="feature" class="download-section content-section text-center">
    <div class="container">
        <div class="col-lg-8 mx-auto">
            <h2><?php echo $lang->index->canjelly1?></h2>
            <p><?php echo $lang->index->canjelly?></p>
            <!-- Text über was kann Jelly ist -->
        </div>
    </div>
</section>

<!-- Registrieren Section -->


<section id="register" class="content-section text-center">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <form action="index.php?btn-register" method="post">
                    <h2><?php echo $lang->index->jellyregister?></h2>


                        <form>
                            <?php echo $lang->index->mailregister?> :<br>
                            <input type="email" class="form-control" size="40" maxlength="250" name="txt_email" placeholder="max.mustermann@jelly.de" value=""><br><br>

                            <?php echo $lang->index->pswdregister?> :<br>
                            <input type="password" class="form-control" size="40"  maxlength="250" name="txt_upass" placeholder="password"><br>
    s
                            <br><br>

                            <input type="submit" class="btn btn-default btn-lg" name="btn-register" value="Jetzt loslegen!">
                        </form>
                    <label><?php echo $lang->index->account?> <a href="index.php"><?php echo $lang->index->login?></a></label>
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