<?php

session_start();
require_once '../assets/includes/pdo.php';

$sales_1 = [];
$total_quantity = $total_amount = $grand_total = 0;


$query = "SELECT * FROM sales_1 WHERE company_profile_id = {$_SESSION['ovalfox_pos_cp_id']}";

if (!empty($_POST['start_date'])) {
    $query .= " AND Date(date) = {$_POST['start_date']}";
    if (!empty($_POST['end_date'])) {
        $query .= " AND Date(date) BETWEEN {$_POST['start_date']} AND {$_POST['end_date']}";
    }
}

if (!empty($_POST['customer_name'])) {
    $query .= " AND customer_name = {$_POST['customer_name']}";
}

if (!empty($_POST['booker_name'])) {
    $query .= " AND booker_name = {$_POST['booker_name']}";
}

if (!empty($_POST['product_name'])) {
    $query .= " AND item_code = {$_POST['product_name']}";
}

$sales_1 = $pdo->customQuery($query);

foreach ($sales_1 as $sale) {
    $total_quantity += $sale['quantity'];
    $total_amount += $sale['amount'];
    $grand_total += $sale['grand_total'];
}

$html = "
<table id='search_table' class='table table-striped table-bordered dt-responsive'>
    <thead>
        <tr>
            <th>#</th>
            <th>Inv.</th>
            <th>Customer Name</th>
            <th>Booker Name</th>
            <th>Operator Name</th>
            <th>Date</th>
            <th>Item Code</th>
            <th>Item Name</th>
            <th>Item Price</th>
            <th>Qty</th>
            <th>Amount</th>
            <th>Discount</th>
            <th>Extra Discount</th>
            <th>Percentage</th>
            <th>Grand Total</th>
        </tr>
    </thead>
    <tbody>";

foreach ($sales_1 as $sale_1) {
    $customer = $pdo->read("customers", ['id' => $sale_1['customer_name']]);
    $booker_name = $pdo->read("access", ['id' => $sale_1['booker_name']]);
    $operator = $pdo->read("access", ['id' => $sale_1['operator_name']]);

    $html .= "<tr>
        <td>#</td>
        <td>{$sale_1['invoice_number']}</td>
        <td>{$customer[0]['name']}</td>
        <td>{$booker_name[0]['username']}</td>
        <td>{$operator[0]['username']}</td>
        <td>{$sale_1['date']}</td>
        <td>{$sale_1['item_code']}</td>
        <td>{$sale_1['item_name']}</td>
        <td>{$sale_1['item_price']}</td>
        <td>{$sale_1['quantity']}</td>
        <td>{$sale_1['amount']}</td>
        <td>{$sale_1['discount']}</td>
        <td>{$sale_1['extra_discount']}</td>
        <td>{$sale_1['percentage']}</td>
        <td>{$sale_1['grand_total']}</td>
    </tr>";
}

$html .= "</tbody></table>
<br /><br /><br />
<div style='display: flex;'>
    <h6>Total Quantity: $total_quantity</h6>
    &nbsp;&nbsp;&nbsp;<h6>Total Amount: $total_amount</h6>
    &nbsp;&nbsp;&nbsp;<h6>Grand Total: $grand_total</h6>
</div>";

echo json_encode([$html, $sales_1]);
