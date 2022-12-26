<?php
    header('Content-Type: application/json');

    include("../mongo_connection.php");

    if($conn){ //in case of specific product
        if(isset($_GET['column']) and isset($_GET['value'])){
            $column = $_GET['column'];
            $value=$_GET['value'];
            $answer = $products->find([$column=>strval($value)], [])->toArray();
            echo json_encode($answer);
            die;
        }else{
            $answer = $products->find()->toArray();
            echo json_encode($answer, JSON_PRETTY_PRINT) ;            
            die;
        }
    }
    