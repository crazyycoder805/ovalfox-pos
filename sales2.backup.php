<!DOCTYPE html>

<html lang="zxx">
<?php require_once 'assets/includes/head.php'; ?>
<?php
if (isset($_SESSION['ovalfox_pos_access_of']->s) && $_SESSION['ovalfox_pos_role_id'] == 3 && $_SESSION['ovalfox_pos_access_of']->s == 0) {
    
        header("location:404.php");
    
}
$success = "";
$error = "";
$id = "";
$user = $pdo->read("access", ['id' => $_SESSION['ovalfox_pos_user_id'], 'company_profile_id' => $_SESSION['ovalfox_pos_cp_id']]); 

$sales_2 = $pdo->read("sales_2", ['company_profile_id' => $_SESSION['ovalfox_pos_cp_id']]);
$products = $pdo->read("products", ['company_profile_id' => $_SESSION['ovalfox_pos_cp_id']]);




$customers = $pdo->read("customers", ['company_profile_id' => $_SESSION['ovalfox_pos_cp_id']]);


$sales_2_inv = "";
$booker_inv = "";
$customer_inv = "";

if (isset($_GET['inv_num'])) {
    $sales_2_inv = $pdo->read("sales_2", ["invoice_number" => $_GET['inv_num']]);
    $booker_inv = $pdo->read("access", ['id' => $sales_2_inv[0]['booker_name']]);
    $customer_inv = $pdo->read("customers", ['id' => $sales_2_inv[0]['customer_name']]);
}


?>

<body>
    <?php require_once 'assets/includes/preloader.php'; ?>



    <div class="offcanvas offcanvas-start" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1"
        id="offcanvasScrolling" aria-labelledby="offcanvasScrollingLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasScrollingLabel">Menu</h5>
            <div class="header-left">
                <div class="header-links">
                    <a href="javascript:void(0);" class="toggle-btn">
                        <span></span>
                    </a>
                </div>

            </div>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">

            <?php require_once 'assets/includes/sidebar.php'; ?>
        </div>
    </div>
    <div class="page-wrapper">
        <div class="main-content">

            <div class="from-wrapper">
                <?php 
                    if (isset($_SESSION['ovalfox_pos_role_id']) && $_SESSION['ovalfox_pos_role_id'] == "2") {
                    ?>

                <form method="post">
                    <button type="submit" name="logout" id="logout" style="color: black !important;"><i
                            class="fas fa-sign-out-alt"></i> logout</button>
                </form>
                <?php } ?>
                <div class="row">
                    <div class="col-md-8-custom" style="background-color: rgb(135, 148, 153);">

                        <div class="d-flex flex-row">
                            <?php 
                    if (isset($_SESSION['ovalfox_pos_role_id']) && $_SESSION['ovalfox_pos_role_id'] != "2") {
                    ?>

                            <a class="btn btn-sm btn-primary" data-bs-toggle="offcanvas" href="#offcanvasScrolling"
                                role="button" aria-controls="offcanvasExample">
                                <i class="fa fa-arrow-left"></i> </a>

                            <?php } ?>
                            <?php 
                                if (isset($_GET['inv_num'])) {
                                ?>
                            <a class="btn btn-danger" href="sales.php">
                                Unload invoice editing </a>
                            <?php } ?>
                            <a class="btn btn-info" href="sales.php">
                                Refresh</a>
                            <h6 class="mt-3">Next Invoice Number: <?php
