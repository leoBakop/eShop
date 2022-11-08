<?php
include "./application_logic/functions.php";
if (session_status() === PHP_SESSION_NONE) session_start();
if (!loged_in_user()) back_to_index();


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <meta charset="UTF-8">

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome page</title>
</head>

<body>

    <div class="sidebar ">
        <a class="active" href="products.php">Products</a>
        <a href="cart.php">Cart</a>
        <a href="seller.php">Seller</a>
        <a href="administration.php">Administrator</a>
    </div>

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



    <?php
    if (array_key_exists('log_out_button', $_POST)) log_out_function();
    ?>


</html>