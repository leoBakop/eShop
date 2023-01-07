<?php
header('Content-Type: application/json');

include("../mongo_connection.php");

if($conn){
    if(isset($_GET['Subscribe_product'])){
        $sub_pr=$_GET['Subscribe_product'];

        $avail = ($products->find(['Product_code'=>$sub_pr], ['limit'=>1])->toArray());
        $avail=$avail[0]["Availability"];
        //change the availabilty to the opposite (avail=(avail+1)mod2)
        if($avail==1) $avail=0;
        elseif ($avail==0) $avail=1;

        $answer = $products->updateOne(['Product_code'=>strval($sub_pr)], ['$set'=>['Availability'=>$avail]]);
        echo $avail;
        die;
    }else{
        $data = json_decode(file_get_contents('php://input'), true);
        $id_c=$data['id_c'];
        $column=$data['column'];
        $value=$data['value'];
        $answer = $products->updateOne(['id_c'=>$id_c], ['$set'=>[$column=>$value]]);
        die; 
    }
}