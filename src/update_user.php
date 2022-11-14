<?php
session_start();
include "sql_connection/sql_connection.php";
include "application_logic/functions.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="javaScript/basic_functionality.js"></script>
    <title>update user</title>
</head>

<body>

    <form method="get">
        <label for="changes">What would you like to update</label>
        <select name="changes">
            <option value="Role">Role</option>
            <option value="Email">Email</option>
        </select>
        <input type="submit" name="sign_up" value="Change it">

    </form>
    <?php

    if ($_GET['changes'] == "Role") {
    ?>
        <form method="post">
            <label for="role">role:</label><br>
            <select id="role" name="role">
                <option value="Admin">admin</option>
                <option value="ProductSeller">product seller</option>
                <option value="User">user</option>
            </select>
            <input type="submit" name="change_role" value="Change Role">
        </form>

    <?php
    if(array_key_exists('change_role', $_POST)) change_user($_SESSION['tmp_user_id'], 
                                                                "Role", $_POST['role'], $con);

    } elseif ($_GET['changes'] == "Email") {
    ?>
        <form method="post">
            <label for="email">email:</label><br>
            <input type="text" id="email" name="email"><br>
            <input type="submit" name="change_email" value="Change Email">
        </form>
    <?php
    if(array_key_exists('change_email', $_POST)) change_user($_SESSION['tmp_user_id'], 
                                                                "Email", $_POST['email'], $con);
    }

    ?>

    <button class="button" onclick="go_to_welcome()">back </button>
</body>

</html>