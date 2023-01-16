<?php
    include("../mongo_connection.php");

    if($conn){
        $data = json_decode(file_get_contents('php://input'), true);
        $user_name=$data['user'];
        $product_code=$data['subscribe_prod'];
        $availability=$data['availability'];
        $product_name=$data['Product_name'];
        //Select ID from Cart order by asc // in order to take the last id 
        //id_c stands for id_custom
        $filter = [];
        $options = ['projection' => [], 'sort'=>['id_c'=>-1], 'limit'=>1]; 
        $last_id = ($sub->find($filter,$options)->toArray())[0]['id_c'];

        $last_id=$last_id+1;
        
        $fields = array(
            'id_c'=>$last_id,
            'User_name'=>$user_name,
            'Subscribe_product'=>$product_code, 
            'Availability'=>$availability,
            'Product_name'=>$product_name
        );
        $sub->insertOne($fields);
        
        die;
    }

   

?>