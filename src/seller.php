<?php
    include "./application_logic/functions.php";
    include "./sql_connection/sql_connection.php";
    if (session_status()=== PHP_SESSION_NONE) session_start();
    if(! loged_in_user()) back_to_index();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller</title>
</head>
<body>
    <?php 
    if(strcmp($_SESSION['Role'], "ProductSeller")!=0) 
        go_to_error();
    print_sellers_products_sql($_SESSION["Username"],$con);
    ?>
  

    <form action="add_product.php" method="post">
        <input type="submit" value="New product">
    </form>
    
    <a href="welcome.php">go back to welcome page</a>
</body>
</html>