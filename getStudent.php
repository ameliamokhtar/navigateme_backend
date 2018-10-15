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

$sql = "SELECT * FROM `student_information`";

$result = mysqli_query($conn,$sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        array_push($data_array,$row);
    }
    $response = array
    (
        'successful' =>true,
        'students' => $data_array
    );
}else{
    $response = array('successful' =>false,
                      'error' => "No data found");
}
echo json_encode($response);

mysqli_close($conn);
?>