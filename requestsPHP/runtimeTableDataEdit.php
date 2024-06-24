<?php
session_start();
require_once '../assets/includes/pdo.php';


$array = json_decode($_POST['target'], true);
$keys = array_keys($array);
$key = preg_replace('/TabledData\d+/', '', trim($keys[0]));
preg_match('/\d+$/', trim($keys[0]), $matches);
$id = $matches[0];





if ($key == "quantity") {
    $selectedItem = $pdo->read("sales_1", ['id' => $id, 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']]);
    $prd = $pdo->read("products", ['item_code' => $selectedItem[0]['item_code']]);
    $discount = 
    round((((array_values($array)[0] * $selectedItem[0]['item_price']) * (1 - (round($selectedItem[0]['percentage'], 2) / 100)))), 2);
    $percentage =  round((((array_values($array)[0] * $selectedItem[0]['item_price']) - $discount) / (array_values($array)[0] * $selectedItem[0]['item_price'])) * 100, 2);
    // if (array_values($array)[0] <= $prd[0]['total_quantity']) {
    //     $pdo->update("products", ['id' => $prd[0]['id'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']], ["total_quantity" => $prd[0]['total_quantity'] - array_values($array)[0]]);
    // }

    $pdo->update("sales_1", ['id' => $id, 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']], 
    ['grand_total' => $discount - $selectedItem[0]['extra_discount'], 
    'amount' => (array_values($array)[0] * $selectedItem[0]['item_price']),
    'discount' => $selectedItem[0]['percentage'] == 0 ? 0 : (array_values($array)[0] * $selectedItem[0]['item_price']) - $discount,
    'percentage' => $selectedItem[0]['percentage'] == 0 ? 0 : $percentage,
    'quantity' => array_values($array)[0] > $prd[0]['total_quantity'] ? $prd[0]['total_quantity'] : array_values($array)[0]]);
    $sls1 = $pdo->read("sales_1", ['invoice_number' => $_POST['invoice_number'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']]);

    $toa = [];
    foreach ($sls1 as $sl1) {
        $toa[] = $sl1['grand_total'];
    }

    $toa = array_sum($toa);


    $pdo->update("sales_2", ['invoice_number' => $_POST['invoice_number']], ['total_amount' => $toa]);
    
} else if ($key == "discount") {
//     $selectedItem = $pdo->read("sales_1", ['id' => $id, 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']]);
//     $pdo->update("sales_1", ['id' => $id, 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']], 
//     [
        
//         // 'grand_total' => (((($selectedItem[0]['quantity'] * $selectedItem[0]['item_price']) - array_values($array)[0]) - $selectedItem[0]['extra_discount'])),
    
    
//     // 'percentage' => round((array_values($array)[0] / ((($selectedItem[0]['quantity'] * $selectedItem[0]['item_price'])) - 
//     // $selectedItem[0]['extra_discount'])) * 100, 2),



//     // 'discount' => (array_values($array)[0])

// ]);
//     $sls1 = $pdo->read("sales_1", ['invoice_number' => $_POST['invoice_number'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']]);

//     $toa = [];
//     foreach ($sls1 as $sl1) {
//         $toa[] = $sl1['grand_total'];
//     }

//     $toa = array_sum($toa);

//     $pdo->update("sales_2", ['invoice_number' => $_POST['invoice_number']], ['total_amount' => $toa]);
} else if ($key == "extra_discount") {
    $selectedItem = $pdo->read("sales_1", ['id' => $id, 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']]);
    $pdo->update("sales_1", ['id' => $id, 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']], 
    ['grand_total' => 
    ((($selectedItem[0]['quantity'] * $selectedItem[0]['item_price']) - $selectedItem[0]['discount']) - array_values($array)[0]), 
    'extra_discount' => array_values($array)[0]]);
    $sls1 = $pdo->read("sales_1", ['invoice_number' => $_POST['invoice_number'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']]);

    $toa = [];
    foreach ($sls1 as $sl1) {
        $toa[] = $sl1['grand_total'];
    }

    $toa = array_sum($toa);

    $pdo->update("sales_2", ['invoice_number' => $_POST['invoice_number']], ['total_amount' => $toa]);
} else if ($key == "percentage") {
    $selectedItem = $pdo->read("sales_1", ['id' => $id, 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']]);
    $discount = round(array_values($array)[0] == 0 ? 0 :
    ((($selectedItem[0]['quantity'] * $selectedItem[0]['item_price']) * (1 - (round(array_values($array)[0], 2) / 100)))), 2);
    $pdo->update("sales_1", ['id' => $id, 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']], 
    ['discount' => (array_values($array)[0] == 0 ? 0 : ($selectedItem[0]['quantity'] * $selectedItem[0]['item_price']) - $discount),
    'grand_total' => array_values($array)[0] == 0 ? ($selectedItem[0]['quantity'] * $selectedItem[0]['item_price']) -  $selectedItem[0]['extra_discount'] : $discount -  $selectedItem[0]['extra_discount'],
    'percentage' => round(array_values($array)[0], 2)]);
    $sls1 = $pdo->read("sales_1", ['invoice_number' => $_POST['invoice_number'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']]);

    $toa = [];
    foreach ($sls1 as $sl1) {
        $toa[] = $sl1['grand_total'];
    }

    $toa = array_sum($toa);

    $pdo->update("sales_2", ['invoice_number' => $_POST['invoice_number']], ['total_amount' => $toa]);
} else if ($key == "item_price") {
    $selectedItem = $pdo->read("sales_1", ['id' => $id, 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']]);
    $discount = 
    round(((($selectedItem[0]['quantity'] * array_values($array)[0]) * (1 - (round($selectedItem[0]['percentage'], 2) / 100)))), 2);
    $percentage =  round(((($selectedItem[0]['quantity'] * array_values($array)[0]) - $discount) / ($selectedItem[0]['quantity'] * array_values($array)[0])) * 100, 2);
    $pdo->update("sales_1", ['id' => $id, 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']], 
    ['grand_total' => $discount - $selectedItem[0]['extra_discount'], 
    'amount' => ($selectedItem[0]['quantity'] 
    * array_values($array)[0]),
    'discount' => $selectedItem[0]['percentage'] == 0 ? 0 : ($selectedItem[0]['quantity'] * array_values($array)[0]) - $discount,
    'percentage' => $selectedItem[0]['percentage'] == 0 ? 0 : $percentage,
    'item_price' => array_values($array)[0]]);
    $sls1 = $pdo->read("sales_1", ['invoice_number' => $_POST['invoice_number'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']]);

    $toa = [];
    foreach ($sls1 as $sl1) {
        $toa[] = $sl1['grand_total'];
    }

    $toa = array_sum($toa);

    $pdo->update("sales_2", ['invoice_number' => $_POST['invoice_number']], ['total_amount' => $toa]);
}
