<?php
session_start();
require_once '../assets/includes/pdo.php';

// Initialize HTML variable
$html = "";

// Fetch customer sales data
$customerSales2 = $pdo->customQuery(
    "SELECT * FROM sales_2 WHERE customer_name = {$_POST['cusId']} AND company_profile_id = {$_SESSION['ovalfox_pos_cp_id']} ORDER BY id DESC"
);
// Iterate over each sale record
foreach ($customerSales2 as $index => $cs) {
    $index += 1;

    // Fetch related customer, sales_1, and booker information
    $customer = $pdo->read("customers", ['id' => $cs['customer_name'], 'company_profile_id' => $_SESSION['ovalfox_pos_cp_id']]);
    $sl1 = $pdo->read("sales_1", ['invoice_number' => $cs['invoice_number'] ?? -1]);
    $booker = $pdo->read("access", ['id' => $cs['booker_name'], 'company_profile_id' => $_SESSION['ovalfox_pos_cp_id']]);

    // Determine item name
    $itemNME = !empty($sl1) && preg_match('/\(Refunded\)/', $sl1[0]['item_name'] ?? '') 
        ? '(Refunded) ' . $cs['invoice_number'] 
        : $cs['invoice_number'];
    $customerLedger = $pdo->read("ledger", ['invoice_number' => $cs['invoice_number']]);

    // Determine status style
    $statusStyle = "";
    switch ($cs['status']) {
        case "Unpaid":
            $statusStyle = "background-color: blue; color: white;";
            break;
        case "Incomplete":
            $statusStyle = "background-color: red; color: white;";
            break;
        default:
            $statusStyle = "";
    }

    // Append row to HTML
    $html .= "<tr>
        <td contenteditable='true'>$index</td>
        <td contenteditable='true'>{$cs['bill_number']}</td>
        <td contenteditable='true'>$itemNME</td>
        <td contenteditable='true' style='$statusStyle'>{$cs['status']}</td>
        <td contenteditable='true'>{$customerLedger[0]['payment_type']}</td>

        <td contenteditable='true'>{$customer[0]['name']}</td>
        <td contenteditable='true'>{$booker[0]['username']}</td>
        <td contenteditable='true'>" . round((double)$cs['final_amount'], 2) . "</td>
        <td contenteditable='true' style='width:10px !important;'>{$cs['details']}</td>
        <td contenteditable='true' style='background-color: #A9A9A9; color: white;'>{$cs['date']}</td>
        <td>
            <a href='printinvoice2.php?inv={$cs['invoice_number']}&amountIn=amount' id='printCustomer' data-cus='{$cs['invoice_number']}' name='printCustomer'>PRINT</a> || 
            <a href='sales.php?inv_num={$cs['invoice_number']}' id='editCustomer' data-cus='{$cs['invoice_number']}' name='printCustomer'>EDIT</a>
        </td>
    </tr>";
}

// Output the HTML as a JSON response
echo json_encode([$html]);
?>
