<?php

//------------------------------>> CENTRALIZED TECHFEST NAME WITH YEAR
require_once "config/techfestName.php";


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
$mail->Username = $emailUsername;
$mail->Password = $emailPassword;
$mail->setFrom($emailSetFrom, $techfestName);
$mail->addReplyTo('non-reply@gmail.com', $techfestName);

$mail->addAddress("$email", "$email");

$mail->Subject = "$techfestName Reactivate Your Account";

$mail->msgHTML("<!doctype html><html><body> $email We are happy to see you again in $techfestName,
                    To reactivate account please click on this link http://localhost/traparmy/activateDisableAccount.php?token=$token </body></html>");

$mail->AltBody = "$email We are happy to see you again in $techfestName,
                    To reactivate account please click on this link http://localhost/traparmy/activateDisableAccount.php?token=$token";
