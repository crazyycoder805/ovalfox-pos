<?php

session_start();
require_once '../assets/includes/pdo.php';

$sales_2 = ""; 
    $html = "";

    if (!empty($_POST['start_date']) && !empty($_POST['end_date']) && !empty($_POST['booker_name']) && !empty($_POST['customer_name'])) {
        $sales_2 = $pdo->customQuery("SELECT * FROM sales_2 WHERE Date(date) BETWEEN '{$_POST['start_date']}' AND '{$_POST['end_date']}' AND company_profile_id = '{$_SESSION['ovalfox_pos_cp_id']}' AND customer_name = '{$_POST['customer_name']}' AND booker_name = '{$_POST['booker_name']}'");
    } else if (!empty($_POST['start_date']) && !empty($_POST['booker_name']) && !empty($_POST['customer_name'])) {
        $sales_2 = $pdo->customQuery("SELECT * FROM sales_2 WHERE Date(date) = '{$_POST['start_date']}' AND company_profile_id = '{$_SESSION['ovalfox_pos_cp_id']}' AND customer_name = '{$_POST['customer_name']}' AND booker_name = '{$_POST['booker_name']}'");
    } else if (!empty($_POST['start_date']) && !empty($_POST['end_date']) && !empty($_POST['customer_name'])) {
        $sales_2 = $pdo->customQuery("SELECT * FROM sales_2 WHERE Date(date) BETWEEN '{$_POST['start_date']}' AND '{$_POST['end_date']}' AND company_profile_id = '{$_SESSION['ovalfox_pos_cp_id']}' AND customer_name = '{$_POST['customer_name']}'");
    } else if (!empty($_POST['start_date']) && !empty($_POST['customer_name'])) {
        $sales_2 = $pdo->customQuery("SELECT * FROM sales_2 WHERE Date(date) = '{$_POST['start_date']}' AND company_profile_id = '{$_SESSION['ovalfox_pos_cp_id']}' AND customer_name = '{$_POST['customer_name']}'");
    } else if (!empty($_POST['start_date']) && !empty($_POST['end_date']) && !empty($_POST['booker_name'])) {
        $sales_2 = $pdo->customQuery("SELECT * FROM sales_2 WHERE Date(date) BETWEEN '{$_POST['start_date']}' AND '{$_POST['end_date']}' AND company_profile_id = '{$_SESSION['ovalfox_pos_cp_id']}' AND booker_name = '{$_POST['booker_name']}'");
    } else if (!empty($_POST['start_date']) && !empty($_POST['booker_name'])) {
        $sales_2 = $pdo->customQuery("SELECT * FROM sales_2 WHERE Date(date) = '{$_POST['start_date']}' AND company_profile_id = '{$_SESSION['ovalfox_pos_cp_id']}' AND booker_name = '{$_POST['booker_name']}'");
    } else if (!empty($_POST['booker_name']) && !empty($_POST['customer_name'])) {
        $sales_2 = $pdo->customQuery("SELECT * FROM sales_2 WHERE company_profile_id = '{$_SESSION['ovalfox_pos_cp_id']}' AND customer_name = '{$_POST['customer_name']}' AND booker_name = '{$_POST['booker_name']}'");
    } else if (!empty($_POST['booker_name'])) {
        $sales_2 = $pdo->customQuery("SELECT * FROM sales_2 WHERE company_profile_id = '{$_SESSION['ovalfox_pos_cp_id']}' AND booker_name = '{$_POST['booker_name']}'");
    } else if (!empty($_POST['customer_name'])) {
        $sales_2 = $pdo->customQuery("SELECT * FROM sales_2 WHERE company_profile_id = '{$_SESSION['ovalfox_pos_cp_id']}' AND customer_name = '{$_POST['customer_name']}'");
    } else if (!empty($_POST['start_date']) && !empty($_POST['end_date'])) {
        $sales_2 = $pdo->customQuery("SELECT * FROM sales_2 WHERE Date(date) BETWEEN '{$_POST['start_date']}' AND '{$_POST['end_date']}' AND company_profile_id = '{$_SESSION['ovalfox_pos_cp_id']}'");
    } else if (!empty($_POST['start_date'])) {
        $sales_2 = $pdo->customQuery("SELECT * FROM sales_2 WHERE Date(date) = '{$_POST['start_date']}'");
    }
    $html = "
    <table id='search_table' class='table table-striped table-bordered dt-responsive'>
    <thead>
        <tr>
            <th>#</th>
            <th>Invoice number</th>
            <th>Bill number</th>

            <th>Customer name</th>
            <th>Booker name</th>
            <th>Operator name</th>
            <th>Date</th>
            <th>Total amount</th>

            <th>Discount</th>
            <th>Final amount</th>
            <th>Received amount</th>
            <th>Returned amount</th>
            <th>Pneding amount</th>
            <th>Status</th>

        </tr>
    </thead>
    <tbody>";
foreach ($sales_2 as $sale_2) {
    $customer = $pdo->read("customers", ['id' => $sale_2['customer_name']]);
    $booker_name = $pdo->read("access", ['id' => $sale_2['booker_name']]);
    $operator = $pdo->read("access", ['id' => $sale_2['operator_name']]);
        $html .= "<tr>
            <td>{$sale_2['id']}</td>
            <td>{$sale_2['invoice_number']}</td>
            <td>{$sale_2['bill_number']}</td>

            <td>{$customer[0]['name']}</td>
            <td>{$booker_name[0]['username']}</td>
            <td>{$operator[0]['username']}</td>
            <td>{$sale_2['date']}</td>
            <td>{$sale_2['total_amount']}</td>

            <td>{$sale_2['discount']}</td>
            <td>{$sale_2['final_amount']}</td>
            <td>{$sale_2['recevied_amount']}</td>
            <td>{$sale_2['returned_amount']}</td>
            <td>{$sale_2['pending_amount']}</td>
            <td>{$sale_2['status']}</td>

        </tr>";
         } 

         $html .= "</tbody>

</table>
    ";
    echo json_encode([$html, $sales_2]);