<?php
include "sp_functions.php.php";

if(strcmp($_POST['function'],"sp_remove_from_cart")==0) 
    sp_remove_from_cart($_POST['id']);