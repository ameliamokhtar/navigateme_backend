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
$r = 1;
//check connection
if(!$conn){
    die("Connection failed :" .mysqli_connect_error());
}

if($requestType == 1){
$sql = "INSERT INTO user (`email`, `password`, `role`) VALUES ('$email','$email', '$r')";

$result = mysqli_query($conn,$sql);
if($result){
        $id = mysqli_insert_id($conn);
        $sql_staff = "INSERT INTO staff_information (`user_id`,`full_name`,`phone_num`,`position`,`email`,`address`) VALUES 
        ('$id','$full_name','$phone_num','$position','$email','$address')";
        $result_staff = mysqli_query($conn,$sql_staff);
        if($result_staff){
            $response = array('successful' =>true , 'msg' => 'Staff Added Succesfully');
        }else{
            $response = array('successful' =>false , 'error' => 'Staff Addition Unsuccesful');
        }
} else {
    $response = array('successful' =>false , 'error' => 'Addition Process Unsuccesful');
}
}else if($requestType == 2){

        $sql_get = "SELECT * FROM `user` WHERE `email` = '$email'" ;
        $result_get = mysqli_query($conn,$sql_get);
        if($row = mysqli_fetch_assoc($result_get)){
        $id = $row['id'];

            $sql_staff = "UPDATE staff_information SET `full_name` = '$full_name' , `phone_num` = '$phone_num', `position` = '$position',`address` = '$address' WHERE `user_id` = '$id'";
            
            $result_staff = mysqli_query($conn,$sql_staff);
            if($result_staff){
                $response = array('successful' =>true , 'msg' => 'Staff editted Succesfully');
            }else{
                $response = array('successful' =>false , 'error' => 'Staff edit unSuccesfull');
            }
    }else{
        $response = array('successful' =>false , 'error' => 'user does not exist');
    }
}else{
    $sql_get = "SELECT * FROM `user` WHERE `email` = '$email'" ;
    $result_get = mysqli_query($conn,$sql_get);
    if($row = mysqli_fetch_assoc($result_get)){
    $id = $row['id'];

        $sql_staff = "DELETE FROM staff_information WHERE `user_id` = '$id'";
        
        $result_staff = mysqli_query($conn,$sql_staff);
        if($result_staff){
        
        $sql_user = "DELETE FROM user WHERE `id` = '$id'";
        $result_user = mysqli_query($conn,$sql_user);

        if($result_user){
            $response = array('successful' =>true , 'msg' => 'Staff editted Succesfully');
        }else{
            $response = array('successful' =>false , 'error' => 'Staff edit unSuccesfull');
        }
        }else{
            $response = array('successful' =>false , 'error' => 'Staff edit unSuccesfull');
        }
}else{
    $response = array('successful' =>false , 'error' => 'user does not exist');
}
}
echo json_encode($response);

mysqli_close($conn);
?>