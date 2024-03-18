<?php

session_start();
require_once 'assets/includes/pdo.php';



if ($_POST['__FILE__'] == "search_sales_1") { 
    $sales_1 = "";

    if (!empty($_POST["end_date"])) { 
        $sales_1 = $pdo->customQuery("SELECT *, SUM(item_price) AS total_price FROM sales_1 WHERE created_at BETWEEN '{$_POST['start_date']}' AND '{$_POST['end_date']}' AND 'company_profile_id'= {$_SESSION['cp_id']} GROUP BY item_code");
    } else if (empty($_POST["end_date"])) {
        $sales_1 = $pdo->customQuery("SELECT *, SUM(item_price) AS total_price FROM sales_1 WHERE created_at = '{$_POST['start_date']}' AND 'company_profile_id'= {$_SESSION['cp_id']} GROUP BY item_code");
    } else if (!empty($_POST["booker_name"]) && !empty($_POST['start_date'])) {
        $sales_1 = $pdo->customQuery("SELECT *, SUM(item_price) AS total_price FROM sales_1 WHERE created_at = '{$_POST['start_date']}' AND 'company_profile_id'= {$_SESSION['cp_id']} AND booker_name = {$_POST["booker_name"]} GROUP BY item_code");
    }else if (!empty($_POST["booker_name"]) && !empty($_POST['start_date']) && !empty($_POST['end_date'])) {
        $sales_1 = $pdo->customQuery("SELECT *, SUM(item_price) AS total_price FROM sales_1 WHERE created_at BETWEEN '{$_POST['start_date']}' AND 'company_profile_id'= {$_SESSION['cp_id']} AND '{$_POST['end_date']}' AND booker_name = {$_POST["booker_name"]} GROUP BY item_code");
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



<?php } else if ($_POST['__FILE__'] == "search_sales_2") {
    $sales_2 = "";

if (!empty($_POST["end_date"])) { 
    $sales_2 = $pdo->customQuery("SELECT *, SUM(total_amount) AS total_price FROM sales_2 WHERE created_at BETWEEN '{$_POST['start_date']}' AND '{$_POST['end_date']}' AND 'company_profile_id'= {$_SESSION['cp_id']}");
} else if (empty($_POST["end_date"])) {
    $sales_2 = $pdo->customQuery("SELECT *, SUM(total_amount) AS total_price FROM sales_2 WHERE created_at = '{$_POST['start_date']}'");
} else if (!empty($_POST["booker_name"]) && !empty($_POST['start_date'])) {
    $sales_2 = $pdo->customQuery("SELECT *, SUM(total_amount) AS total_price FROM sales_2 WHERE created_at = '{$_POST['start_date']}' AND booker_name = {$_POST["booker_name"]} AND 'company_profile_id'= {$_SESSION['cp_id']}");
}else if (!empty($_POST["booker_name"]) && !empty($_POST['start_date']) && !empty($_POST['end_date'])) {
    $sales_2 = $pdo->customQuery("SELECT *, SUM(total_amount) AS total_price FROM sales_2 WHERE created_at BETWEEN '{$_POST['start_date']}' AND '{$_POST['end_date']}' AND booker_name = {$_POST["booker_name"]} AND 'company_profile_id'= {$_SESSION['cp_id']}");
}else if (!empty($_POST["customer_name"]) && !empty($_POST['start_date'])) {
    $sales_2 = $pdo->customQuery("SELECT *, SUM(total_amount) AS total_price FROM sales_2 WHERE created_at = '{$_POST['start_date']}' AND customer_name = {$_POST["customer_name"]} AND 'company_profile_id'= {$_SESSION['cp_id']}");
}else if (!empty($_POST["customer_name"]) && !empty($_POST['start_date']) && !empty($_POST['end_date'])) {
    $sales_2 = $pdo->customQuery("SELECT *, SUM(total_amount) AS total_price FROM sales_2 WHERE created_at BETWEEN '{$_POST['start_date']}' AND '{$_POST['end_date']}' AND customer_name = {$_POST["customer_name"]} AND 'company_profile_id'= {$_SESSION['cp_id']}");
}
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
            <th>Pneding amount</th>
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


<?php } else if ($_POST['__FILE__'] == "search_purchase_1") { 
    $purchases_1 = $pdo->customQuery("SELECT * FROM purchases_1 WHERE created_at BETWEEN '{$_POST['start_date']}' AND '{$_POST['end_date']}' AND 'company_profile_id'= {$_SESSION['cp_id']}");
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
            <th>Item code</th>
            <th>Item name</th>

            <th>Item price</th>
            <th>Quantity</th>
            <th>Total amount</th>
            <th>Discount</th>
            <th>Net amount</th>
            <th>Product expiry</th>

            <th>Created at</th>
        </tr>
    </thead>
    <tbody>
        <?php 
foreach ($purchases_1 as $purchase_1) {

?>
        <tr>
            <td>#</td>
            <td><?php echo $purchase_1['order_number']; ?></td>
            <td><?php echo $purchase_1['bill_number']; ?></td>

            <td><?php echo $purchase_1['date']; ?></td>
            <td><?php echo $purchase_1['operator']; ?></td>
            <td><?php echo $purchase_1['company_name']; ?></td>
            <td><?php echo $purchase_1['item_code']; ?></td>
            <td><?php echo $purchase_1['item_name']; ?></td>

            <td><?php echo $purchase_1['item_price']; ?></td>
            <td><?php echo $purchase_1['quantity']; ?></td>
            <td><?php echo $purchase_1['total_amount']; ?></td>
            <td><?php echo $purchase_1['discount']; ?></td>
            <td><?php echo $purchase_1['net_amount']; ?></td>
            <td><?php echo $purchase_1['product_expiry']; ?></td>

            <td><?php echo $purchase_1['created_at']; ?></td>
        </tr>
        <?php } ?>

    </tbody>

</table>


<?php } else if ($_POST['__FILE__'] == "search_purchase_2") { 
    $purchases_2 = $pdo->customQuery("SELECT * FROM purchases_2 WHERE created_at BETWEEN '{$_POST['start_date']}' AND '{$_POST['end_date']}' AND 'company_profile_id'= {$_SESSION['cp_id']}");
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
    $ledgers = $pdo->customQuery("SELECT * FROM ledger WHERE created_at BETWEEN '{$_POST['start_date']}' AND '{$_POST['end_date']}' AND 'company_profile_id'= {$_SESSION['cp_id']}");

    if (!empty($_POST["customer_name"]) && !empty($_POST['start_date'])) {
        $ledgers = $pdo->customQuery("SELECT *, SUM(total_amount) AS total_price FROM ledger WHERE created_at = '{$_POST['start_date']}' AND customer_name = {$_POST["customer_name"]} AND 'company_profile_id'= {$_SESSION['cp_id']}");
    }else if (!empty($_POST["customer_name"]) && !empty($_POST['start_date']) && !empty($_POST['end_date'])) {
        $ledgers = $pdo->customQuery("SELECT *, SUM(total_amount) AS total_price FROM ledger WHERE created_at BETWEEN '{$_POST['start_date']}' AND '{$_POST['end_date']}' AND customer_name = {$_POST["customer_name"]} AND 'company_profile_id'= {$_SESSION['cp_id']}");
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


<?php } ?>