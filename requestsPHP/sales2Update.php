<?php
session_start();
require_once '../assets/includes/pdo.php';

$customerSales = $pdo->read("sales_2", ["invoice_number" => $_POST['invoice_number'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']]);
$customer = $pdo->read("customers", ["id" => $customerSales[0]['customer_name'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']]);
$ledger = $pdo->read("ledger", ['invoice_number' => $_POST['invoice_number'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']]);
$currentBalance = (double)($customer[0]['balance']);
$previousPendingAmount = (double)($customerSales[0]['pending_amount']);

$newPendingAmount = (double)($_POST['pending_amount']);

if ($newPendingAmount != $previousPendingAmount) {
    $balanceAdjustment = ($newPendingAmount) - $previousPendingAmount;

    $blnc = ($currentBalance + $balanceAdjustment);

    $pdo->update("customers", ["id" => $customerSales[0]['customer_name'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']], ["balance" => ((double)$blnc)]);
}

    $balance = (double)$customer[0]['balance']; // 19000
$received_amount = (double)$_POST['recevied_amount']; // 0
$final_amount = (double)$_POST['final_amount']; // 1000
                        // 19000 - 1000 = 18000
$new_balance = round($balance - ($final_amount - $received_amount), 2);
                                                                        // 
$nw = $balance != 0 ? (empty($_POST['returned_amount']) ? $new_balance : $new_balance - (double)$_POST['returned_amount']) : 0;
                        //echo ($customers[0]['balance']) - ($minused) >= 0 ? ($customers[0]['balance']) - ($minused) : 0 ;

if (empty($ledger)) {
    $pdo->create("ledger", ["invoice_number" => $_POST['invoice_number'],
    "payment_type" => $_POST['payment_type'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id'], "total_amount" => $_POST['total_amount'], 
"recevied_amount" => $_POST['recevied_amount'],
"details" => $_POST['details'], "payment_from" => $customer[0]['id'], "dr" => $_POST['pending_amount'], "cr" => $_POST['recevied_amount'], 
"remaining_amount" => $_POST['final_amount'], "status" => $_POST['pending_amount'] != 0 || $_POST['pending_amount'] != "0" ? "Paid" : "Unpaid"]);
} else {
    $pdo->update("ledger",["invoice_number" => $_POST['invoice_number']] , 
    ["payment_type" => $_POST['payment_type'], "total_amount" => $_POST['total_amount'], 
"recevied_amount" => $_POST['recevied_amount'],
"details" => $_POST['details'], "payment_from" => $customer[0]['id'], "dr" => $_POST['pending_amount'], "cr" => $_POST['recevied_amount'], 
"remaining_amount" => $_POST['pending_amount'], "status" => $_POST['pending_amount'] != 0 || $_POST['pending_amount'] != "0" ? "Paid" : "Unpaid"]);
}

 
$pdo->update("sales_2", ['invoice_number' => $_POST['invoice_number'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']], ['discount' => 
$_POST['discount_in_amount'], 
'previous_blnce' => $nw,
'final_amount' => $_POST['final_amount'],'details' => $_POST['details'], 
'recevied_amount' => $_POST['recevied_amount'], 'returned_amount' => $_POST['returned_amount'], 'pending_amount' => $_POST['pending_amount'],
"status" => ($_POST['isIncmp'] != "true" ? ($_POST['pending_amount'] == 0 || $_POST['pending_amount'] == "0" ? "Paid" : "Unpaid") : "Incomplete")]);
