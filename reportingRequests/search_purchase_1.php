<?php

session_start();
require_once '../assets/includes/pdo.php';

$purchases_1 = "";
    $html = "";
    if (!empty($_POST['start_date']) && !empty($_POST['end_date'])) {
        $purchases_1 = $pdo->customQuery("SELECT * FROM purchases_1 WHERE Date(date) BETWEEN '{$_POST['start_date']}' AND '{$_POST['end_date']}' AND company_profile_id = {$_SESSION['ovalfox_pos_cp_id']}");
    } else if (!empty($_POST['start_date']) && !empty($_POST['supplier'])) {
        $purchases_1 = $pdo->customQuery("SELECT * FROM purchases_1 WHERE Date(date) = '{$_POST['start_date']}' AND company_name = '{$_POST['supplier']}' AND company_profile_id = {$_SESSION['ovalfox_pos_cp_id']}");

    } else if (!empty($_POST['start_date']) && !empty($_POST['end_date']) && !empty($_POST['supplier'])) {
        $purchases_1 = $pdo->customQuery("SELECT * FROM purchases_1 WHERE Date(date) BETWEEN '{$_POST['start_date']}' AND '{$_POST['end_date']}' AND company_name = '{$_POST['supplier']}' AND company_profile_id = {$_SESSION['ovalfox_pos_cp_id']}");

    } else if (!empty($_POST['start_date'])) {
        $purchases_1 = $pdo->customQuery("SELECT * FROM purchases_1 WHERE Date(date) = '{$_POST['start_date']}' AND company_profile_id = {$_SESSION['ovalfox_pos_cp_id']}");

    }

    $html = "
    <table id='search_table' class='table table-striped table-bordered dt-responsive'>
    <thead>
        <tr>
            <th>#</th>
            <th>Order number</th>
            <th>Bill number</th>

            <th>Date</th>
            <th>Operator</th>
            <th>Company name</th>
            <th>Item code</th>
            <th>Item name</th>

            <th>Item price</th>
            <th>Quantity</th>
            <th>Total amount</th>
            <th>Discount</th>
            <th>Net amount</th>
            <th>Product expiry</th>

        </tr>
    </thead>
    <tbody>";
foreach ($purchases_1 as $purchase_1) {

        $html .= "<tr>
            <td>#</td>
            <td>{$purchase_1['order_number']}</td>
            <td>{$purchase_1['bill_number']}</td>

            <td>{$purchase_1['date']}</td>
            <td>{$purchase_1['operator']}</td>
            <td>{$purchase_1['company_name']}</td>
            <td>{$purchase_1['item_code']}</td>
            <td>{$purchase_1['item_name']}</td>

            <td>{$purchase_1['item_price']}</td>
            <td>{$purchase_1['quantity']}</td>
            <td>{$purchase_1['total_amount']}</td>
            <td>{$purchase_1['discount']}</td>
            <td>{$purchase_1['net_amount']}</td>
            <td>{$purchase_1['product_expiry']}</td>

        </tr>";
        }
        $html .= "

    </tbody>

</table>
    ";
    echo json_encode([$html, $purchases_1]);
