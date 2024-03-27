<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');


$email=$_POST['Email'];
$pass=$_POST['Password'];




// For MySQL connection

//  Connect to the database in AWS
$servername = "guvi.c8dazahfss6a.us-east-1.rds.amazonaws.com";
$username = "admin";
$password = "administrator";
$dbname = "guvi";

$conn = new mysqli($servername, $username, $password,$dbname);

// Check connection
if ($conn->connect_error) {
    $t="MySQL server Busy";
  die(json_encode(array("status" => $t)));
  exit();

}

// prepare and bind
$stmt = $conn->prepare("SELECT pass FROM Users WHERE email=(?)and pass=(?)");
$stmt->bind_param("ss",$email,$pass);
$stmt->execute();
// set parameters and execute

$result=$stmt->get_result();
$p=$result->num_rows;

$stmt->close();
$conn->close();
if($p==1)
{
$text="success";
die(json_encode(array("status" => $text ,"uid"=>$email)));
exit();

}
else
{

    $text="emailerror";
    die(json_encode(array("status" => $text )));
    exit();

}



}


?>