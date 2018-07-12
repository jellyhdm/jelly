<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
    <a class="navbar-brand" href="start.php">
        <img src="img/nutzerbild.png" class="rounded-circle" width="30px" height="30px"/>  jelly</a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Übersicht">
                <a class="nav-link" href="start.php">
                    <i class="fa fa-fw fa-dashboard"></i>
                    <span class="nav-link-text">Übersicht</span>
                </a>
            </li>
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Upload">
                <a class="nav-link" href="upload.php">
                    <i class="fas fa-upload"></i>
                    <span class="nav-link-text">Files</span>
                </a>
            </li>
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Download">
                <a class="nav-link" href="download.php">
                    <i class="fas fa-download"></i>
                    <span class="nav-link-text">Download</span>
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
                    <img src="img/nutzerbild.png" class="rounded-circle" alt="Nutzer" width="30px" height="30px"/>
                </a>
                <div class="dropdown-menu" aria-labelledby="messagesDropdown">
                    <h6 class="dropdown-header">Max Mustermann</h6>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">
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
