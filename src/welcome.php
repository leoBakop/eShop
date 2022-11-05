<?php
    include "./application_logic/functions.php";
    if (session_status()=== PHP_SESSION_NONE) session_start();
    if(! loged_in_user()) back_to_index();


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome page</title>
</head>
<body>
  
    <ol>
    <li><a href="products.php">Products</a></li>
    <li><a href="cart.php">Cart</a></li>
    <li><a href="seller.php">Seller</a></li>
    <li><a href="administration.php">Administrator</a></li>
    </ol>  

    <form  method="post">
        <input type="submit" value="Log out" 
               name="log_out_button" class="button"/> 
    </form>

    <?php
        if(array_key_exists('log_out_button', $_POST)) log_out_function();
    ?>

    
</html>