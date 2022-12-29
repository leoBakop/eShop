<?php
include("../mongo_connection.php");
if($conn){
    if(isset($_GET['id_c'])){
        $id_c=$_GET['id_c'];
        $answer = $products->deleteOne(['id_c'=>intval($id_c)]);
        echo json_encode($answer);
        die;
    }
}

?>