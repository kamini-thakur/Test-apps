<?php
require_once("class.phpmailer.php");
include("class.smtp.php");

$mail = new PHPMailer();
$body             = "Hello ,  Your stock finished";

$mail->IsSMTP(); // telling the class to use SMTP
$mail->Host       = "smtp.gmail.com"; // SMTP server
$mail->SMTPDebug  = 1;                     // enables SMTP debug information (for testing)
                                           // 1 = errors and messages
                                           // 2 = messages only
$mail->SMTPAuth   = true;                  // enable SMTP authentication
$mail->Host       = "smtp.gmail.com"; // sets the SMTP server
$mail->Port       = 587;                    // set the SMTP port for the GMAIL server
$mail->Username   = "testmail.esfera@gmail.com"; // SMTP account username
$mail->Password   = "esfera123";        // SMTP account password

$mail->Subject    = "Less Inventory";
$mail->MsgHTML($body);


$address = "kamini_thakur@esferasoft.com";
$mail->AddAddress($address);

if(!$mail->Send()) {
 echo "Mailer Error: " . $mail->ErrorInfo;
} else {
  echo "Message sent!";
} 

?>