<?php 


session_start();
require_once '../assets/includes/pdo.php';


echo $pdo->read("customers", ['id' => $_POST['cus_id']])[0]['balance'];