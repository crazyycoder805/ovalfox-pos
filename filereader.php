<?php

require_once 'vendor/autoload.php'; // Include Composer's autoload file

use Symfony\Component\Filesystem\Filesystem;
use Shuchkin\SimpleXLSX;


require_once 'assets/includes/pdo.php';
// Path to your Excel file
$filePath = 'assets/includes/products.xlsx';

function removeEmptyValues($array) {
    foreach ($array as $key => $value) {
        if (is_array($value)) {
            $array[$key] = removeEmptyValues($value);
            if (empty($array[$key])) {
                unset($array[$key]);
            }
        } else {
            if ($value === '' || $value === null) {
                unset($array[$key]);
            }
        }
    }
    return $array;
}
if ($xlsx = SimpleXLSX::parse($filePath)) {
    // Produce array keys from the array values of 1st array element
    $keys = [0 => 'Sr.', 1 => 'item_code', 4 => 'product_name', 5 => 'category_id', 7 => 'total_quantity', 9 => 'trade_unit_price', 10 => 'Total'];
    $rows = [];
    foreach ($xlsx->rows() as $r) {
        // Map keys to the columns
        $rowWithKeys = [];
        foreach ($r as $index => $value) {
            if (isset($keys[$index])) {
                $rowWithKeys[$keys[$index]] = $value;
            }
        }
        $rows[] = $rowWithKeys;
    }

   
}

// foreach (removeEmptyValues($rows) as $key => $value) {
//     $pdo->create("products", ['product_name' => $value['product_name'], 'item_code' => $value['item_code'], 'total_quantity' => $value['total_quantity'], 'trade_unit_price' => $value['trade_unit_price'], 'company_profile_id' => 1]);

    

// }
foreach (removeEmptyValues($rows) as $key => $value) {
     $pdo->create("products", ['product_name' => !empty($value['product_name']) ?  $value['product_name'] : "no_product_name", 'item_code' => !empty($value['item_code']) ?  $value['item_code'] : "no_product_item_code", 'total_quantity' => !empty($value['total_quantity']) ?  $value['total_quantity'] : "no_product_quantity", 'trade_unit_price' => !empty($value['trade_unit_price']) ? $value['trade_unit_price'] : 0, 'company_profile_id' => 1]);
    // echo "<pre>";
    // print_r($value['trade_unit_price']);
}

?>
