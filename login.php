<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Content-Type: application/x-www-form-urlencoded");

$servername="localhost";
$username="root";
$password="";
$dbname="NavigateMe";

$email = $_POST['email'];
$pass = $_POST['password'];

//create connection
$conn =  mysqli_connect($servername,$username,$password,$dbname);

//check connection
if(!$conn){
    die("Connection failed :" .mysqli_connect_error());
}

$sql = "SELECT * FROM `user` WHERE `email` = '$email' AND `password` = '$pass'";

$result = mysqli_query($conn,$sql);
if($row = mysqli_fetch_assoc($result)){
    $id= $row['id'];
    error_log($id);
    error_log($row['role']);
    if($row['role'] ==  1){ // role == 1, staff
        $sql_staff = "SELECT * FROM `staff_information` WHERE `user_id` = '$id'" ;
        $result_staff = mysqli_query($conn,$sql_staff);
        if($row_staff = mysqli_fetch_assoc($result_staff)){
            $response = array
            (
                'successful' =>true,
                'student_id' => $row_staff['staff_id'],
                'user_id' => $row_staff['user_id'],
                'address' => $row_staff['address'],
                'full_name' => $row_staff['full_name'],
                'password' => $row['password'],
                'position' => $row_staff['position'],
                'email' => $row_staff['email'],
                'phone_num' => $row_staff['phone_num'],
                'prefix' => $row_staff['prefix'],
                'role' => $row['role']
            );
        }
    }else if($row['role'] == 2){
        $sql_student = "SELECT * FROM `student_information` WHERE `user_id` = '$id'";
        $result_student = mysqli_query($conn,$sql_student);
        if($row_student = mysqli_fetch_assoc($result_student)){
            $response = array
            (
                'successful' =>true,
                'student_id' => $row_student['student_id'],
                'user_id' => $row_student['user_id'],
                'full_name' => $row_student['full_name'],
                'password' => $row['password'],
                'role' => $row['role'],
                'email' => $row['email'],
                'phone_num' => $row_student['phone_number']
            );
        }
    }else if($row['role'] == 3){
        $sql_guest = "SELECT * FROM `guest_information` WHERE `user_id` = '$id'";
        $result_guest = mysqli_query($conn,$sql_guest);
        if($row_guest = mysqli_fetch_assoc($result_guest)){
            $response = array
            (
                'successful' =>true,
                'user_id' => $row_guest['user_id'],
                'full_name' => $row_guest['full_name'],
                'password' => $row['password'],
                'role' => $row['role'],
                'email' => $row['email'],
                'phone_num' => $row_guest['phone_number']
            );
        }
    }else{ //admin
        $response = array
        (
            'successful' =>true,
            'role' => $row['role'],
            'email' => $row['email'],
            'password' => $row['password'],
            
        );
    }
   
}else{
    $response = array('successful' =>false,
                      'error' => "Login unsuccessful. Please try again.",$email);
}
echo json_encode($response);

mysqli_close($conn);
?>