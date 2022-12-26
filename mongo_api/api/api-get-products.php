<?php
    header('Content-Type: application/json');

    include("../mongo_connection.php");

    if($conn){ //in case of specific product
        if(isset($_GET['search'] ) and $_GET['search']==1){
            $data = json_decode(file_get_contents('php://input'), true);
            $column = $data['column'];
            $value=$data['value'];
            $answer = $products->find([$column=>strval($value)], [])->toArray();
            echo json_encode($answer);
            die;
        }else{
            $answer = $products->find()->toArray();
            echo json_encode($answer, JSON_PRETTY_PRINT) ;            
            die;
        }
    }
    