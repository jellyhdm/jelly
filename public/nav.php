<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
    <a class="navbar-brand" href="start.php">
        <img src="img/nutzerbild.png" class="rounded-circle" width="30px" height="30px"/>  jelly</a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Home">
                <a class="nav-link" href="start.php">
                    <i class="fas fa-home"></i>
                    <span class="nav-link-text">Home</span>
                </a>
            </li>
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Deine Ordner">
                <a class="nav-link" href="files.php">
                    <i class="fas fa-file"></i>
                    <span class="nav-link-text">Deine Dateien</span>
                </a>
            </li>
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Deine Ordner">
                <a class="nav-link" href="folder.php">
                    <i class="fas fa-folder-open"></i>
                    <span class="nav-link-text">Deine Ordner</span>
                </a>
            </li>
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Download">
                <a class="nav-link" href="profile.php">
                    <i class="fas fa-user-circle"></i>
                    <span class="nav-link-text">Profil</span>
                </a>
            </li>
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Download">
                <a class="nav-link" href="share.php">
                    <i class="fas fa-user-circle"></i>
                    <span class="nav-link-text">Share</span>
                </a>
            </li>
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Logout" >
                <a class="nav-link" href="logout.php">
                    <i class="fa fa-fw fa-sign-out"></i>
                    <span class="nav-link-text">Logout</span>
                </a>
            </li>


        </ul>
        <ul class="navbar-nav sidenav-toggler">
            <li class="nav-item">
                <a class="nav-link text-center" id="sidenavToggler">
                    <i class="fa fa-fw fa-angle-left"></i>
                </a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle mr-lg-2" id="messagesDropdown" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img src="../upload/uploaded/<?php echo "$owner_id" ?>/up/userpic.PNG" class="rounded-circle" alt="Nutzer" width="30" height="30">
                </a>
                <div class="dropdown-menu" aria-labelledby="messagesDropdown">
                    <a class="dropdown-item" href="profile.php">
    Profil bearbeiten
</a>
                    <div class="dropdown-divider"></div>
                    <a href="logout.php" class="dropdown-item small" data-toggle="modal" data-target="#exampleModal">
                        <i class="fa fa-fw fa-sign-out"></i>Logout</a>
                </div>
            </li>
            <li class="nav-item">
                <form class="form-inline my-2 my-lg-0 mr-lg-2">
                    <div class="input-group">
                        <input class="form-control" type="text" placeholder="Search for...">
                        <span class="input-group-append">
                <button class="btn btn-secondary" type="button">
                  <i class="fa fa-search"></i>
                </button>
              </span>
                    </div>
                </form>
            </li>
        </ul>
    </div>
</nav>
