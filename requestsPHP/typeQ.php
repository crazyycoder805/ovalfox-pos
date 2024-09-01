<?php
session_start();
require_once '../assets/includes/pdo.php';

if (!empty($_POST['productId'])) {
    $productId = $_POST['productId'];
    $type = $_POST['type'];
    $quantityType = $_POST['typeQuantity'];

    // Read product data from database
    $pr = $pdo->read("products", [
        'id' => $productId,
        'company_profile_id' => $_SESSION['ovalfox_pos_cp_id']
    ]);

    if (!empty($pr)) {
        $product = $pr[0];
        $priceKey = '';
        $quantityTypeIndex = $quantityType == 'piece' ? 0 : 1;

        // Determine the correct price key based on type
        if ($type == 'tr') {
            $priceKey = 'trade';
        } elseif ($type == 'wr') {
            $priceKey = 'whole_sale';
        }

        // Build the price key string
        if ($priceKey && $quantityTypeIndex !== null) {
            $priceKey .= $quantityTypeIndex ? '_box_price' : '_unit_price';
            $pdData = [
                $product[$priceKey],
                $product['total_quantity'],
                $product['box_quantity'],
                $product['quantity_per_box']
            ];
            echo json_encode($pdData);
        }
    }
}
