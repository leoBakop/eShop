<?php
include "./application_logic/sp_functions.php";
session_start();
?><script>alert("inside returnSub");</script><?php
sp_update_availability_subscriptions($_SESSION['product_code']);

?>