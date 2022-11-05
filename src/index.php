<?php
    include "./application_logic/functions.php";
    include "./sql_connection/sql_connection.php";


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>index</title>
</head>
<body>
    <form method="GET"> <!-- ex form method="GET" action="welcome.php"> it sends the data in the .php page  -->
   
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username"><br>
        <label for="password">password:</label><br>
        <input type="password" id="password" name="password"><br><br>
        <input type="submit" name="login" value="login">
    </form>
    <br>
    <a href="sign_up.php">not a user?</a>    
    
   
    <?php
        if(array_key_exists('login', $_GET))log_in_sql($_GET['username'], $_GET['password'],$con);
        //if(array_key_exists('login', $_GET)) log_in_mongodb($_GET['username'], $_GET['password']);

    ?>
    
    

    
</body>
</html>
