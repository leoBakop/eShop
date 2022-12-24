<?php
    header('Content-Type: application/json');

    include("../mongo_connection.php");

    if($conn){ //incase of specific product
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            $answer = $products->find(array('id'=>strval($id)))->toArray();
            echo json_encode($answer, JSON_PRETTY_PRINT);
            die;
        }else{
            $answer = $products->find()->toArray();
            echo json_encode($answer, JSON_PRETTY_PRINT) ;            
            die;
        }
    }
    