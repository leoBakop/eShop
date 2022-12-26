<?
header('Content-Type: application/json');
include("../mongo_connection.php");
if($conn){
    if(isset($_GET['user_id'])){
        $user_id=$_GET['user_id'];
        $answer = $cart->find(['user_id'=>strval($user_id)], [])->toArray();
        echo json_encode($answer);
        die; 
    }
}