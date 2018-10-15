<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$servername="localhost";
$username="root";
$password="";
$dbname="NavigateMe";

//create connection
$conn =  mysqli_connect($servername,$username,$password,$dbname);

$requestType = $_POST['requestType']; // admin staff CRUD type C = 1, U = 2, D = 3

$full_name = $_POST['full_name'];
$position = $_POST['position'];
$address = $_POST['address'];
$phone_num = $_POST['phone_num'];
$email = $_POST['email'];
$r = 2;
//check connection
if(!$conn){
    die("Connection failed :" .mysqli_connect_error());
}

if($requestType == 1){
$sql = "INSERT INTO user (`email`, `password`, `role`) VALUES ('$email','$email', '$r')";

$result = mysqli_query($conn,$sql);
if($result){
        $id = mysqli_insert_id($conn);
        $sql_student = "INSERT INTO student_information (`user_id`,`full_name`,`phone_num`,`email`) VALUES 
        ('$id','$full_name','$phone_num','$email')";
        $result_student = mysqli_query($conn,$sql_student);
        if($result_student){
            $response = array('successful' =>true , 'msg' => 'student Added Succesfully');
        }else{
            $response = array('successful' =>false , 'error' => 'student Addition Unsuccesful');
        }
} else {
    $response = array('successful' =>false , 'error' => 'Addition Process Unsuccesful');
}
}else if($requestType == 2){

        $sql_get = "SELECT * FROM `user` WHERE `email` = '$email'" ;
        $result_get = mysqli_query($conn,$sql_get);
        if($row = mysqli_fetch_assoc($result_get)){
        $id = $row['id'];

            $sql_student = "UPDATE student_information SET `full_name` = '$full_name' , `phone_num` = '$phone_num', `email` = '$email' WHERE `user_id` = '$id'";
            
            $result_student = mysqli_query($conn,$sql_student);
            if($result_student){
                $response = array('successful' =>true , 'msg' => 'student editted Succesfully');
            }else{
                $response = array('successful' =>false , 'error' => 'student edit unSuccesfull');
            }
    }else{
        $response = array('successful' =>false , 'error' => 'user does not exist');
    }
}else{
    $sql_get = "SELECT * FROM `user` WHERE `email` = '$email'" ;
    $result_get = mysqli_query($conn,$sql_get);
    if($row = mysqli_fetch_assoc($result_get)){
    $id = $row['id'];

        $sql_student = "DELETE FROM student_information WHERE `user_id` = '$id'";
        
        $result_student = mysqli_query($conn,$sql_student);
        if($result_student){
        
        $sql_user = "DELETE FROM user WHERE `id` = '$id'";
        $result_user = mysqli_query($conn,$sql_user);

        if($result_user){
            $response = array('successful' =>true , 'msg' => 'student editted Succesfully');
        }else{
            $response = array('successful' =>false , 'error' => 'student edit unSuccesfull');
        }
        }else{
            $response = array('successful' =>false , 'error' => 'student edit unSuccesfull');
        }
}else{
    $response = array('successful' =>false , 'error' => 'user does not exist');
}
}
echo json_encode($response);

mysqli_close($conn);
?>