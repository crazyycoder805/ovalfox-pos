<?php

session_start();
require_once '../assets/includes/pdo.php';


// Build the query
$query = "SELECT item_code, item_name, SUM(item_price) AS total_price, 
          SUM(quantity) AS quantity, SUM(amount) AS amount, 
          SUM(discount) AS discount, SUM(extra_discount) AS extra_discount, 
          SUM(percentage) AS percentage, SUM(grand_total) AS grand_total 
          FROM sales_1 
          WHERE company_profile_id = {$_SESSION['ovalfox_pos_cp_id']}";

// Add conditions based on POST data
if (!empty($_POST['start_date'])) {
    $query .= " AND Date(date) = {$_POST['start_date']}";
    

    if (!empty($_POST['end_date'])) {
        $query .= " AND Date(date) BETWEEN {$_POST['start_date']} AND {$_POST['end_date']}";
    }
}

if (!empty($_POST['booker_name'])) {
    $query .= " AND booker_name = {$_POST['booker_name']}";
}

$query .= " GROUP BY item_code";

$sales_1 = $pdo->customQuery($query);

$html = "<table id='search_table' class='table table-striped table-bordered dt-responsive'>
    <thead>
        <tr>
            <th>#</th>
            <th>Inv</th>
            <th>Customer</th>
            <th>Booker</th>
            <th>Operator</th>
            <th>Date</th>
            <th>Item Code</th>
            <th>Item Name</th>
            <th>Item Price</th>
            <th>Qty</th>
            <th>Amount</th>
            <th>Discount</th>
            <th>Extra Discount</th>
            <th>%</th>
            <th>Grand Total</th>
        </tr>
    </thead>
    <tbody>";

foreach ($sales_1 as $sale_1) {
    $customer = $pdo->read("customers", ['id' => $sale_1['customer_name']])[0] ?? [];
    $booker_name = $pdo->read("access", ['id' => $sale_1['booker_name']])[0] ?? [];
    $operator = $pdo->read("access", ['id' => $sale_1['operator_name']])[0] ?? [];

    $html .= "<tr>
        <td>{$sale_1['id']}</td>
        <td>{$sale_1['invoice_number']}</td>
        <td>" . htmlspecialchars($customer['name'] ?? 'N/A') . "</td>
        <td>" . htmlspecialchars($booker_name['username'] ?? 'N/A') . "</td>
        <td>" . htmlspecialchars($operator['username'] ?? 'N/A') . "</td>
        <td>{$sale_1['date']}</td>
        <td>{$sale_1['item_code']}</td>
        <td>{$sale_1['item_name']}</td>
        <td>{$sale_1['total_price']}</td>
        <td>{$sale_1['quantity']}</td>
        <td>{$sale_1['amount']}</td>
        <td>{$sale_1['discount']}</td>
        <td>{$sale_1['extra_discount']}</td>
        <td>{$sale_1['percentage']}</td>
        <td>{$sale_1['grand_total']}</td>
    </tr>";
}

$html .= "</tbody></table>";

// Output the result
echo json_encode([$html, $sales_1]);

?>
