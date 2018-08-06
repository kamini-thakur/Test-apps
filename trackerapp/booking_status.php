<?php
	
$email= $_POST['email'];
$value=$_POST['value'];
$cname=$_POST['name'];
if($value==1)
	$status="Confirmed";
else
	$status="Cancelled";

include('mysql.php');
global $wpdb;
$wpdb->query($wpdb->prepare("UPDATE wp_booking SET status='$value' WHERE Customeremail='$email'"));
?>
<?php
require_once('class.phpmailer.php');
include("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded
//include("PHPMailerAutoload.php");
$mail             = new PHPMailer();

$body             = "Hello, ".$cname.". Your Booking has been $status successfully";

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

$mail->SetFrom('deepak_gupta@esferasoft.com', 'Esferasoft');

$mail->AddReplyTo("deepak_gupta@esferasoft.com","Esferasoft");

$mail->Subject    = "Booking Confirmation";


$mail->MsgHTML($body);

$address = $email;;
$mail->AddAddress($address, $cname);

if(!$mail->Send()) {
 echo "Mailer Error: " . $mail->ErrorInfo;
} else {
  echo "Message sent!";
}
    ?>