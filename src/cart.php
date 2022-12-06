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
    <script src="./javaScript/basic_functionality.js"></script>
    <title>Cart</title>
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
    <button class="button" onclick="go_to_welcome()">Back </button>
    <?php
    print_cart_ajax($_SESSION["User_id"], $con);
    ?>
    <br><br><br>
    

    <?php
    if (array_key_exists('log_out_button', $_POST)) log_out_function();
    ?>


</body>

</html>