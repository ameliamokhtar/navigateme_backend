<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$servername="localhost";
$username="root";
$password="";
$dbname="NavigateMe";
//create connection
$conn =  mysqli_connect($servername,$username,$password,$dbname);

$email = $_POST['mail'];
//check connection
if(!$conn){
    die("Connection failed :" .mysqli_connect_error());
}
/* Exception class. */
require 'PHPMailer\src\Exception.php';

/* The main PHPMailer class. */
require 'PHPMailer\src\PHPMailer.php';

/* SMTP class, needed if you want to use SMTP. */
require 'PHPMailer\src\SMTP.php';

$mail = new PHPMailer(TRUE);

try {
   $rand = substr(uniqid('', true), -5);
   $mail->setFrom('navigate.me.manager@gmail.com');
   $mail->addAddress($_POST['mail']);
   $mail->Subject = 'NavigateMe Reset Password';
   $mail->Body = 'Your password is resetted by the system. Please log in using the following temporary password.'."\r\n \r\n". "Email : ".$email."\r\n"."Temporary Password : ".$rand;
   
   $sql = "UPDATE `user` set `password` = '$rand' WHERE `email` = '$email'";
   
	$result = mysqli_query($conn,$sql);
   /* SMTP parameters. */
   
   /* Tells PHPMailer to use SMTP. */
   $mail->isSMTP();
   
   /* SMTP server address. */
   $mail->Host = 'smtp.gmail.com';

   /* Use SMTP authentication. */
   $mail->SMTPAuth = TRUE;
   
   /* Set the encryption system. */
   $mail->SMTPSecure = 'tls';
   
   /* SMTP authentication username. */
   $mail->Username = 'navigate.me.manager@gmail.com';
   
   /* SMTP authentication password. */
   $mail->Password = 'Admin.123';
   
   /* Set the SMTP port. */
   $mail->Port = 587;
   
   /* Finally send the mail. */
   $mail->send();
}
catch (Exception $e)
{
   echo $e->errorMessage();
}
catch (\Exception $e)
{
   echo $e->getMessage();
}

?>

