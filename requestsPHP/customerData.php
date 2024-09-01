<?php 
session_start();
require_once '../assets/includes/pdo.php';

// Fetch the customer information based on the provided customer ID and company profile ID
$onecus = $pdo->read("sales_2", [
    'id' => $_POST['cusId'], 
    'company_profile_id' => $_SESSION['ovalfox_pos_cp_id']
]);
?>
    <tr><td><?php $onecus[0]['customer_name']; ?></td></tr>


