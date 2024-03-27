<?php
require '../assets/vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  header('Content-Type: application/json');
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
  header('Access-Control-Allow-Methods: POST, GET, OPTIONS');



  $email = $_POST['Email'];


  //Before Hiting mongoDB we can whether it is available in Redis 

  $redis = new Redis();

  $redis->connect('redis-15996.c305.ap-south-1-1.ec2.cloud.redislabs.com', 15996);
  $redis->auth('mPxk6IYeuqpDRyr5B7OiN3Mcz58eZKJo');

  $value = $redis->get($email);


  if ($value == null) {
    // MongoDB for using Extra details about users

    $mongo  = new MongoDB\Client("mongodb+srv://admin:admin@cluster0.oign8db.mongodb.net/?retryWrites=true&w=majority");
    $collection = $mongo->Test->Users;
    // $database->echo(['ping' => 1]);
    $cursor = $collection->find([
      'email' => $email
    ]);
    foreach ($cursor as $document) {
      $cur = $document;
    }
    $t = 'alreadyExist';
    $redis->set($email, json_encode($cur));
    die(json_encode(array("email" => $cur["email"], "DOB" => $cur["DOB"], "phone" => $cur["phone"], "name" => $cur["name"], "id" => $cur["gid"],"from"=>"MongoDB")));
    exit();
  }
  else
  {
    $data=json_decode($value);
    die(json_encode(array("email" => $data->email,"DOB"=>$data->DOB,"phone"=>$data->phone,"name"=>$data->name,"id"=>$data->gid,"from"=>"Redis")));
    exit();
  }
}
