<?php

session_start();
require_once 'assets/includes/pdo.php';



if ($_POST['__FILE__'] == "search_sales_1") { 
    $sales_1 = "";
    $html = "";
    if (!empty($_POST['start_date']) && !empty($_POST['end_date']) && !empty($_POST['booker_name'])) {
        $sales_1 = $pdo->customQuery("SELECT *, SUM(item_price) AS total_price FROM sales_1 WHERE Date(date) BETWEEN '{$_POST['start_date']}' AND '{$_POST['end_date']}' AND company_profile_id = '{$_SESSION['ovalfox_pos_cp_id']}' AND booker_name = '{$_POST['booker_name']}' GROUP BY item_code");
    } else if (!empty($_POST['start_date']) && !empty($_POST['end_date'])) {
        $sales_1 = $pdo->customQuery("SELECT *, SUM(item_price) AS total_price FROM sales_1 WHERE Date(date) BETWEEN '{$_POST['start_date']}' AND '{$_POST['end_date']}' AND company_profile_id = '{$_SESSION['ovalfox_pos_cp_id']}' GROUP BY item_code");
    } else if (!empty($_POST['start_date']) && !empty($_POST['booker_name'])) {
        $sales_1 = $pdo->customQuery("SELECT *, SUM(item_price) AS total_price FROM sales_1 WHERE Date(date) = '{$_POST['start_date']}' AND company_profile_id = '{$_SESSION['ovalfox_pos_cp_id']}' AND booker_name = '{$_POST['booker_name']}' GROUP BY item_code");
    } else if (!empty($_POST['start_date'])) {
        $sales_1 = $pdo->customQuery("SELECT *, SUM(item_price) AS total_price FROM sales_1 WHERE Date(date) = '{$_POST['start_date']}' AND company_profile_id = '{$_SESSION['ovalfox_pos_cp_id']}' GROUP BY item_code");
    } else if (!empty($_POST['booker_name'])) {
        $sales_1 = $pdo->customQuery("SELECT *, SUM(item_price) AS total_price FROM sales_1 WHERE company_profile_id = '{$_SESSION['ovalfox_pos_cp_id']}' AND booker_name = '{$_POST['booker_name']}' GROUP BY item_code");
    }
    $html = "<table id='search_table' class='table table-striped table-bordered dt-responsive'>
    <thead>
        <tr>
            <th>#</th>
                        <th>Inv</th>
            <th>Customer</th>
            <th>Booker</th>
            <th>Operator</th>
            <th>Date</th>

            <th>Item code</th>
            <th>Item name</th>
            <th>Item price</th>
            <th>Qty</th>
                    <th>Amount</th>
            <th>Discount</th>
            <th>Extra Discount</th>
            <th>%</th>
            <th>Grand Total</th>


    </thead>
    <tbody>";
         
foreach ($sales_1 as $sale_1) {
    $customer = $pdo->read("customers", ['id' => $sale_1['customer_name']]);
    $booker_name = $pdo->read("access", ['id' => $sale_1['booker_name']]);
    $operator = $pdo->read("access", ['id' => $sale_1['operator_name']]);
        $html .= "<tr>
            <td>{$sale_1['id']}</td>
                        <td>{$sale_1['invoice_number']}</td>
            <td>{$customer[0]['name']}</td>
            <td>{$booker_name[0]['username']}</td>
            <td>{$operator[0]['username']}</td>
            <td>{$sale_1['date']}</td>

            <td>{$sale_1['item_code']}</td>
            <td>{$sale_1['item_name']}</td>
            <td>{$sale_1['total_price']}</td>
            <td>{$sale_1['quantity']}</td>
            <td>{$sale_1['amount']}</td>
            <td>{$sale_1['discount']}</td>
            <td>{$sale_1['extra_discount']}</td>
            <td>{$sale_1['percentage']}</td>
            <td>{$sale_1['grand_total']}</td>

        </tr>";
         } 
    $html .= "</tbody>

</table>";
    echo json_encode([$html, $sales_1]);
    

?>






<?php } else if ($_POST['__FILE__'] == "search_sales_2") {
    $sales_2 = ""; 
    $html = "";

    if (!empty($_POST['start_date']) && !empty($_POST['end_date']) && !empty($_POST['booker_name']) && !empty($_POST['customer_name'])) {
        $sales_2 = $pdo->customQuery("SELECT * FROM sales_2 WHERE Date(date) BETWEEN '{$_POST['start_date']}' AND '{$_POST['end_date']}' AND company_profile_id = '{$_SESSION['ovalfox_pos_cp_id']}' AND customer_name = '{$_POST['customer_name']}' AND booker_name = '{$_POST['booker_name']}'");
    } else if (!empty($_POST['start_date']) && !empty($_POST['booker_name']) && !empty($_POST['customer_name'])) {
        $sales_2 = $pdo->customQuery("SELECT * FROM sales_2 WHERE Date(date) = '{$_POST['start_date']}' AND company_profile_id = '{$_SESSION['ovalfox_pos_cp_id']}' AND customer_name = '{$_POST['customer_name']}' AND booker_name = '{$_POST['booker_name']}'");
    } else if (!empty($_POST['start_date']) && !empty($_POST['end_date']) && !empty($_POST['customer_name'])) {
        $sales_2 = $pdo->customQuery("SELECT * FROM sales_2 WHERE Date(date) BETWEEN '{$_POST['start_date']}' AND '{$_POST['end_date']}' AND company_profile_id = '{$_SESSION['ovalfox_pos_cp_id']}' AND customer_name = '{$_POST['customer_name']}'");
    } else if (!empty($_POST['start_date']) && !empty($_POST['customer_name'])) {
        $sales_2 = $pdo->customQuery("SELECT * FROM sales_2 WHERE Date(date) = '{$_POST['start_date']}' AND company_profile_id = '{$_SESSION['ovalfox_pos_cp_id']}' AND customer_name = '{$_POST['customer_name']}'");
    } else if (!empty($_POST['start_date']) && !empty($_POST['end_date']) && !empty($_POST['booker_name'])) {
        $sales_2 = $pdo->customQuery("SELECT * FROM sales_2 WHERE Date(date) BETWEEN '{$_POST['start_date']}' AND '{$_POST['end_date']}' AND company_profile_id = '{$_SESSION['ovalfox_pos_cp_id']}' AND booker_name = '{$_POST['booker_name']}'");
    } else if (!empty($_POST['start_date']) && !empty($_POST['booker_name'])) {
        $sales_2 = $pdo->customQuery("SELECT * FROM sales_2 WHERE Date(date) = '{$_POST['start_date']}' AND company_profile_id = '{$_SESSION['ovalfox_pos_cp_id']}' AND booker_name = '{$_POST['booker_name']}'");
    } else if (!empty($_POST['booker_name']) && !empty($_POST['customer_name'])) {
        $sales_2 = $pdo->customQuery("SELECT * FROM sales_2 WHERE company_profile_id = '{$_SESSION['ovalfox_pos_cp_id']}' AND customer_name = '{$_POST['customer_name']}' AND booker_name = '{$_POST['booker_name']}'");
    } else if (!empty($_POST['booker_name'])) {
        $sales_2 = $pdo->customQuery("SELECT * FROM sales_2 WHERE company_profile_id = '{$_SESSION['ovalfox_pos_cp_id']}' AND booker_name = '{$_POST['booker_name']}'");
    } else if (!empty($_POST['customer_name'])) {
        $sales_2 = $pdo->customQuery("SELECT * FROM sales_2 WHERE company_profile_id = '{$_SESSION['ovalfox_pos_cp_id']}' AND customer_name = '{$_POST['customer_name']}'");
    } else if (!empty($_POST['start_date']) && !empty($_POST['end_date'])) {
        $sales_2 = $pdo->customQuery("SELECT * FROM sales_2 WHERE Date(date) BETWEEN '{$_POST['start_date']}' AND '{$_POST['end_date']}' AND company_profile_id = '{$_SESSION['ovalfox_pos_cp_id']}'");
    } else if (!empty($_POST['start_date'])) {
        $sales_2 = $pdo->customQuery("SELECT * FROM sales_2 WHERE Date(date) = '{$_POST['start_date']}'");
    }
    $html = "
    <table id='search_table' class='table table-striped table-bordered dt-responsive'>
    <thead>
        <tr>
            <th>#</th>
            <th>Invoice number</th>
            <th>Bill number</th>

            <th>Customer name</th>
            <th>Booker name</th>
            <th>Operator name</th>
            <th>Date</th>
            <th>Total amount</th>

            <th>Discount</th>
            <th>Final amount</th>
            <th>Received amount</th>
            <th>Returned amount</th>
            <th>Pneding amount</th>
            <th>Status</th>

        </tr>
    </thead>
    <tbody>";
foreach ($sales_2 as $sale_2) {
    $customer = $pdo->read("customers", ['id' => $sale_2['customer_name']]);
    $booker_name = $pdo->read("access", ['id' => $sale_2['booker_name']]);
    $operator = $pdo->read("access", ['id' => $sale_2['operator_name']]);
        $html .= "<tr>
            <td>{$sale_2['id']}</td>
            <td>{$sale_2['invoice_number']}</td>
            <td>{$sale_2['bill_number']}</td>

            <td>{$customer[0]['name']}</td>
            <td>{$booker_name[0]['username']}</td>
            <td>{$operator[0]['username']}</td>
            <td>{$sale_2['date']}</td>
            <td>{$sale_2['total_amount']}</td>

            <td>{$sale_2['discount']}</td>
            <td>{$sale_2['final_amount']}</td>
            <td>{$sale_2['recevied_amount']}</td>
            <td>{$sale_2['returned_amount']}</td>
            <td>{$sale_2['pending_amount']}</td>
            <td>{$sale_2['status']}</td>

        </tr>";
         } 

         $html .= "</tbody>

</table>
    ";
    echo json_encode([$html, $sales_2]);

?>





<?php } else if ($_POST['__FILE__'] == "search_purchase_1") {
    $purchases_1 = "";
    $html = "";
    if (!empty($_POST['start_date']) && !empty($_POST['end_date'])) {
        $purchases_1 = $pdo->customQuery("SELECT * FROM purchases_1 WHERE Date(date) BETWEEN '{$_POST['start_date']}' AND '{$_POST['end_date']}' AND company_profile_id = {$_SESSION['ovalfox_pos_cp_id']}");
    } else if (!empty($_POST['start_date']) && !empty($_POST['supplier'])) {
        $purchases_1 = $pdo->customQuery("SELECT * FROM purchases_1 WHERE Date(date) = '{$_POST['start_date']}' AND company_name = '{$_POST['supplier']}' AND company_profile_id = {$_SESSION['ovalfox_pos_cp_id']}");

    } else if (!empty($_POST['start_date']) && !empty($_POST['end_date']) && !empty($_POST['supplier'])) {
        $purchases_1 = $pdo->customQuery("SELECT * FROM purchases_1 WHERE Date(date) BETWEEN '{$_POST['start_date']}' AND '{$_POST['end_date']}' AND company_name = '{$_POST['supplier']}' AND company_profile_id = {$_SESSION['ovalfox_pos_cp_id']}");

    } else if (!empty($_POST['start_date'])) {
        $purchases_1 = $pdo->customQuery("SELECT * FROM purchases_1 WHERE Date(date) = '{$_POST['start_date']}' AND company_profile_id = {$_SESSION['ovalfox_pos_cp_id']}");

    }

    $html = "
    <table id='search_table' class='table table-striped table-bordered dt-responsive'>
    <thead>
        <tr>
            <th>#</th>
            <th>Order number</th>
            <th>Bill number</th>

            <th>Date</th>
            <th>Operator</th>
            <th>Company name</th>
            <th>Item code</th>
            <th>Item name</th>

            <th>Item price</th>
            <th>Quantity</th>
            <th>Total amount</th>
            <th>Discount</th>
            <th>Net amount</th>
            <th>Product expiry</th>

        </tr>
    </thead>
    <tbody>";
foreach ($purchases_1 as $purchase_1) {

        $html .= "<tr>
            <td>#</td>
            <td>{$purchase_1['order_number']}</td>
            <td>{$purchase_1['bill_number']}</td>

            <td>{$purchase_1['date']}</td>
            <td>{$purchase_1['operator']}</td>
            <td>{$purchase_1['company_name']}</td>
            <td>{$purchase_1['item_code']}</td>
            <td>{$purchase_1['item_name']}</td>

            <td>{$purchase_1['item_price']}</td>
            <td>{$purchase_1['quantity']}</td>
            <td>{$purchase_1['total_amount']}</td>
            <td>{$purchase_1['discount']}</td>
            <td>{$purchase_1['net_amount']}</td>
            <td>{$purchase_1['product_expiry']}</td>

        </tr>";
        }
        $html .= "

    </tbody>

</table>
    ";
    echo json_encode([$html, $purchases_1]);

?>





<?php } else if ($_POST['__FILE__'] == "search_purchase_2") { 
    $purchases_2 = $pdo->customQuery("SELECT * FROM purchases_2 WHERE created_at BETWEEN '{$_POST['start_date']}' AND '{$_POST['end_date']}' AND company_profile_id = {$_SESSION['ovalfox_pos_cp_id']}");
?>


<table id="search_table" class="table table-striped table-bordered dt-responsive">
    <thead>
        <tr>
            <th>#</th>
            <th>Order number</th>
            <th>Bill number</th>

            <th>Date</th>
            <th>Operator</th>
            <th>Company name</th>

            <th>Total amount</th>
            <th>Paid amount</th>
            <th>Remaining amount</th>

            <th>Created at</th>
        </tr>
    </thead>
    <tbody>
        <?php 
foreach ($purchases_2 as $purchase_2) {

?>
        <tr>
            <td>#</td>
            <td><?php echo $purchase_2['order_number']; ?></td>
            <td><?php echo $purchase_2['bill_number']; ?></td>

            <td><?php echo $purchase_2['date']; ?></td>
            <td><?php echo $purchase_2['operator']; ?></td>
            <td><?php echo $purchase_2['company_name']; ?></td>

            <td><?php echo $purchase_2['total_amount']; ?></td>
            <td><?php echo $purchase_2['paid_amount']; ?></td>
            <td><?php echo $purchase_2['remaining_amount']; ?></td>

            <td><?php echo $purchase_2['created_at']; ?></td>
        </tr>
        <?php } ?>

    </tbody>

</table>


<?php } else if ($_POST['__FILE__'] == "search_ledger") { 
    $ledgers = "";

    if (!empty($_POST["customer_name"]) && !empty($_POST['start_date'])) {
        $ledgers = $pdo->customQuery("SELECT *, SUM(total_amount) AS total_price FROM ledger WHERE Date(date) = '{$_POST['start_date']}' AND customer_name = {$_POST["customer_name"]} AND company_profile_id = {$_SESSION['ovalfox_pos_cp_id']}");
    } else if (!empty($_POST["customer_name"]) && !empty($_POST['start_date']) && !empty($_POST['end_date'])) {
        $ledgers = $pdo->customQuery("SELECT *, SUM(total_amount) AS total_price FROM ledger WHERE Date(date) BETWEEN '{$_POST['start_date']}' AND '{$_POST['end_date']}' AND customer_name = {$_POST["customer_name"]} AND company_profile_id = {$_SESSION['ovalfox_pos_cp_id']}");
    } else if (!empty($_POST["customer_name"])) {
        $ledgers = $pdo->customQuery("SELECT *, SUM(total_amount) AS total_price FROM ledger WHERE  customer_name = {$_POST["customer_name"]} AND company_profile_id = {$_SESSION['ovalfox_pos_cp_id']}");
    }
?>


<table id="search_table" class="table table-striped table-bordered dt-responsive">
    <thead>
        <tr>
            <th>#</th>
            <th>Date</th>
            <th>Payment type</th>

            <th>Total amount</th>
            <th>Recevied amount</th>
            <th>Details</th>

            <th>Payment from</th>
            <th>Dr</th>
            <th>Cr</th>
            <th>Remaining amount</th>

            <th>Created at</th>
        </tr>
    </thead>
    <tbody>
        <?php 
foreach ($ledgers as $ledger) {

?>
        <tr>
            <td>#</td>
            <td><?php echo $ledger['date']; ?></td>
            <td><?php echo $ledger['payment_type']; ?></td>

            <td><?php echo $ledger['total_amount']; ?></td>
            <td><?php echo $ledger['recevied_amount']; ?></td>
            <td><?php echo $ledger['details']; ?></td>

            <td><?php echo $ledger['payment_from']; ?></td>
            <td><?php echo $ledger['dr']; ?></td>
            <td><?php echo $ledger['cr']; ?></td>
            <td><?php echo $ledger['remaining_amount']; ?></td>

            <td><?php echo $ledger['created_at']; ?></td>
        </tr>
        <?php } ?>

    </tbody>

</table>


<?php } else if ($_POST['__FILE__'] == "search_daily_report") { 
    $sales_2 = "";


    $total_amount = [];
    $final_amount = [];
    $received_amount = [];
    $returned_amount = [];
    $pending_amount = [];
    

    if (!empty($_POST['start_date']) && !empty($_POST['end_date']) && !empty($_POST['booker_name']) && !empty($_POST['customer_name'])) {
        $sales_2 = $pdo->customQuery("SELECT *, SUM(total_amount) AS total_price FROM sales_2 WHERE Date(date) BETWEEN '{$_POST['start_date']}' AND '{$_POST['end_date']}' AND company_profile_id = '{$_SESSION['ovalfox_pos_cp_id']}' AND customer_name = '{$_POST['customer_name']}' AND booker_name = '{$_POST['booker_name']}'");
    } else if (!empty($_POST['start_date']) && !empty($_POST['booker_name']) && !empty($_POST['customer_name'])) {
        $sales_2 = $pdo->customQuery("SELECT *, SUM(total_amount) AS total_price FROM sales_2 WHERE Date(date) = '{$_POST['start_date']}' AND company_profile_id = '{$_SESSION['ovalfox_pos_cp_id']}' AND customer_name = '{$_POST['customer_name']}' AND booker_name = '{$_POST['booker_name']}'");
    } else if (!empty($_POST['start_date']) && !empty($_POST['end_date']) && !empty($_POST['customer_name'])) {
        $sales_2 = $pdo->customQuery("SELECT *, SUM(total_amount) AS total_price FROM sales_2 WHERE Date(date) BETWEEN '{$_POST['start_date']}' AND '{$_POST['end_date']}' AND company_profile_id = '{$_SESSION['ovalfox_pos_cp_id']}' AND customer_name = '{$_POST['customer_name']}'");
    } else if (!empty($_POST['start_date']) && !empty($_POST['customer_name'])) {
        $sales_2 = $pdo->customQuery("SELECT *, SUM(total_amount) AS total_price FROM sales_2 WHERE Date(date) = '{$_POST['start_date']}' AND company_profile_id = '{$_SESSION['ovalfox_pos_cp_id']}' AND customer_name = '{$_POST['customer_name']}'");
    } else if (!empty($_POST['start_date']) && !empty($_POST['end_date']) && !empty($_POST['booker_name'])) {
        $sales_2 = $pdo->customQuery("SELECT *, SUM(total_amount) AS total_price FROM sales_2 WHERE Date(date) BETWEEN '{$_POST['start_date']}' AND '{$_POST['end_date']}' AND company_profile_id = '{$_SESSION['ovalfox_pos_cp_id']}' AND booker_name = '{$_POST['booker_name']}'");
    } else if (!empty($_POST['start_date']) && !empty($_POST['booker_name'])) {
        $sales_2 = $pdo->customQuery("SELECT *, SUM(total_amount) AS total_price FROM sales_2 WHERE Date(date) = '{$_POST['start_date']}' AND company_profile_id = '{$_SESSION['ovalfox_pos_cp_id']}' AND booker_name = '{$_POST['booker_name']}'");
    } else if (!empty($_POST['booker_name']) && !empty($_POST['customer_name'])) {
        $sales_2 = $pdo->customQuery("SELECT *, SUM(total_amount) AS total_price FROM sales_2 WHERE company_profile_id = '{$_SESSION['ovalfox_pos_cp_id']}' AND customer_name = '{$_POST['customer_name']}' AND booker_name = '{$_POST['booker_name']}'");
    } else if (!empty($_POST['booker_name'])) {
        $sales_2 = $pdo->customQuery("SELECT *, SUM(total_amount) AS total_price FROM sales_2 WHERE company_profile_id = '{$_SESSION['ovalfox_pos_cp_id']}' AND booker_name = '{$_POST['booker_name']}'");
    } else if (!empty($_POST['customer_name'])) {
        $sales_2 = $pdo->customQuery("SELECT *, SUM(total_amount) AS total_price FROM sales_2 WHERE company_profile_id = '{$_SESSION['ovalfox_pos_cp_id']}' AND customer_name = '{$_POST['customer_name']}'");
    } else if (!empty($_POST['start_date']) && !empty($_POST['end_date'])) {
        $sales_2 = $pdo->customQuery("SELECT *, SUM(total_amount) AS total_price FROM sales_2 WHERE Date(date) BETWEEN '{$_POST['start_date']}' AND '{$_POST['end_date']}' AND company_profile_id = '{$_SESSION['ovalfox_pos_cp_id']}'");
    } else if (!empty($_POST['start_date'])) {
        $sales_2 = $pdo->customQuery("SELECT *, SUM(total_amount) AS total_price FROM sales_2 WHERE Date(date) = '{$_POST['start_date']}'");
    }
    foreach ($sales_2 as $sale) {
        $total_amount[] = $sale['total_amount'];
        $final_amount[] = $sale['final_amount'];
        $received_amount[] = $sale['recevied_amount'];
        $returned_amount[] = $sale['returned_amount'];
        $pending_amount[] = $sale['pending_amount'];

    }

    $total_amount = array_sum($total_amount);
    $final_amount = array_sum($final_amount);
    $received_amount = array_sum($received_amount);
    $returned_amount = array_sum($returned_amount);
    $pending_amount = array_sum($pending_amount);
?>


<table id="search_table" class="table table-striped table-bordered dt-responsive">
    <thead>
        <tr>
            <th>#</th>
            <th>Invoice number</th>
            <th>Bill number</th>

            <th>Customer name</th>
            <th>Booker name</th>
            <th>Operator name</th>
            <th>Date</th>
            <th>Total amount</th>

            <th>Discount</th>
            <th>Final amount</th>
            <th>Received amount</th>
            <th>Returned amount</th>
            <th>Pending amount</th>
            <th>Status</th>

            <th>Created at</th>
        </tr>
    </thead>
    <tbody>
        <?php 
foreach ($sales_2 as $sale_2) {

?>
        <tr>
            <td>#</td>
            <td><?php echo $sale_2['invoice_number']; ?></td>
            <td><?php echo $sale_2['bill_number']; ?></td>

            <td><?php echo $sale_2['customer_name']; ?></td>
            <td><?php echo $sale_2['booker_name']; ?></td>
            <td><?php echo $sale_2['operator_name']; ?></td>
            <td><?php echo $sale_2['date']; ?></td>
            <td><?php echo $sale_2['total_price']; ?></td>

            <td><?php echo $sale_2['discount']; ?></td>
            <td><?php echo $sale_2['final_amount']; ?></td>
            <td><?php echo $sale_2['recevied_amount']; ?></td>
            <td><?php echo $sale_2['returned_amount']; ?></td>
            <td><?php echo $sale_2['pending_amount']; ?></td>
            <td><?php echo $sale_2['status']; ?></td>

            <td><?php echo $sale_2['created_at']; ?></td>
        </tr>
        <?php } ?>


    </tbody>

</table>
<br /><br /><br />

<div style="display: flex;">
    <h6>Total Amount: <?php echo $total_amount; ?></h6>
    &nbsp;&nbsp;&nbsp;<h6>Final Amount: <?php echo $final_amount; ?></h6>
    &nbsp;&nbsp;&nbsp;<h6>Received Amount: <?php echo $received_amount; ?></h6>
    &nbsp;&nbsp;&nbsp;<h6>Returned Amount: <?php echo $returned_amount; ?></h6>
    &nbsp;&nbsp;&nbsp;<h6>Pending Amount: <?php echo $pending_amount; ?></h6>
</div>



<?php } else if ($_POST['__FILE__'] == "search_item_wise") { 
    $sales_1 = "";



    if (!empty($_POST['start_date']) && !empty($_POST['end_date']) && !empty($_POST['booker_name']) && !empty($_POST['customer_name']) && !empty($_POST['product_name'])) {
        $sales_1 = $pdo->customQuery("SELECT *, SUM(amount) AS total_price FROM sales_1 WHERE Date(date) BETWEEN '{$_POST['start_date']}' AND '{$_POST['end_date']}' AND company_profile_id = '{$_SESSION['ovalfox_pos_cp_id']}' AND customer_name = '{$_POST['customer_name']}' AND item_code = '{$_POST['product_name']}' AND booker_name = '{$_POST['booker_name']}'");
    } else if (!empty($_POST['start_date']) && !empty($_POST['booker_name']) && !empty($_POST['customer_name']) && !empty($_POST['product_name'])) {
        $sales_1 = $pdo->customQuery("SELECT *, SUM(amount) AS total_price FROM sales_1 WHERE Date(date) = '{$_POST['start_date']}' AND company_profile_id = '{$_SESSION['ovalfox_pos_cp_id']}' AND customer_name = '{$_POST['customer_name']}' AND item_code = '{$_POST['product_name']}' AND booker_name = '{$_POST['booker_name']}'");
    } else if (!empty($_POST['start_date']) && !empty($_POST['end_date']) && !empty($_POST['customer_name']) && !empty($_POST['product_name'])) {
        $sales_1 = $pdo->customQuery("SELECT *, SUM(amount) AS total_price FROM sales_1 WHERE Date(date) BETWEEN '{$_POST['start_date']}' AND '{$_POST['end_date']}' AND company_profile_id = '{$_SESSION['ovalfox_pos_cp_id']}' AND item_code = '{$_POST['product_name']}' AND customer_name = '{$_POST['customer_name']}'");
    } else if (!empty($_POST['start_date']) && !empty($_POST['customer_name'])) {
        $sales_1 = $pdo->customQuery("SELECT *, SUM(amount) AS total_price FROM sales_1 WHERE Date(date) = '{$_POST['start_date']}' AND company_profile_id = '{$_SESSION['ovalfox_pos_cp_id']}' AND item_code = '{$_POST['product_name']}' AND customer_name = '{$_POST['customer_name']}'");
    } else if (!empty($_POST['start_date']) && !empty($_POST['end_date']) && !empty($_POST['booker_name']) && !empty($_POST['product_name'])) {
        $sales_1 = $pdo->customQuery("SELECT *, SUM(amount) AS total_price FROM sales_1 WHERE Date(date) BETWEEN '{$_POST['start_date']}' AND '{$_POST['end_date']}' AND company_profile_id = '{$_SESSION['ovalfox_pos_cp_id']}' AND item_code = '{$_POST['product_name']}' AND booker_name = '{$_POST['booker_name']}'");
    } else if (!empty($_POST['start_date']) && !empty($_POST['booker_name']) && !empty($_POST['product_name'])) {
        $sales_1 = $pdo->customQuery("SELECT *, SUM(amount) AS total_price FROM sales_1 WHERE Date(date) = '{$_POST['start_date']}' AND company_profile_id = '{$_SESSION['ovalfox_pos_cp_id']}' AND item_code = '{$_POST['product_name']}' AND booker_name = '{$_POST['booker_name']}'");
    } else if (!empty($_POST['booker_name']) && !empty($_POST['customer_name']) && !empty($_POST['product_name'])) {
        $sales_1 = $pdo->customQuery("SELECT *, SUM(amount) AS total_price FROM sales_1 WHERE company_profile_id = '{$_SESSION['ovalfox_pos_cp_id']}' AND customer_name = '{$_POST['customer_name']}' AND item_code = '{$_POST['product_name']}' AND booker_name = '{$_POST['booker_name']}'");
    } else if (!empty($_POST['booker_name']) && !empty($_POST['product_name'])) {
        $sales_1 = $pdo->customQuery("SELECT *, SUM(amount) AS total_price FROM sales_1 WHERE company_profile_id = '{$_SESSION['ovalfox_pos_cp_id']}' AND item_code = '{$_POST['product_name']}' AND booker_name = '{$_POST['booker_name']}'");
    } else if (!empty($_POST['customer_name']) && !empty($_POST['product_name'])) {
        $sales_1 = $pdo->customQuery("SELECT *, SUM(amount) AS total_price FROM sales_1 WHERE company_profile_id = '{$_SESSION['ovalfox_pos_cp_id']}' AND item_code = '{$_POST['product_name']}' AND customer_name = '{$_POST['customer_name']}'");
    } else if (!empty($_POST['start_date']) && !empty($_POST['end_date']) && !empty($_POST['product_name'])) {
        $sales_1 = $pdo->customQuery("SELECT *, SUM(amount) AS total_price FROM sales_1 WHERE Date(date) BETWEEN '{$_POST['start_date']}' AND '{$_POST['end_date']}' AND item_code = '{$_POST['product_name']}' AND  company_profile_id = '{$_SESSION['ovalfox_pos_cp_id']}'");
    } else if (!empty($_POST['start_date']) && !empty($_POST['product_name'])) {
        $sales_1 = $pdo->customQuery("SELECT *, SUM(amount) AS total_price FROM sales_1 WHERE Date(date) = '{$_POST['start_date']}' AND item_code = '{$_POST['product_name']}'");
    }

?>


<table id="search_table" class="table table-striped table-bordered dt-responsive">
    <thead>
        <tr>
            <th>#</th>
            <th>Item code</th>
            <th>Item name</th>
            <th>Item price</th>
            <th>Qty</th>
            <th>Total price</th>
            <th>My rate</th>

            <th>%</th>
            <th>Total amount</th>
            <th>Commision</th>
        </tr>
    </thead>
    <tbody>
        <?php 
foreach ($sales_1 as $sale_1) {

?>
        <tr>
            <td>#</td>
            <td><?php echo $sale_1['item_code']; ?></td>
            <td><?php echo $sale_1['item_name']; ?></td>
            <td><?php echo $sale_1['total_price']; ?></td>
            <td><?php echo $sale_1['quantity']; ?></td>

            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>

        </tr>
        <?php } ?>


    </tbody>

</table>




<?php } ?>