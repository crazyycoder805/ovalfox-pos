<?php
session_start();
require_once '../assets/includes/pdo.php';

$invoiceNumber = $_POST['in'];
$companyProfileId = $_SESSION['ovalfox_pos_cp_id'];

$sales_1 = $pdo->customQuery("SELECT * FROM sales_1 
    WHERE invoice_number = $invoiceNumber 
    AND company_profile_id = $companyProfileId 
    ORDER BY id DESC
");

$sales_2 = $pdo->read("sales_2", [
    'invoice_number' => $invoiceNumber,
    'company_profile_id' => $companyProfileId
]);

$customerName = $sales_2[0]['customer_name'] ?? null;

$customerInvMinus = $pdo->customQuery("
    SELECT * FROM sales_2 
    WHERE customer_name = $customerName 
    AND invoice_number < $invoiceNumber 
    AND company_profile_id = $companyProfileId 
    ORDER BY invoice_number DESC 
    LIMIT 1
") ?? [];

$customerInvPlus = $pdo->customQuery("
    SELECT * FROM sales_2 
    WHERE customer_name = $customerName 
    AND invoice_number > $invoiceNumber 
    AND company_profile_id = $companyProfileId 
    ORDER BY invoice_number ASC 
    LIMIT 1
") ?? [];

$all_over_qty = 0;
$isRefunded = false;

foreach ($sales_1 as $ss) {
    if (preg_match('/\(Refunded\)/', $ss['item_name'])) {
        $isRefunded = true;
    }
    $all_over_qty += $ss['quantity'];
}

$html = "";

foreach ($sales_1 as $key => $sale) {
    $key += 1;
    $gt = $sale['grand_total'] ?? $sale['amount'];
    $isEditable = !preg_match('/\(Refunded\)|\(Free Item\)/', $sale['item_name']) ? "contenteditable='true'" : "";

    $html .= "
    <tr>
        <td style='font-size: 21px !important;font-weight:bolder;'>{$key}</td>
        <td style='font-size: 13px !important;font-weight:bolder;' id='item_codeTabledData{$sale['id']}'>{$sale['item_code']}</td>
        <td style='width:400px;font-size: 13px !important;font-weight:bolder;' id='item_nameTabledData{$sale['id']}'>{$sale['item_name']}</td>
        <td style='font-size: 13px !important;font-weight:bolder;' id='quantityTabledData{$sale['id']}' {$isEditable}>{$sale['quantity']}</td>
        <td style='font-size: 13px !important;font-weight:bolder;' id='item_priceTabledData{$sale['id']}' {$isEditable}>{$sale['item_price']}</td>
        <td style='font-size: 13px !important;font-weight:bolder;' id='amountTabledData{$sale['id']}'>".round($sale['amount'], 2)."</td>
        <td style='font-size: 13px !important;font-weight:bolder;' id='discountTabledData{$sale['id']}'>".round($sale['discount'], 2)."</td>
        <td style='font-size: 13px !important;font-weight:bolder;' id='extra_discountTabledData{$sale['id']}' {$isEditable}>{$sale['extra_discount']}</td>
        <td style='font-size: 13px !important;font-weight:bolder;' id='percentageTabledData{$sale['id']}' {$isEditable}>{$sale['percentage']}</td>
        <td style='font-size: 13px !important;font-weight:bolder;' id='grandTotalTabledData{$sale['id']}'>{$gt}</td>
        <td style='font-size: 13px !important;font-weight:bolder;'>
            <div style='position: relative;' class='container-cus'>
                <div style='position: absolute; top: 0; left: 0; width: 100%; height: 100%; color: red; text-align: center; background-color: rgba(0, 0, 0, 1);' class='overlay-cus'>
                    LOCKED
                </div>
                <div class='content-cus'>
                    <button class='sales-btn-remove btn-sm' value='{$sale['id']}' id='removeItem'>Remove</button>
                </div>
            </div>
        </td>
    </tr>";
}

// Prepare product data for JSON response
$productData = [
    $html, 
    $sales_2, 
    count($sales_1), 
    $all_over_qty, 
    $isRefunded, 
    $customerInvMinus[0]['pending_amount'] ?? 0
];

echo json_encode($productData);
?>
