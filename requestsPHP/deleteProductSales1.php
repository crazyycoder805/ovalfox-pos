<?php
session_start();
require_once '../assets/includes/pdo.php';

$pr = $pdo->read("sales_1", ['id' => $_POST['salesId'], 'company_profile_id' => $_SESSION['ovalfox_pos_cp_id']]);
$sl2 = $pdo->read("sales_2", ['invoice_number' => $pr[0]['invoice_number']]);
$totalAmount = $pr[0]['grand_total'];
$totalAmountMinus = intval($sl2[0]['total_amount']) - intval($totalAmount) < 0 ? 0 : intval($sl2[0]['total_amount']) - intval($totalAmount);
$finalAmountMinus = (intval($sl2[0]['total_amount']) - intval($totalAmount)) - intval($sl2[0]['discount']) < 0 ? 0 : (intval($sl2[0]['total_amount']) - intval($totalAmount)) - intval($sl2[0]['discount']);
$pendingAmountMinus = ((intval($sl2[0]['total_amount']) - intval($totalAmount)) - intval($sl2[0]['discount'])) - intval($sl2[0]['recevied_amount']) < 0 ? 0 : ((intval($sl2[0]['total_amount']) - intval($totalAmount)) - intval($sl2[0]['discount'])) - intval($sl2[0]['recevied_amount']);
// $returnAmountMinus = ((intval($sl2[0]['total_amount']) - intval($totalAmount)) - intval($sl2[0]['discount'])) - intval($sl2[0]['recevied_amount']) < 0 ? 0 : intval($sl2[0]['recevied_amount']) -  (intval($sl2[0]['total_amount']) - intval($totalAmount)) - intval($sl2[0]['discount']);
$productData = [$totalAmount];

echo json_encode($productData);
$pdo->customQuery("UPDATE sales_2 
SET 
sales_2.total_amount = $totalAmountMinus,
sales_2.final_amount = $finalAmountMinus,

sales_2.pending_amount = $pendingAmountMinus
WHERE 
    company_profile_id = {$_SESSION['ovalfox_pos_cp_id']} 
    AND invoice_number = {$pr[0]['invoice_number']}
");
$pdo->customQuery("DELETE FROM sales_1 WHERE id = {$_POST['salesId']} AND company_profile_id = {$_SESSION['ovalfox_pos_cp_id']}");


if (!empty($sl2)) {
    $pdo->customQuery("UPDATE customers SET balance = balance - ".((double)$totalAmount - (double)$sl2[0]['recevied_amount'])." WHERE id = {$sl2[0]['customer_name']}");
}