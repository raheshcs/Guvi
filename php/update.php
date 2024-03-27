<?php
require '../assets/vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');



$dob=$_POST['DOB'];
$phone=$_POST['Phone'];
$uname = $_POST['Name'];
$email=$_POST['Email'];

$redis = new Redis();

  $redis->connect('redis-15996.c305.ap-south-1-1.ec2.cloud.redislabs.com', 15996);
  $redis->auth('mPxk6IYeuqpDRyr5B7OiN3Mcz58eZKJo');

// MongoDB for using Extra details about users

$mongo  = new MongoDB\Client("mongodb+srv://admin:admin@cluster0.oign8db.mongodb.net/?retryWrites=true&w=majority");
$collection = $mongo->Test->Users;
$cursor = $collection->updateOne([
  'email' => $email
],
['$set'=>['name'=>$uname,'phone'=>$phone,'DOB'=>$dob]]
);





$curs = $collection->find([
    'email' => $email
  ]);
  foreach ($curs as $document) {
    $cur = $document;
  }


  //Updating the Redis Cache Server
  $redis->set($email, json_encode($cur));


  $text = 'success';
  die(json_encode(array('text' => $text)));




}


?>