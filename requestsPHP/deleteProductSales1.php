<?php
session_start();
require_once '../assets/includes/pdo.php';

$salesId = $_POST['salesId'];
$companyProfileId = $_SESSION['ovalfox_pos_cp_id'];

$pr = $pdo->read("sales_1", ['id' => $salesId, 'company_profile_id' => $companyProfileId]);
if (empty($pr)) {
    echo json_encode(['error' => 'Sales record not found']);
    exit;
}

$invoiceNumber = $pr[0]['invoice_number'];
$totalAmount = intval($pr[0]['grand_total']);

$sl2 = $pdo->read("sales_2", ['invoice_number' => $invoiceNumber]);
if (empty($sl2)) {
    echo json_encode(['error' => 'Sales invoice not found']);
    exit;
}

$totalAmount2 = intval($sl2[0]['total_amount']);
$discount = intval($sl2[0]['discount']);
$receivedAmount = intval($sl2[0]['recevied_amount']);

$totalAmountMinus = max(0, $totalAmount2 - $totalAmount);
$finalAmountMinus = max(0, $totalAmountMinus - $discount);
$pendingAmountMinus = max(0, $finalAmountMinus - $receivedAmount);

$productData = ['totalAmount' => $totalAmount];
echo json_encode($productData);

$pdo->customQuery("
    UPDATE sales_2 
    SET 
        total_amount = $totalAmountMinus,
        final_amount = $finalAmountMinus,
        pending_amount =  $pendingAmountMinus
    WHERE 
        company_profile_id = $companyProfileId
        AND invoice_number = $invoiceNumber
");

// Delete the sales_1 record
$pdo->customQuery("
    DELETE FROM sales_1 
    WHERE id = $salesId
    AND company_profile_id = $companyProfileId
");

// Update customer balance if applicable
if (!empty($sl2)) {
    $balanceUpdate = (double)$totalAmount - (double)$receivedAmount;
    $pdo->customQuery("
        UPDATE customers 
        SET balance = balance - $balanceUpdate 
        WHERE id = {$sl2[0]['customer_name']}
    ");
}
?>
