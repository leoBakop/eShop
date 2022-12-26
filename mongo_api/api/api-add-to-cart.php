<?php
    include("../mongo_connection.php");

    if($conn){
        $data = json_decode(file_get_contents('php://input'), true);
        $user_id=$data['user_id'];
        $product_id=$data['product_id'];
        $product_name=$data['product_name'];
        $price=$data['Price'];
        //Select ID from Cart order by asc // in order to take the last id 
        //id_c stands for id_custom
        $filter = [];
        $options = ['projection' => [], 'sort'=>['id_c'=>-1], 'limit'=>1]; 
        $last_id = ($cart->find($filter,$options)->toArray())[0]['id_c'];

        $last_id=$last_id+1;
        
        $fields = array(
            'id_c'=>$last_id,
            'user_id'=>$user_id,
            'product_id'=>$product_id, 
            'date'=>date("Y-m-d"),
            'product_name'=>$product_name,
            'price'=>$price
        );
        $cart->insertOne($fields);
        
        die;
    }

   

?>