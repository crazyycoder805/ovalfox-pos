<?php

session_start();
require_once '../assets/includes/pdo.php';



    $sales_1 = "";
    $html = "";
    if (!empty($_POST['start_date']) && !empty($_POST['end_date']) && !empty($_POST['booker_name'])) {
        $sales_1 = $pdo->customQuery("SELECT *, SUM(item_price) AS total_price FROM sales_1 WHERE Date(date) BETWEEN '{$_POST['start_date']}' AND '{$_POST['end_date']}' AND company_profile_id = '{$_SESSION['ovalfox_pos_cp_id']}' AND booker_name = '{$_POST['booker_name']}' GROUP BY item_code");
    } else if (!empty($_POST['start_date']) && !empty($_POST['end_date'])) {
        $sales_1 = $pdo->customQuery("SELECT *, SUM(item_price) AS total_price FROM sales_1 WHERE Date(date) BETWEEN '{$_POST['start_date']}' AND '{$_POST['end_date']}' AND company_profile_id = '{$_SESSION['ovalfox_pos_cp_id']}' GROUP BY item_code");
    } else if (!empty($_POST['start_date']) && !empty($_POST['booker_name'])) {
        $sales_1 = $pdo->customQuery("SELECT *, SUM(item_price) AS total_price FROM sales_1 WHERE Date(date) = '{$_POST['start_date']}' AND company_profile_id = '{$_SESSION['ovalfox_pos_cp_id']}' AND booker_name = '{$_POST['booker_name']}' GROUP BY item_code");
    } else if (!empty($_POST['start_date'])) {
        $sales_1 = $pdo->customQuery("SELECT *, SUM(item_price) AS total_price FROM sales_1 WHERE Date(date) = '{$_POST['start_date']}' AND company_profile_id = '{$_SESSION['ovalfox_pos_cp_id']}' GROUP BY item_code");
    } else if (!empty($_POST['booker_name'])) {
        $sales_1 = $pdo->customQuery("SELECT *, SUM(item_price) AS total_price FROM sales_1 WHERE company_profile_id = '{$_SESSION['ovalfox_pos_cp_id']}' AND booker_name = '{$_POST['booker_name']}' GROUP BY item_code");
    }
    $html = "<table id='search_table' class='table table-striped table-bordered dt-responsive'>
    <thead>
        <tr>
            <th>#</th>
                        <th>Inv</th>
            <th>Customer</th>
            <th>Booker</th>
            <th>Operator</th>
            <th>Date</th>

            <th>Item code</th>
            <th>Item name</th>
            <th>Item price</th>
            <th>Qty</th>
                    <th>Amount</th>
            <th>Discount</th>
            <th>Extra Discount</th>
            <th>%</th>
            <th>Grand Total</th>


    </thead>
    <tbody>";
         
foreach ($sales_1 as $sale_1) {
    $customer = $pdo->read("customers", ['id' => $sale_1['customer_name']]);
    $booker_name = $pdo->read("access", ['id' => $sale_1['booker_name']]);
    $operator = $pdo->read("access", ['id' => $sale_1['operator_name']]);
        $html .= "<tr>
            <td>{$sale_1['id']}</td>
                        <td>{$sale_1['invoice_number']}</td>
            <td>{$customer[0]['name']}</td>
            <td>{$booker_name[0]['username']}</td>
            <td>{$operator[0]['username']}</td>
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
    $html .= "</tbody>

</table>";
    echo json_encode([$html, $sales_1]);
    
        
