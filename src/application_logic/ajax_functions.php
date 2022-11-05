<?php
include "functions.php";
include "../sql_connection/sql_connection.php";

if(strcmp($_POST['function'],"remove_from_cart")==0) 
    delete_from_cart_sql($_POST['id'], $con);
if (strcmp($_POST["function"],"delete_user_confirmation")==0) 
    delete_sql($_POST['id'], $con);