<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$servername="localhost";
$username="root";
$password="";
$dbname="NavigateMe";

//create connection
$conn =  mysqli_connect($servername,$username,$password,$dbname);

$fn = $_POST['fullname'];
$e = $_POST['email'];
$f = $_POST['userfeedback'];

//check connection
if(!$conn){
    die("Connection failed :" .mysqli_connect_error());
}

$sql = "INSERT INTO userfeedback (`full_name`, `email`, `feedback`) VALUES ('$fn','$e', '$f')";

$result = mysqli_query($conn,$sql);
if($result){
        $response = array('successful' =>true , 'msg' => 'Thank you for your feedback');
} else {
       $response = array('successful' =>false , 'error' => 'Feedback Unsuccesful');
}

echo json_encode($response);

mysqli_close($conn);
?>