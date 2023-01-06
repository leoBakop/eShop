<?php
    require '../config/vendor/autoload.php';
    $conn = new MongoDB\Client("mongodb://admin:admin@mongo:27017");
    $db = $conn->eshop_db;

    $products = $db->products;
    $cart = $db->cart;
    $sub= $db->subscribtions;
?>