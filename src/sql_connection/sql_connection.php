<?php
 
//$con=mysqli_connect('10.1.2.6', "user", "user", 'cloud_eshop_db'); //in case of docker
$con=mysqli_connect('localhost', 'root', '', 'cloud_eshop_db');
if(!$con){
    die("connection failed again and again");
}
    