$maxedInvoiceNumber = (int)$pdo->customQuery("SELECT 
MAX(CAST(invoice_number AS UNSIGNED)) AS maxedInvoiceNumber,
company_profile_id
FROM 
sales_2 
WHERE 
company_profile_id = '{$_SESSION['ovalfox_pos_cp_id']}'
")[0]['maxedInvoiceNumber'] + 1;
echo $maxedInvoiceNumber;

?></h6>
                        </div>
                        <div class="row">
                            <div class="col-md">
                                <div class="form-group">


                                    <label class="col-form-label">Inv number</label>
                                    <input class="form-control" class=""
                                        value="<?php echo isset($_GET['inv_num']) ? $_GET['inv_num'] : ""; ?>"
                                        name="invoice_number" type="number" placeholder="Invoice No."
                                        id="invoice_number">


                                </div>
                            </div>
                            <div class="col-md">

                                <div class="form-group">


                                    <?php 
if (isset($_GET['inv_num'])) {
?>
                                    <label class="col-form-label">Customer name</label>
                                    <input type="text" class="form-control" disabled
                                        value="<?php echo $customer_inv[0]['name']; ?>">
                                    <input type="text" hidden class="form-control" disabled
                                        value="<?php echo $customer_inv[0]['id']; ?>" name="customer_name"
                                        id="customer_name">
                                    <?php } else { ?>
                                    <label class="col-form-label">Customer name</label>
                                    <select class="select2 form-control select-opt customer-select" name="customer_name"
                                        id="customer_name">
                                        <option selected value="">
                                            Select Customer Name
                                        </option>
                                        <?php

foreach ($customers as $customer) {

?>
                                        <option value="<?php echo $customer['id']; ?>">
                                            <?php echo $customer['name']; ?>
                                        </option>


                                        <?php } ?>
                                    </select>
                                    <?php } ?>

                                </div>


                            </div>

                            <div class="col-md">
                                <div class="form-group">
                                    <label class="col-form-label">Booker name</label>
                                    <?php 
if ((isset($_SESSION['ovalfox_pos_role_id']) && $_SESSION['ovalfox_pos_role_id'] == "2") || (isset($_GET['inv_num']))) {
?>
                                    <input type="text" class="form-control" disabled
                                        value="<?php echo isset($_SESSION['ovalfox_pos_role_id']) && $_SESSION['ovalfox_pos_role_id'] == "2" ? $_SESSION['ovalfox_pos_username'] : $booker_inv[0]['username']; ?>">

                                    <input hidden type="text" class="form-control" disabled
                                        value="<?php echo isset($_SESSION['ovalfox_pos_role_id']) && $_SESSION['ovalfox_pos_role_id'] == "2" ? $_SESSION['ovalfox_pos_user_id'] : $booker_inv[0]['id']; ?>"
                                        name="booker_name" id="booker_name">

                                    <?php } else if (isset($_SESSION['ovalfox_pos_role_id']) && $_SESSION['ovalfox_pos_role_id'] == "1") {
$bookers = $pdo->read("access", ['role_id' => '2', 'company_profile_id' => $_SESSION['ovalfox_pos_cp_id']]); 
?>

                                    <select class="select2 booker-select form-control select-opt" name="booker_name"
                                        id="booker_name">
                                        <option selected value="">
                                            Select Booker
                                        </option>
                                        <?php

foreach ($bookers as $booker) {

?>
                                        <option
                                            <?php echo isset($_SESSION['booker_select']) && $_SESSION['booker_select'] != "" && $_SESSION['booker_select'] == $booker['id'] ? "selected" : "" ?>
                                            value="<?php echo $booker['id']; ?>">
                                            <?php echo $booker['username']; ?>
                                        </option>


                                        <?php } ?>
                                    </select>

                                    <?php } else if (isset($_SESSION['ovalfox_pos_role_id']) && $_SESSION['ovalfox_pos_role_id'] == "3") {
$bookers = $pdo->read("access", ['role_id' => '2', 'company_profile_id' => $_SESSION['ovalfox_pos_cp_id']]); 
?>

                                    <select class="select2 booker-select form-control select-opt" name="booker_name"
                                        id="booker_name">
                                        <option selected value="">
                                        </option>
                                        <?php

foreach ($bookers as $booker) {

?>
                                        <option value="<?php echo $booker['id']; ?>">
                                            <?php echo $booker['username']; ?>
                                        </option>


                                        <?php } ?>
                                    </select>
                                    <?php } ?>

                                </div>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md">


                                <label class="col-form-label">Current date</label>

                                <input value="<?php echo isset($_GET['edit_employee']) ? $id[0]['end_date'] : null; ?>"
                                    class="form-control" name="current_date" type="datetime-local"
                                    placeholder="End Date" id="current_date">


                            </div>


                            <div class="col-md">
                                <label class="col-form-label">Sale price type</label>

                                <select class="select2 form-control select-opt" name="type" id="type">
                                    <option disabled>Select type</option>
                                    <option selected value="tr">
                                        Trade
                                        rate
                                    </option>
                                    <option value="wr">Wholesale
                                        rate
                                    </option>
                                    <option value="rf">Refund
                                    </option>

                                </select>
                            </div>
                            <div class="col-md">

                                <!-- <div class="form-group">

                                    <label class="col-form-label">Customer name</label>
                                    <input class="form-control" class="" disabled name="customer_manual" type="text"
                                        id="customer_manual">
                                </div>


                                <div class="checkbox">
                                    <input name="manual_customer" value="manual_customer" id="manual_customer"
                                        type="checkbox">
                                    <label for="manual_customer">Add Customer</label>
                                </div> -->

                                <div class="form-group">
                                    <label class="col-form-label">Customer name</label>

                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1">
                                            <input name="manual_customer" value="manual_customer" id="manual_customer"
                                                type="checkbox">
                                        </span>
                                        <input class="form-control" class="" placeholder="Check the box to add customer"
                                            disabled name="customer_manual" type="text" id="customer_manual">
                                    </div>

                                </div>



                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md">
                                <div class="form-group">
                                    <label class="col-form-label">Search Through Item Code</label>
                                    <input class="form-control" class="" name="item_code_search" type="text"
                                        placeholder="Search Through Item Code" id="item_code_search">

                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-group">
                                    <label class="col-form-label">Product name</label>


                                    <select class="select2 form-control select-opt" name="product" id="product">
                                        <option selected value="">Select
                                            product
                                        </option>
                                        <?php

foreach ($products as $product) {

?>
                                        <option value="<?php echo $product['id']; ?>">
                                            <?php echo $product['product_name']; ?>
                                        </option>


                                        <?php } ?>
                                    </select>
                                </div>

                            </div>

                            <div class="col-md-2">
                                <div class="form-group">

                                    <label class="col-form-label">Last rate</label>

                                    <select class="select2 form-control select-opt" name="last_rate" id="last_rate">
                                        <option disabled selected value="">
                                            Select last rate
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="col-form-label">Item unit price</label>


                                    <input class="form-control" class="" name="unit_price" type="number"
                                        placeholder="Unit Price" id="unit_price">
                                </div>



                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md">
                                <div class="card" style="overflow: scroll; height: 800px;">

                                    <div class="card-body">

                                        <div class="row">
                                            <div class="col-md">
                                                <div class="d-flex flex-row">
                                                    <h3>Total items: <b id="total_items">0</b></h3>
                                                    &nbsp;&nbsp;&nbsp;
                                                    <h3>Total Quantity: <b id="total_quantity_added">0</b></h3>
                                                    &nbsp;&nbsp;&nbsp;

                                                    <h3>||</h3>
                                                    &nbsp;&nbsp;&nbsp;
                                                    <h4 style="color: blue;">Customer Previous: <b id="cust_prev">0</b>
                                                    </h4>

                                                    &nbsp;&nbsp;&nbsp;
                                                    <h4 style="color: red;">Customer Now Balance: <b id="cust_now">0</b>
                                                        </h4s>
                                                        &nbsp;&nbsp;&nbsp;
                                                        <div id="pass_sales_div" hidden>
                                                            <label for="password_sales_1"
                                                                style="padding-top: 8px;">password to
                                                                delete items:</label>
                                                            &nbsp;&nbsp;&nbsp;

                                                            <input type="password" id="password_sales_1"
                                                                name="password_sales_1" placeholder="password" />
                                                            <button id="deleteBtn">Delete</button>
                                                        </div>
                                                </div>
                                                <table style="user-select: none;
-webkit-user-select: none;
-moz-user-select: none;" id="itemAddedtable" class="table table-striped table-bordered dt-responsive ">
                                                    <thead>
                                                        <tr>
                                                            <th style="font-size: 13px !important;">#
                                                            </th>

                                                            <th style="font-size: 13px !important;">
                                                                Item
                                                                Code</th>

                                                            <th style="font-size: 13px !important;">
                                                                Item
                                                                Name</th>

                                                            <th style="font-size: 13px !important;">
                                                                Quantity</th>
                                                            <th style="font-size: 13px !important;">
                                                                Price</th>
                                                            <th style="font-size: 13px !important;">
                                                                Total Amount</th>
                                                            <th style="font-size: 13px !important;">
                                                                Discount</th>
                                                            <th style="font-size: 13px !important;">
                                                                Extra discount</th>
                                                            <th style="font-size: 13px !important;">%
                                                            </th>
                                                            <th style="font-size: 13px !important;">
                                                                Grand Total</th>

                                                            <th style="font-size: 13px !important;">
                                                                Remove</th>

                                                        </tr>
                                                    <tbody id="data">
                                                    </tbody>
                                                    </thead>

                                                </table>
                                            </div>

                                        </div>

                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md" style="display: none;">
                                        <div class="form-group">
                                            <label class="col-form-label">Item
                                                Name</label>

                                            <input class="form-control" disabled class="" name="item_name" type="text"
                                                placeholder="Item Name" id="item_name">

                                        </div>
                                    </div>


                                </div>

                            </div>

                        </div>
                    </div>
                    <div class="col-md bg-secondary text-white">
                        <div class="row">

                            <div class="col-md">

                                <div class="form-group">



                                    <div class="checkbox mt-3">
                                        <input id="free_items" name="free_items" value="free_items" type="checkbox">
                                        <label for="free_items">Click
                                            For Free
                                            Items</label>
                                    </div>




                                </div>
                            </div>
                        </div>
                        <div class="row">


                            <div class="col-md">
                                <div class="form-group">

                                    <div class="form-group">
                                        <label class="col-form-label">Item qunatity</label>

                                        <input style="font-size: 13px;" class="form-control" class="" name="quantity"
                                            type="number" placeholder="Quantity" id="quantity">

                                        <div class="d-flex flex-row">

                                            <div class="splash-radio-button">
                                                <input id="piece" name="qua" type="radio" value="piece" checked="">
                                                <label for="piece" class="radio-label">Piece</label>
                                                &nbsp;&nbsp;&nbsp;
                                                <input id="box" name="qua" type="radio" value="box">
                                                <label for="box" class="radio-label">Box</label>
                                            </div>

                                        </div>



                                    </div>
                                </div>

                            </div>
                            <div class="col-md">
                                <div class="form-group">
                                    <label class="col-form-label">Items total price</label>

                                    <input class="form-control" disabled class="" name="taaup" type="number"
                                        placeholder="Total Amount" id="taaup">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md">
                                <div class="form-group">
                                    <label class="col-form-label">Item available quantity</label>

                                    <input class="form-control" disabled class="" name="total_quantity" type="number"
                                        placeholder="Total Available Quantity" id="total_quantity">
                                </div>
                            </div>

                            <div class="col-md">
                                <div class="form-group">
                                    <label class="col-form-label">Discount</label>

                                    <input class="form-control" class="" name="discount" type="number"
                                        placeholder="Discount" id="discount">
                                    <!-- <label class="col-form-label">(<strong style="color: red;">Press
                Enter</strong>)</label> -->

                                    <div class="splash-radio-button">
                                        <input id="discount_amount" name="discountchkbx1" value="amount" type="radio"
                                            checked="">
                                        <label for="discount_amount" class="radio-label">In
                                            Amount</label>
                                        &nbsp;&nbsp;&nbsp;
                                        <input id="discount_percentage" name="discountchkbx1" value="percentage"
                                            type="radio">
                                        <label for="discount_percentage" class="radio-label">In
                                            Percentage</label>
                                    </div>






                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md">
                                <div class="form-group">
                                    <label class="col-form-label">Extra discount</label>

                                    <input class="form-control" class="" name="extra_discount" type="number"
                                        placeholder="Extra Discount" id="extra_discount">
                                </div>

                            </div>
                            <div class="col-md">
                                <div class="form-group">
                                    <label class="col-form-label">Grand total</label>

                                    <input class="form-control" disabled class="" name="total_amount" type="text"
                                        placeholder="Grand Total Amount" id="total_amount">
                                </div>
                                <div class="form-group">

                                    <button style="border-radius: 0pX;" id="wholeFormBtn"
                                        class="btn col-md-12 btn-primary">Add
                                        Item</button>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md">

                                <div class="form-group">
                                    <label class="col-form-label">Total
                                        Amount</label>
                                    <input class="form-control" class="" disabled name="final_amount" type="number"
                                        placeholder="Final Amount" id="final_amount">
                                </div>
                            </div>

                            <div class="col-md">

                                <div class="form-group">
                                    <label class="col-form-label">Discount</label>
                                    <input class="form-control" class="" name="discount_in_amount" type="number"
                                        placeholder="Discount" id="discount_in_amount">

                                    <div class="splash-radio-button">
                                        <input id="discount_amount2" name="discountchkbx2" value="amount" type="radio"
                                            checked="">
                                        <label for="discount_amount2" class="radio-label">In
                                            Amount</label>
                                        &nbsp;&nbsp;&nbsp;
                                        <input id="discount_percentage2" name="discountchkbx2" value="percentage"
                                            type="radio">
                                        <label for="discount_percentage2" class="radio-label">In
                                            Percentage</label>
                                    </div>





                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md">
                                <div class="form-group">

                                    <label class="col-form-label">Total
                                        Payable</label>
                                    <input class="form-control" class="" disabled name="total_payable" type="number"
                                        placeholder="Total Payable" id="total_payable">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md">
                                <div class="form-group">

                                    <label class="col-form-label">Amount
                                        Received</label>
                                    <input class="form-control" class="" name="amount_received" type="number"
                                        placeholder="Amount Received" id="amount_received">
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-group">
                                    <label class="col-form-label">Payment
                                        type</label>

                                    <select class="select2 form-control select-opt" name="payment_type"
                                        id="payment_type">

                                        <option value="cod">Cash on
                                            delivery
                                        </option>
                                        <option value="op">Online
                                            payment
                                        </option>


                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md">
                                <div class="form-group">
                                    <label class="col-form-label">Amount
                                        Return</label>
                                    <input class="form-control" disabled class="" name="amount_return" type="number"
                                        placeholder="Amount Return" id="amount_return">
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-group">
                                    <label class="col-form-label">Pending
                                        Amount</label>
                                    <input class="form-control" disabled class="" name="pending_amount" type="number"
                                        placeholder="Pending Amount" id="pending_amount">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md">
                                <label class="col-form-label">Invoice</label>

                                <select class="select2 form-control select-opt" name="inv_type" id="inv_type">
                                    <option selected value="si">
                                        Simple
                                    </option>
                                    <option value="gw">
                                        Gateway
                                    </option>


                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md">
                                <div class="form-group">
                                    <label class="col-form-label">Details</label>
                                    <textarea rows="1" cols="1" class="form-control" name="details" id="details"
                                        placeholder="Details"><?php echo isset($_GET['inv_num']) ? $sales_2_inv[0]['details'] : ""; ?></textarea>
                                </div>

                                <div class="form-group">
                                    <button id="pBill" name="pBill" style="border-radius: 0pX;"
                                        class="btn col-md-12 btn-primary">Print
                                        Bill</button>

                                    <!-- 
                                    <button style="border-radius: 0pX;" class="btn col-md-12 btn-danger">Show
                                        Unpaid Bills</button> -->
                                    <?php  if (isset($_SESSION['ovalfox_pos_role_id']) && $_SESSION['ovalfox_pos_role_id'] == 1) { ?>

                                    <button id="clear_bill" style="border-radius: 0pX;"
                                        class="btn col-md-12 btn-warning">Clear
                                        Bill</button>
                                    <?php } ?>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>

    </div>


    <div class="row">
        <div class="col-md" style="display: none;">
            <div class="form-group">
                <label class="col-form-label">Item
                    Code</label>

                <input class="form-control" disabled class="" name="item_code" type="text" placeholder="Item Code"
                    id="item_code">

            </div>
        </div>


    </div>



    <div class="modal fade modalCustomer" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title h4" id="myLargeModalLabel">Customer previous record</h5>
                    <button type="button" id="customer-modal-close-btn" name="customer-modal-close-btn" class="close"
                        data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" style="overflow: scroll;">
                    <div class="row">
                        <div class="col-md">
                            <table id="customerPreviosTable"
                                class="table table-striped table-bordered dt-responsive table-responsive ">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Bill number</th>
                                        <th>Inv number</th>


                                        <th>Customer Name</th>
                                        <th>Booker Name</th>

                                        <th>Total Amount</th>
                                        <th>Date</th>

                                        <th>Action</th>

                                    </tr>
                                <tbody id="customerDataShow">
                                </tbody>
                                </thead>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Preview Setting Box -->
    <?php require_once 'assets/includes/settings-sidebar.php'; ?>
    <!-- Preview Setting -->
    <?php require_once 'assets/includes/javascript.php'; ?>
    <script>
    $(document).ready(() => {


        // ----- //
        // -- Sales 1 input fields (START) --- //
        const invoiceNumber_input = $("#invoice_number");
        const customerName_input = $("#customer_name");
        const currentDate_input = $("#current_date");
        const priceType_input = $("#type");
        const customerManualAdd_checkbox = $("#manual_customer");
        const customerManualAdd_input = $("#customer_manual");
        const searchThrough_ItemCode_input = $("#item_code_search");
        const productName_selectInput = $("#product");
        const lastRate_selectInput = $("#last_rate");
        const unitPrice_input = $("#unit_price");
        const quantity_input = $("#quantity");
        const itemTotalPrice_input = $("#taaup");
        const itemTotalAvailableQuantity_input = $("#total_quantity");
        const discount_input = $("#discount");
        const extraDiscount_input = $("#extra_discount");
        const grandTotal_input = $("#total_amount");
        const addItem_button = $("#wholeFormBtn");
        // -- Sales 1 input fields (END) --- //
        // ----- //

        // ----- //
        // -- Sales 2 input fields (START) --- //
        const finalAmount_input = $("#final_amount");
        const discountAfterFinalAmount_input = $("#discount_in_amount");
        const totalPayable_input = $("#total_payable");
        const amountReceived_input = $("#amount_received");
        const paymentType_SelectInput = $("#payment_type");
        const amountReturn_input = $("#amount_return");
        const pendingAmount_input = $("#pending_amount");
        const invoiceType_SelectInput = $("#inv_type");
        const details_input = $("#details");
        const printBill_button = $("#pBill");
        const clearBill_button = $("#clear_bill");
        // ----- //
        // -- Sales 2 input fields (START) --- //

        const item_code = $("#item_code");
        const unit_price = $("#unit_price");
        const item_name = $("#item_name");
        const last_rate = $("#last_rate");

        const total_quantity = $("#total_quantity");
        const total_amount = $("#total_amount");

        const quantity = $("#quantity");
        const discount = $("#discount");
        const current_date = $("#current_date");
        const extra_discount = $("#extra_discount");

        let currentDate = new Date();
        let formattedDate = currentDate.toISOString().split('T')[0]; // Get the date part

        let hours = currentDate.getHours().toString().padStart(2,
            '0'); // Get hours (with leading zero if needed)
        let minutes = currentDate.getMinutes().toString().padStart(2,
            '0'); // Get minutes (with leading zero if needed)

        let formattedDateTime = `${formattedDate}T${hours}:${minutes}`;
        current_date.val(formattedDateTime);
        let isDisInAmntorInPer = "amount";

        let isIncmp = false;
        let isIncmpTrue = false;

        let initialQuantity = 0;
        <?php 
            if (isset($_GET['inv_num'])) {

            
            ?>
        $.ajax({
            type: "POST",
            url: "requestsPHP/loadInvoice.php",
            data: {
                "in": <?php echo $_GET['inv_num']; ?>,

                "__FILE__": "loadInvoice",

            },
            success: e => {
                const product = JSON.parse(e);
                finalAmount = +product[1][0]['total_amount'];
                totalPayable = +product[1][0]['final_amount'];

                $("#data").html(product[0]);
                $("#total_items").text(product[2]);
                $("#total_quantity_added").text(product[3]);

                $("#final_amount").val(+product[1][0]['total_amount']);
                $("#discount_in_amount").val(+product[1][0]['discount']);
                totalPayable_input.val((+product[1][0]['final_amount'] != 0 ? product[1][0][
                    'final_amount'
                ] : +product[1][0]['total_amount']));

                amountReceived_input.val(+product[1][0][
                    'recevied_amount'
                ]);

                // amountReturn_input.val(+product[1][0]['returned_amount']);
                // pendingAmount_input.val((+product[1][0]['pending_amount'] != 0 ? product[1][0][
                //     'pending_amount'
                // ] : +product[1][0]['total_amount']));
                if (+parseFloat(amountReceived_input.val() || 0) >= totalPayable_input.val()) {
                    amountReturn_input.val(+parseFloat(amountReceived_input.val() || 0) - (+
                        totalPayable != 0 &&
                        +
                        totalPayable != "" ? +
                        totalPayable : +finalAmount));
                    //amountReturn_input.val(priceType_input.val() != "rf" ? parseFloat(amountReceived_input.val() || 0) - (totalPayable != 0 ? totalPayable : finalAmount) : Math.abs(parseFloat(amountReceived_input.val() || 0)) - (totalPayable != 0 ? Math.abs(totalPayable) : Math.abs(finalAmount)))  ;

                    pendingAmount_input.val(0);
                } else {

                    pendingAmount_input.val((+totalPayable != 0 ? +totalPayable : +finalAmount) - +
                        parseFloat(amountReceived_input.val() || 0));
                    amountReturn_input.val(0);

                }


                currentDate_input.val(product[1][0]['date']);


                quantity_input.focus();
                $("#pass_sales_div").removeAttr("hidden");


                if (product[4]) {
                    amountReceived_input.prop("disabled", true);
                    pendingAmount_input.val(0);
                    $("#recevied_amount").val(0);
                    $("#discount_in_amount").prop("disabled", true);
                    details_input.focus();
                    $('#type').val('rf');
                    $('#type').prop('disabled', true);

                } else {
                    amountReceived_input.focus();
                    $('#type option[value="rf"]').remove();

                }
                customerManualAdd_input.prop("disabled", true);
                customerManualAdd_checkbox.prop("disabled", true);


                loadScreen();
                $.ajax({
                    type: "POST",
                    url: "requestsPHP/sales2Update.php",
                    data: {
                        "__FILE__": "sales2Update",
                        "invoice_number": invoiceNumber_input.val(),
                        "discount_in_amount": $("#discount_in_amount").val(),
                        "final_amount": totalPayable_input.val(),
                        "recevied_amount": amountReceived_input.val(),
                        "returned_amount": amountReturn_input.val(),
                        "pending_amount": pendingAmount_input.val(),
                        "total_amount": $("#final_amount").val(),
                        "payment_type": paymentType_SelectInput.val(),
                        "details": details_input.val(),
                        "isIncmp": false,
                        "amountIn": isDisInAmntorInPer == "" ? "amount" :
                            isDisInAmntorInPer,

                    },


                });
            }
        });



        <?php } else { ?>
        customerName_input.focus();

        <?php } ?>
        let quantityAdd = 0;
        let totalQuan = 0;
        let productId = 0;
        let finalAmount = 0;

        let totalPayable = 0;
        let totalItems = 0;
        let toggleValue = $('input[name="qua').val();
        let quantity_per_box = 0;
        let box_quantity = 0;
        let total_quantity_is = 0;
        let total_discount = 0;

        function loadScreen() {
            $(window).on('beforeunload', function(
                event) {
                var confirmationMessage =
                    'Are you sure you want to leave this page?';

                (event || window.event)
                .returnValue
                    = confirmationMessage;

                return confirmationMessage;
            });



        }

        productName_selectInput.on("input", e => {

            productId = e.target.value;
            searchThrough_ItemCode_input.val('');
            quantity_input.val('');
            itemTotalAvailableQuantity_input.val('');

            itemTotalAvailableQuantity_input.val('');
            discount_input.val('');
            extraDiscount_input.val('');
            grandTotal_input.val('');

            if (searchThrough_ItemCode_input.val() == "") {
                $.ajax({
                    type: "POST",
                    url: "requestsPHP/productSelect.php",
                    data: {
                        '__FILE__': "productSelect",
                        product: e.target.value,
                        "customer_name": customerManualAdd_checkbox.is(":checked") == true ?
                            customerManualAdd_input.val() : customerName_input.val(),

                    },
                    success: e => {

                        const product = JSON.parse(e);
                        item_code.val(product[0]);
                        unit_price.val(product[1]);
                        item_name.val(product[2]);
                        total_quantity.val(product[3]);
                        lastRate_selectInput.html(product[4]);

                        $('#unit_price').focus().select();
                        initialQuantity = total_quantity.val();
                    }
                });
            } else {
                $.ajax({
                    type: "POST",
                    url: "requestsPHP/productSelectItemCode.php",
                    data: {
                        '__FILE__': "productSelectItemCode",
                        productId: e.target.value,
                        "customer_name": customerManualAdd_checkbox.is(":checked") == true ?
                            customerManualAdd_input.val() : customerName_input.val(),
                    },
                    success: e => {
                        const product = JSON.parse(e);
                        totalQuan = product[3];
                        item_code.val(product[0]);
                        unit_price.val(product[1]);
                        item_name.val(product[2]);

                        quantity.val(quantityAdd++);

                        total_quantity.val(totalQuan - quantity.val());


                        lastRate_selectInput.html(product[4]);

                        initialQuantity = totalQuan;
                        total_amount.val(quantity.val() * unit_price.val());

                    }
                });
            }
        });

        let prevVal = "";
        searchThrough_ItemCode_input.on("change", target => {
            document.getElementById("product").selectedIndex = 0;

            if (target.target.value != "") {
                $.ajax({
                    type: "POST",
                    url: "requestsPHP/productSelectItemCode.php",
                    data: {
                        '__FILE__': "productSelectItemCode",
                        product: target.target.value,
                        "customer_name": customerManualAdd_checkbox.is(":checked") == true ?
                            customerManualAdd_input.val() : customerName_input.val(),
                    },
                    success: e => {


                        const product = JSON.parse(e);
                        if (target.target.value == prevVal) {
                            quantityAdd++;
                        } else {
                            quantityAdd = 1;

                        }
                        totalQuan = product[3];

                        item_code.val(product[0]);
                        unit_price.val(product[1]);
                        item_name.val(product[2]);

                        quantity.val(quantityAdd);
                        total_quantity.val(totalQuan - quantity.val());
                        lastRate_selectInput.html(product[4]);
                        total_quantity_is = product[5];
                        box_quantity = product[6];
                        quantity_per_box = product[7];
                        if (toggleValue == "box") {
                            itemTotalAvailableQuantity_input.val(+total_quantity_is - (+$(
                                "#quantity").val() * +quantity_per_box));
                            total_amount.val((+quantity_input.val() * +
                                quantity_per_box) * +unit_price.val());
                            itemTotalPrice_input.val((+quantity_input.val() * +
                                quantity_per_box) * +unit_price.val());
                        } else if (toggleValue == "piece") {
                            total_quantity.val(totalQuan - quantity.val());
                            total_amount.val(+quantity_input.val() * +unit_price.val());
                            itemTotalPrice_input.val(+quantity_input.val() * +unit_price.val());
                        }
                        unit_price.focus();
                        initialQuantity = totalQuan;
                        prevVal = target.target.value;
                    }
                });
            }

        });



        quantity_input.on('input', e => {
            let inputValue = parseFloat(e.target.value);
            if (inputValue <= 0) {
                e.target.value = 1;
            }
            if (!$("#free_items").is(":checked")) {
                if (priceType_input.val() == "rf") {
                    itemTotalAvailableQuantity_input.val(+initialQuantity + +quantity_input.val());
                    total_amount.val(+e.target.value * +unit_price.val());
                    itemTotalPrice_input.val(+e.target.value * +unit_price.val());

                } else {
                    if (toggleValue == "piece") {
                        if (+e.target.value > initialQuantity) {
                            alert(
                                "Quantity can't be greater than the total quantity the higher available quantity will be automatically selected"
                            );
                            e.target.value = initialQuantity;
                        }
                        itemTotalAvailableQuantity_input.val(+initialQuantity - +quantity_input.val());
                        total_amount.val(+e.target.value * +unit_price.val());
                        itemTotalPrice_input.val(+e.target.value * +unit_price.val());

                    } else if (toggleValue == "box") {
                        if (+e.target.value > box_quantity) {
                            alert(
                                "Quantity can't be greater than the total quantity the higher available quantity will be automatically selected"
                            );
                            e.target.value = box_quantity;
                        }
                        itemTotalAvailableQuantity_input.val(+total_quantity_is - (+quantity_input.val() * +
                            quantity_per_box));
                        total_amount.val((+quantity_input.val() * +quantity_per_box) * +unit_price
                            .val());
                        itemTotalPrice_input.val((+quantity_input.val() * +quantity_per_box) * +unit_price
                            .val());
                    }
                }
            } else {
                if (toggleValue == "piece") {
                    if (+e.target.value > initialQuantity) {
                        alert(
                            "Quantity can't be greater than the total quantity the higher available quantity will be automatically selected"
                        );
                        e.target.value = initialQuantity;
                    }
                    itemTotalAvailableQuantity_input.val(+initialQuantity - +quantity_input.val());

                } else if (toggleValue == "box") {
                    if (+e.target.value > box_quantity) {
                        alert(
                            "Quantity can't be greater than the total quantity the higher available quantity will be automatically selected"
                        );
                        e.target.value = box_quantity;
                    }
                    itemTotalAvailableQuantity_input.val(+total_quantity_is - (+quantity_input.val() * +
                        quantity_per_box));

                }
            }







        });


        // function AmountToPer(discount, amount) {
        //     return (discount / amount) * 100;
        // }

        // function PertToAmount(discount, amount) {
        //     return (+quantity_input.val() * +unitPrice_input.val()) - ;
        // }

        // const calculateDiscount = (quantity, unitPrice, discountRate) => {
        //     const discountedPrice = (unitPrice * quantity) - discountRate;
        //     let totalNEW = +quantity_input.val() * +unit_price.val();

        //     const discountPercentage = totalNEW - ((unitPrice * quantity) / 100) * discountRate;
        //     return {
        //         discountedPrice: discountedPrice,
        //         discountPercentage: discountPercentage
        //     };
        // }
        // const calculateExtraDiscount = (totalAmount, extraDiscountRate) => {
        //     const extraDiscountedPrice = totalAmount - extraDiscountRate;
        //     let totalNEW = +quantity_input.val() * +unit_price.val();

        //     const discountPercentage = totalNEW - (totalAmount / 100) * extraDiscountRate;

        //     return {
        //         extraDiscountedPrice: extraDiscountedPrice,
        //         discountPercentage: discountPercentage,
        //     };
        // };



        const calculateDiscount = (quantity = 0, unitPrice = 0, finalAmount = 0, discountRate, ) => {
            const discountedPrice = quantity != 0 && unitPrice != 0 ? ((quantity * unitPrice) -
                discountRate) : ((finalAmount) - discountRate);
            let percentage = quantity != 0 && unitPrice != 0 ? (quantity * unitPrice) * (1 - (discountRate /
                100)) : (finalAmount) * (1 - (discountRate / 100));
            return {
                discountedPrice,
                percentage
            };
        }
        const calculateExtraDiscount = (totalAmount, extraDiscountRate) => {

            const extraDiscountedPrice = totalAmount - extraDiscountRate;

            return extraDiscountedPrice;
        };



        // discount.on("input", e => {
        //     const result = calculateDiscount(quantity.val(), unit_price.val(), discount.val());
        //     total_amount.val(result.discountedPrice);
        //     total_discount = result.discountedPrice;
        //     extra_discount.val('');
        // });
        // extra_discount.on("input", e => {
        //     const extraDiscountValue = parseFloat(e.target.value || 0);
        //     const total = parseFloat(total_discount || 0);
        //     const result = calculateExtraDiscount(total, extraDiscountValue);
        //     total_amount.val(result.extraDiscountedPrice);
        // });
        // $("#discount_amount").on("click", e => {
        //     const resultDis = AmountToPer(+discount.val(), +quantity.val() * +unit_price.val());
        //     total_amount.val(resultDis);
        // });
        // $("#discount_percentage").on("click", e => {
        //     const resultDis = PertToAmount(+discount.val(), +quantity.val() * +unit_price.val());
        //     total_amount.val(resultDis);
        // });

        let isAmount = "";

        discount.on("input", e => {
            let inputValue = parseFloat(e.target.value);
            if (inputValue < 0) {
                e.target.value = 0;
            }
            const result = calculateDiscount(+quantity.val(), +unit_price.val(), 0, +discount.val());
            total_discount = isAmount == "" ? +result
                .discountedPrice : (isAmount == "amount" ? +result.discountedPrice : +result
                    .percentage);
            total_amount.val(+total_discount);
            // itemTotalPrice_input.val(+total_discount);

            extra_discount.val('');
        });
        extra_discount.on("input", e => {
            let inputValue = parseFloat(e.target.value);
            if (inputValue < 0) {
                e.target.value = 0;
            }
            const extraDiscountValue = parseFloat(e.target.value || 0);
            const result = calculateExtraDiscount(total_discount != 0 ? ($("#extra_dsicount").val() ==
                    0 ? +quantity
                    .val() * +unit_price.val() : +total_discount) : +quantity
                .val() * +unit_price.val(), +extraDiscountValue);
            total_amount.val(+result);
            // $("#discount_amount").prop("checked", true);
            // itemTotalPrice_input.val(+result);

        });
        $("#discount_amount").on("click", e => {
            const resultDis = calculateDiscount(+quantity_input.val(), +unitPrice_input.val(), 0, +$(
                "#discount").val());
            total_amount.val(resultDis.discountedPrice);
            total_discount = resultDis.discountedPrice;
            extraDiscount_input.val('');
            isAmount = e.target.value;
            // itemTotalPrice_input.val(resultDis);

        });
        $("#discount_percentage").on("click", e => {
            const resultDis = calculateDiscount(+quantity_input.val(), +unitPrice_input.val(), 0, +$(
                "#discount").val());
            total_amount.val(resultDis.percentage);
            total_discount = resultDis.percentage;

            extraDiscount_input.val('');
            isAmount = e.target.value;

            // itemTotalPrice_input.val(resultDis);

        });





        // $("#discount_amount").on("click", e => {
        //     const resultDis = calculateDiscount(quantity.val(), unit_price.val(), discount
        //         .val());
        //     const extraDiscountValue = parseFloat(extra_discount.val() || 0);
        //     const total = parseFloat(total_discount || 0);
        //     const result = calculateExtraDiscount(total, extraDiscountValue);
        //     total_amount.val(result.extraDiscountedPrice);
        // });
        // $("#discount_percentage").on("click", e => {
        //     const resultDis = calculateDiscount(quantity.val(), unit_price.val(), discount
        //         .val());
        //     const extraDiscountValue = parseFloat(extra_discount.val() || 0);
        //     const total = parseFloat(total_discount || 0);
        //     const result = calculateExtraDiscount(total, extraDiscountValue);
        //     total_amount.val(extra_discount.val() != 0 && extra_discount.val() != "" &&
        //         extra_discount
        //         .val() != null ? result.discountPercentage : resultDis.discountPercentage);
        // });



        $("#discount_in_amount").on("input", e => {
            let inputValue = parseFloat(e.target.value);
            if (inputValue < 0) {
                e.target.value = 0;
            }
            const result = calculateDiscount(0, 0, finalAmount, +e.target.value);


            totalPayable_input.val(isDisInAmntorInPer == "" ? +result
                .discountedPrice : (isDisInAmntorInPer == "amount" ? +result.discountedPrice : +
                    result
                    .percentage));
            totalPayable = isDisInAmntorInPer == "" ? +result
                .discountedPrice : (isDisInAmntorInPer == "amount" ? +result.discountedPrice : +result
                    .percentage);

            amountReceived_input.val('');

            amountReturn_input.val('');
            pendingAmount_input.val(totalPayable);

        });


        $("#discount_amount2").on("click", e => {
            const resultDis = calculateDiscount(0, 0, finalAmount, +$("#discount_in_amount").val());
            totalPayable_input.val(resultDis.discountedPrice);
            isDisInAmntorInPer = e.target.value;
            totalPayable = resultDis.discountedPrice;
            amountReceived_input.val('');

            amountReturn_input.val('');
            pendingAmount_input.val(totalPayable);
        });
        $("#discount_percentage2").on("click", e => {

            const resultDis = calculateDiscount(0, 0, finalAmount, +$("#discount_in_amount").val());
            totalPayable_input.val(resultDis.percentage);
            isDisInAmntorInPer = e.target.value;
            totalPayable = resultDis.percentage;

            amountReceived_input.val('');

            amountReturn_input.val('');
            pendingAmount_input.val(totalPayable);
        });



        amountReceived_input.on("input", e => {
            let inputValue = parseFloat(e.target.value);
            if (inputValue < 0) {
                e.target.value = 0;

            }
            if (+parseFloat(e.target.value || 0) >= totalPayable_input.val()) {
                amountReturn_input.val(+parseFloat(e.target.value || 0) - (+totalPayable != 0 && +
                    totalPayable != "" ? +
                    totalPayable : +finalAmount));
                //amountReturn_input.val(priceType_input.val() != "rf" ? parseFloat(e.target.value || 0) - (totalPayable != 0 ? totalPayable : finalAmount) : Math.abs(parseFloat(e.target.value || 0)) - (totalPayable != 0 ? Math.abs(totalPayable) : Math.abs(finalAmount)))  ;

                pendingAmount_input.val(0);
            } else {

                pendingAmount_input.val((+totalPayable != 0 ? +totalPayable : +finalAmount) - +
                    parseFloat(e.target.value || 0));
                amountReturn_input.val(0);

            }
        });

        $(document).on("click", "#removeItem", e => {
            $.ajax({
                type: "POST",
                url: "requestsPHP/deleteProductSales1.php",
                data: {
                    "__FILE__": "deleteProductSales1",
                    "salesId": e.target.value,
                    "invoice_number": invoiceNumber_input.val(),

                },
                success: e => {
                    const item = JSON.parse(e);

                    $("#final_amount").val(finalAmount - item[0]);
                    totalPayable_input.val(finalAmount - item[0]);
                    pendingAmount_input.val(finalAmount - item[0]);

                    $.ajax({
                        type: "POST",
                        url: "requestsPHP/productFetch.php",
                        data: {
                            "__FILE__": "productFetch",
                            "invoice_number": invoiceNumber_input.val(),

                        },
                        success: e => {
                            const product = JSON.parse(e);
                            $("#data").html(product[0]);
                            $("#total_items").text(product[1]);
                            $("#total_quantity_added").text(product[2]);
                            finalAmount = product[3];
                            totalPayable = product[3];
                            if (+parseFloat(amountReceived_input.val() ||
                                    0) >= totalPayable_input.val()) {
                                amountReturn_input.val(+parseFloat($(
                                        "#amount_received").val() ||
                                    0) - (+
                                    totalPayable != 0 &&
                                    +
                                    totalPayable != "" ? +
                                    totalPayable : +finalAmount));
                                //amountReturn_input.val(priceType_input.val() != "rf" ? parseFloat(amountReceived_input.val() || 0) - (totalPayable != 0 ? totalPayable : finalAmount) : Math.abs(parseFloat(amountReceived_input.val() || 0)) - (totalPayable != 0 ? Math.abs(totalPayable) : Math.abs(finalAmount)))  ;

                                pendingAmount_input.val(0);
                            } else {

                                pendingAmount_input.val((+totalPayable !=
                                        0 ? +totalPayable : +finalAmount
                                    ) - +
                                    parseFloat($("#amount_received")
                                        .val() || 0));
                                amountReturn_input.val(0);

                            }
                        }
                    });
                }
            });
        });


        $("input[name='qua']").on("change", e => {
            toggleValue = e.target.value;
            quantityAdd = 0;
            itemTotalAvailableQuantity_input.val(initialQuantity);

            $.ajax({
                type: "POST",
                url: "requestsPHP/selectTypeQuantity.php",
                data: {
                    "__FILE__": "selectTypeQuantity",
                    "typeQuantity": e.target.value,
                    "type": priceType_input.val(),

                    "productId": productId,
                    "itemSearch": searchThrough_ItemCode_input.val(),

                },
                success: e => {
                    const item = JSON.parse(e);
                    unit_price.val(item[0]);
                    total_quantity_is = item[1];
                    box_quantity = item[2];
                    quantity_per_box = item[3];
                    quantity.val('');
                    discount.val('');
                    extra_discount.val('');
                    grandTotal_input.val('');
                    itemTotalAvailableQuantity_input.val(total_quantity_is);

                }
            });
        });



        $('#type').on("input", e => {
            $.ajax({
                type: "POST",
                url: "requestsPHP/typeQ.php",
                data: {
                    "__FILE__": "typeQ",
                    "typeQuantity": toggleValue,

                    "type": e.target.value,

                    "productId": productId,

                },
                success: e => {
                    quantity.val('');
                    discount.val('');
                    extra_discount.val('');
                    grandTotal_input.val('');
                    const item = JSON.parse(e);
                    unit_price.val(item[0]);
                    total_quantity_is = item[1];
                    box_quantity = item[2];
                    quantity_per_box = item[3];
                    quantityAdd = 0;
                    itemTotalAvailableQuantity_input.val(initialQuantity);
                }
            });
        });


        unit_price.on("input", e => {
            let inputValue = parseFloat(e.target.value);
            if (inputValue < 0) {
                e.target.value = 1;
            }
            quantity.val('');
            discount.val('');
            extra_discount.val('');
            grandTotal_input.val('');
            itemTotalPrice_input.val('');

            quantityAdd = 0;

            itemTotalAvailableQuantity_input.val(initialQuantity);

        });
        invoiceNumber_input.on("change", e => {
            let inputValue = parseFloat(e.target.value);
            if (inputValue <= 0) {
                e.target.value = 1;
            }
            location.href = `sales.php?inv_num=${e.target.value}`;

        });
        // invoiceNumber_input.on("change", e => {
        //     $.ajax({
        //         type: "POST",
        //         url: "requestsPHP/data.php",
        //         data: {
        //             "in": e.target.value,

        //             "__FILE__": "loadInvoice",

        //         },
        //         success: e => {
        //             const product = JSON.parse(e);
        //             finalAmount = +product[1][0]['total_amount'];
        //             totalPayable = +product[1][0]['final_amount'];

        //             $("#data").html(product[0]);
        //             $("#total_items").text(product[2]);
        //             $("#total_quantity_added").text(product[3]);

        //             $("#final_amount").val(+product[1][0]['total_amount']);
        //             $("#discount_in_amount").val(+product[1][0]['discount']);
        //             totalPayable_input.val(+product[1][0]['final_amount']);
        //             amountReceived_input.val(+product[1][0][
        //                 'recevied_amount'
        //             ]);
        //             amountReturn_input.val(+product[1][0]['returned_amount']);
        //             pendingAmount_input.val(+product[1][0]['pending_amount']);
        //             quantity_input.focus();
        //             $("#pass_sales_div").removeAttr("hidden");

        //         }
        //     });

        // });
        $(document).keydown(function(event) {
            if (event.key === '.') {
                $(document).one('keydown', function(e) {
                    if (e.key === 'Enter') {
                        productName_selectInput.focus();
                        productName_selectInput.select2("open");
                        setTimeout(function() {
                            var searchField = $(
                                '.select2-container--open .select2-search__field');
                            if (searchField.length) {
                                searchField[0].focus();
                            }
                        }, 0.1);
                    }
                });
            }
        });

        let A = 0;
        addItem_button.on("click", e => {
            A = 1;
            productName_selectInput.focus();
            productName_selectInput.select2("open");
            setTimeout(function() {
                var searchField = $(
                    '.select2-container--open .select2-search__field');
                if (searchField.length) {
                    searchField[0].focus();
                }
            }, 0.1);
            quantityAdd = 0;

            if (invoiceNumber_input.val() == "") {
                <?php
                    $maxedInvoiceNumber = (int)$pdo->customQuery("SELECT 
                    MAX(CAST(invoice_number AS UNSIGNED)) AS maxedInvoiceNumber,
                    company_profile_id
                    FROM 
                    sales_2 
                    WHERE 
                    company_profile_id = '{$_SESSION['ovalfox_pos_cp_id']}'")[0]['maxedInvoiceNumber'] + 1;
                    ?>

                invoiceNumber_input.val(+<?php echo $maxedInvoiceNumber ?>);

            }


            if (A == 1) {
                if (priceType_input.val() == "rf") {
                    finalAmount -= +grandTotal_input.val();
                    amountReceived_input.prop("disabled", true);
                    pendingAmount_input.val(0);
                    $("#recevied_amount").val(0);
                    $("#discount_in_amount").prop("disabled", true);
                } else {
                    finalAmount += +grandTotal_input.val();
                }

                console.log($("#free_items").is(":checked") ? true : false);

                $.ajax({
                    type: "POST",
                    url: "requestsPHP/productAdd.php",
                    data: {
                        "__FILE__": "productAdd",
                        "invoice_number": invoiceNumber_input.val(),
                        "booker_name": $("#booker_name").val(),
                        "customer_name": customerName_input.val(),
                        "item_code": $("#item_code").val(),
                        "date": currentDate_input.val(),
                        "item_name": $("#item_name").val(),
                        "item_price": unitPrice_input.val(),
                        "quantity": quantity_input.val(),
                        "amount": grandTotal_input.val(),
                        "discount": discount_input.val(),
                        "discount_in_amount": discount.val(),
                        "extra_discount": extraDiscount_input.val(),
                        "total_amount": finalAmount,
                        "taaup": itemTotalPrice_input.val(),

                        "final_amount": totalPayable_input.val(),
                        "recevied_amount": amountReceived_input.val(),
                        "returned_amount": amountReturn_input.val(),
                        "pending_amount": pendingAmount_input.val(),
                        "product_id": productName_selectInput.val(),
                        "item_code_search": searchThrough_ItemCode_input.val(),
                        "total_quantity": itemTotalAvailableQuantity_input.val(),
                        "type": priceType_input.val(),
                        "isItemFree": $("#free_items").is(":checked") ? true : false,
                        "customer_manual": customerManualAdd_checkbox.is(":checked") ? $(
                            "#customer_manual").val() : "",
                        "amountIn": isAmount == "" ? "amount" : isAmount,

                    },

                    success: e => {
                        console.log(e);
                        item_code.val('');
                        unit_price.val('');
                        item_name.val('');
                        last_rate.val('');
                        quantity.val('');
                        discount.val('');
                        total_quantity.val('');
                        itemTotalPrice_input.val('');

                        $("#extra_dsicount").val('');
                        // productName_selectInput.select2("open");
                        // setTimeout(function() {
                        //     var searchField = $(
                        //         '.select2-container--open .select2-search__field');
                        //     if (searchField.length) {
                        //         searchField[0].focus();
                        //     }
                        // }, 100);

                        $("#final_amount").val(finalAmount);
                        totalPayable_input.val($("#final_amount").val());
                        pendingAmount_input.val($("#final_amount").val());
                        totalPayable = finalAmount;

                        extraDiscount_input.val('');
                        amountReceived_input.val('');
                        amountReturn_input.val('');
                        total_amount.val('');
                        document.getElementById("product").selectedIndex = 0;



                        $.ajax({
                            type: "POST",
                            url: "requestsPHP/productFetch.php",
                            data: {
                                "__FILE__": "productFetch",
                                "invoice_number": invoiceNumber_input.val(),
                                "desc": true
                            },
                            complete: () => {
                                A = 0;

                            },
                            success: e => {
                                const product = JSON.parse(e);
                                $("#data").html(product[0]);
                                $("#total_items").text(product[1]);
                                $("#total_quantity_added").text(product[2]);

                                document.getElementById("free_items")
                                    .checked =
                                    false;
                                invoiceNumber_input.prop("disabled", true);
                                if (customerManualAdd_checkbox.is(":checked")) {
                                    customerManualAdd_input.prop("disabled",
                                        true);
                                    customerManualAdd_checkbox.prop("disabled",
                                        true);

                                } else {
                                    customerManualAdd_checkbox.prop("disabled",
                                        true);
                                    customerManualAdd_input.prop("disabled",
                                        true);

                                }

                                customerName_input.prop("disabled", true);
                                $("#booker_name").prop("disabled", true);

                                customerManualAdd_input.prop("disabled", true);
                                customerManualAdd_checkbox.prop("disabled", true);
                                $("#pass_sales_div").removeAttr("hidden");
                                quantity.prop("disabled", false);
                                discount.prop("disabled", false);
                                extra_discount.prop("disabled", false);
                                grandTotal_input.prop("disabled", false);
                                if (priceType_input.val() == "rf") {
                                    priceType_input.prop("disabled", true);
                                } else {
                                    $('#type option[value="rf"]').remove();

                                }
                                $("#discount_amount").prop("checked", true);
                                isAmount = "amount";

                                total_discount = 0;
                                loadScreen();
                                $.ajax({
                                    type: "POST",
                                    url: "requestsPHP/sales2Update.php",
                                    data: {
                                        "__FILE__": "sales2Update",
                                        "invoice_number": $(
                                                "#invoice_number")
                                            .val(),
                                        "discount_in_amount": $(
                                                "#discount_in_amount")
                                            .val(),
                                        "final_amount": $(
                                            "#total_payable").val(),
                                        "recevied_amount": $(
                                                "#amount_received")
                                            .val(),
                                        "returned_amount": $(
                                            "#amount_return").val(),
                                        "pending_amount": $(
                                                "#pending_amount")
                                            .val(),
                                        "total_amount": $(
                                            "#final_amount").val(),
                                        "payment_type": $(
                                            "#payment_type").val(),
                                        "details": details_input.val(),
                                        "isIncmp": true,
                                        "amountIn": isDisInAmntorInPer ==
                                            "" ? "amount" :
                                            isDisInAmntorInPer,

                                    },


                                });
                            }
                        });
                    }
                });
            }

        });



        printBill_button.on("click", event => {
            $.ajax({
                type: "POST",
                url: "requestsPHP/sales2Update.php",
                data: {
                    "__FILE__": "sales2Update",
                    "invoice_number": invoiceNumber_input.val(),
                    "discount_in_amount": $("#discount_in_amount").val(),
                    "final_amount": totalPayable_input.val(),
                    "recevied_amount": amountReceived_input.val(),
                    "returned_amount": amountReturn_input.val(),
                    "pending_amount": pendingAmount_input.val(),
                    "total_amount": $("#final_amount").val(),
                    "payment_type": paymentType_SelectInput.val(),
                    "details": details_input.val(),
                    "isIncmp": false,
                    "amountIn": isDisInAmntorInPer == "" ? "amount" : isDisInAmntorInPer,

                },
                success: target => {
                    <?php if ($user[0]['printing_page_size'] == "large") {
                        ?>
                    $(window).off('beforeunload');

                    openPopup(
                        invoiceType_SelectInput.val() == "si" ?
                        `printinvoice1.php?inv=${invoiceNumber_input.val()}&amountIn=${isDisInAmntorInPer}` :
                        `printinvoice3.php?inv=${invoiceNumber_input.val()}&amountIn=${isDisInAmntorInPer}`
                    );
                    location.href = `sales.php`;

                    <?php 
                       } else if ($user[0]['printing_page_size'] == "small") {
                        ?>
                    $(window).off('beforeunload');

                    openPopup(
                        invoiceType_SelectInput.val() == "si" ?
                        `printinvoice2.php?inv=${invoiceNumber_input.val()}&amountIn=${isDisInAmntorInPer}` :
                        `printinvoice3.php?inv=${invoiceNumber_input.val()}&amountIn=${isDisInAmntorInPer}`
                    );
                    location.href = `sales.php`;

                    <?php } ?>
                    <?php
                        // if ($user[0]['printing_page_size'] == "large") {
                         ?>
                    // location.href = `printinvoice1.php?inv=${invoice_number.val()}`;
                    <?php 
                        //} else if ($user[0]['printing_page_size'] == "small") {
                         ?>
                    //location.href = `printinvoice2.php?inv=${invoice_number.val()}`;

                    <?php //} ?>
                },

            });
        });
        $('#free_items').change(function() {
            itemTotalAvailableQuantity_input.val(initialQuantity);

            if ($(this).is(':checked')) {

                discount.val(0);
                extra_discount.val(0);
                grandTotal_input.val(0);
                discount.prop("disabled", true);
                extra_discount.prop("disabled", true);
                grandTotal_input.prop("disabled", true);
            } else {
                quantityAdd = 0;
                quantity.val('');

                discount.prop("disabled", false);
                extra_discount.prop("disabled", false);
                grandTotal_input.prop("disabled", false);
            }

        });

        function showConfirmation() {
            return confirm("Are you sure to clear this bill?");
        }

        $("#clear_bill").on("click", e => {

            if (showConfirmation()) {
                $.ajax({
                    type: "POST",
                    url: "requestsPHP/salesDelete.php",
                    data: {
                        "__FILE__": "salesDelete",
                        "invoice_number": invoiceNumber_input.val(),
                    },
                    success: function(e) {
                        location.href = "sales.php";
                    }
                });
            }

        });

        customerManualAdd_checkbox.change(function() {
            if ($(this).is(":checked")) {
                customerManualAdd_input.prop("disabled", false);
                document.getElementById("customer_name").selectedIndex = -1;
                customerName_input.prop("disabled", true);

            } else {
                customerManualAdd_input.prop("disabled", true);
                customerManualAdd_input.val("");
                customerName_input.prop("disabled", false);

            }
        });

        customerName_input.on("change", e => {
            customerManualAdd_checkbox.prop("checked", false);
            customerManualAdd_input.prop("disabled", true);

            customerManualAdd_input.val("");

        });


        customerName_input.on("change", e => {
            $.ajax({
                type: "POST",
                url: "requestsPHP/showCustomerData.php",
                data: {
                    '__FILE__': "showCustomerData",
                    "cusId": e.target.value
                },
                success: e => {
                    const items = JSON.parse(e);
                    $("#customerDataShow").html(items[0]);
                    $(".modalCustomer").modal("show");
                }
            })

        });
        let focusSet = false;
        // Function to toggle active cell class
        // Function to toggle active cell class
        function toggleActiveCell($cell) {
            $('#itemAddedtable td').removeClass('active-cell');
            $cell.addClass('active-cell');

            // Set cursor position to the end of the cell content
            let range = document.createRange();
            let selection = window.getSelection();
            range.selectNodeContents($cell[0]);
            selection.removeAllRanges();
            selection.addRange(range);
        }


        // Function to find the next editable cell in a given direction
        function findNextEditableCell($startCell, direction) {
            let $cell = $startCell;

            switch (direction) {
                case 'left':
                    while ($cell.prev('td').length > 0) {
                        $cell = $cell.prev('td');
                        if ($cell.is('[contenteditable="true"]')) {
                            return $cell;
                        }
                    }
                    break;
                case 'right':
                    while ($cell.next('td').length > 0) {
                        $cell = $cell.next('td');
                        if ($cell.is('[contenteditable="true"]')) {
                            return $cell;
                        }
                    }
                    break;
                case 'up':
                    let $row = $cell.closest('tr');
                    let cellIndex = $cell.index();
                    while ($row.prev('tr').length > 0) {
                        $row = $row.prev('tr');
                        $cell = $row.children().eq(cellIndex);
                        if ($cell.is('[contenteditable="true"]')) {
                            return $cell;
                        }
                    }
                    break;
                case 'down':
                    let $rowDown = $cell.closest('tr');
                    let cellIndexDown = $cell.index();
                    while ($rowDown.next('tr').length > 0) {
                        $rowDown = $rowDown.next('tr');
                        $cell = $rowDown.children().eq(cellIndexDown);
                        if ($cell.is('[contenteditable="true"]')) {
                            return $cell;
                        }
                    }
                    break;
            }

            return null; // No editable cell found
        }

        // Keydown event handler
        $(document).on("keydown", "#itemAddedtable td", function(e) {
            let $this = $(this);

            switch (e.which) {
                case 37: // left arrow key
                    let $leftCell = findNextEditableCell($this, 'left');
                    if ($leftCell) {
                        $leftCell.focus();
                        toggleActiveCell($leftCell);
                    }
                    break;

                case 38: // up arrow key
                    let $upCell = findNextEditableCell($this, 'up');
                    if ($upCell) {
                        $upCell.focus();
                        toggleActiveCell($upCell);
                    }
                    break;

                case 39: // right arrow key
                    let $rightCell = findNextEditableCell($this, 'right');
                    if ($rightCell) {
                        $rightCell.focus();
                        toggleActiveCell($rightCell);
                    }
                    break;

                case 40: // down arrow key
                    let $downCell = findNextEditableCell($this, 'down');
                    if ($downCell) {
                        $downCell.focus();
                        toggleActiveCell($downCell);
                    }
                    break;

                default:
                    return;
            }
            e.preventDefault();
        });

        // Focus event handler for mouse clicks
        $(document).on("focus", "#itemAddedtable td[contenteditable='true']", function() {
            let $this = $(this);
            toggleActiveCell($this);
        });


        $(document).on('keydown', "#itemAddedtable td", eTarget => {
            if (eTarget.keyCode == 13) {
                focusSet = false;
                let target = eTarget;



                let inputValue = parseFloat(eTarget.target.textContent);
                if (!eTarget.target.id.match(/discountTabledData/) && !eTarget.target.id.match(
                        /extraTabledData/) && !eTarget
                    .target.id.match(/percentageTabledData/)) {
                    if (inputValue <= 0) {
                        eTarget.target.textContent = 1;
                    }
                }



                $.ajax({
                    type: "POST",
                    url: "requestsPHP/runtimeTableDataEdit.php",
                    data: {
                        "__FILE__": "runtimeTableDataEdit",
                        "target": `{"${eTarget.target.id}": "${eTarget.target.textContent}"}`,
                        "invoice_number": invoiceNumber_input.val()
                    },
                    success: runtimeTableDataEditE => {
                        const product = JSON.parse(runtimeTableDataEditE);


                        $.ajax({
                            type: "POST",
                            url: "requestsPHP/productFetch.php",
                            data: {
                                "__FILE__": "productFetch",
                                "invoice_number": invoiceNumber_input.val(),
                                'updatedRowId': product[0]
                            },
                            complete: (jq) => {
                                focusSet = true;

                            },
                            success: e => {
                                const product = JSON.parse(e);

                                $("#data").html(product[0]);
                                const regexPattern = new RegExp(
                                    `itemMainKey_${product[4]}`);

                                console.log($(
                                    document
                                ).find(
                                    `#${product[0].match(regexPattern)[0]}`
                                ).addClass("active-cell"));
                                // let html = ;
                                $("#total_items").text(product[1]);
                                $("#total_quantity_added").text(product[
                                    2]);
                                finalAmount = product[3];
                                totalPayable = finalAmount = product[3];

                                $("#final_amount").val(product[
                                    3]);
                                totalPayable_input.val($("#final_amount")
                                    .val());
                                pendingAmount_input.val($("#final_amount")
                                    .val());
                                if (+parseFloat(amountReceived_input.val() ||
                                        0) >= totalPayable_input.val()) {
                                    amountReturn_input.val(+parseFloat($(
                                            "#amount_received").val() ||
                                        0) - (+
                                        totalPayable != 0 &&
                                        +
                                        totalPayable != "" ? +
                                        totalPayable : +finalAmount));
                                    //amountReturn_input.val(priceType_input.val() != "rf" ? parseFloat(amountReceived_input.val() || 0) - (totalPayable != 0 ? totalPayable : finalAmount) : Math.abs(parseFloat(amountReceived_input.val() || 0)) - (totalPayable != 0 ? Math.abs(totalPayable) : Math.abs(finalAmount)))  ;

                                    pendingAmount_input.val(0);
                                } else {

                                    pendingAmount_input.val((+totalPayable !=
                                            0 ? +totalPayable : +finalAmount
                                        ) - +
                                        parseFloat($("#amount_received")
                                            .val() || 0));
                                    amountReturn_input.val(0);

                                }
                                // if (focusSet == false) {
                                //     $(document).find(
                                //         `#${$(product[0].match(/<td.*?id=['"]discountTabledData(\d+)['"].*?>.*?<\/td>/)[0]).attr("id")}`
                                //     ).focus();

                                // }

                                // if (target.target.id.match(
                                //         /percentageTabledData\d*/) && !focusSet) {

                                //     $(document).find(
                                //         `#${$(html.match(/<td.*?id=['"]discountTabledData(\d+)['"].*?>.*?<\/td>/)[0]).attr("id")}`
                                //     ).focus();

                                //     unitPrice_input.focus();
                                //     focusSet = true;
                                // }

                                // if (target.target.id.match(
                                //         /discountTabledData\d*/) && !focusSet) {
                                //     $(document).find(
                                //         `#${$(html.match(/<td.*?id=['"]percentageTabledData(\d+)['"].*?>.*?<\/td>/)[0]).attr("id")}`
                                //     ).focus();
                                //     unitPrice_input.focus();
                                //     focusSet = true;
                                // }


                                // if (target.target.id.match(
                                //         /quantityTabledData\d*/) && !focusSet) {
                                //     $(document).find(
                                //         `#${$(html.match(/<td.*?id=['"]discountTabledData(\d+)['"].*?>.*?<\/td>/)[0]).attr("id")}`
                                //     ).focus();
                                //     unitPrice_input.focus();
                                //     focusSet = true;
                                // }

                                // if (target.target.id.match(
                                //         /item_priceTabledData\d*/) && !focusSet) {
                                //     $(document).find(
                                //         `#${$(html.match(/<td.*?id=['"]discountTabledData(\d+)['"].*?>.*?<\/td>/)[0]).attr("id")}`
                                //     ).focus();
                                //     unitPrice_input.focus();
                                //     focusSet = true;
                                // }


                                // if (target.target.id.match(
                                //         /percentageTabledData\d*/) && !focusSet) {

                                //     // $(document).find(
                                //     //     `#${$(html.match(/<td.*?id=['"]discountTabledData(\d+)['"].*?>.*?<\/td>/)[0]).attr("id")}`
                                //     // ).focus();

                                //     unitPrice_input.focus();
                                //     focusSet = true;
                                // }

                                // if (target.target.id.match(
                                //         /discountTabledData\d*/) && !focusSet) {
                                //     $(document).find(
                                //         `#${$(html.match(/<td.*?id=['"]percentageTabledData(\d+)['"].*?>.*?<\/td>/)[0]).attr("id")}`
                                //     ).focus();
                                //     unitPrice_input.focus();
                                //     focusSet = true;
                                // }
                                // if (target.target.id.match(
                                //         /quantityTabledData\d*/) && !
                                //     focusSet) {
                                //     $(document).find(
                                //         `#${$(product[0].match(/<td.*?id=['"]percentageTabledData(\d+)['"].*?>.*?<\/td>/)[0]).attr("id")}`
                                //     ).focus();

                                //     unitPrice_input.focus();
                                //     focusSet = true;
                                // }

                                // if (target.target.id.match(
                                //         /item_priceTabledData\d*/) && !
                                //     focusSet) {
                                //     $(document).find(
                                //         `#${$(product[0].match(/<td.*?id=['"]percentageTabledData(\d+)['"].*?>.*?<\/td>/)[0]).attr("id")}`
                                //     ).focus();


                                //     unitPrice_input.focus();
                                //     focusSet = true;
                                // }

                            }
                        });

                    }
                });
            }
        });

        // $(document).on("blur", "#itemAddedtable td", eTarget => {

        // });

        customerName_input.on("input", e => {

            $("#customer-modal-close-btn").focus();
        });
        $("#customer-modal-close-btn").on("click", e => {
            $("#booker_name").focus();
        })

        $(document).on("change", "#booker_name", e => {
            productName_selectInput.focus();
        });
        productName_selectInput.on("input", e => {
            unitPrice_input.focus();
        });
        unitPrice_input.keydown(e => {
            if (e.keyCode == 13) {
                quantity_input.focus();
            }
        });
        quantity_input.keydown(e => {
            if (e.keyCode == 13) {
                if ($("#free_items").is(":checked")) {
                    addItem_button.focus();
                } else {
                    discount_input.focus();

                }
            }

        });
        discount_input.keydown(e => {
            if (e.keyCode == 13) {
                extraDiscount_input.focus();
            }
        });

        extraDiscount_input.keydown(e => {
            if (e.keyCode == 13) {
                addItem_button.focus();
            }
        });

        $(document).keydown(e => {
            if (e.keyCode == 27) {
                if (priceType_input.val() != "rf") {
                    amountReceived_input.focus();
                } else {
                    details_input.focus();


                }

            }
        });

        $("#discount_in_amount").keydown(e => {
            if (e.keyCode == 13) {

                amountReceived_input.focus();
            }
        });
        amountReceived_input.keydown(e => {
            if (e.keyCode == 13) {

                details_input.focus();
            }
        });


        details_input.keydown(e => {
            if (e.keyCode == 13) {

                printBill_button.focus();
            }
        });

        $("#deleteBtn").on("click", e => {
            if ($("#password_sales_1").val() ==
                "<?php echo $_SESSION['ovalfox_pos_cp_sales_1_password'] ?>") {
                $(".overlay-cus").prop("hidden", true);
            } else {
                $(".overlay-cus").prop("hidden", false);

            }
        });

        function openPopup(urlUp) {
            var url = urlUp;
            var windowName = "Customer Data Print";
            var windowFeatures = "width=1000,height=1000";

            window.open(url, windowName, windowFeatures);
        }
        $(document).on("click", "#printCustomer", e => {
            e.preventDefault();

            <?php if ($user[0]['printing_page_size'] == "large") {
                        ?>
            openPopup(
                invoiceType_SelectInput.val() == "si" ?
                `printinvoice1.php?inv=${$(e.target).data("cus")}&amountIn=${isDisInAmntorInPer}` :
                `printinvoice3.php?inv=${$(e.target).data("cus")}&amountIn=${isDisInAmntorInPer}`
            );
            <?php 
                       } else if ($user[0]['printing_page_size'] == "small") {
                        ?>

            openPopup(
                invoiceType_SelectInput.val() == "si" ?
                `printinvoice2.php?inv=${$(e.target).data("cus")}&amountIn=${isDisInAmntorInPer}` :
                `printinvoice3.php?inv=${$(e.target).data("cus")}&amountIn=${isDisInAmntorInPer}`
            );

            <?php } ?>
        });

        // $(document).on("click", "#editCustomer", e => {
        //     $.ajax({
        //         type: "POST",
        //         url: "requestsPHP/data.php",
        //         data: {
        //             "in": $(e.target).data("cus"),

        //             "__FILE__": "loadInvoice",

        //         },
        //         success: e => {
        //             const product = JSON.parse(e);
        //             finalAmount = +product[1][0]['total_amount'];
        //             totalPayable = +product[1][0]['final_amount'];

        //             $("#data").html(product[0]);
        //             $("#total_items").text(product[2]);
        //             $("#total_quantity_added").text(product[3]);

        //             $("#final_amount").val(+product[1][0]['total_amount']);
        //             $("#discount_in_amount").val(+product[1][0]['discount']);
        //             totalPayable_input.val(+product[1][0]['final_amount']);
        //             amountReceived_input.val(+product[1][0][
        //                 'recevied_amount'
        //             ]);
        //             amountReturn_input.val(+product[1][0]['returned_amount']);
        //             pendingAmount_input.val(+product[1][0]['pending_amount']);
        //             quantity_input.focus();
        //             $("#pass_sales_div").removeAttr("hidden");
        //         }
        //     });
        // });




    });
    </script>



</body>

</html>




























