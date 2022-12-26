<?php
include "./application_logic/functions.php";
include "./sql_connection/sql_connection.php";
include "./application_logic/sp_functions.php";
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
    <title>Products</title>
    <script src="./javaScript/basic_functionality.js"></script>


</head>

<body>
    <div class="welcome_info ">
        <div class="log_out_btn button">
            <form method="post">
                <input type="submit" value="Log out" name="log_out_button" class="button" />
            </form>
        </div>


        <div class="user">
            <?php echo $_SESSION["Username"] . " (" . $_SESSION["Role"] . ")"  ?>
        </div>
    </div>

    <form method="POST" class="search">
            <label for="changes">Search using</label>
            <select name="changes">
                <option value="Name">Product Name</option>
                <option value="SellerName">Seller Name</option>
                <option value="DateOfWithdrawal">DateOfWithdrawal</option>
                <option value="ProductCode">Product Code</option>
                <option value="Category">Category</option>
            </select>
            <label for="search">Insert the key:</label>
            <input type="text" name="search">
            <input type="submit" name="search_btn" value="search" class="button">
            <input type="submit" name="print_all" value="print all" class="button">

    </form>
    <button class="button" onclick="go_to_welcome()">Back </button>
    <button class="button" onclick="go_to_cart()">Cart </button>


    <?php
    if(array_key_exists('search_btn', $_POST)){
        sp_print_searched_products($_POST['changes'], $_POST['search']);
    }elseif(array_key_exists('print_all', $_POST)){
        sp_print_all_products();
    }else{
        sp_print_all_products();
    }

    
    ?>



    
    
    <?php
    if (array_key_exists('log_out_button', $_POST)) log_out_function();
    ?>



</body>

</html>