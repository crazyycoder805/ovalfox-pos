<?php
session_start();
require_once '../assets/includes/pdo.php';

$pdouctId = $pdo->read("products", ["id" => $_POST['productId'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']]);


$pdo->create("sales_1", ['invoice_number' => $_POST['invoice_number'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id'], 'customer_name' => $_POST['customer_name'], 'booker_name' => $_POST['booker_name'], 'operator_name' => $_POST['booker_name'], 'date' => $_POST['date'], 'item_code' => "(Refunded)" . $_POST['item_code'], 'item_name' => $_POST['item_name'], 'item_price' => $_POST['item_price'], 'quantity' => $_POST['quantity'], 'amount' => $_POST['amount'], 'discount' => $_POST['discount'], 'extra_discount' => $_POST['extra_discount']]);
