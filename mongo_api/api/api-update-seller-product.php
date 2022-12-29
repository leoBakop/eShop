<?
header('Content-Type: application/json');
include("../mongo_connection.php");

if($conn){
    $data = json_decode(file_get_contents('php://input'), true);
    $id_c=$data['id_c'];
    $column=$data['column'];
    $value=$data['value'];
    $answer = $products->updateOne(['id_c'=>$id_c], ['$set'=>[$column=>$value]]);
    die; 
}