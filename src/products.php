<?php
include "./application_logic/functions.php";
include "./sql_connection/sql_connection.php";
if (session_status() === PHP_SESSION_NONE) session_start();
if (!loged_in_user()) back_to_index();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <script src="./javaScript/basic_functionality.js"></script>


</head>

<body>

    <form method="POST" class="search">
            <label for="changes">Search using</label>
            <select name="changes">
                <option value="Name">Product Name</option>
                <option value="SellerName">Seller Name</option>
                <option value="DateOfWithdrawal">DateOfWithdrawal</option>
                <option value="Category">Category</option>
            </select>
            <label for="search">Insert the key:</label>
            <input type="text" name="search">
            <input type="submit" name="search_btn" value="search" class="button">
            <input type="submit" name="print_all" value="print all" class="button">

    </form>



    <?php
    if(array_key_exists('search_btn', $_POST)){
        search_product_by_specific_attribute_sql($_POST['changes'], $_POST['search'], 
                                                    $con,$_SESSION['User_id'] );
    }elseif(array_key_exists('print_all', $_POST)){
        print_all_products_sql($con, $_SESSION['User_id']);
    }else{
        print_all_products_sql($con, $_SESSION['User_id']);
    }
    ?>



    
    <button class="button" onclick="go_to_welcome()">back </button>
    <button class="button" onclick="go_to_cart()">cart </button>


</body>

</html>