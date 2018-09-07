<?php
header("Allow-Control-Allow-Origin: *");
header("Content-Type: application/json");

$servername="localhost";
$username="root";
$password="";
$dbname="NavigateMe";

$uname = $_POST['username'];
$pass = $_POST['password'];
$fn = $_POST['fullname'];
$r = $_POST['role'];
$m = $_POST['mobile'];
$e = $_POST['email'];

// $uname = "roslan";
// $pass = "12345";

//create connection
$conn =  mysqli_connect($servername,$username,$password,$dbname);

//check connection
if(!$conn){
    die("Connection failed :" .mysqli_connect_error());
}

$sql = "SELECT * FROM `users` WHERE `username` = '$uname', `password` = '$pass', `fullname` = '$fn, `role` = '$r', `mobile` = '$m', `email` = '$e'";

$result = mysqli_query($conn,$sql);

if($row = mysqli_fetch_assoc($result)){
    $response = array
    (
        'successful' =>true,
        'username' => $row['username'],
        'pass' => $row['password'],
        'fullname' => $row['fullname'],
        'role' => $row['role'],
        'mobile' => $row['mobile'],
        'email' => $row['email'] 
    );
}else{
    $response = array('successful' =>false,
                      'error' => "Login unsuccessful. Please try again.");
}
echo json_encode($response);

mysqli_close($conn);
?>