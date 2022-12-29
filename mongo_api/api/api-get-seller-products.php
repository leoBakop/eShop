<?
header('Content-Type: application/json');
include("../mongo_connection.php");

if($conn){
    if(isset($_GET['seller_name'])){
        $seller_name=$_GET['seller_name'];
        $answer = $products->find(['SellerName'=>strval($seller_name)], [])->toArray();
        echo json_encode($answer);
        die; 
    }
}