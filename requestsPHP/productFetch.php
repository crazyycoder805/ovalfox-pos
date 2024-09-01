<?php
session_start();
require_once '../assets/includes/pdo.php';

$invoiceNumber = $_POST['invoice_number'];
$companyProfileId = $_SESSION['ovalfox_pos_cp_id'];

// Fetch sales_2 record
$sales_2 = $pdo->read("sales_2", [
    'invoice_number' => $invoiceNumber,
    'company_profile_id' => $companyProfileId
]);

$customerName = $sales_2[0]['customer_name'] ?? null;

$customerInvMinus = $pdo->customQuery(" SELECT * FROM sales_2 
    WHERE customer_name = '$customerName'
    AND invoice_number < $invoiceNumber 
    ORDER BY invoice_number DESC 
    LIMIT 1
") ?? [];

$customerInvPlus = $pdo->customQuery(" SELECT * FROM sales_2 
    WHERE customer_name = '$customerName'
    AND invoice_number > $invoiceNumber 
    ORDER BY invoice_number ASC 
    LIMIT 1
") ?? [];

$productsYES = [];
if (isset($_POST['item_name'], $_POST['invoice_number'])) {
    $productsYES = $pdo->customQuery(" SELECT * FROM sales_1 
        WHERE item_name = '{$_POST['item_name']}' 
        AND invoice_number < $invoiceNumber
        AND customer_name = {$_POST['customer_name']} 
        ORDER BY id DESC 
        LIMIT 1
    ") ?? [];
}

$sales_1 = $pdo->customQuery(" SELECT * FROM sales_1 
    WHERE invoice_number = $invoiceNumber 
    AND company_profile_id = $companyProfileId 
    ORDER BY id DESC
");

$all_over_qty = array_sum(array_column($sales_1, 'quantity'));
$amountGrand = array_sum(array_column($sales_1, 'grand_total'));

$html = "";
foreach ($sales_1 as $key => $sale) {
    $key += 1;
    $gt = !empty($sale['grand_total']) ? $sale['grand_total'] : $sale['amount'];
    $isEditable = !preg_match('/\(Refunded\)/', $sale['item_name']) && !preg_match('/\(Free Item\)/', $sale['item_name']) ? "contenteditable='true'" : "";
    $previousPrice = isset($_POST['item_name'], $_POST['invoice_number']) ? (!empty($productsYES) ? $productsYES[0]['item_price'] : 0) : "";

    $html .= "
    <tr>
        <td style='font-size: 21px !important;font-weight:bolder;' id='itemMainKey_{$sale['id']}'>{$key}</td>
        <td style='font-size: 13px !important;font-weight:bolder;' id='item_codeTabledData{$sale['id']}'>{$sale['item_code']}</td>
        <td style='width:400px;font-size: 13px !important;font-weight:bolder;' id='item_nameTabledData{$sale['id']}'>
            {$sale['item_name']}
            <span> (<b style='background-color:yellow;'>{$previousPrice}</b>)</span>
        </td>
        <td style='font-size: 13px !important;font-weight:bolder;' id='quantityTabledData{$sale['id']}' {$isEditable}>{$sale['quantity']}</td>
        <td style='font-size: 13px !important;font-weight:bolder;' id='item_priceTabledData{$sale['id']}' {$isEditable}>{$sale['item_price']}</td>
        <td style='font-size: 13px !important;font-weight:bolder;' id='amountTabledData{$sale['id']}'>".round($sale['amount'], 2)."</td>
        <td style='font-size: 13px !important;font-weight:bolder;' id='discountTabledData{$sale['id']}'>{$sale['discount']}</td>
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

$data = [
    $html, 
    count($sales_1), 
    $all_over_qty, 
    $amountGrand, 
    $_POST['updatedRowId'] ?? 0, 
    $customerInvMinus[0]['pending_amount'] ?? 0
];

echo json_encode($data);
?>
