<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$servername="localhost";
$username="root";
$password="";
$dbname="NavigateMe";

//create connection
$conn =  mysqli_connect($servername,$username,$password,$dbname);

//check connection
if(!$conn){
    die("Connection failed :" .mysqli_connect_error());
}

$sql_get = "SELECT * FROM `user`" ;
$result_get = mysqli_query($conn,$sql_get);

if (mysqli_num_rows($result_get) > 0) {
    while($row = mysqli_fetch_assoc($result_get)) {
        $e = $row['email'];
        $id = $row['id'];
        $sql_student = "UPDATE guest_information SET `email` = '$e' WHERE `user_id` = '$id'";
        
        $result_student = mysqli_query($conn,$sql_student);
        if($result_student){
        echo "yeahh";
        }
        else{
            echo "Oh no menn,damnnnnn sonn";
        }
    }
}
?>