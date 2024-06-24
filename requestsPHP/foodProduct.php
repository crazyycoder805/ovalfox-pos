<?php
session_start();
require_once '../assets/includes/pdo.php';

$productSelected = $pdo->read('products', ['id'=>$_POST['pid'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']]);
    $sales_1 = $pdo->read("sales_1", ['invoice_number' => $_POST['invoice_number'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']]);

    $pdo->update("products", ['id' => $_POST['pid'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']], ["total_quantity" => $productSelected[0]["total_quantity"] - 1]);

     
       
    
        // if (empty($pdo->read("sales_2", ["invoice_number" => $_POST['invoice_number']]))) {
        //     $pdo->create("sales_2", ['invoice_number' => $_POST['invoice_number'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id'], 'customer_name' => $_POST['customer_name'], 'booker_name' => $_POST['booker_name'], 
        //     'operator_name' => $_POST['booker_name'], 'date' => $_POST['date'], 'discount' => $_POST['discount_in_amount'], 'bill_number' => $_POST['bill_number'], 
        //     'total_amount' => $_POST['total_amount'], 'final_amount' => $_POST['final_amount'], 'recevied_amount' => $_POST['recevied_amount'],  
        //     'returned_amount' => $_POST['returned_amount'], 'pending_amount' => $_POST['pending_amount'], 'status' => "Unpaid"]);
        // } else {
        //     $pdo->update("sales_2", ["invoice_number" => $_POST['invoice_number']], ['total_amount' => $_POST['total_amount']]);
        // }
        
    
    
    $salePd = $pdo->read("sales_1", ['invoice_number' => $_POST['invoice_number'], "item_code"=> $productSelected[0]["item_code"], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']]);

    if (empty($salePd)) {
        $pdo->create("sales_1", ['invoice_number' => $_POST['invoice_number'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id'], 'customer_name' => "AA", 
        'booker_name' => "AA", 'operator_name' => "AA", 'date' => "AA", 
        'item_code' => $productSelected[0]['item_code'], 'item_name' => $productSelected[0]['product_name'], 'item_price' => $productSelected[0]['purchase_per_unit_price'], 
        'quantity' => 1, 'amount' => $_POST['amount'], 'discount' => 0, 'extra_discount' => 0]);
        $pods = [$productSelected[0]['purchase_per_unit_price'], 1];
        echo json_encode($pods);
    } else {
        $pdo->update("sales_1", ['invoice_number' => $_POST['invoice_number'], 'item_code'=> $productSelected[0]['item_code'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']], ['quantity' => $salePd[0]['quantity'] + 1, 
        'amount' =>$_POST['amount']]);
        $pods = [$productSelected[0]['purchase_per_unit_price'], $sales_1[0]['quantity']];
        echo json_encode($pods);
    
    }

    if (isset($_POST['value'])) {
        if ($_POST['value'] == "plus") { 

            $pdo->update("sales_1", ['invoice_number' => $_POST['invoice_number'], 'item_code'=> $productSelected[0]['item_code'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']], ['quantity' => $_POST['quantity'], 
            'amount' => $salePd[0]['amount'] + $productSelected[0]['purchase_per_unit_price']]);
        } else {
           
                $pdo->update("sales_1", ['invoice_number' => $_POST['invoice_number'], 'item_code'=> $productSelected[0]['item_code'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']], ['quantity' => $_POST['quantity'], 
                'amount' => $salePd[0]['amount'] + $productSelected[0]['purchase_per_unit_price']]);
            
        }
    }