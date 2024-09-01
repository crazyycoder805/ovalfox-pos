<?php
session_start();
require_once '../assets/includes/pdo.php';

$productId = $_POST['productId'] ?? null;
$invoiceNumber = $_POST['invoice_number'] ?? null;
$companyProfileId = $_SESSION['ovalfox_pos_cp_id'] ?? null;
$customerName = $_POST['customer_name'] ?? null;
$bookerName = $_POST['booker_name'] ?? null;
$date = $_POST['date'] ?? null;
$itemCode = $_POST['item_code'] ?? null;
$itemName = $_POST['item_name'] ?? null;
$itemPrice = $_POST['item_price'] ?? null;
$quantity = $_POST['quantity'] ?? null;
$amount = $_POST['amount'] ?? null;
$discount = $_POST['discount'] ?? null;
$extraDiscount = $_POST['extra_discount'] ?? null;

// Validate inputs
if (!$productId || !$invoiceNumber || !$companyProfileId || !$customerName || !$bookerName || !$date || !$itemCode || !$itemName || !$itemPrice || !$quantity || !$amount || !$discount || !$extraDiscount) {
    die('Invalid input');
}

// Read product details
$productDetails = $pdo->read('products', [
    'id' => $productId,
    'company_profile_id' => $companyProfileId
]);

// Create sales entry
$salesData = [
    'invoice_number' => $invoiceNumber,
    'company_profile_id' => $companyProfileId,
    'customer_name' => $customerName,
    'booker_name' => $bookerName,
    'operator_name' => $bookerName,
    'date' => $date,
    'item_code' => "(Refunded)$itemCode",
    'item_name' => $itemName,
    'item_price' => $itemPrice,
    'quantity' => $quantity,
    'amount' => $amount,
    'discount' => $discount,
    'extra_discount' => $extraDiscount
];

$pdo->create('sales_1', $salesData);
