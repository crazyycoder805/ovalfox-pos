<?php
session_start();
require_once '../assets/includes/pdo.php';

// Check if either productId or itemSearch is provided
if (!empty($_POST['productId']) || !empty($_POST['itemSearch'])) {
    $criteria = [];
    if (!empty($_POST['productId'])) {
        $criteria = ['id' => $_POST['productId']];
    } elseif (!empty($_POST['itemSearch'])) {
        $criteria = ['item_code' => $_POST['itemSearch']];
    }
    
    // Add company profile id to the criteria
    $criteria['company_profile_id'] = $_SESSION['ovalfox_pos_cp_id'];
    
    // Fetch product details
    $pr = $pdo->read("products", $criteria);
    
    if (!empty($pr)) {
        $type = $_POST['type'];
        $quantityType = $_POST['typeQuantity'];
        
        $priceKey = ($type == "tr") ? 'trade_' : 'whole_sale_';
        $quantityKey = ($quantityType == "piece") ? 'piece' : 'box';
        
        $priceField = $priceKey . ($quantityType == "piece" ? 'unit_price' : 'box_price');
        $quantityFields = ['total_quantity', 'box_quantity', 'quantity_per_box'];
        
        $pdData = array_merge([$pr[0][$priceField]], array_map(fn($field) => $pr[0][$field], $quantityFields));
        
        echo json_encode($pdData);
    } else {
        echo json_encode([]);
    }
}
