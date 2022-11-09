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
    <script src="./javaScript/basic_functionality.js"> </script>
    <title>Administrator</title>
</head>

<body>

    <?php

    if (strcmp($_SESSION["Role"], "Admin") != 0) go_to_error();
    //print_users_sql($con);
    ?>
    <div class="table">
        <?php print_users_ajax_sql($con);?>
    </div>

    <button class="button" onclick="go_to_welcome()">back </button>

</body>
</body>

</html>