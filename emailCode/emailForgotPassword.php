<?php

//------------------------------>> CENTRALIZED TECHFEST NAME WITH YEAR
require_once "config/techfestName.php";

// Please Read official documentation on GitHUb Account -> https: //github.com/PHPMailer/PHPMailer
require_once "config/demo-Secret.php";
date_default_timezone_set('Etc/UTC');
require 'PHPMailer/PHPMailerAutoload.php';

$mail = new PHPMailer;
$mail->isSMTP();
$mail->SMTPDebug = 0;
$mail->Debugoutput = 'html';
$mail->Host = 'smtp.gmail.com';
$mail->Port = 587;
$mail->SMTPSecure = 'tls';
$mail->SMTPAuth = true;
// Enter Your Email Username
$mail->Username = $emailUsername;
// Enter Your Email Password
$mail->Password = $emailPassword;
$mail->setFrom($emailSetFrom, $techfestName);
$mail->addReplyTo('non-reply@gmail.com', $techfestName);
$mail->addAddress($email, $email);
$mail->Subject = "$techfestName PASSWORD RESET";

$mail->msgHTML("<!doctype html>
    <html><body> <p>$email You're receiving this e-mail because you requested a password reset
    for your user account at $techfestName</p>
    <p>Please go to the following page and choose a new password:</p>
    <p>http://localhost/traparmy/resetPassword.php?token=$token</p>
    <p>This Link is valid for 45 Minutes Only </p>
    <p>If you didn't request this change, you can disregard this email - we have not yet reset your password.</p>
    <p>Thanks for using our site!</p>
    <p>The TRAP ARMY ESPORTS Team<p>
     </body></html>");

$mail->AltBody = "$email You're receiving this e-mail because you requested a password reset
    for your user account at $techfestName <br/>
    Please go to the following page and choose a new password: <br/>
    http://localhost/traparmy/resetPassword.php?token=$token<br/>
    This Link is valid for 45 Minutes Only <br/>
    If you didn't request this change, you can disregard this email - we have not yet reset your password. <br/>
     Thanks for using our site!<br/>
     The TRAP ARMY ESPORTS Team";
?>