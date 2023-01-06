<?php
include("../mongo_connection.php");

if($conn){
    if(isset($_GET['Subscribe_product'])){
        $sub_pr=$_GET['Subscribe_product'];
        $avail = $sub->find(['Subscribe_product'=>strval($sub_pr)], ['limit'=>1])->toArray();
        $avail=$avail[0]["Availability"];
        //change the availabilty to the opposite (avail=(avail+1)mod2)
        if($avail==1) $avail=0;
        elseif ($avail==0) $avail=1;
        $answer = $sub->updateOne(['Subscribe_product'=>$sub_pr], ['$set'=>['Availability'=>$avail]]);
        die; 
    }
}

?>