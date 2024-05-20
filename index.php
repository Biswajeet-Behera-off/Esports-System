<?php

require_once "config/techfestName.php";

require_once "config/configPDO.php";

session_start();

try {

    $visitorIpAddress = $_SERVER['REMOTE_ADDR'];

    $sql1 = "SELECT * FROM visitor_counter WHERE ipAddress = :visitorIpAddress";
    $result1 = $conn->prepare($sql1);
    $result1->bindValue("visitorIpAddress", $visitorIpAddress);
    $result1->execute();

    # Total row Count
    $totaVisitor = $result1->rowCount();

    if ($totaVisitor == 0) {
        $sql2 = "INSERT INTO visitor_counter (ipAddress) VALUES (:visitorIpAddress)";
        $result2 = $conn->prepare($sql2);
        $result2->bindValue(":visitorIpAddress", $visitorIpAddress);
        $result2->execute();
    }

    $sql = "SELECT * FROM visitor_counter";
    $result = $conn->prepare($sql);
    $result->execute();

    if ($result) {
        $totaVisitors = $result->rowCount();
    }
} catch (PDOException $e) {
    echo "<script>alert('We are sorry, there seems to be a problem with our systems. Please try again.');</script>";
    # Development Purpose Error Only
    echo "Error " . $e->getMessage();
}


?>

<!Doctype html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="">

    <!--First Inlude Header Scripts, then Loader.css then Index.css-->
    <?php include_once "includes/headerScripts.php"; ?>
    <link rel="stylesheet" href="css/loader.css">
    <link rel="stylesheet" href="css/index.css">

    <title><?php echo $techfestName ?> | HOME</title>

</head>

<body>


    <!--Loader-->
    <div id="loader"></div>

    <!--Include User Navbar-->
    <?php include_once "includes/navbar.php"; ?>


    <main class="container-fluid welcome-section">
        <div class="row mx-auto text-center">
            <h1 class="p-3 font-Staatliches-heading mx-auto text-white" data-aos="zoom-in" data-aos-duration="1500">Welcome to <?php echo $techfestName ?> <br> India's First Gamer
                Friendly Esports platform </h1>
            <img src="images/home/HOME.png" class="img-fluid">
        </div>
    </main>

    <main class="container-fluid p-5 second-section">
        <div class="row">
            <section class="col-md-7 mt-3 mb-5">
                <div class="bd-example">
                    <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
                            <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
                            <li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
                        </ol>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="images/home/slide1.png" class="d-block w-100 img-fluid" alt="git1">
                            </div>
                            <div class="carousel-item">
                                <img src="images/home/slide2.png" class="d-block w-100 img-fluid" lt="git2">
                            </div>
                            <div class="carousel-item">
                                <img src="images/home/slide3.png" class="d-block w-100 img-fluid" lt="git4">

                            </div>
                            <div class="carousel-item">
                                <img src="images/home/slide4.png" class="d-block w-100 img-fluid" lt="git4">

                            </div>
                            <div class="carousel-item">
                                <img src="images/home/slide5.png" class="d-block w-100 img-fluid" lt="git4">

                            </div>
                            <div class="carousel-item">
                                <img src="images/home/slide6.png" class="d-block w-100 img-fluid" lt="git4">

                            </div>
                            <div class="carousel-item">
                                <img src="images/home/slide7.png" class="d-block w-100 img-fluid" lt="git4">

                            </div>
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
            </section>

            <section class="col-md-5">
                <h3 class="text-center font-time text-white">ABOUT <?php echo $techfestName ?></h3>
                <p class="text-justify text-white">Trap Army Esports is the best esports tournament platform in INDIA,
                    Started in
                    2018 with the aim of providing a Gamer Friendly platform to every Indian Gamer. Gamer can communicat with other gamers in the comminity. 

                    Year after year, Trap Army Esports explores the various Esports game and Chellanging Esports Teams. For the last 1 years, Trap Army Esports has constantly grown, evolved, and pushed the boundaries of what
                    a Esports Tournament can
                    be. With something to offer for everyone, Trap Army Esports is the ideal destination for all Indian gamer.

                    This year marks the 7th Edition of Trap Army Esports. The Esports Tournament shall take place from 11th to 12th of
                    May, 2024 at the
                    beautiful, green campus of CUTM in PKD Odisha, India.
                    This edition of Trap Army Esports promises to be grander, greater and more glorious than ever before.
                    So grab your friends, mark your calendars, and gear up for Trap Army Esports Largest Esports Tournament.</p>

            </section>
        </div>
    </main>


    <!--Newsletter Section-->

    <div class="container">
        <div class="row">
            <section class="col-md-6 offset-md-3 py-5">
                <h2 class="text-center text-uppercase font-time  mb-4">Subscribe to our newsletter</h2>

                <form id="newsletterForm">
                    <div class="text-center mt-2">
                        <div class="form-group">
                            <button type="button" class="btn btn-danger" id="submit">Subscribe Now</button>
                        </div>
                        <span class="text-danger">
                            You must Login to subscribe Newsletter,
                            you will receive newsletter on your registered email.
                        </span>
                    </div>

                    <h5 id="responseMessage" class="mt-3 text-center font-time"></h5>
                </form>

            </section>
        </div>
    </div>


    <hr>

    <!-- Visitor Counter-->
    <div class="visitor-container p-3">
        <h3 class="text-uppercase text-center text-dark font-time">Total Visitor
            Count: <?php echo $totaVisitors ?></h3>
    </div>

    <!-- Include Footer & Footer Scripts PHP -->
    <?php
    include_once "includes/footer.php";
    include_once "includes/footerScripts.php";
    ?>

    <!-- Index js -->
    <script src="js/index.js"></script>

    <!-- Close Database Connection -->
    <?php $conn = null; ?>

</body>

</html>