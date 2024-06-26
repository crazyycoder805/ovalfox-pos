<?php
session_start();
require_once '../assets/includes/pdo.php';

$_POST['date'] = str_replace("T", " ", $_POST['date']);
$item_name = ($_POST['type'] != "rf" ? ($_POST['isItemFree'] == "true" ? "(Free Item)" . " " . $_POST['item_name'] : $_POST['item_name']) : ('(Refunded)' . " " . $_POST['item_name']));
    
    $sales_1 = $pdo->read("sales_1", ['invoice_number' => $_POST['invoice_number'], 'item_code' => $_POST['item_code']
    , 'item_name' => $item_name
    , 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']]);
if (!empty($_POST['invoice_number']) && (!empty($_POST['customer_name']) || !empty($_POST['customer_manual'])) && 
!empty($_POST['booker_name']) && !empty($_POST['date']) && !empty($_POST['date']) && !empty($_POST['total_quantity']) 
&& (!empty($_POST['item_code_search']) || !empty($_POST['product_id']))) {
    $_SESSION['booker_select'] = $_POST['booker_name'];
    
    $billNumber = $pdo->customQuery("SELECT MAX(CAST(bill_number AS UNSIGNED)) AS billNumber,
    company_profile_id, customer_name FROM sales_2 WHERE customer_name = '{$_POST['customer_name']}' AND company_profile_id = {$_SESSION['ovalfox_pos_cp_id']}")[0]['billNumber'] + 1;

    $customerId = "";
    $customer = "";
    
    $discount = 0;
    $extra_discount = 0;

    if (!empty($_POST['discount'])) $discount = $_POST['discount'];
    if (!empty($_POST['extra_discount'])) $extra_discount = $_POST['extra_discount'];

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
        

        $pdo->update("products", ['id' => $_POST['product_id'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']], 
        ["total_quantity" => $_POST['total_quantity']]);
        if (empty($pdo->read("sales_2", ["invoice_number" => $_POST['invoice_number'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']]))) {
            

            if ($pdo->create("sales_2", ['invoice_number' => $_POST['invoice_number'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id'], 
            'customer_name' => !empty($_POST['customer_manual']) ? $customerId[0]['id'] : $_POST['customer_name'], 
            'booker_name' => $_POST['booker_name'], 'operator_name' => $_POST['booker_name'], 'date' => $_POST['date'], 'discount' => 0, 
            'bill_number' => $billNumber, 'total_amount' => $_POST['total_amount'], 'final_amount' => 0, 'recevied_amount' => 0, 
            'returned_amount' => 0, 'pending_amount' => 0, 'status' => "Refund"])) {
                echo "Item added.";
                

            } else {
                echo "Something went wrong.";
                


            }
        } else {

            $pdo->update("sales_2", ["invoice_number" => $_POST['invoice_number'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']], ['total_amount' => $_POST['total_amount']]);
            

        }
        if (empty($sales_1)) {
            if ($_POST['amountIn'] == "amount") {
                $discount = empty($sales_1[0]['discount']) ? (double)$_POST['discount'] : (double)$sales_1[0]['discount'];
                $extra_discount = empty($sales_1[0]['extra_discount']) ? (double)$_POST['extra_discount'] : (double)$sales_1[0]['extra_discount'];
                // Fetch and validate quantity and item price
                $quantity = (double)($_POST['quantity']);
                $item_price = (double)($_POST['item_price']);

                // Calculate total price before any discounts
                $total_price_before_discounts = $quantity * $item_price;

                // Apply extra discount
                $total_price_after_extra_discount = $total_price_before_discounts;
                if ($total_price_after_extra_discount > 0) {
                    $discount_percentage = round(($discount / $total_price_after_extra_discount) * 100, 2);
                } else {
                    $discount_percentage = 0;
                }
             
                $pdo->create("sales_1", ['invoice_number' => $_POST['invoice_number'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id'], 
                'customer_name' => !empty($_POST['customer_manual']) ? $customerId[0]['id'] : $_POST['customer_name'], 
                'booker_name' => $_POST['booker_name'], 'operator_name' => $_POST['booker_name'], 'date' => $_POST['date'], 
                'item_code' => $_POST['item_code'], 'item_name' => $item_name, 'item_price' => $_POST['item_price'], 
                'quantity' => (empty($_POST['quantity']) ? 0 : $_POST['quantity']), 
                'grand_total' => ($_POST['isItemFree'] == "true" ? 0 : ((($_POST['quantity'] * $_POST['item_price']) - $discount) - $extra_discount)), 
                'percentage' => $discount_percentage, 
                'amount' => ($_POST['isItemFree'] == "true" ? 0 : (empty($_POST['taaup']) ? 0 : $_POST['taaup'])), 
                'discount' => round(empty($_POST['discount']) ? 0 : $_POST['discount'], 2), 
                'extra_discount' => empty($_POST['extra_discount']) ? 0 : $_POST['extra_discount']]);
            } else {
                $discount2 = $_POST['discount'] == 0 ? 0 :
                ((($_POST['quantity'] * $_POST['item_price']) * (1 - ($_POST['discount'] / 100))));
                $percentageCut = $_POST['discount'] == 0 ? 0 : ($_POST['quantity'] * $_POST['item_price']) - $discount2;
                $pdo->create("sales_1", ['invoice_number' => $_POST['invoice_number'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id'], 
                'customer_name' => !empty($_POST['customer_manual']) ? $customerId[0]['id'] : $_POST['customer_name'], 
                'booker_name' => $_POST['booker_name'], 'operator_name' => $_POST['booker_name'], 'date' => $_POST['date'], 
                'item_code' => $_POST['item_code'], 'item_name' => $item_name, 'item_price' => $_POST['item_price'], 
                'quantity' => (empty($_POST['quantity']) ? 0 : $_POST['quantity']), 
                'grand_total' => ($_POST['isItemFree'] == "true" ? 0 : ((($_POST['quantity'] * $_POST['item_price']) - $percentageCut) - $extra_discount)), 
                'percentage' => $_POST['discount'], 
                'amount' => ($_POST['isItemFree'] == "true" ? 0 : (empty($_POST['taaup']) ? 0 : $_POST['taaup'])), 
                'discount' => round($percentageCut, 2), 
                'extra_discount' => empty($_POST['extra_discount']) ? 0 : $_POST['extra_discount']]);
            }
        

        } else {
            $qun = ($sales_1[0]['quantity'] + $_POST['quantity']);

            $discount = (double)$sales_1[0]['discount'];
            $extra_discount = (double)$sales_1[0]['extra_discount'];
            $quantity = (double)($qun);
            $item_price = (double)($sales_1[0]['item_price']);

            $total_price_before_discounts = $quantity * $item_price;
            $discount_percentage = 0;
            $total_price_after_extra_discount = $total_price_before_discounts;
            if ($total_price_after_extra_discount > 0) {
                $discount_percentage = round(($discount / $total_price_after_extra_discount) * 100, 2);
            } else {
                $discount_percentage = 0;
            }

            $discountedValue = round($discount_percentage == 0 ? 0 :
            ((($qun * $sales_1[0]['item_price']) * 
            (1 - (round($discount_percentage, 2) / 100)))), 2);

            $pdo->update("sales_1", ["invoice_number" => $_POST['invoice_number'], 'item_code' => $_POST['item_code'], 'item_name' => $item_name, 
            'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']], ['quantity' => 
            $qun, 'amount' => $_POST['isItemFree'] == "true" ? 0 : ($qun * $sales_1[0]['item_price']),
            'percentage' => $discount_percentage,
            'discount' => ($qun * $sales_1[0]['item_price']) - $discountedValue,
            'grand_total' => $_POST['isItemFree'] == "true" ? 0 : ($discountedValue - $extra_discount)]);
            
        }
    } else {

        $pdo->update("products", ['id' => $_POST['product_id'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']], ["total_quantity" => $_POST['total_quantity']]);
        

        if (empty($pdo->read("sales_2", ["invoice_number" => $_POST['invoice_number'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']]))) {
            $pdo->create("sales_2", ['invoice_number' => $_POST['invoice_number'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id'], 
            'customer_name' => !empty($_POST['customer_manual']) ? $customerId[0]['id'] : $_POST['customer_name'], 'booker_name' => $_POST['booker_name'], 
            'operator_name' => $_POST['booker_name'], 'date' => $_POST['date'], 'discount' => 0, 'bill_number' => $billNumber, 
            'total_amount' => $_POST['total_amount'], 'final_amount' => 0, 'recevied_amount' => 0,  
            'returned_amount' => 0, 'pending_amount' => 0, 'status' => "Incomplete"]);
            

        } else {
            $pdo->update("sales_2", ["invoice_number" => $_POST['invoice_number'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']], ['total_amount' => 
            $_POST['total_amount']]);
            

        }




        if (empty($sales_1)) {
            if ($_POST['amountIn'] == "amount") {
                $discount = empty($sales_1[0]['discount']) ? (double)($_POST['discount']) : (double)($sales_1[0]['discount']);
                $extra_discount = empty($sales_1[0]['extra_discount']) ? (double)($_POST['extra_discount']) : (double)($sales_1[0]['extra_discount']);
                // Fetch and validate quantity and item price
                $quantity = (double)($_POST['quantity']);
                $item_price = (double)($_POST['item_price']);

                // Calculate total price before any discounts
                $total_price_before_discounts = $quantity * $item_price;
                $discount_percentage = 0;
                // Apply extra discount
                $total_price_after_extra_discount = $total_price_before_discounts;
                if ($total_price_after_extra_discount > 0) {
                    $discount_percentage = round(($discount / $total_price_after_extra_discount) * 100, 2);
                } else {
                    $discount_percentage = 0;
                }
                $pdo->create("sales_1", ['invoice_number' => $_POST['invoice_number'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id'], 
                'customer_name' => !empty($_POST['customer_manual']) ? $customerId[0]['id'] : $_POST['customer_name'], 
                'booker_name' => $_POST['booker_name'], 'operator_name' => $_POST['booker_name'], 'date' => $_POST['date'], 
                'item_code' => $_POST['item_code'], 'item_name' => $item_name, 'item_price' => $_POST['item_price'], 
                'quantity' => (empty($_POST['quantity']) ? 0 : $_POST['quantity']), 
                'grand_total' => ($_POST['isItemFree'] == "true" ? 0 : ((($_POST['quantity'] * $_POST['item_price']) - $discount) - $extra_discount)), 
                'percentage' => $discount_percentage, 
                'amount' => ($_POST['isItemFree'] == "true" ? 0 : (empty($_POST['taaup']) ? 0 : $_POST['taaup'])), 
                'discount' => round(empty($_POST['discount']) ? 0 : $_POST['discount'], 2), 
                'extra_discount' => empty($_POST['extra_discount']) ? 0 : $_POST['extra_discount']]);
            } else {
                $discount2 = $_POST['discount'] == 0 ? 0 :
                ((((double)($_POST['quantity']) * (double)($_POST['item_price'])) * (1 - ((double)($_POST['discount']) / 100))));
                $percentageCut = $_POST['discount'] == 0 ? 0 : ($_POST['quantity'] * $_POST['item_price']) - $discount2;



                $pdo->create("sales_1", ['invoice_number' => $_POST['invoice_number'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id'], 
                'customer_name' => !empty($_POST['customer_manual']) ? $customerId[0]['id'] : $_POST['customer_name'], 
                'booker_name' => $_POST['booker_name'], 'operator_name' => $_POST['booker_name'], 'date' => $_POST['date'], 
                'item_code' => $_POST['item_code'], 'item_name' => $item_name, 'item_price' => $_POST['item_price'], 
                'quantity' => (empty($_POST['quantity']) ? 0 : $_POST['quantity']), 
                'grand_total' => ($_POST['isItemFree'] == "true" ? 0 : ((($_POST['quantity'] * $_POST['item_price']) - $percentageCut) - $extra_discount)), 
                'percentage' => $_POST['discount'], 
                'amount' => ($_POST['isItemFree'] == "true" ? 0 : (empty($_POST['taaup']) ? 0 : $_POST['taaup'])), 
                'discount' => round($percentageCut, 2), 
                'extra_discount' => empty($_POST['extra_discount']) ? 0 : $_POST['extra_discount']]);
            }
        
        } else {
            $qun = ($sales_1[0]['quantity'] + $_POST['quantity']);

            $discount = (double)$sales_1[0]['discount'];
            $extra_discount = (double)$sales_1[0]['extra_discount'];
            $quantity = (double)($qun);
            $item_price = (double)($sales_1[0]['item_price']);

            $total_price_before_discounts = $quantity * $item_price;
            $discount_percentage = 0;
            $total_price_after_extra_discount = $total_price_before_discounts;
            if ($total_price_after_extra_discount > 0) {
                $discount_percentage = round(($discount / $total_price_after_extra_discount) * 100, 2);
            } else {
                $discount_percentage = 0;
            }

            $discountedValue = round($discount_percentage == 0 ? 0 :
            ((($qun * $sales_1[0]['item_price']) * 
            (1 - (round($discount_percentage, 2) / 100)))), 2);

            $pdo->update("sales_1", ["invoice_number" => $_POST['invoice_number'], 'item_code' => $_POST['item_code'], 'item_name' => $item_name, 
            'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']], ['quantity' => 
            $qun, 'amount' => $_POST['isItemFree'] == "true" ? 0 : ($qun * $sales_1[0]['item_price']),
            'percentage' => $discount_percentage,
            'discount' => ($qun * $sales_1[0]['item_price']) - $discountedValue,
            'grand_total' => $_POST['isItemFree'] == "true" ? 0 : ($discountedValue - $extra_discount)]);
            


        }

     
    }

}

foreach ($sales_1 as $key => $sale) {
    $gt = !empty($sale['grand_total']) ? $sale['grand_total'] : $sale['amount'];

    $key += 1;
    ?>



<tr>

    <td style='font-size: 21px !important;font-weight:bolder;'><?php echo $key; ?></td>
    <td style='font-size: 13px !important;font-weight:bolder;' id='item_codeTabledData<?php echo $sale['id'];?>'>
        <?php echo $sale['item_code']; ?></td>
    <td style='width:400px;font-size: 13px !important;font-weight:bolder;' id='item_nameTabledData<?php echo $sale['id'];?>'>
        <?php echo $sale['item_name']; ?></td>
    <td style='font-size: 13px !important;font-weight:bolder;' id='quantityTabledData<?php echo $sale['id'];?>'
        <?php !preg_match('/\(Refunded\)/', $sale['item_name']) && !preg_match('/\(Free Item\)/', $sale['item_name']) ? "contenteditable='true'" : ""; ?>>
        <?php echo $sale['quantity']; ?></td>

    <td style='font-size: 13px !important;font-weight:bolder;' id='item_priceTabledData<?php echo $sale['id'];?>'
        <?php !preg_match('/\(Refunded\)/', $sale['item_name']) && !preg_match('/\(Free Item\)/', $sale['item_name']) ? "contenteditable='true'" : ""; ?>>
        <?php echo $sale['item_price']; ?></td>
    <td style='font-size: 13px !important;font-weight:bolder;' id='amountTabledData<?php echo $sale['id'];?>'>
        <?php echo $sale['amount']; ?></td>
    <td style='font-size: 13px !important;font-weight:bolder;'
        
        id='discountTabledData<?php echo $sale['id'];?>'>
        <?php echo round($sale['discount'], 2); ?></td>
    <td style='font-size: 13px !important;font-weight:bolder;' id='extra_discountTabledData<?php echo $sale['id'];?>'
        <?php !preg_match('/\(Refunded\)/', $sale['item_name']) && !preg_match('/\(Free Item\)/', $sale['item_name']) ? "contenteditable='true'" : ""; ?>>
        <?php echo $sale['extra_discount']; ?></td>
    <td style='font-size: 13px !important;font-weight:bolder;' oninput="limitDecimalPlaces(this)"
        id='percentageTabledData<?php echo $sale['id'];?>'
        <?php !preg_match('/\(Refunded\)/', $sale['item_name']) && !preg_match('/\(Free Item\)/', $sale['item_name']) ? "contenteditable='true'" : ""; ?>>
        <?php echo $sale['percentage']; ?></td>
    <td style='font-size: 13px !important;font-weight:bolder;' id='grandTotalTabledData<?php echo $sale['id'];?>'>
        <?php echo $gt; ?></td>


    <td style='font-size: 13px !important;font-weight:bolder;'>
        <div style='position: relative;' class='container-cus'>
            <div style='
        position: absolute;
        top: 0;
        left: 0;
        width: 100%; /* Adjust width and height as needed */
        height: 100%;
        color: red;
        text-align: center;

        background-color: rgba(0, 0, 0, 1); /* Semi-transparent black overlay */' class='overlay-cus'>
                LOCKED
            </div>
            <div class='content-cus'>
                <button class="btn btn-danger btn-sm sales-btn-remove" value="<?php echo $sale['id']; ?>"
                    id="removeItem">Remove</button>
            </div>
        </div>

    </td>



</tr>
<?php } ?>