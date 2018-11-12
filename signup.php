<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$servername="localhost";
$username="root";
$password="";
$dbname="NavigateMe";

//create connection
$conn =  mysqli_connect($servername,$username,$password,$dbname);

$pass = $_POST['password'];
$fn = $_POST['fullname'];
$r = $_POST['role'];
$m = $_POST['phone_num'];
$e = $_POST['email'];

//check connection
if(!$conn){
    die("Connection failed :" .mysqli_connect_error());
}

$sql = "INSERT INTO user (`email`, `password`, `role`) VALUES ('$e','$pass', '$r')";

$result = mysqli_query($conn,$sql);
if($result){
    if($r == 1) { //staff
        $id = mysqli_insert_id($conn);
        $lt = $_POST['location_id'];
        $add = $_POST['address'];
        $p = $_POST['prefix'];
        $position = $_POST['position'];
        $sql_staff = "INSERT INTO staff_information (`user_id`,`full_name`,`phone_num`,`position`,`email`,`prefix`,`location_id`,`address`) VALUES 
        ('$id','$fn','$m','$position','$e','$p','$lt','$add')";
        $result_staff = mysqli_query($conn,$sql_staff);
        if($result_staff){
            $response = array('successful' =>true , 'msg' => 'Staff SignUp Succesfully');
        }else{
            $response = array('successful' =>false , 'msg' => 'Staff SignUp Unsuccesful');
        }
    }else if($r == 2){
        $id = mysqli_insert_id($conn);
        $sql_student = "INSERT INTO student_information (`user_id`,`full_name`, `phone_number`,`email`) 
        VALUES ('$id','$fn','$m','$e')";
        $result_student = mysqli_query($conn,$sql_student);
        if($result_student){
            $response = array('successful' =>true , 'msg' => 'Student SignUp Succesfully');
        }else{
            $response = array('successful' =>false , 'msg' => 'Student SignUp Unsuccesful');
        }
    }else if($r == 3){
        $id = mysqli_insert_id($conn);
        $sql_student = "INSERT INTO guest_information (`user_id`,`full_name`, `phone_number`,`email`) 
        VALUES ('$id','$fn','$m','$e')";
        $result_student = mysqli_query($conn,$sql_student);
        if($result_student){
            $response = array('successful' =>true , 'msg' => 'Student SignUp Succesfully');
        }else{
            $response = array('successful' =>false , 'msg' => 'Student SignUp Unsuccesful');
        }
    }
} else {
    $response = array('successful' =>false , 'error' => 'SignUp Unsuccesful');
}

echo json_encode($response);

mysqli_close($conn);
?>