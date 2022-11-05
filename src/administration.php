<?php
include "./application_logic/functions.php";
include "./sql_connection/sql_connection.php";
if (session_status()=== PHP_SESSION_NONE) session_start();

if(! loged_in_user()) back_to_index();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrator</title>
</head>
<body>

    <?php
        
        if(strcmp($_SESSION["Role"], "Admin")!=0) return_to_welcome();
        print_users_sql($con);
        //print_users_ajax_sql($con);
    ?>
    
    <a href="welcome.php"> return to welcome page</a>
</body>
</body>
</html>