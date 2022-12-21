<?php
include "./application_logic/functions.php";
include  "./application_logic/sp_functions.php";
include "./sql_connection/sql_connection.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="./style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>index</title>
</head>

<body>
    <div class="box text-center">
        <div class="search">
            <form method="GET">
                <label for="email">Email:</label><br>
                <input type="text" id="email" name="email"><br>
                <label for="password">Password:</label><br>
                <input type="password" id="password" name="password"><br><br>
                <input type="submit" name="login" value="login" class="button">
            </form>
            <br>
        </div>
        <a class="button" href="sign_up.php">not a user?</a>
    </div>




    <?php
    //if (array_key_exists('login', $_GET)) log_in_sql($_GET['username'], $_GET['password'], $con);
    if (array_key_exists('login', $_GET)) sp_login($_GET['email'], $_GET['password'], $con);
    ?>


</body>

</html>