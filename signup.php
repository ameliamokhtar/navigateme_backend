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

        $p = $_POST['prefix'] ;
        $a = $_POST['address'] ;
        $position = $_POST['position'] ;
        $id = mysqli_insert_id($conn);
        $sql_staff = "INSERT INTO staff_information (`user_id`, `full_name`, `position`, `address`, `phone_num`, `email`, `prefix` ) VALUES 
        ('$id','$fn','$position','$a','$m','$e','$p')";
        $result_staff = mysqli_query($conn,$sql_staff);
        if($result_staff){
            $response = array('successful' =>true , 'msg' => 'Staff Sign Up Succesful');
        }else{
            $response = array('successful' =>false , 'msg' => 'Staff Sign Up Unsuccesful');
        }
    }
    else if($r == 2){ //student
        $id = mysqli_insert_id($conn);
        $sql_student = "INSERT INTO student_information (`user_id`, `full_name`, `phone_number`) VALUES ('$id','$fn','$m')";
        $result_student = mysqli_query($conn,$sql_student);
        if($result_student){
            $response = array('successful' =>true , 'msg' => 'Student Sign Up Succesful');
        }else{
            $response = array('successful' =>false , 'msg' => 'Student Sign Up Unsuccesful');
        }
    }
    else if($r == 3){ //guest
        $id = mysqli_insert_id($conn);
        $sql_guest = "INSERT INTO guest_information (`user_id`,`full_name`, `phone_number`) VALUES ('$id','$fn','$m')";
        $result_guest = mysqli_query($conn,$sql_guest);
        if($result_guest){
            $response = array('successful' =>true , 'msg' => 'Guest Sign Up Succesful');
        }else{
            $response = array('successful' =>false , 'msg' => 'Guest Sign Up Unsuccesful');
        }
    }
} else {
    $response = array('successful' =>false , 'error' => 'SignUp Unsuccesful');
}

echo json_encode($response);

mysqli_close($conn);
?>