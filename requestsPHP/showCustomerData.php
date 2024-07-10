<?php 
session_start();
require_once '../assets/includes/pdo.php';
$html = "";
    $customerSales2 = $pdo->customQuery("SELECT *  FROM sales_2 WHERE customer_name = {$_POST['cusId']} AND company_profile_id = {$_SESSION['ovalfox_pos_cp_id']} ORDER BY id DESC");
    foreach ($customerSales2 as $index => $cs) {
        $index += 1;
        $customer = $pdo->read("customers" , ['id' => $cs['customer_name'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']]);
        $sl1 = $pdo->read("sales_1", ['invoice_number' => !empty($cs['invoice_number']) ? $cs['invoice_number'] : -1]);
        $booker = $pdo->read("access" , ['id' => $cs['booker_name'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']]);
        $itemNME = preg_match('/\(Refunded\)/', (!empty($sl1[0]['item_name']) ? $sl1[0]['item_name'] : "")) ? '(Refunded) ' . $cs['invoice_number'] : $cs['invoice_number']; 

$html .= "<tr>
    <td>$index</td>
    <td>{$cs['bill_number']}</td>
    <td>$itemNME
    </td>";
    if ($cs['status'] == "Unpaid") {

        $html .= "<td style='background-color: blue;color:white;'>{$cs['status']}</td>";
 
 
 
   } else if ($cs['status'] == "Incomplete") {
           $html .= "<td style='background-color: red;color:white;'>{$cs['status']}</td>";
 
 
 
      }  else { 
         $html .= "<td>{$cs['status']}</td>";
 
 
      } 
    $html .= "<td>{$customer[0]['name']}</td>
    <td>{$booker[0]['username']}</td>

    <td>{$cs['final_amount']}</td>";
    

    $html .= "<td style='background-color: #A9A9A9;color:white;'>{$cs['date']}</td>";

    $html .= "<td>
        <a href='printinvoice2.php?inv={$cs['invoice_number']}&amountIn=amount' id='printCustomer' data-cus='{$cs['invoice_number']}' name='printCustomer'>PRINT</a> || <a
            href='sales.php?inv_num={$cs['invoice_number']}' id='editCustomer'
            data-cus='{$cs['invoice_number']}' name='printCustomer'>EDIT</a>
    </td>

</tr>";
}
echo json_encode([$html]);