<?php
session_start();
require_once '../assets/includes/pdo.php';

$data = "";
$product = $pdo->read("products", ['id' => $_POST['product'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']]);
$customer = $pdo->read("customers", ['id'=>$_POST['customer_name'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']]);
if (!empty($customer)) {
    $sales_2_last_rate = $pdo->customQuery("SELECT * FROM sales_1 WHERE customer_name = '{$customer[0]['id']}' AND company_profile_id = {$_SESSION['ovalfox_pos_cp_id']} AND item_code = '{$product[0]['item_code']}' ORDER BY id DESC LIMIT 0, 5");

    foreach ($sales_2_last_rate as $sale1) {
        $data .= "
        
        <option>{$sale1['item_price']}</option>
        ";
    }
    
}


$item_code = $product[0]['item_code'];
$product_name = $product[0]['product_name'];
$product_price = $product[0]['trade_unit_price'];
$total_quantity = $product[0]['total_quantity'];

$productData = [$item_code, $product_price, $product_name, $total_quantity, $data];
echo json_encode($productData);