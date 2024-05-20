<?php

//------------------------------>> CENTRALIZED TECHFEST NAME WITH YEAR
require_once "config/techfestName.php";

session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $techfestName ?> | ESPORTS</title>

    <!--Header Scripts -->
    <?php include_once "includes/headerScripts.php";?>

</head>

<body>

    <!--Include User Navbar-->
    <?php include_once "includes/navbar.php";?>

    <main class="container mt-5 text-uppercase">

        <!-- BGMI Events -->
        <section class="row mb-5">
            <div class="col-md-4">
                <img src="images/departments/BGMI.jpg" class="img-fluid w-100" data-aos="fade-right"
                    data-aos-duration="1500" style="max-height:250px">
            </div>
            <div class="col-md-8 text-center">
                <h3 class="font-time font-weight-bold text-uppercase mt-2">BATTLEGROUNDS
                    MOBILE INDIA (BGMI)</h3>
                <hr>

                <form id="extcForm" action="departmentalEvents.php" method="post">
                    <input type="submit" class="text-center text-uppercase btn  btn-outline-dark rounded-pill"
                        value="View Events">
                    <input type="hidden" name="eventDepartmentName" value="BGMI">
                </form>

            </div>
        </section>

        <!-- free fire Events -->
        <section class="row mb-5">
            <div class="col-md-4">
                <img src="images/departments/FREEFIRE.jpg" class="img-fluid w-100" data-aos="fade-right"
                    data-aos-duration="1500" style="max-height:250px">
            </div>
            <div class="col-md-8 text-center">
                <h3 class="font-time font-weight-bold text-uppercase mt-2">FREE FIRE</h3>
                <hr>

                <form id="chemicalForm" action="departmentalEvents.php" method="post">
                    <input type="submit" class="text-center text-uppercase btn btn-outline-dark rounded-pill"
                        value="View Events">
                    <input type="hidden" name="eventDepartmentName" value="FREEFIRE">
                </form>
            </div>
        </section>

        <!-- valorent Events -->
        <section class="row mb-5">
            <div class="col-md-4">
                <img src="images/departments/VALO.jpg" class="img-fluid w-100" data-aos="fade-right"
                    data-aos-duration="1500" style="max-height:250px">
            </div>
            <div class="col-md-8 text-center">
                <h3 class="font-time font-weight-bold text-uppercase mt-2">VALORENT</h3>
                <hr>

                <form id="computerForm" action="departmentalEvents.php" method="post">
                    <input type="submit" class="text-center btn btn-outline-dark rounded-pill" value="View Events">
                    <input type="hidden" name="eventDepartmentName" value="VALORENT">
                </form>
            </div>
        </section>

        <!-- Mechanical Events -->
        <section class="row mb-5">
            <div class="col-md-4">
                <img src="images/departments/PUBGNEW.jpg" class="img-fluid w-100" data-aos="fade-right"
                    data-aos-duration="1500" style="max-height:250px">
            </div>
            <div class="col-md-8 text-center">
                <h3 class="font-time font-weight-bold text-uppercase mt-2">PUBG NEW STATE</h3>
                <hr>

                <form id="mechanicalForm" action="departmentalEvents.php" method="post">
                    <input type="submit" class="text-center btn btn-outline-dark rounded-pill" value="View Events">
                    <input type="hidden" name="eventDepartmentName" value="PUBGNEW">
                </form>
            </div>
        </section>

        <!-- Civil Events -->
        <section class="row mb-5">
            <div class="col-md-4">
                <img src="images/departments/GL11.jpg" class="img-fluid w-100" data-aos="fade-right"
                    data-aos-duration="1500" style="max-height:250px">
            </div>
            <div class="col-md-8 text-center">
                <h3 class="font-time font-weight-bold text-uppercase mt-2">MOBILE LEGENDS BANG BANG</h3>
                <hr>

                <form id="civilForm" action="departmentalEvents.php" method="post">
                    <input type="submit" class="text-center btn btn-outline-dark rounded-pill" value="View Events">
                    <input type="hidden" name="eventDepartmentName" value="MOBILE">
                </form>
            </div>
        </section>

        <!-- Civil Events -->
        <section class="row mb-5">
            <div class="col-md-4">
                <img src="images/departments/POKEMON.jpg" class="img-fluid w-100" data-aos="fade-right"
                    data-aos-duration="1500" style="max-height:250px">
            </div>
            <div class="col-md-8 text-center">
                <h3 class="font-time font-weight-bold text-uppercase mt-2">POKEMON UNITE</h3>
                <hr>

                <form id="civilForm" action="departmentalEvents.php" method="post">
                    <input type="submit" class="text-center btn btn-outline-dark rounded-pill" value="View Events">
                    <input type="hidden" name="eventDepartmentName" value="POKEMON">
                </form>
            </div>
        </section>


        <!-- Civil Events -->
        <section class="row mb-5">
            <div class="col-md-4">
                <img src="images/departments/CSGO.jpg" class="img-fluid w-100" data-aos="fade-right"
                    data-aos-duration="1500" style="max-height:250px">
            </div>
            <div class="col-md-8 text-center">
                <h3 class="font-time font-weight-bold text-uppercase mt-2">CSGO</h3>
                <hr>

                <form id="civilForm" action="departmentalEvents.php" method="post">
                    <input type="submit" class="text-center btn btn-outline-dark rounded-pill" value="View Events">
                    <input type="hidden" name="eventDepartmentName" value="CSGO">
                </form>
            </div>
        </section>

    </main>

    <!-- Include Footer & Footer Scripts -->
    <?php
        include_once "includes/footer.php";
        include_once "includes/footerScripts.php";
    ?>

</body>

    <!-- Javascript -->
    <script src="js/eventPage.js"></script>

</body>

</html>