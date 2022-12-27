<?php
    include("../mongo_connection.php");

    if($conn){
        $data = json_decode(file_get_contents('php://input'), true);
        $name=$data['name'];
        $product_code=$data['product_code'];
        $date=$data['date'];
        $price=$data['price'];
        $seller_name=$data['sellerName'];
        $category=$data['category'];
        //Select ID from Cart order by asc // in order to take the last id 
        //id_c stands for id_custom
        $filter = [];
        $options = ['projection' => [], 'sort'=>['id_c'=>-1], 'limit'=>1]; 
        $last_id = ($products->find($filter,$options)->toArray())[0]['id_c'];

        $last_id=$last_id+1;
        
        $fields = array(
            'id_c'=>$last_id,
            'Name'=>$name,
            'Product_code'=>$product_code, 
            'Price'=>$price,
            'DateOfWithdrawl'=>$date,
            'SellerName'=>$seller_name,
            'Category'=>$category
        );
        $products->insertOne($fields);
        
        die;
    }

   

?>