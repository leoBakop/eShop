<?php
header('Content-Type: application/json');
include("../mongo_connection.php");

if($conn){
    if(isset($_GET['user_name'])){
        $user_name=$_GET['user_name'];
        $answer = $sub->find(['User_name'=>strval($user_name)], [])->toArray();
        echo json_encode($answer);
        die; 
    }
}