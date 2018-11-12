<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$servername="localhost";
$username="root";
$password="";
$dbname="NavigateMe";

$fullname = $_POST['fullname'];
$mobile = $_POST['mobile'];
$pass = $_POST['password'];
$email = $_POST['email'];

//create connection
$conn =  mysqli_connect($servername,$username,$password,$dbname);

//check connection
if(!$conn){
    die("Connection failed :" .mysqli_connect_error());
}

$sql = "UPDATE `user` set `password` = '$pass' WHERE `email` = '$email'";

$result = mysqli_query($conn,$sql);
if($result){
    $sql_get = "SELECT * FROM `user` WHERE `email` = '$email'" ;
    $result_get = mysqli_query($conn,$sql_get);
    if($row = mysqli_fetch_assoc($result_get)){
   $id = $row['id'];
   error_log($id);
    if($row['role'] ==  1){ // role == 1, staff
        $sql_staff = "UPDATE staff_information SET `full_name` = '$fullname' , `phone_num` = '$mobile' WHERE `user_id` = '$id'";
        
        $result_staff = mysqli_query($conn,$sql_staff);
        if($result_staff){
            $sql_staff_get = "SELECT * FROM `staff_information` WHERE `user_id` = '$id'" ;
            $result_staff_get = mysqli_query($conn,$sql_staff_get);
            if($row_staff = mysqli_fetch_assoc($result_staff_get)){
            $response = array
            (
                'successful' =>true,
                'staff_id' => $row_staff['staff_id'],
                'user_id' => $row_staff['user_id'],
                'address' => $row_staff['address'],
                'full_name' => $row_staff['full_name'],
                'password' => $row['password'],
                'position' => $row_staff['position'],
                'email' => $row_staff['email'],
                'phone_num' => $row_staff['phone_num'],
                'prefix' => $row_staff['prefix'] 
            );
        }
        }else {
            $response = array
            (
                'successful' =>false,
                'error' => 'Update staff information failed'
            );
        }
    }else if($row['role'] == 2){
        $sql_student = "UPDATE student_information SET `full_name` = '$fullname', `phone_number` = '$mobile' WHERE `user_id` = '$id'";
        
        $result_student = mysqli_query($conn,$sql_student);
        if($result_student){

        $sql_student_get = "SELECT * FROM `student_information` WHERE `user_id` = '$id'";
        $result_student_get = mysqli_query($conn,$sql_student_get);
        if($row_student = mysqli_fetch_assoc($result_student_get)){
            $response = array
            (
                'successful' =>true,
                'student_id' => $row_student['student_id'],
                'user_id' => $row_student['user_id'],
                'full_name' => $row_student['full_name'],
                'password' => $row['password'],
                'role' => $row['role'],
                'email' => $row['email'],
                'phone_number' => $row_student['phone_number'],
                'prefix' => $row_student['prefix'] 
            );
        }
        }else {
            $response = array
            (
                'successful' =>false,
                'error' => 'Update student information failed'
            );
        }
    }
}
}else{
    $response = array('successful' =>false,
                      'error' => "Update password failed");
}
echo json_encode($response);

mysqli_close($conn);
?>