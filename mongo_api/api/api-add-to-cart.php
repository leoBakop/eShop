<?php
    include("../mongo_connection.php");

    /* if($conn){
        $data = json_decode(file_get_contents('php://input'), true);
        $user_id=$data['user_id'];
        $product_id=$data['product_id'];
        $product_name=$data['product_name'];
        $price=$data['price'];
        //Select ID from Cart order by asc // in order to take the last id 

        $filter = [];
        $options = ['sort' => ['id' => 1], 'limit' =>1];
        $result = $cart->find($filter,$options);
        $last_id=json_encode($result, JSON_PRETTY_PRINT)['id'];
        if (!$last_id) $last_id=0;
        else $last_id=$last_id+1;
        
        $fields = array('id'=>strval(0),'user_id'=>$user_id,'product_code'=>$product_code, 'date'=>date("Y-m-d"));
        $cart->insertOne($fields);
        echo json_encode(["response"=>"New concert added!","newID"=>$response]);
        die;
    } */

    echo json_encode(["response"=>"New concert added!","newID"=>$conn]);
    die;

?>