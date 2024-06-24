<?php
session_start();
require_once '../assets/includes/pdo.php';

if (!empty($_POST["net_payable_amount"])) { 

    $pdo->update("purchases_2", ['order_number'=>$_POST['order_no'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']], ['total_amount' => $_POST['net_payable_amount'], 
    'paid_amount' => $_POST['amount_paid'], 
    'remaining_amount' => $_POST['pending_amount'], 
    ]);
    
    $pdo->create("ledger", ['date'=>$_POST['date'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id'],'total_amount' => $_POST['net_payable_amount'], 
    'remaining_amount' => $_POST['pending_amount'], 
    'payment_from' => $_SESSION['ovalfox_pos_user_id'], 
    'dr' => $_POST["amount_paid"], 
    'cr' => 0
    ]);
    $pdo->update("suppliers", ["id"=>$_POST['company_id'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']], ['balanace'=>$_POST['pending_amount']]);
    }