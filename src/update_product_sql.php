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
    <title>Update product</title>
</head>

<body>
    <form method="GET">
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

        <input type="submit" name="update" value="update product">
    </form>

    <?php
    if (array_key_exists('update', $_GET))
        update_product_sql(
            $_SESSION["product_id"],
            $con,
            $_GET["name"],
            $_GET['productCode'],
            $_GET['price'],
            $_GET['date'],
            $_GET['category']
        );

    ?>

</body>

</html>