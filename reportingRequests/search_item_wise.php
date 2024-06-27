<?php

session_start();
require_once '../assets/includes/pdo.php';

$sales_1 = [];


$total_quantity = [];
    $total_amount = [];
    $grand_total = [];

if (!empty($_POST['start_date']) && !empty($_POST['end_date']) && !empty($_POST['booker_name']) && !empty($_POST['customer_name']) && !empty($_POST['product_name'])) {
    $sales_1 = $pdo->customQuery("SELECT * FROM sales_1 WHERE Date(date) BETWEEN '{$_POST['start_date']}' AND '{$_POST['end_date']}' AND company_profile_id = '{$_SESSION['ovalfox_pos_cp_id']}' AND customer_name = '{$_POST['customer_name']}' AND item_code = '{$_POST['product_name']}' AND booker_name = '{$_POST['booker_name']}'");
} else if (!empty($_POST['start_date']) && !empty($_POST['booker_name']) && !empty($_POST['customer_name']) && !empty($_POST['product_name'])) {
    $sales_1 = $pdo->customQuery("SELECT * FROM sales_1 WHERE Date(date) = '{$_POST['start_date']}' AND company_profile_id = '{$_SESSION['ovalfox_pos_cp_id']}' AND customer_name = '{$_POST['customer_name']}' AND item_code = '{$_POST['product_name']}' AND booker_name = '{$_POST['booker_name']}'");
} else if (!empty($_POST['start_date']) && !empty($_POST['end_date']) && !empty($_POST['customer_name']) && !empty($_POST['product_name'])) {
    $sales_1 = $pdo->customQuery("SELECT * FROM sales_1 WHERE Date(date) BETWEEN '{$_POST['start_date']}' AND '{$_POST['end_date']}' AND company_profile_id = '{$_SESSION['ovalfox_pos_cp_id']}' AND item_code = '{$_POST['product_name']}' AND customer_name = '{$_POST['customer_name']}'");
} else if (!empty($_POST['start_date']) && !empty($_POST['customer_name'])) {
    $sales_1 = $pdo->customQuery("SELECT * FROM sales_1 WHERE Date(date) = '{$_POST['start_date']}' AND company_profile_id = '{$_SESSION['ovalfox_pos_cp_id']}' AND item_code = '{$_POST['product_name']}' AND customer_name = '{$_POST['customer_name']}'");
} else if (!empty($_POST['start_date']) && !empty($_POST['end_date']) && !empty($_POST['booker_name']) && !empty($_POST['product_name'])) {
    $sales_1 = $pdo->customQuery("SELECT * FROM sales_1 WHERE Date(date) BETWEEN '{$_POST['start_date']}' AND '{$_POST['end_date']}' AND company_profile_id = '{$_SESSION['ovalfox_pos_cp_id']}' AND item_code = '{$_POST['product_name']}' AND booker_name = '{$_POST['booker_name']}'");
} else if (!empty($_POST['start_date']) && !empty($_POST['booker_name']) && !empty($_POST['product_name'])) {
    $sales_1 = $pdo->customQuery("SELECT * FROM sales_1 WHERE Date(date) = '{$_POST['start_date']}' AND company_profile_id = '{$_SESSION['ovalfox_pos_cp_id']}' AND item_code = '{$_POST['product_name']}' AND booker_name = '{$_POST['booker_name']}'");
} else if (!empty($_POST['booker_name']) && !empty($_POST['customer_name']) && !empty($_POST['product_name'])) {
    $sales_1 = $pdo->customQuery("SELECT * FROM sales_1 WHERE company_profile_id = '{$_SESSION['ovalfox_pos_cp_id']}' AND customer_name = '{$_POST['customer_name']}' AND item_code = '{$_POST['product_name']}' AND booker_name = '{$_POST['booker_name']}'");
} else if (!empty($_POST['booker_name']) && !empty($_POST['product_name'])) {
    $sales_1 = $pdo->customQuery("SELECT * FROM sales_1 WHERE company_profile_id = '{$_SESSION['ovalfox_pos_cp_id']}' AND item_code = '{$_POST['product_name']}' AND booker_name = '{$_POST['booker_name']}'");
} else if (!empty($_POST['customer_name']) && !empty($_POST['product_name'])) {
    $sales_1 = $pdo->customQuery("SELECT * FROM sales_1 WHERE company_profile_id = '{$_SESSION['ovalfox_pos_cp_id']}' AND item_code = '{$_POST['product_name']}' AND customer_name = '{$_POST['customer_name']}'");
} else if (!empty($_POST['start_date']) && !empty($_POST['end_date']) && !empty($_POST['product_name'])) {
    $sales_1 = $pdo->customQuery("SELECT * FROM sales_1 WHERE Date(date) BETWEEN '{$_POST['start_date']}' AND '{$_POST['end_date']}' AND item_code = '{$_POST['product_name']}' AND  company_profile_id = '{$_SESSION['ovalfox_pos_cp_id']}'");
} else if (!empty($_POST['start_date']) && !empty($_POST['product_name'])) {
    $sales_1 = $pdo->customQuery("SELECT * FROM sales_1 WHERE Date(date) = '{$_POST['start_date']}' AND item_code = '{$_POST['product_name']}'");
}
foreach ($sales_1 as $sale) {
    $total_quantity[] = $sale['quantity'];
    $total_amount[] = $sale['amount'];
    $grand_total[] = $sale['grand_total'];

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

        <th>Item code</th>
        <th>Item name</th>
        <th>Item price</th>
        <th>Qty</th>
        <th>Amount</th>
        <th>Discount</th>
        <th>Extra Discount</th>
        <th>Percentage</th>
        <th>Grand Total</th>

        <!-- <th>Total price</th>
        <th>My rate</th>

        <th>%</th>
        <th>Total amount</th>
        <th>Commision</th> -->
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

        <!-- <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td> -->

    </tr>";
    }

    $total_quantity = array_sum($total_quantity);
    $total_amount = array_sum($total_amount);
    $grand_total = array_sum($grand_total);
    
$html .= "</tbody>

</table>

<br /><br /><br />

<div style='display: flex;'>
    <h6>Total Quantity: $total_quantity</h6>
    &nbsp;&nbsp;&nbsp;<h6>Total Amount: $total_amount</h6>
    &nbsp;&nbsp;&nbsp;<h6>Grand Total: $grand_total</h6>

</div>";

echo json_encode([$html, $sales_1]);



