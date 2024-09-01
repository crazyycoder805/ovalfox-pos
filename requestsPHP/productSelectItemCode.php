<?php
session_start();
require_once '../assets/includes/pdo.php';

// Initialize variables
$product = "";
$data = "";

// Fetch product based on provided POST data
if (isset($_POST['productId'])) {
    $product = $pdo->read("products", [
        'id' => $_POST['productId'], 
        'company_profile_id' => $_SESSION['ovalfox_pos_cp_id']
    ]);
} elseif (isset($_POST['product'])) {
    $product = $pdo->read("products", [
        'item_code' => $_POST['product'], 
        'company_profile_id' => $_SESSION['ovalfox_pos_cp_id']
    ]);
}

// Fetch customer information
$customer = $pdo->read("customers", [
    'id' => $_POST['customer_name'], 
    'company_profile_id' => $_SESSION['ovalfox_pos_cp_id']
]);

if (!empty($customer) && !empty($product)) {
    // Fetch the last 5 sales records for the customer and product
    $sales_2_last_rate = $pdo->customQuery("
        SELECT item_price 
        FROM sales_1 
        WHERE customer_name = {$customer[0]['id']} 
        AND company_profile_id = {$_SESSION['ovalfox_pos_cp_id']} 
        AND product_name = {$product[0]['product_name']} 
        ORDER BY id DESC 
        LIMIT 5
    ");

    // Generate the <option> elements for the prices
    foreach ($sales_2_last_rate as $sale1) {
        $data .= "<option>{$sale1['item_price']}</option>";
    }

    // Prepare the response data
    $productData = [
        $product[0]['item_code'], 
        $product[0]['trade_unit_price'], 
        $product[0]['product_name'], 
        $product[0]['total_quantity'], 
        $data, 
        $product[0]['total_quantity'], 
        $product[0]['box_quantity'], 
        $product[0]['quantity_per_box']
    ];

    // Output the response data as JSON
    echo json_encode($productData);
} else {
    // Handle the case where customer or product is not found
    echo json_encode(['error' => 'Customer or Product not found']);
}
?>
