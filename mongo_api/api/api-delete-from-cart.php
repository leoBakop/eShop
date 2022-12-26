<?php
header('Content-Type: application/json');
include("../mongo_connection.php");
if($conn){
    if(isset($_GET['id_c'])){
        $id_c=$_GET['id_c'];
        $answer = $cart->deleteOne(['id_c'=>strval($id_c)], [])->toArray();
    }
}

?>