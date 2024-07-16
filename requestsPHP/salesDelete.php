<?php
session_start();
require_once '../assets/includes/pdo.php';

$sales_1Del = $pdo->read("sales_1", ['invoice_number'=>$_POST['invoice_number'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']]);
$sales_2Del = $pdo->read("sales_2", ['invoice_number'=>$_POST['invoice_number'] , 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']]);

$pdo->customQuery("UPDATE customers SET balance = balance - {$sales_2Del[0]['pending_amount']} WHERE id = '{$sales_2Del[0]['customer_name']}'");

$pdo->delete("sales_2", $_POST['invoice_number'], 'invoice_number');
$pdo->delete("ledger", $_POST['invoice_number'], 'invoice_number');


foreach ($sales_1Del as $sale) {
    if (!empty($sale)) {
        $pdo->delete("sales_1", $sale['id']);
    }
}
