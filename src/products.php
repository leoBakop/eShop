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
    <div class="search">
        <form method="POST">

            <input class="field" type="text" name="ProductName" id="ProductName">
            <input class="button" type="submit" name="name" value="search using product name"><br>

            <input class="field" type="text" name="sellerName" id="sellerName">
            <input class="button" type="submit" name="seller" value="search using seller name"><br>

            <input class="field" type="text" name="category" id="category">
            <input class="button" type="submit" name="Category" value="search using category"><br>

            <input class="field" type="text" name="date" id="date">
            <input class="button" type="submit" name="date_button" value="search using date of withdrawl"><br>

            <input class="button" type="submit" name="all_button" value="print all available products"><br>

        </form>
    </div>



    <?php
    if (array_key_exists('name', $_POST)) search_product_by_productName_sql($_POST["ProductName"], $con, $_SESSION["User_id"]);
    else if (array_key_exists('seller', $_POST)) search_product_by_sellerName_sql($_POST["sellerName"], $con, $_SESSION["User_id"]);
    else if (array_key_exists('Category', $_POST)) search_product_by_category_sql($_POST["category"], $con, $_SESSION["User_id"]);
    else if (array_key_exists('date_button', $_POST)) search_product_by_date_sql($_POST["date"], $con, $_SESSION["User_id"]);
    else if (array_key_exists('all_button', $_POST))  print_all_products_sql($con, $_SESSION["User_id"]);
    else print_all_products_sql($con, $_SESSION["User_id"]); //just in order to activate the listeners in the "add to favorites button"


    //to do
    /* update burron is going to call a function update(... $_SESSION["User_id"])
        this function is going to navigate to a different page and perform the update */

    ?>
    <button class="button" onclick="go_to_welcome()">back </button>
    <button class="button" onclick="go_to_cart()">cart </button>


</body>

</html>