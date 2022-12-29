<?php
include "./sp_functions.php";
session_start();
if(strcmp($_POST['function'],"sp_remove_from_cart")==0) {
    sp_remove_from_cart($_POST['id'], $_SESSION['Access_token']);
}
if(strcmp($_POST['function'],"sp_delete_seller_product")==0) {
    sp_delete_seller_product($_POST['id'], $_SESSION['Access_token']);
}
?>