<?php
session_start();
require_once '../assets/includes/pdo.php';

// Retrieve and decode input data
$array = json_decode($_POST['target'], true);
$keys = array_keys($array);
$key = preg_replace('/TabledData\d+/', '', trim($keys[0]));
preg_match('/\d+$/', trim($keys[0]), $matches);
$id = $matches[0];
$value = array_values($array)[0]; // Get the updated value

// Ensure company profile ID is set
$companyProfileId = $_SESSION['ovalfox_pos_cp_id'] ?? null;
if (!$companyProfileId) {
    die('Company profile ID is not set.');
}

function updateSales($pdo, $id, $companyProfileId, $updates) {
    $pdo->update("sales_1", ['id' => $id, 'company_profile_id' => $companyProfileId], $updates);
}

function calculateTotals($pdo, $invoiceNumber, $companyProfileId) {
    $sales = $pdo->read("sales_1", ['invoice_number' => $invoiceNumber, 'company_profile_id' => $companyProfileId]);
    return array_sum(array_column($sales, 'grand_total'));
}

function updateSalesTotalAmount($pdo, $invoiceNumber, $totalAmount) {
    $pdo->customQuery("UPDATE sales_2 SET total_amount = $totalAmount, final_amount = $totalAmount - discount WHERE invoice_number = $invoiceNumber");
}

$selectedItem = $pdo->read("sales_1", ['id' => $id, 'company_profile_id' => $companyProfileId])[0] ?? null;
if (!$selectedItem) {
    die('Selected item not found.');
}

if ($key == "quantity") {
    $product = $pdo->read("products", ['item_code' => $selectedItem['item_code']])[0] ?? null;
    if (!$product) {
        die('Product not found.');
    }

    $discount = round(($value * $selectedItem['item_price']) * (1 - ($selectedItem['percentage'] / 100)), 2);
    $percentage = round((($value * $selectedItem['item_price']) - $discount) / ($value * $selectedItem['item_price']) * 100, 2);

    $newQuantity = min($value, $product['total_quantity']);
    updateSales($pdo, $id, $companyProfileId, [
        'grand_total' => $discount - $selectedItem['extra_discount'],
        'amount' => $value * $selectedItem['item_price'],
        'discount' => $selectedItem['percentage'] == 0 ? 0 : ($value * $selectedItem['item_price']) - $discount,
        'percentage' => $selectedItem['percentage'] == 0 ? 0 : $percentage,
        'quantity' => $newQuantity
    ]);

} else if ($key == "discount") {
    // Uncomment and implement logic if needed
    // ...

} else if ($key == "extra_discount") {
    updateSales($pdo, $id, $companyProfileId, [
        'grand_total' => ($selectedItem['quantity'] * $selectedItem['item_price'] - $selectedItem['discount']) - $value,
        'extra_discount' => $value
    ]);

} else if ($key == "percentage") {
    $discount = round(($selectedItem['quantity'] * $selectedItem['item_price']) * (1 - ($value / 100)), 2);
    updateSales($pdo, $id, $companyProfileId, [
        'discount' => $value == 0 ? 0 : ($selectedItem['quantity'] * $selectedItem['item_price']) - $discount,
        'grand_total' => $value == 0 ? ($selectedItem['quantity'] * $selectedItem['item_price']) - $selectedItem['extra_discount'] : $discount - $selectedItem['extra_discount'],
        'percentage' => round($value, 2)
    ]);

} else if ($key == "item_price") {
    $discount = round(($selectedItem['quantity'] * $value) * (1 - ($selectedItem['percentage'] / 100)), 2);
    $percentage = round((($selectedItem['quantity'] * $value) - $discount) / ($selectedItem['quantity'] * $value) * 100, 2);
    updateSales($pdo, $id, $companyProfileId, [
        'grand_total' => $discount - $selectedItem['extra_discount'],
        'amount' => $selectedItem['quantity'] * $value,
        'discount' => $selectedItem['percentage'] == 0 ? 0 : ($selectedItem['quantity'] * $value) - $discount,
        'percentage' => $selectedItem['percentage'] == 0 ? 0 : $percentage,
        'item_price' => $value
    ]);
}

$totalAmount = calculateTotals($pdo, $_POST['invoice_number'], $companyProfileId);
updateSalesTotalAmount($pdo, $_POST['invoice_number'], $totalAmount);

echo json_encode([$selectedItem['id'] ?? null]);
