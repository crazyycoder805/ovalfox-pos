<?php

session_start();
require_once 'assets/includes/pdo.php';



if ($_POST['__FILE__'] == "productSelect") {
    $data = "";
    $product = $pdo->read("products", ['id' => $_POST['product'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']]);
    $customer = $pdo->read("customers", ['id'=>$_POST['customer_name'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']]);
    if (!empty($customer)) {
        $sales_2_last_rate = $pdo->read("sales_1", ['customer_name'=> $customer[0]['id'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']], ' LIMIT 0, 5');

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
} else if ($_POST['__FILE__'] == "productFetch") {
    $sales_1 = $pdo->read("sales_1", ['invoice_number' => $_POST['invoice_number'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']]);

    $all_over_qty = [];

    foreach ($sales_1 as $ss) {
        $all_over_qty[] = $ss['quantity'];
    }

    $all_over_qty = array_sum($all_over_qty);
    $html = "";
?>

<?php

    foreach ($sales_1 as $key => $sale) {
        $key += 1;
        $html .= "
        <tr>
    <td>{$key}</td>

    <td id='"."item_codeTabledData{$sale['id']}'>{$sale['item_code']}</td>
    <td id='"."item_nameTabledData{$sale['id']}'>{$sale['item_name']}</td>
    <td id='"."quantityTabledData{$sale['id']}' contenteditable='true'>{$sale['quantity']}</td>

    <td id='"."item_priceTabledData{$sale['id']}'>{$sale['item_price']}</td>
    <td id='"."amountTabledData{$sale['id']}'>{$sale['amount']}</td>
    <td id='"."discountTabledData{$sale['id']}' contenteditable='true'>{$sale['discount']}</td>
    <td id='"."extra_discountTabledData{$sale['id']}' contenteditable='true'>{$sale['extra_discount']}</td>

    <td><button class='btn btn-danger btn-sm' value='{$sale['id']}' id='removeItem'>Remove</button></td>

</tr>
        ";

    ?>

<?php } 

$data = [$html, count($sales_1), $all_over_qty];

echo json_encode($data);



?>



<?php
} else if ($_POST['__FILE__'] == 'productAdd') {
    $sales_1 = $pdo->read("sales_1", ['invoice_number' => $_POST['invoice_number'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']]);
    if (!empty($_POST['invoice_number']) && (!empty($_POST['customer_name']) || !empty($_POST['customer_manual'])) && 
    !empty($_POST['booker_name']) && !empty($_POST['date']) && !empty($_POST['date']) && !empty($_POST['total_quantity']) && !empty($_POST['quantity']) 
    && (!empty($_POST['item_code_search']) || !empty($_POST['product_id']))) {

        $customerId = "";
        $customer = "";
        if (!empty($_POST['customer_manual'])) { 
            if (!$pdo->isDataInserted("customers", ['name'=> $_POST['customer_manual'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']])) {
                $returnedId = $pdo->create('customers', ['name'=> $_POST['customer_manual'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']]);
                $customerId = $pdo->read('customers', ['id'=> $returnedId, 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']]);
                $customer = $pdo->read("customers", ['id'=> $customerId[0]['name'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']]);
            } else {
                $customerId = $pdo->read('customers', ['name'=> $_POST['customer_manual'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']]);

            }
        }
        if ($_POST['type'] == "rf") {
            $pdo->update("products", ['id' => $_POST['product_id'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']], ["total_quantity" => $_POST['total_quantity']]);
            if (empty($pdo->read("sales_2", ["invoice_number" => $_POST['invoice_number'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']]))) {
    
                if ($pdo->create("sales_2", ['invoice_number' => $_POST['invoice_number'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id'], 'customer_name' => !empty($_POST['customer_manual']) ? $customerId[0]['id'] : $_POST['customer_name'], 
                'booker_name' => $_POST['booker_name'], 'operator_name' => $_POST['booker_name'], 'date' => $_POST['date'], 'discount' => 0, 
                'bill_number' => $_POST['bill_number'], 'total_amount' => $_POST['total_amount'], 'final_amount' => 0, 'recevied_amount' => 0, 
                'returned_amount' => 0, 'pending_amount' => 0, 'status' => "Incomplete"])) {
                    echo "Item added.";
                } else {
                    echo "Something went wrong.";
    
                }
            } else {
                $pdo->update("sales_2", ["invoice_number" => $_POST['invoice_number'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']], ['total_amount' => $_POST['total_amount']]);
            }
            $pdo->create("sales_1", ['invoice_number' => $_POST['invoice_number'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id'], 'customer_name' => !empty($_POST['customer_manual']) ? $customerId[0]['id'] : $_POST['customer_name'], 
            'booker_name' => $_POST['booker_name'], 'operator_name' => $_POST['booker_name'], 'date' => $_POST['date'], 'item_code' => $_POST['item_code'], 
            'item_name' => "(Refunded) " . $_POST['item_name'], 'item_price' => $_POST['item_price'], 'quantity' => $_POST['quantity'], 'amount' => $_POST['amount'], 
            'discount' => empty($_POST['discount_in_amount']) ? 0 : $_POST['discount_in_amount'], 'extra_discount' => empty($_POST['extra_discount']) ? 0 : $_POST['extra_discount']]);
        } else {
            $pdo->update("products", ['id' => $_POST['product_id'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']], ["total_quantity" => $_POST['total_quantity']]);
            if (empty($pdo->read("sales_2", ["invoice_number" => $_POST['invoice_number'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']]))) {
                $pdo->create("sales_2", ['invoice_number' => $_POST['invoice_number'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id'], 'customer_name' => !empty($_POST['customer_manual']) ? $customerId[0]['id'] : $_POST['customer_name'], 'booker_name' => $_POST['booker_name'], 
                'operator_name' => $_POST['booker_name'], 'date' => $_POST['date'], 'discount' => 0, 'bill_number' => $_POST['bill_number'], 
                'total_amount' => $_POST['total_amount'], 'final_amount' => 0, 'recevied_amount' => 0,  
                'returned_amount' => 0, 'pending_amount' => 0, 'status' => "Incomplete"]);
            } else {
                $pdo->update("sales_2", ["invoice_number" => $_POST['invoice_number'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']], ['total_amount' => $_POST['total_amount']]);
            }
    
    
    
            $pdo->create("sales_1", ['invoice_number' => $_POST['invoice_number'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id'], 
            'customer_name' => !empty($_POST['customer_manual']) ? $customerId[0]['id'] : $_POST['customer_name'], 
            'booker_name' => $_POST['booker_name'], 'operator_name' => $_POST['booker_name'], 'date' => $_POST['date'], 
            'item_code' => $_POST['item_code'], 'item_name' => $_POST['item_name'], 'item_price' => $_POST['item_price'], 
            'quantity' => empty($_POST['quantity']) ? 0 : $_POST['quantity'], 'amount' => empty($_POST['amount']) ? 0 : $_POST['amount'], 
            'discount' => empty($_POST['discount_in_amount']) ? 0 : $_POST['discount_in_amount'], 
            'extra_discount' => empty($_POST['extra_discount']) ? 0 : $_POST['extra_discount']]);
        }

    }
   

?>
<?php
    foreach ($sales_1 as $key => $sale) {
        $key += 1;

    ?>


<tr>

    <td><?php echo $key; ?></td>
    <td id='item_codeTabledData<?php echo $sale['id'];?>'><?php echo $sale['item_code']; ?></td>
    <td id='item_nameTabledData<?php echo $sale['id'];?>'><?php echo $sale['item_name']; ?></td>
    <td id='quantityTabledData<?php echo $sale['id'];?>' contenteditable='true'><?php echo $sale['quantity']; ?></td>

    <td id='item_priceTabledData<?php echo $sale['id'];?>'><?php echo $sale['item_price']; ?></td>
    <td id='amountTabledData<?php echo $sale['id'];?>'><?php echo $sale['amount']; ?></td>
    <td id='discountTabledData<?php echo $sale['id'];?>' contenteditable='true'><?php echo $sale['discount']; ?></td>
    <td id='extra_discountTabledData<?php echo $sale['id'];?>' contenteditable='true'><?php echo $sale['extra_discount']; ?></td>

    <td><button class="btn btn-danger btn-sm" value="<?php echo $sale['id']; ?>" id="removeItem">Remove</button></td>

</tr>
<?php } ?>


<?php } else if ($_POST['__FILE__'] == "productSelectItemCode") {


    $product = "";

    $data = "";

    if (isset($_POST['productId'])) {
        $product = $pdo->read("products", ['id' => $_POST['productId'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']]);
    } else if (isset($_POST['product'])) {
        $product = $pdo->read("products", ['item_code' => $_POST['product'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']]);
    }

    $customer = $pdo->read("customers", ['id'=>$_POST['customer_name'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']]);
    if (!empty($customer)) {
        $sales_2_last_rate = $pdo->read("sales_1", ['customer_name'=> $customer[0]['id'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']], ' LIMIT 0, 5 ORDER ASC');

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

    $productData = [$item_code, $product_price, $product_name, $total_quantity, $data, $product[0]['total_quantity'], $product[0]['box_quantity'], $product[0]['quantity_per_box']];
    echo json_encode($productData);


?>

<?php } else if ($_POST['__FILE__'] == "deleteProductSales1") {
    $pr = $pdo->read("sales_1", ['id' => $_POST['salesId'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']]);
    $totalAmount = $pr[0]['amount'];
    $productData = [$totalAmount];
    echo json_encode($productData);
    $pdo->customQuery("DELETE FROM sales_1 WHERE id = {$_POST['salesId']}");
?>
<?php } else if ($_POST['__FILE__'] == "deletePurchase") {
    $pr = $pdo->read("purchases_1", ['id' => $_POST['purchaseId'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']]);
    $totalAmount = $pr[0]['total_amount'];
    $productData = [$totalAmount];
    echo json_encode($productData);
    $pdo->customQuery("DELETE FROM purchases_1 WHERE id = {$_POST['purchaseId']}");
?>


<?php } else if ($_POST['__FILE__'] == "selectTypeQuantity") {
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
?>

<?php } else if ($_POST['__FILE__'] == "refundItem") {

    $pdouctId = $pdo->read("products", ["id" => $_POST['productId'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']]);


    $pdo->create("sales_1", ['invoice_number' => $_POST['invoice_number'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id'], 'customer_name' => $_POST['customer_name'], 'booker_name' => $_POST['booker_name'], 'operator_name' => $_POST['booker_name'], 'date' => $_POST['date'], 'item_code' => "(Refunded)" . $_POST['item_code'], 'item_name' => $_POST['item_name'], 'item_price' => $_POST['item_price'], 'quantity' => $_POST['quantity'], 'amount' => $_POST['amount'], 'discount' => $_POST['discount'], 'extra_discount' => $_POST['extra_discount']]);

?>

<?php } else if ($_POST['__FILE__'] == "loadInvoice") {
    $sales_1 = $pdo->read("sales_1", ['invoice_number' => $_POST['in'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']]);
    $sales_2 = $pdo->read("sales_2", ['invoice_number' => $_POST['in'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']]);
    $all_over_qty = [];

    foreach ($sales_1 as $ss) {
        $all_over_qty[] = $ss['quantity'];
    }

    $all_over_qty = array_sum($all_over_qty);
    
    $html = "";

    foreach ($sales_1 as $key => $sale) {
        $key += 1;
        $html .= "   <tr>
        <td>{$key}</td>

        <td id='"."item_codeTabledData{$sale['id']}'>{$sale['item_code']}</td>
        <td id='"."item_nameTabledData{$sale['id']}'>{$sale['item_name']}</td>
        <td id='"."quantityTabledData{$sale['id']}' contenteditable='true'>{$sale['quantity']}</td>
    
        <td id='"."item_priceTabledData{$sale['id']}'>{$sale['item_price']}</td>
        <td id='"."amountTabledData{$sale['id']}'>{$sale['amount']}</td>
        <td id='"."discountTabledData{$sale['id']}' contenteditable='true'>{$sale['discount']}</td>
        <td id='"."extra_discountTabledData{$sale['id']}' contenteditable='true'>{$sale['extra_discount']}</td>

        <td><button class='btn btn-danger btn-sm' value='{$sale['id']}' id='removeItem'>Remove</button></td>

    </tr>";
    }


    $productData = [$html, $sales_2, count($sales_1), $all_over_qty];
    echo json_encode($productData);

?>



<?php } else if ($_POST['__FILE__'] == "sales2Update") {
    
    $customerSales = $pdo->read("sales_2", ["invoice_number" => $_POST['invoice_number'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']]);
    $customer = $pdo->read("customers", ["id" => $customerSales[0]['customer_name'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']]);

    $pdo->update("customers", ["id" => $customer[0]['id'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']], ["balance" => $_POST['pending_amount']]);
    $pdo->create("ledger", ["payment_type" => $_POST['payment_type'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id'], "total_amount" => $_POST['total_amount'], "recevied_amount" => $_POST['recevied_amount'],
    "details" => $_POST['details'], "payment_from" => $customer[0]['id'], "dr" => $_POST['pending_amount'], "cr" => $_POST['recevied_amount'], 
    "remaining_amount" => $_POST['final_amount'], "status" => $_POST['pending_amount'] != 0 || $_POST['pending_amount'] != "0" ? "Paid" : "Unpaid"]);
    $pdo->update("sales_2", ['invoice_number' => $_POST['invoice_number'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']], ['discount' => $_POST['discount_in_amount'], 'final_amount' => $_POST['final_amount'], 
    'recevied_amount' => $_POST['recevied_amount'], 'returned_amount' => $_POST['returned_amount'], 'pending_amount' => $_POST['pending_amount'], 
    "status" => $_POST['pending_amount'] == 0 || $_POST['pending_amount'] == "0" ? "Paid" : "Unpaid"]);
    
?>

<?php } else if ($_POST['__FILE__'] == "purchaseDataAdd") {
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
    ?>


<?php
} else if ($_POST['__FILE__'] == 'purchaseFetch') {
    $purchases_2 = $pdo->read("purchases_1", ['order_number'=>$_POST['order_no'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']]);

?>
<?php
    foreach ($purchases_2 as $pur) {
        $pdouct = $pdo->read("products", ['product_name'=> $pur['item_name'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']]);
    ?>


<tr>
    <td><?php echo $pur['id']; ?></td>

    <td><?php echo $pur['order_number']; ?></td>
    <td><?php echo $pur['bill_number']; ?></td>
    <td><?php echo $pdouct[0]['product_name']; ?></td>

    <td><?php echo $pur['quantity']; ?></td>
    <td><?php echo $pur['product_expiry']; ?></td>
    <td><?php echo $pdouct[0]['trade_unit_price']; ?></td>
    <td><?php echo $pur['total_amount']; ?></td>
    <td><?php echo $pdouct[0]['whole_sale_price']; ?></td>

    <td><button class="btn btn-danger btn-sm" value="<?php echo $pur['id']; ?>" id="removeItem">Remove</button></td>

</tr>
<?php } ?>


<?php } else if($_POST['__FILE__'] == "purchase2") {
      
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
    ?>

<?php
} else if ($_POST['__FILE__'] == 'foodProduct') {
   
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
?>



<?php } else if ($_POST['__FILE__'] == "foodFetch") {
    $pdo->update("sales_1", ['invoice_number' => $_POST['invoice_number'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']]);

    $sales_1 = $pdo->read("sales_1", ['invoice_number' => $_POST['invoice_number'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']]);
?>

<?php
    foreach ($sales_1 as $sale) {
        $pddd = $pdo->read("products", ['item_code'=>$sale['item_code'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']]);

    ?>


<tr id="parentElement">
    <td>
        <div class="img-chair">
            <img src="display_image.php?t=products&i=image&it=image_type&id=<?php echo $pddd[0]['id']; ?>" alt=" " />
        </div>
    </td>
    <td><?php echo $sale['item_name']; ?></td>
    <td id="itemp"><?php echo $sale['item_price']; ?></td>
    <td>
        <div class="int-table-quantity">
            <div class="quantity-wrapper">
                <div class="input-group">
                    <span id="val-plus" class="quantity-minus"> - </span>
                    <input type="number" class="quantity" value="<?php echo $sale['quantity'] ?>">
                    <span id="val-minus" class="quantity-plus"> + </span>
                </div>
            </div>
        </div>
    </td>
    <td><a href="javascript:;"><i class="far fa-times-circle"></i></a></td>
    <td id="itemtotalp"><?php echo $sale['amount']; ?></td>
</tr>




<?php } ?>

<?php } else if ($_POST['__FILE__'] == 'salesDelete'){ 
    foreach ($pdo->read("sales_1", ['invoice_number'=>$_POST['invoice_number'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']]) as $sale) {
        if (!empty($sale)) {
            $pdo->delete("sales_1", $sale['id']);
        }
    }

    $pdo->read("sales_2", ['invoice_number'=> $_POST['invoice_number'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']])
    ?>


<?php } else if ($_POST['__FILE__'] == "typeQ") {
   if (!empty($_POST['productId'])){
        $pr = $pdo->read("products", ['id' => $_POST['productId'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']]);
        $type = $_POST['type'];
        $quantityType = $_POST['typeQuantity'];

        $pdData = [];

        if ($type != "rf" && $type != "") {
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
   }
?>

<?php } else if ($_POST['__FILE__'] == "customerData") {
    $onecus = $pdo->read("sales_2", ['id' => $_POST['cusId']]);
            ?>
<tr>

    <td><?php echo $onecus[0]['customer_name']; ?></td>


</tr>


<?php } else if ($_POST['__FILE__'] == "runtimeTableDataEdit") {  ?>
    <?php


$array = json_decode($_POST['target'], true);
$keys = array_keys($array);
$key = preg_replace('/TabledData\d+/', '', trim($keys[0]));
preg_match('/\d+$/', trim($keys[0]), $matches);
$id = $matches[0];


if ($key == "quantity") {
    $selectedItem = $pdo->read("sales_1", ['id' => $id]);
    $previousAmount = $selectedItem[0]['amount'];
    $pdo->update("sales_1", ['id' => $id], ['amount' => array_values($array)[0] * $selectedItem[0]['item_price'], 'quantity' => array_values($array)[0]]);

} else if ($key == "discount") {
    $selectedItem = $pdo->read("sales_1", ['id' => $id]);
    $pdo->update("sales_1", ['id' => $id], ['amount' => $selectedItem[0]['quantity'] * $selectedItem[0]['item_price'] - array_values($array)[0], 'discount' => array_values($array)[0]]);

} else if ($key == "extra_discount") {
    $selectedItem = $pdo->read("sales_1", ['id' => $id]);
    $pdo->update("sales_1", ['id' => $id], ['amount' => $selectedItem[0]['quantity'] * $selectedItem[0]['item_price'] - array_values($array)[0], 'extra_discount' => array_values($array)[0]]);

}
?>


<?php } ?>