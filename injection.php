<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$servername="localhost";
$username="root";
$password="";
$dbname="NavigateMe";

//create connection
$conn =  mysqli_connect($servername,$username,$password,$dbname);
$data_array = array();
//check connection
if(!$conn){
    die("Connection failed :" .mysqli_connect_error());
}


$sql2 = "SELECT * FROM `staff_information`";

$result2 = mysqli_query($conn,$sql2);

if (mysqli_num_rows($result2) > 0) {
    // output data of each row
    while($row2 = mysqli_fetch_assoc($result2)) {
        $userid = $row2['user_id'];
        $sql = "SELECT * FROM `location_information`";

        $result = mysqli_query($conn,$sql);

        if(mysqli_num_rows($result)){
            while($row = mysqli_fetch_assoc($result)) {
                
                $id= $row['location_id'];
                if($row2['address'] == $row['address']){
                    $update = "UPDATE `staff_information` set `location_id` = '$id' WHERE `user_id` = '$userid'";
                    
                    $result3 = mysqli_query($conn,$update);
                    
                }
        }
    }
}
}

?>