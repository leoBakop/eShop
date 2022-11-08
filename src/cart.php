<?php
include "./application_logic/functions.php";
//include "./application_logic/functions_mongodb.php";
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
</head>

<body>
    <?php
    print_cart_ajax($_SESSION["User_id"], $con);
    //print_favorites_mongodb($_SESSION["User_id"]);
    ?>

    <a href="welcome.php">back to welcome</a>
</body>

</html>