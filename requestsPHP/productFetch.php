<?php
session_start();
require_once '../assets/includes/pdo.php';
$sales_1 = "";
$sales_2 = $pdo->read("sales_2", ['invoice_number' => $_POST['invoice_number'], "company_profile_id" => $_SESSION['ovalfox_pos_cp_id']]);



$productsYES = isset($_POST['item_name']) && isset($_POST['invoice_number']) ? $pdo->customQuery("SELECT * 
FROM sales_1 
WHERE item_name = '{$_POST['item_name']}' AND invoice_number < '{$_POST['invoice_number']}'
  AND customer_name = '{$_POST['customer_name']}' 
ORDER BY id DESC 
LIMIT 1;
") : [];




$customerInvMinus = empty($pdo->customQuery("SELECT * 
FROM sales_2 
WHERE customer_name = '{$sales_2[0]['customer_name']}'
AND invoice_number < '{$_POST['invoice_number']}'
ORDER BY invoice_number DESC 
LIMIT 1")) ? [] : $pdo->customQuery("SELECT * 
FROM sales_2 
WHERE customer_name = '{$sales_2[0]['customer_name']}'
AND invoice_number < '{$_POST['invoice_number']}'
ORDER BY invoice_number DESC 
LIMIT 1");










$customerInvPlus = empty($pdo->customQuery("SELECT * 
FROM sales_2 
WHERE customer_name = '{$sales_2[0]['customer_name']}'
AND invoice_number > '{$_POST['invoice_number']}' 
ORDER BY invoice_number ASC 
LIMIT 1")) ? [] : $pdo->customQuery("SELECT * 
FROM sales_2 
WHERE customer_name = '{$sales_2[0]['customer_name']}'
AND invoice_number > '{$_POST['invoice_number']}' 
ORDER BY invoice_number ASC 
LIMIT 1");


if (isset($_POST['desc']) && $_POST['desc'] == "true") {
    $sales_1 = $pdo->customQuery("SELECT * FROM sales_1 WHERE invoice_number = {$_POST['invoice_number']} AND company_profile_id = {$_SESSION['ovalfox_pos_cp_id']} ORDER BY id DESC");

} else {
    $sales_1 = $pdo->customQuery("SELECT * FROM sales_1 WHERE invoice_number = {$_POST['invoice_number']} AND company_profile_id = {$_SESSION['ovalfox_pos_cp_id']} ORDER BY id DESC");

}

    $all_over_qty = [];

    foreach ($sales_1 as $ss) {
        $all_over_qty[] = $ss['quantity'];
    }
    $sumOfAllProduct = $pdo->read("sales_1", ["invoice_number" => $_POST['invoice_number'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']]);
    $amountGrand = [];
    foreach ($sumOfAllProduct as $amount) {
        $amountGrand[] = $amount['grand_total'];
    }
    $all_over_qty = array_sum($all_over_qty);
    $html = "";

    foreach ($sales_1 as $key => $sale) {
        $key += 1;
        $gt = !empty($sale['grand_total']) ? $sale['grand_total'] : $sale['amount'];
        $html .= "
        <tr>
    <td style='font-size: 21px !important;font-weight:bolder;' id='itemMainKey_{$sale['id']}'>{$key}</td>

    <td style='font-size: 13px !important;font-weight:bolder;' id='"."item_codeTabledData{$sale['id']}'>{$sale['item_code']}</td>
    <td style='width:400px;font-size: 13px !important;font-weight:bolder;' id='"."item_nameTabledData{$sale['id']}'>".$sale['item_name'] ."<span> (<b style='background-color:yellow;'>". (isset($_POST['item_name']) && isset($_POST['invoice_number']) ? (!empty($productsYES) ? $productsYES[0]['item_price'] : 0) : "") . "</b>)</span>"." </td>
    <td style='font-size: 13px !important;font-weight:bolder;' id='"."quantityTabledData{$sale['id']}' ".(!preg_match('/\(Refunded\)/', $sale['item_name']) && !preg_match('/\(Free Item\)/', $sale['item_name']) ? "contenteditable='true'" : "").">{$sale['quantity']}</td>

    <td style='font-size: 13px !important;font-weight:bolder;' id='"."item_priceTabledData{$sale['id']}' ".(!preg_match('/\(Refunded\)/', $sale['item_name']) && !preg_match('/\(Free Item\)/', $sale['item_name']) ? "contenteditable='true'" : "").">{$sale['item_price']}</td>
    <td style='font-size: 13px !important;font-weight:bolder;' id='"."amountTabledData{$sale['id']}'>".round($sale['amount'], 2)."</td>
    <td style='font-size: 13px !important;font-weight:bolder;' id='"."discountTabledData{$sale['id']}'>{$sale['discount']}</td>
    <td style='font-size: 13px !important;font-weight:bolder;' id='"."extra_discountTabledData{$sale['id']}' ".(!preg_match('/\(Refunded\)/', $sale['item_name']) && !preg_match('/\(Free Item\)/', $sale['item_name']) ? "contenteditable='true'" : "").">{$sale['extra_discount']}</td>
    <td style='font-size: 13px !important;font-weight:bolder;'  id='"."percentageTabledData{$sale['id']}' ".(!preg_match('/\(Refunded\)/', $sale['item_name']) && !preg_match('/\(Free Item\)/', $sale['item_name']) ? "contenteditable='true'" : "").">{$sale['percentage']}</td>
    <td style='font-size: 13px !important;font-weight:bolder;' id='"."grandTotalTabledData{$sale['id']}'>$gt</td>

    
  <td style='font-size: 13px !important;font-weight:bolder;'>
  <div style='position: relative;' class='container-cus'>
  <div style='
  position: absolute;
  top: 0;
  left: 0;
  width: 100%; /* Adjust width and height as needed */
  height: 100%;
  color: red;
  text-align: center;
        background-color: rgba(0, 0, 0, 1); /* Semi-transparent black overlay */
  ' class='overlay-cus'>
  LOCKED
  </div>
  <div class='content-cus'>
  <button class='sales-btn-remove btn-sm' value='{$sale['id']}' id='removeItem'>Remove</button>
  </div>
</div>

  </td>

  
</tr>
        ";
    }

    $amountGrand = array_sum($amountGrand);

$data = [$html, count($sales_1), $all_over_qty, $amountGrand, isset($_POST['updatedRowId']) ? $_POST['updatedRowId'] : 0, empty($customerInvMinus[0]['pending_amount']) ? 0 : $customerInvMinus[0]['pending_amount']];

echo json_encode($data);
