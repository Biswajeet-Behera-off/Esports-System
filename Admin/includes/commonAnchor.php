<?php

if ($_SESSION['adminType'] === "Administrator") {

    $index = "adminIndex.php";
    $participants = "adminIndexData.php";
    $admins = "adminManage.php";
    $emails = "sendMails.php";
    $sponsors = "manageSponsor.php";
    $news = "manageNews.php";
    $events = "manageEvent.php";
    $newsletter = "sendNewsletter.php";

} else {

    $index = "#";
    $charts = "#";
    $participants = "#";
    $admins = "#";
    $events = "#";
    $emails = "#";
    $sponsors = "#";
    $news = "#";
    $galleryImages = "#";
    $newsletters = "#";
    $feedback = "#";

}
