<?php
session_start();
require_once '../assets/includes/pdo.php';

// Retrieve sales records
$sales_1Del = $pdo->read("sales_1", ['invoice_number' => $_POST['invoice_number'], 'company_profile_id' => $_SESSION['ovalfox_pos_cp_id']]);
$sales_2Del = $pdo->read("sales_2", ['invoice_number' => $_POST['invoice_number'], 'company_profile_id' => $_SESSION['ovalfox_pos_cp_id']]);

if (!empty($sales_2Del)) {
    // Update customer balance
    $pendingAmount = $sales_2Del[0]['pending_amount'];
    $customerName = $sales_2Del[0]['customer_name'];
    $pdo->customQuery("UPDATE customers SET balance = balance - $pendingAmount WHERE id = $customerName");
}

// Delete sales_2 and ledger records
$pdo->delete("sales_2", $_POST['invoice_number'], 'invoice_number');
$pdo->delete("ledger", $_POST['invoice_number'], 'invoice_number');

// Delete sales_1 records
foreach ($sales_1Del as $sale) {
    if (!empty($sale)) {
        $pdo->delete("sales_1", $sale['id']);
    }
}
