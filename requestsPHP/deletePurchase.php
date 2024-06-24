<?php
session_start();
require_once '../assets/includes/pdo.php';

$pr = $pdo->read("purchases_1", ['id' => $_POST['purchaseId'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']]);
    $totalAmount = $pr[0]['total_amount'];
    $productData = [$totalAmount];
    echo json_encode($productData);
    $pdo->customQuery("DELETE FROM purchases_1 WHERE id = {$_POST['purchaseId']} AND company_profile_id = {$_SESSION['ovalfox_pos_cp_id']}");