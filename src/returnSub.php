<?php
include "./application_logic/sp_functions.php";
session_start();
$data = json_decode(file_get_contents("php://input"),true);
var_dump($data);
$prod_code=$data['data']['0']['id'];

sp_update_availability_subscriptions($prod_code);

?>