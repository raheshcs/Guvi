<?php
require '../assets/vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  header('Content-Type: application/json');
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
  header('Access-Control-Allow-Methods: POST, GET, OPTIONS');



  $dob = $_POST['DOB'];
  $phone = $_POST['Phone'];
  $uname = $_POST['Name'];
  $email = $_POST['Email'];
  $pass = $_POST['Password'];


  // MongoDB for Storing Extra details about users

  $mongo  = new MongoDB\Client("mongodb+srv://admin:admin@cluster0.oign8db.mongodb.net/?retryWrites=true&w=majority");
  $collection = $mongo->Test->Users;
  // $database->echo(['ping' => 1]);
  $cursor = $collection->find([
    'email' => $email
  ]);

  //If User Email Already Exist
  $count = 0;
  foreach ($cursor as $document) {
    $count = $count + 1;
  }
  if ($count > 0) 
  {
    $t = 'alreadyExist';
    die(json_encode(array("text" => $t)));
    exit();
  } 
  else 
  {


    $insertOneResult = $collection->insertOne([
      'email' => $email,
      'DOB' => $dob,
      'phone' => $phone,
      'name' => $uname,
      'gid' => '#' . $uname . substr($phone, 4)
    ]);



    // For MySQL connection

    //  Connect to the database in AWS
    $servername = "guvi.c8dazahfss6a.us-east-1.rds.amazonaws.com";
    $username = "admin";
    $password = "administrator";
    $dbname = "guvi";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
      $t = 'mysqlError';
      die(json_encode(array("text" => $t)));
    }

    // prepare and bind
    $stmt = $conn->prepare("INSERT INTO Users (pass, email) VALUES ( ?, ?)");
    $stmt->bind_param("ss", $pass, $email);

    // set parameters and execute

    $stmt->execute();
    $text = 'success';
    die(json_encode(array('text' => $text, "uid" => $email)));
    $stmt->close();
    $conn->close();
  }
}
