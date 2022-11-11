<?php
include './application_logic/functions.php';
include 'sql_connection/sql_connection.php';
if (session_status() === PHP_SESSION_NONE) session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>sign_up</title>
</head>

<body>
    <form method="GET" class="search">
        <!--action="welcome.php" it sends the data in the .php page  -->


        <label for="name">name:</label><br>
        <input type="text" id="name" name="name"><br>
        <label for="surname">surname:</label><br>
        <input type="text" id="surname" name="surname"><br>
        <label for="username">username:</label><br>
        <input type="text" id="username" name="username"><br>
        <label for="password">password:</label><br>
        <input type="password" id="password" name="password"><br>
        <label for="email">email:</label><br>
        <input type="text" id="email" name="email"><br>
        <label for="role">role:</label><br>
        <select id="role" name="role">
            <option value="Admin">admin</option>
            <option value="ProductSeller">product seller</option>
            <option value="User">user</option>
        </select>


        <input type="submit" name="sign_up" value="Become a member">
    </form>

    <?php

    if (array_key_exists('sign_up', $_GET))
        sign_up_sql(
            $_GET["name"],
            $_GET["surname"],
            $_GET["username"],
            $_GET["password"],
            $_GET["email"],
            $_GET["role"],
            $con
        );

    ?>

    <a href="index.php">not sure? return to index</a>

</body>

</html>