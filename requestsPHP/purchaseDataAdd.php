<?php

session_start();
require_once '../assets/includes/pdo.php';

if (!empty($_POST['order_no']) && !empty($_POST['bill_number']) && !empty($_POST['date']) && 
!empty($_POST['company_name']) && 
!empty($_POST['item_name']) && 
!empty($_POST['total_quantity']) &&
!empty($_POST['quantity_per_box']) &&
!empty($_POST['box_quantity']) && 
!empty($_POST['expiry_date']) && 
!empty($_POST['purchase_price'])&& 
!empty($_POST['trades_price'])&& 
!empty($_POST['wholesale_price'])&& 
!empty($_POST['purchase_price'])) {

    $product = $pdo->read("products", ['id'=> $_POST['item_name'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']]);


    $pdo->update("products", ['id' => $_POST['item_name'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']], ["total_quantity" => $_POST['total_quantity'],
    "quantity_per_box" => $_POST['quantity_per_box'],"box_quantity" => $_POST['box_quantity'],
     "purchase_per_unit_price" => $_POST['purchase_price'],
     "trade_unit_price" => $_POST['trades_price'],
     "whole_sale_price" => $_POST['wholesale_price']]);

    if (empty($pdo->read("purchases_2", ["order_number" => $_POST['order_no'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']]))) {

        $pdo->create("purchases_2", ['order_number' => $_POST['order_no'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id'], 'bill_number' => $_POST['bill_number'], 
        'date' => $_POST['date'], 'company_name' => $_POST['company_name']
        , 'operator' => $_SESSION['ovalfox_pos_user_id'],
        'total_amount' => $_POST['net_payable_amount'], 'paid_amount' => 0, 
        'remaining_amount' => 0]);
    } else {
        $pdo->update("purchases_2", ["order_number" => $_POST['order_no'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']], ['total_amount' => $_POST['net_payable_amount']]);

    }
    $pdo->create("purchases_1", ['order_number' => $_POST['order_no'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id'], 'bill_number' => $_POST['bill_number'], 'date' => $_POST['date'], 
    'company_name' => $_POST['company_name']
    , 'operator' => $_SESSION['ovalfox_pos_user_id'], 'item_code' => $product[0]['item_code'], 'item_name' => $product[0]['product_name'], 'item_price' => $_POST['purchase_price'], 
    'quantity' => $_POST['total_quantity'], 
    'total_amount' => $_POST['purchase_price'], 'discount' => $_POST['discount'], 'net_amount' =>  $_POST['net_payable_amount'], 'product_expiry' => $_POST['expiry_date']]);    

    if (!empty($pdo->read("purchases_1", ['order_number'=>$_POST['order_no'], 'bill_number'=>$_POST['bill_number'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']]))) {

        $ps = $pdo->read("purchases_1", ['order_number'=>$_POST['order_no'], 'bill_number'=>$_POST['bill_number'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']]);
        $tm = [];
        $amm = 0;
        foreach ($ps as $item) {
            $tm[] = $item['total_amount'];
        }
        $amm = array_sum($tm);
        $am = [$amm];
        echo json_encode($am);
    }
}