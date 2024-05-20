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
    <meta name="author" content="Vishal Bait">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $techfestName ?> | ABOUT</title>

    <!-- First AOS Animation then Include Header Scripts then CSS file -->
    <?php include_once "includes/headerScripts.php"; ?>
    <link rel="stylesheet" href="css/aboutPage.css">

</head>

<body>

    <!-- Include User Navbar-->
    <?php include_once "includes/navbar.php"; ?>

    <main class="container">
        <div class="row">


            <section class="col-md-10 offset-md-1">
                <div class="p-5 my-3 text-justify" data-aos="zoom-in" data-aos-duration="1500">

                    <h1 class="p-1 text-center text-uppercase font-Staatliches-heading">About Trap Army Esports</h1>
                    <hr class="mb-5" style="border-top: 2px solid rgba(0,0,0,.1);"/>

                    <p><strong>Welcome to Trap Army Esports: Where Gamers Rise to the Challenge!</strong></p>
                    
                    <p>Are you ready to level up your gaming experience? Welcome to Trap Army Esports, 
                        where the battlefield meets the prize pool! We're not just another gaming platform; 
                        we're a community-driven hub designed for gamers, by gamers. Whether you're a seasoned 
                        veteran or just starting your journey, we've got something for everyone.</p>
                    <p><strong>What is Trap Army Esports?</strong></p>
                    <p> Trap Army Esports isn't your typical gaming platform. We're a dynamic arena where players showcase their skills, 
                        compete for exciting prizes, and hone their craft to reach the next level of gaming greatness. 
                        Our platform is built on the belief that every gamer deserves a chance to shine, 
                        and we provide the stage for you to do just that.</p>
                    <p> <strong>How does it work?</strong></p>
                    <p>At Trap Army Esports, you'll find a variety of tournaments, challenges, and events tailored to different skill 
                        levels and gaming genres. Whether you're into shooters, strategy games, MOBAs, or something entirely different, 
                        there's a place for you here. Participate in our tournaments to compete against fellow gamers, earn rewards, 
                        and claim your share of the prize pool.</p>
                    <p>But Trap Army Esports isn't just about winning; it's also about growth. Our platform offers resources 
                        and tools to help you improve your skills, learn from the best, and become the ultimate gaming champion. 
                        From strategy guides to expert tips and tutorials, we've got everything you need to take your game to the next level.</p>
                    

                </div>
            </section>
        </div>
    </main>

    <!-- Include Footer & Footer Scripts -->
    <?php
    include_once 'includes/footer.php';
    include_once "includes/footerScripts.php";
    ?>

</body>

</html>