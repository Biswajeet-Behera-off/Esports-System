<?php
//------------------------------>> CENTRALIZED TECHFEST NAME WITH YEAR
require_once "config/techfestName.php";

?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#"><?php echo $techfestName ?></a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">

        <ul class="navbar-nav mx-auto">

            <li>
                <a class="nav-link text-uppercase" href="index.php">Home</a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-uppercase " href="eventPage.php">EVENTS</a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-uppercase " href="contactUs.php">Contact Us</a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-uppercase " href="developers.php">Developers</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-uppercase " href="news.php">News & Notification</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-uppercase " href="aboutPage.php">About</a>
            </li>
        </ul>


        <?php if (empty($_SESSION['user'])) : ?>
            <ul class="navbar-nav ml-auto">
                <button class="mr-2 btn-info text-uppercase btn text-white">
                    <a class="text-white" href="login.php">Login</a>
                </button>

                <button class="btn-info text-uppercase btn ">
                    <a class="text-white ml-2" href="register.php">Register</a>
                </button>
            </ul>
        <?php endif; ?>

        <?php if (!empty($_SESSION['user'])) : ?>

            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown"><i class="fa fa-user fa-2x"></i></a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="userProfile.php">My Profile</a>
                        <a class="dropdown-item" href="userAccount.php">Account</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" id="userLogout" href="#">Log out</a>
                    </div>
                </li>
            </ul>

        <?php endif ?>
    </div>
</nav>