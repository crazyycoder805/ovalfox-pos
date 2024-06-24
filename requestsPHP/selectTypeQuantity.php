<?php
session_start();
require_once '../assets/includes/pdo.php';

if (!empty($_POST['productId']) || !empty($_POST['itemSearch'])){
    $pr = $pdo->read("products", ['id' => $_POST['productId'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']]);

    if (!empty($_POST['productId'])) {
        $pr = $pdo->read("products", ['id' => $_POST['productId'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']]);
    } else if (!empty($_POST['itemSearch'])) {
        $pr = $pdo->read("products", ['item_code' => $_POST['itemSearch'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']]);

    }
    $type = $_POST['type'];
    $quantityType = $_POST['typeQuantity'];

    $pdData = [];

    if ($type == "tr") {
        if ($quantityType == "piece") {
            $pdData = [$pr[0]['trade_unit_price'], $pr[0]['total_quantity'], $pr[0]['box_quantity'], $pr[0]['quantity_per_box']];
        }
    }
    if ($type == "wr") {
        if ($quantityType == "piece") {
            $pdData = [$pr[0]['whole_sale_price'], $pr[0]['total_quantity'], $pr[0]['box_quantity'], $pr[0]['quantity_per_box']];
        }
    }
    if ($type == "tr") {
        if ($quantityType == "box") {
            $pdData = [$pr[0]['trade_box_price'], $pr[0]['total_quantity'], $pr[0]['box_quantity'], $pr[0]['quantity_per_box']];
        }
    }
    if ($type == "wr") {
        if ($quantityType == "box") {
            $pdData = [$pr[0]['whole_sale_box_price'], $pr[0]['total_quantity'], $pr[0]['box_quantity'], $pr[0]['quantity_per_box']];
        }
    }
    echo json_encode($pdData);
}