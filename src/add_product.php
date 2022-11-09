<?php
//if (session_status()=== PHP_SESSION_NONE) session_start();
include "./application_logic/functions.php";
include "sql_connection/sql_connection.php";
if (!loged_in_user()) back_to_index();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="./javaScript/basic_functionality.js"></script>
    <title>Add concert</title>
</head>

<body>
    <form method="GET" class="search">
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name"><br>
        <label for="date">Date of withdrawal(YYYY-MM-DD):</label><br>
        <input type="text" id="date" name="date"><br>
        <label for="productCode">product code:</label><br>
        <input type="text" id="productCode" name="productCode"><br>
        <label for="price">price:</label><br>
        <input type="text" id="price" name="price"><br>
        <label for="category">Category:</label><br>
        <input type="text" id="category" name="category"><br>

        <input class="button" type="submit" name="add_product" value="Add product">
    </form>
    <?php
    if (array_key_exists('add_product', $_GET)) add_product_sql(
        $_SESSION['Username'],
        $_GET["name"],
        $_GET["productCode"],
        $_GET["date"],
        $_GET["price"],
        $_GET["category"],
        $con
    );
    ?>

</body>

</html>