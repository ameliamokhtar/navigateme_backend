<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$servername="localhost";
$username="root";
$password="";
$dbname="NavigateMe";

$mail = $_POST['mail'];
// the message
$to = "ameliamokhtar96@gmail.com";
$subject = "Reset Password NavigateMe";
$txt = "Click link below to reset";
$headers = "From: ameliamokhtar96@gmail.com";

$sent = mail($to,$subject,$txt,$headers);
echo $sent;
?>