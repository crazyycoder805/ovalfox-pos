<?php
session_start();
require_once '../assets/includes/pdo.php';
$_POST['date'] = str_replace("T", " ", $_POST['date']);
$customerSales = $pdo->customQuery("SELECT * FROM sales_2 WHERE invoice_number = {$_POST['invoice_number']} AND company_profile_id = {$_SESSION['ovalfox_pos_cp_id']}");

// $customerSales = $pdo->customQuery("SELECT * FROM sales_2 WHERE invoice_number = {$_POST['invoice_number']} AND company_profile_id = {$_SESSION['ovalfox_pos_cp_id']} ORDER BY id DESC");
$date = isset($_POST['date']) && $_POST['date'] != "" ? $_POST['date'] : $customerSales[0]['date'];
$booker = isset($_POST['booker_name']) && $_POST['booker_name'] != "" ? $_POST['booker_name'] : $customerSales[0]['booker_name'];








$customerInvMinus = empty($pdo->customQuery("SELECT * 
FROM sales_2 
WHERE customer_name = '{$customerSales[0]['customer_name']}'
AND invoice_number < '{$_POST['invoice_number']}'
ORDER BY invoice_number DESC 
LIMIT 1")) ? [] : $pdo->customQuery("SELECT * 
FROM sales_2 
WHERE customer_name = '{$customerSales[0]['customer_name']}'
AND invoice_number < '{$_POST['invoice_number']}'
ORDER BY invoice_number DESC 
LIMIT 1");





$customerInvMinusAll = empty($pdo->customQuery("SELECT * 
FROM sales_2 
WHERE customer_name = {$customerSales[0]['customer_name']}
AND invoice_number < {$_POST['invoice_number']}

")) ? [] : $pdo->customQuery("SELECT * 
FROM sales_2 
WHERE customer_name = {$customerSales[0]['customer_name']}
AND invoice_number < {$_POST['invoice_number']}

");





$customerInvPlus = empty($pdo->customQuery("SELECT * 
FROM sales_2 
WHERE customer_name = '{$customerSales[0]['customer_name']}'
AND invoice_number > '{$_POST['invoice_number']}' 
ORDER BY invoice_number ASC 
LIMIT 1")) ? [] : $pdo->customQuery("SELECT * 
FROM sales_2 
WHERE customer_name = '{$customerSales[0]['customer_name']}'
AND invoice_number > '{$_POST['invoice_number']}' 
ORDER BY invoice_number ASC 
LIMIT 1");



$customer = $pdo->read("customers", ["id" => $customerSales[0]['customer_name'], 'company_profile_id' => $_SESSION['ovalfox_pos_cp_id']]);
$ledger = $pdo->read("ledger", ['invoice_number' => $_POST['invoice_number'], 'company_profile_id' => $_SESSION['ovalfox_pos_cp_id']]);
$currentBalance = (double)($customer[0]['balance']);
$previousPendingAmount = (double)($customerSales[0]['pending_amount']);
$newPendingAmount = (double)($_POST['pending_amount']);
$receivedAmount = (double)($_POST['recevied_amount']);
if ($newPendingAmount != $previousPendingAmount) {
    $balanceAdjustment = $newPendingAmount - $previousPendingAmount;
    $blnc = $currentBalance + $balanceAdjustment;
    $pdo->update("customers", ["id" => $customerSales[0]['customer_name'], 'company_profile_id' => $_SESSION['ovalfox_pos_cp_id']], ["balance" => $blnc]);
}

if ($receivedAmount > $newPendingAmount) {
    $balanceAdjustment = $newPendingAmount - $previousPendingAmount;
    $blnc = $currentBalance + $balanceAdjustment;
    $newBalance = $blnc - (double)$_POST['returned_amount'];
    $pdo->update("customers", ["id" => $customerSales[0]['customer_name'], 'company_profile_id' => $_SESSION['ovalfox_pos_cp_id']], ["balance" => $newBalance]);
}

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


if (isset($_POST['isEdit']) && $_POST['isEdit'] == "false") {

    $pdo->update("sales_2", ['invoice_number' => $_POST['invoice_number'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']], ['discount' => 
    $_POST['discount_in_amount'],
    'date' => $date,
    "booker_name" => $booker,
    'previous_blnce' => empty($customerInvMinus) ? 0 : $customerInvMinus[0]['pending_amount'] ,
    'final_amount' => $_POST['final_amount'],'details' => $_POST['details'], 
    'recevied_amount' => $_POST['recevied_amount'], 'returned_amount' => $_POST['returned_amount'], 'pending_amount' => $_POST['pending_amount'],
    "status" => ($_POST['isIncmp'] != "true" ? ($_POST['pending_amount'] == 0 || $_POST['pending_amount'] == "0" ? "Paid" : "Unpaid") : "Incomplete")]);    
}
 else {
    $updatedRow = $pdo->update("sales_2", ['invoice_number' => $_POST['invoice_number'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']], ['discount' => 
    $_POST['discount_in_amount'], 
    'date' => $date,
    "booker_name" => $booker,

    'final_amount' => $_POST['final_amount'],'details' => $_POST['details'], 
    'recevied_amount' => $_POST['recevied_amount'], 'returned_amount' => $_POST['returned_amount'], 'pending_amount' => $_POST['pending_amount'],
    "status" => ($_POST['isIncmp'] != "true" ? ($_POST['pending_amount'] == 0 || $_POST['pending_amount'] == "0" ? "Paid" : "Unpaid") : "Incomplete")]);


    $row = $pdo->read("sales_2", ['id' => $updatedRow]);
    $pdo->update("sales_2", ['invoice_number' => $customerInvPlus[0]['invoice_number'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']], [
    'previous_blnce' => $row[0]['pending_amount'],     
    "booker_name" => $booker, 

]); 
}








