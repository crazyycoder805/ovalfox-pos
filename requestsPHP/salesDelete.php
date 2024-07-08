<?php
session_start();
require_once '../assets/includes/pdo.php';

$sales_1Del = $pdo->read("sales_1", ['invoice_number'=>$_POST['invoice_number'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']]);
$pdo->delete("sales_2", $_POST['invoice_number'], 'invoice_number');
$pdo->delete("ledger", $_POST['invoice_number'], 'invoice_number');

foreach ($sales_1Del as $sale) {
    if (!empty($sale)) {
        $pdo->delete("sales_1", $sale['id']);
    }
}
