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
                                        value="<?php echo $customer_inv[0]['name']; ?>" name="customer_name"
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
                                        value="<?php echo isset($_SESSION['ovalfox_pos_role_id']) && $_SESSION['ovalfox_pos_role_id'] == "2" ? $_SESSION['ovalfox_pos_username'] : $booker_inv[0]['username']; ?>"
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
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="card">

                                    <div class="card-body">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="card" style="overflow: scroll; height: 800px;">

                                                <div class="card-body">

                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                        <div class="row">
                                                            <div class="col-md">
                                                                <div class="d-flex flex-row">
                                                                    <h3>Total items: <b id="total_items">0</b></h3>
                                                                    &nbsp;&nbsp;&nbsp;
                                                                    <h3>Total Quantity: <b
                                                                            id="total_quantity_added">0</b></h3>
                                                                    &nbsp;&nbsp;&nbsp;
                                                                    <div id="pass_sales_div" hidden>
                                                                        <label for="password_sales_1"
                                                                            style="padding-top: 8px;">password to
                                                                            delete items:</label>
                                                                        &nbsp;&nbsp;&nbsp;

                                                                        <input type="text" id="password_sales_1"
                                                                            name="password_sales_1"
                                                                            placeholder="password" />
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
                                        <?php     if ($settings[0]['theme'] == "full_white") {
?>
                                        <div class="d-flex flex-row">

                                            <div class="splash-radio-button">
                                                <input id="piece" name="qua" type="radio" value="piece" checked="">
                                                <label for="piece" class="radio-label">Piece</label>
                                                &nbsp;&nbsp;&nbsp;
                                                <input id="box" name="qua" type="radio" value="box">
                                                <label for="box" class="radio-label">Box</label>
                                            </div>

                                        </div>

                                        <?php } ?>
                                        <?php     if ($settings[0]['theme'] == "dark" || $settings[0]['theme'] == "light") {
?>
                                        <div class="ad-radio-button">
                                            <input class="radio" id="piece" value="piece" name="qua" type="radio"
                                                checked>
                                            <label for="piece" class="radio-label">Piece</label>
                                            &nbsp;&nbsp;
                                            <input class="radio" id="box" value="box" name="qua" type="radio">
                                            <label for="box" class="radio-label">Box</label>
                                        </div>


                                        <?php } ?>

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
                                    <?php     if ($settings[0]['theme'] == "full_white") {
                            ?>
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




                                    <?php } ?>
                                    <?php     if ($settings[0]['theme'] == "dark" || $settings[0]['theme'] == "light") {
                            ?>
                                    <div class="ad-radio-button">

                                        <input id="discount_amount" name="discountchkbx1" type="radio" checked>
                                        <label for="discount_amount" class="radio-label">In
                                            Amount</label>

                                        <input id="discount_percentage" name="discountchkbx1" type="radio">
                                        <label for="discount_percentage" class="radio-label">In
                                            Percentage</label>
                                    </div>
                                    <?php } ?>



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
                                    <?php     if ($settings[0]['theme'] == "full_white") {
                            ?>
                                    <div class="splash-radio-button">
                                        <input id="discount_amount2" name="discountchkbx2" type="radio" checked="">
                                        <label for="discount_amount2" class="radio-label">In
                                            Amount</label>
                                        &nbsp;&nbsp;&nbsp;
                                        <input id="discount_percentage2" name="discountchkbx2" type="radio">
                                        <label for="discount_percentage2" class="radio-label">In
                                            Percentage</label>
                                    </div>




                                    <?php } ?>
                                    <?php     if ($settings[0]['theme'] == "dark" || $settings[0]['theme'] == "light") {
                            ?>
                                    <div class="ad-radio-button">

                                        <input id="discount_amount2" name="discountchkbx2" type="radio" checked>
                                        <label for="discount_amount2" class="radio-label">In
                                            Amount</label>

                                        <input id="discount_percentage2" name="discountchkbx2" type="radio">
                                        <label for="discount_percentage2" class="radio-label">In
                                            Percentage</label>
                                    </div>
                                    <?php } ?>
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

        const item_code = $("#item_code");
        const invoice_number = $("#invoice_number");
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

        let initialQuantity = 0;
        <?php 
            if (isset($_GET['inv_num'])) {

            
            ?>
        $.ajax({
            type: "POST",
            url: "data.php",
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
                $("#total_payable").val((+product[1][0]['final_amount'] != 0 ? product[1][0][
                    'final_amount'
                ] : +product[1][0]['total_amount']));
                $("#amount_received").val(+product[1][0][
                    'recevied_amount'
                ]);
                $("#amount_return").val(+product[1][0]['returned_amount']);
                $("#pending_amount").val((+product[1][0]['pending_amount'] != 0 ? product[1][0][
                    'pending_amount'
                ] : +product[1][0]['total_amount']));
                $("#current_date").val(product[1][0]['date']);


                $("#quantity").focus();
                $("#pass_sales_div").removeAttr("hidden");


                if (product[4]) {
                    $("#amount_received").prop("disabled", true);
                    $("#pending_amount").val(0);
                    $("#recevied_amount").val(0);
                    $("#discount_in_amount").prop("disabled", true);
                    $("#details").focus();
                    $('#type').val('rf');
                    $('#type').prop('disabled', true);

                } else {
                    $("#amount_received").focus();
                    $('#type option[value="rf"]').remove();

                }
                $("#customer_manual").prop("disabled", true);
                $("#manual_customer").prop("disabled", true);

            }
        });



        <?php } else { ?>
        $("#customer_name").focus();

        <?php } ?>
        let quantityAdd = 0;
        let totalQuan = 0;
        let productId = 0;
        let finalerAmount = 0;
        let finalAmount = 0;

        let totalPayable = 0;
        let totalItems = 0;
        let toggleValue = $('input[name="qua').val();
        let quantity_per_box = 0;
        let box_quantity = 0;
        let total_quantity_is = 0;
        let total_discount = 0;

        $("#product").on("input", e => {

            productId = e.target.value;
            $("#item_code_search").val('');
            $("#quantity").val('');
            $("#total_quantity").val('');

            $("#total_quantity").val('');
            $("#discount").val('');
            $("#extra_discount").val('');
            $("#total_amount").val('');

            if ($("#item_code_search").val() == "") {
                $.ajax({
                    type: "POST",
                    url: "data.php",
                    data: {
                        '__FILE__': "productSelect",
                        product: e.target.value,
                        "customer_name": $("#manual_customer").is(":checked") == true ?
                            $("#customer_manual").val() : $("#customer_name").val(),

                    },
                    success: e => {

                        const product = JSON.parse(e);
                        item_code.val(product[0]);
                        unit_price.val(product[1]);
                        item_name.val(product[2]);
                        total_quantity.val(product[3]);
                        $("#last_rate").html(product[4]);
                        unit_price.focus();

                        initialQuantity = total_quantity.val();
                    }
                });
            } else {
                $.ajax({
                    type: "POST",
                    url: "data.php",
                    data: {
                        '__FILE__': "productSelectItemCode",
                        productId: e.target.value,
                        "customer_name": $("#manual_customer").is(":checked") == true ?
                            $("#customer_manual").val() : $("#customer_name").val(),
                    },
                    success: e => {
                        const product = JSON.parse(e);
                        totalQuan = product[3];
                        item_code.val(product[0]);
                        unit_price.val(product[1]);
                        item_name.val(product[2]);

                        quantity.val(quantityAdd++);

                        total_quantity.val(totalQuan - quantity.val());


                        $("#last_rate").html(product[4]);

                        unit_price.focus();
                        initialQuantity = totalQuan;
                        total_amount.val(quantity.val() * unit_price.val());

                    }
                });
            }
        });

        let prevVal = "";
        $("#item_code_search").on("change", target => {
            document.getElementById("product").selectedIndex = 0;

            if (target.target.value != "") {
                $.ajax({
                    type: "POST",
                    url: "data.php",
                    data: {
                        '__FILE__': "productSelectItemCode",
                        product: target.target.value,
                        "customer_name": $("#manual_customer").is(":checked") == true ?
                            $("#customer_manual").val() : $("#customer_name").val(),
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
                        $("#last_rate").html(product[4]);
                        total_quantity_is = product[5];
                        box_quantity = product[6];
                        quantity_per_box = product[7];
                        if (toggleValue == "box") {
                            $("#total_quantity").val(+total_quantity_is - (+$(
                                "#quantity").val() * +quantity_per_box));
                            total_amount.val((+$("#quantity").val() * +
                                quantity_per_box) * +unit_price.val());
                            $("#taaup").val((+$("#quantity").val() * +
                                quantity_per_box) * +unit_price.val());
                        } else if (toggleValue == "piece") {
                            total_quantity.val(totalQuan - quantity.val());
                            total_amount.val(+$("#quantity").val() * +unit_price.val());
                            $("#taaup").val(+$("#quantity").val() * +unit_price.val());
                        }
                        unit_price.focus();
                        initialQuantity = totalQuan;
                        prevVal = target.target.value;
                    }
                });
            }

        });



        $("#quantity").on('input', e => {
            let inputValue = parseInt(e.target.value);
            if (inputValue <= 0) {
                e.target.value = 1;
            }
            if (!$("#free_items").is(":checked")) {
                if ($("#type").val() == "rf") {
                    $("#total_quantity").val(+initialQuantity + +$("#quantity").val());
                    total_amount.val(+e.target.value * +unit_price.val());
                    $("#taaup").val(+e.target.value * +unit_price.val());

                } else {
                    if (toggleValue == "piece") {
                        if (+e.target.value > initialQuantity) {
                            alert(
                                "Quantity can't be greater than the total quantity the higher available quantity will be automatically selected"
                            );
                            e.target.value = initialQuantity;
                        }
                        $("#total_quantity").val(+initialQuantity - +$("#quantity").val());
                        total_amount.val(+e.target.value * +unit_price.val());
                        $("#taaup").val(+e.target.value * +unit_price.val());

                    } else if (toggleValue == "box") {
                        if (+e.target.value > box_quantity) {
                            alert(
                                "Quantity can't be greater than the total quantity the higher available quantity will be automatically selected"
                            );
                            e.target.value = box_quantity;
                        }
                        $("#total_quantity").val(+total_quantity_is - (+$("#quantity").val() * +
                            quantity_per_box));
                        total_amount.val((+$("#quantity").val() * +quantity_per_box) * +unit_price
                            .val());
                        $("#taaup").val((+$("#quantity").val() * +quantity_per_box) * +unit_price
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
                    $("#total_quantity").val(+initialQuantity - +$("#quantity").val());

                } else if (toggleValue == "box") {
                    if (+e.target.value > box_quantity) {
                        alert(
                            "Quantity can't be greater than the total quantity the higher available quantity will be automatically selected"
                        );
                        e.target.value = box_quantity;
                    }
                    $("#total_quantity").val(+total_quantity_is - (+$("#quantity").val() * +
                        quantity_per_box));

                }
            }







        });


        // function AmountToPer(discount, amount) {
        //     return (discount / amount) * 100;
        // }

        // function PertToAmount(discount, amount) {
        //     return (+$("#quantity").val() * +$("#unit_price").val()) - ;
        // }

        // const calculateDiscount = (quantity, unitPrice, discountRate) => {
        //     const discountedPrice = (unitPrice * quantity) - discountRate;
        //     let totalNEW = +$("#quantity").val() * +unit_price.val();

        //     const discountPercentage = totalNEW - ((unitPrice * quantity) / 100) * discountRate;
        //     return {
        //         discountedPrice: discountedPrice,
        //         discountPercentage: discountPercentage
        //     };
        // }
        // const calculateExtraDiscount = (totalAmount, extraDiscountRate) => {
        //     const extraDiscountedPrice = totalAmount - extraDiscountRate;
        //     let totalNEW = +$("#quantity").val() * +unit_price.val();

        //     const discountPercentage = totalNEW - (totalAmount / 100) * extraDiscountRate;

        //     return {
        //         extraDiscountedPrice: extraDiscountedPrice,
        //         discountPercentage: discountPercentage,
        //     };
        // };



        const calculateDiscount = (quantity, unitPrice, discountRate) => {
            const discountedPrice = ((quantity * unitPrice) - discountRate);
            let percentage = (quantity * unitPrice) * (1 - (discountRate / 100));
            // 50 * 0.95
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
        //     const extraDiscountValue = parseInt(e.target.value || 0);
        //     const total = parseInt(total_discount || 0);
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
            let inputValue = parseInt(e.target.value);
            if (inputValue < 0) {
                e.target.value = 0;
            }
            const result = calculateDiscount(+quantity.val(), +unit_price.val(), +discount.val());
            total_discount = isAmount == "" ? +result
                .discountedPrice : (isAmount == "amount" ? +result.discountedPrice : +result
                    .percentage);
            total_amount.val(+total_discount);
            // $("#taaup").val(+total_discount);

            extra_discount.val('');
        });
        extra_discount.on("input", e => {
            let inputValue = parseInt(e.target.value);
            if (inputValue < 0) {
                e.target.value = 0;
            }
            const extraDiscountValue = parseInt(e.target.value || 0);
            const result = calculateExtraDiscount(total_discount != 0 ? ($("#extra_dsicount").val() ==
                    0 ? +quantity
                    .val() * +unit_price.val() : +total_discount) : +quantity
                .val() * +unit_price.val(), +extraDiscountValue);
            total_amount.val(+result);
            // $("#discount_amount").prop("checked", true);
            // $("#taaup").val(+result);

        });
        $("#discount_amount").on("click", e => {
            const resultDis = calculateDiscount(+$("#quantity").val(), +$("#unit_price").val(), +$(
                "#discount").val());
            total_amount.val(resultDis.discountedPrice);
            total_discount = resultDis.discountedPrice;
            $("#extra_discount").val('');
            isAmount = e.target.value;
            // $("#taaup").val(resultDis);

        });
        $("#discount_percentage").on("click", e => {
            const resultDis = calculateDiscount(+$("#quantity").val(), +$("#unit_price").val(), +$(
                "#discount").val());
            total_amount.val(resultDis.percentage);
            total_discount = resultDis.percentage;

            $("#extra_discount").val('');
            isAmount = e.target.value;

            // $("#taaup").val(resultDis);

        });





        // $("#discount_amount").on("click", e => {
        //     const resultDis = calculateDiscount(quantity.val(), unit_price.val(), discount
        //         .val());
        //     const extraDiscountValue = parseInt(extra_discount.val() || 0);
        //     const total = parseInt(total_discount || 0);
        //     const result = calculateExtraDiscount(total, extraDiscountValue);
        //     total_amount.val(result.extraDiscountedPrice);
        // });
        // $("#discount_percentage").on("click", e => {
        //     const resultDis = calculateDiscount(quantity.val(), unit_price.val(), discount
        //         .val());
        //     const extraDiscountValue = parseInt(extra_discount.val() || 0);
        //     const total = parseInt(total_discount || 0);
        //     const result = calculateExtraDiscount(total, extraDiscountValue);
        //     total_amount.val(extra_discount.val() != 0 && extra_discount.val() != "" &&
        //         extra_discount
        //         .val() != null ? result.discountPercentage : resultDis.discountPercentage);
        // });




        $("#discount_in_amount").on("input", e => {
            let inputValue = parseInt(e.target.value);
            if (inputValue < 0) {
                e.target.value = 0;
            }
            $("#total_payable").val(+finalAmount - +parseInt(e.target.value || 0));
            totalPayable = +finalAmount - +parseInt(e.target.value || 0);

            $("#amount_received").val('');

            $("#amount_return").val('');
            $("#pending_amount").val('');

        });


        $("#discount_amount2").on("click", e => {
            $("#total_payable").val(+finalAmount - +$("#discount_in_amount").val());


        });
        $("#discount_percentage2").on("click", e => {

            $("#total_payable").val((finalAmount) * (1 - (+$("#discount_in_amount").val() / 100)));
        });



        $("#amount_received").on("input", e => {
            let inputValue = parseInt(e.target.value);
            if (inputValue < 0) {
                e.target.value = 0;
            }
            if (+parseInt(e.target.value || 0) >= $("#total_payable").val()) {
                $("#amount_return").val(+parseInt(e.target.value || 0) - (+totalPayable != 0 ? +
                    totalPayable : +finalAmount));
                //$("#amount_return").val($("#type").val() != "rf" ? parseInt(e.target.value || 0) - (totalPayable != 0 ? totalPayable : finalAmount) : Math.abs(parseInt(e.target.value || 0)) - (totalPayable != 0 ? Math.abs(totalPayable) : Math.abs(finalAmount)))  ;

                $("#pending_amount").val(0);
            } else {

                $("#pending_amount").val((+totalPayable != 0 ? +totalPayable : +finalAmount) - +
                    parseInt(e.target.value || 0));
                $("#amount_return").val(0);

            }
        });

        $(document).on("click", "#removeItem", e => {
            $.ajax({
                type: "POST",
                url: "data.php",
                data: {
                    "__FILE__": "deleteProductSales1",
                    "salesId": e.target.value,
                    "invoice_number": $("#invoice_number").val(),

                },
                success: e => {
                    const item = JSON.parse(e);

                    $("#final_amount").val(finalAmount - item[0]);
                    $("#total_payable").val(finalAmount - item[0]);
                    $("#pending_amount").val(finalAmount - item[0]);

                    $.ajax({
                        type: "POST",
                        url: "data.php",
                        data: {
                            "__FILE__": "productFetch",
                            "invoice_number": $("#invoice_number").val(),

                        },
                        success: e => {
                            const product = JSON.parse(e);
                            $("#data").html(product[0]);
                            $("#total_items").text(product[1]);
                            $("#total_quantity_added").text(product[2]);

                        }
                    });
                }
            });
        });


        $("input[name='qua']").on("change", e => {
            toggleValue = e.target.value;
            quantityAdd = 0;
            $("#total_quantity").val(initialQuantity);

            $.ajax({
                type: "POST",
                url: "data.php",
                data: {
                    "__FILE__": "selectTypeQuantity",
                    "typeQuantity": e.target.value,
                    "type": $("#type").val(),

                    "productId": productId,
                    "itemSearch": $("#item_code_search").val(),

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
                    $("#total_amount").val('');
                    $("#total_quantity").val(total_quantity_is);

                }
            });
        });



        $('#type').on("input", e => {
            $.ajax({
                type: "POST",
                url: "data.php",
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
                    $("#total_amount").val('');
                    const item = JSON.parse(e);
                    unit_price.val(item[0]);
                    total_quantity_is = item[1];
                    box_quantity = item[2];
                    quantity_per_box = item[3];
                    quantityAdd = 0;
                    $("#total_quantity").val(initialQuantity);
                }
            });
        });


        unit_price.on("input", e => {
            let inputValue = parseInt(e.target.value);
            if (inputValue < 0) {
                e.target.value = 1;
            }
            quantity.val('');
            discount.val('');
            extra_discount.val('');
            $("#total_amount").val('');
            $("#taaup").val('');

            quantityAdd = 0;

            $("#total_quantity").val(initialQuantity);

        });
        $("#invoice_number").on("change", e => {
            let inputValue = parseInt(e.target.value);
            if (inputValue <= 0) {
                e.target.value = 1;
            }
            location.href = `sales.php?inv_num=${e.target.value}`;

        });
        // $("#invoice_number").on("change", e => {
        //     $.ajax({
        //         type: "POST",
        //         url: "data.php",
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
        //             $("#total_payable").val(+product[1][0]['final_amount']);
        //             $("#amount_received").val(+product[1][0][
        //                 'recevied_amount'
        //             ]);
        //             $("#amount_return").val(+product[1][0]['returned_amount']);
        //             $("#pending_amount").val(+product[1][0]['pending_amount']);
        //             $("#quantity").focus();
        //             $("#pass_sales_div").removeAttr("hidden");

        //         }
        //     });

        // });

        let A = 0;
        $("#wholeFormBtn").on("click", e => {
            A = 1;
            $("#product").focus();
            $("#product").select2("open");
            setTimeout(function() {
                var searchField = $(
                    '.select2-container--open .select2-search__field');
                if (searchField.length) {
                    searchField[0].focus();
                }
            }, 0.1);
            quantityAdd = 0;

            if ($("#invoice_number").val() == "") {
                <?php
                    $maxedInvoiceNumber = (int)$pdo->customQuery("SELECT 
                    MAX(CAST(invoice_number AS UNSIGNED)) AS maxedInvoiceNumber,
                    company_profile_id
                    FROM 
                    sales_2 
                    WHERE 
                    company_profile_id = '{$_SESSION['ovalfox_pos_cp_id']}'")[0]['maxedInvoiceNumber'] + 1;
                    ?>

                $("#invoice_number").val(+<?php echo $maxedInvoiceNumber ?>);

            }


            if (A == 1) {
                if ($("#type").val() == "rf") {
                    finalAmount -= +$("#total_amount").val();
                    $("#amount_received").prop("disabled", true);
                    $("#pending_amount").val(0);
                    $("#recevied_amount").val(0);
                    $("#discount_in_amount").prop("disabled", true);
                } else {
                    finalAmount += +$("#total_amount").val();
                }



                $.ajax({
                    type: "POST",
                    url: "data.php",
                    data: {
                        "__FILE__": "productAdd",
                        "invoice_number": $("#invoice_number").val(),
                        "booker_name": $("#booker_name").val(),
                        "customer_name": $("#customer_name").val(),
                        "item_code": $("#item_code").val(),
                        "date": $("#current_date").val(),
                        "item_name": $("#item_name").val(),
                        "item_price": $("#unit_price").val(),
                        "quantity": $("#quantity").val(),
                        "amount": $("#total_amount").val(),
                        "discount": $("#discount").val(),
                        "discount_in_amount": discount.val(),
                        "extra_discount": $("#extra_discount").val(),
                        "total_amount": finalAmount,
                        "taaup": $("#taaup").val(),

                        "final_amount": $("#total_payable").val(),
                        "recevied_amount": $("#amount_received").val(),
                        "returned_amount": $("#amount_return").val(),
                        "pending_amount": $("#pending_amount").val(),
                        "product_id": $("#product").val(),
                        "item_code_search": $("#item_code_search").val(),
                        "total_quantity": $("#total_quantity").val(),
                        "type": $("#type").val(),
                        "isItemFree": $("#free_items").is(":checked") ? true : false,
                        "customer_manual": $("#manual_customer").is(":checked") ? $(
                            "#customer_manual").val() : "",
                        "amountIn": isAmount == "" ? "amount" : isAmount

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
                        $("#taaup").val('');

                        $("#extra_dsicount").val('');
                        // $("#product").select2("open");
                        // setTimeout(function() {
                        //     var searchField = $(
                        //         '.select2-container--open .select2-search__field');
                        //     if (searchField.length) {
                        //         searchField[0].focus();
                        //     }
                        // }, 100);

                        $("#final_amount").val(finalAmount + finalerAmount);
                        $("#total_payable").val($("#final_amount").val());
                        $("#pending_amount").val($("#final_amount").val());


                        $("#extra_discount").val('');
                        $("#amount_received").val('');
                        $("#amount_return").val('');
                        total_amount.val('');
                        document.getElementById("product").selectedIndex = 0;



                        $.ajax({
                            type: "POST",
                            url: "data.php",
                            data: {
                                "__FILE__": "productFetch",
                                "invoice_number": $("#invoice_number").val(),

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
                                $("#invoice_number").prop("disabled", true);
                                if ($("#manual_customer").is(":checked")) {
                                    $("#customer_manual").prop("disabled",
                                        true);
                                    $("#manual_customer").prop("disabled",
                                        true);

                                } else {
                                    $("#manual_customer").prop("disabled",
                                        true);
                                    $("#customer_manual").prop("disabled",
                                        true);

                                }

                                $("#customer_name").prop("disabled", true);
                                $("#booker_name").prop("disabled", true);

                                $("#customer_manual").prop("disabled", true);
                                $("#manual_customer").prop("disabled", true);
                                $("#pass_sales_div").removeAttr("hidden");
                                quantity.prop("disabled", false);
                                discount.prop("disabled", false);
                                extra_discount.prop("disabled", false);
                                $("#total_amount").prop("disabled", false);
                                if ($("#type").val() == "rf") {
                                    $("#type").prop("disabled", true);
                                } else {
                                    $('#type option[value="rf"]').remove();

                                }
                                $("#discount_amount").prop("checked", true);
                                isAmount = "amount";
                            }
                        });
                    }
                });
            }

        });



        $("#pBill").on("click", event => {
            $.ajax({
                type: "POST",
                url: "data.php",
                data: {
                    "__FILE__": "sales2Update",
                    "invoice_number": $("#invoice_number").val(),
                    "discount_in_amount": $("#discount_in_amount").val(),
                    "final_amount": $("#total_payable").val(),
                    "recevied_amount": $("#amount_received").val(),
                    "returned_amount": $("#amount_return").val(),
                    "pending_amount": $("#pending_amount").val(),
                    "total_amount": $("#final_amount").val(),
                    "payment_type": $("#payment_type").val(),
                    "details": $("#details").val(),

                },
                success: target => {
                    <?php if ($user[0]['printing_page_size'] == "large") {
                        ?>
                    openPopup(`printinvoice1.php?inv=${$("#invoice_number").val()}`);
                    location.href = `sales.php`;

                    <?php 
                       } else if ($user[0]['printing_page_size'] == "small") {
                        ?>
                    openPopup(`printinvoice2.php?inv=${$("#invoice_number").val()}`);
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
            $("#total_quantity").val(initialQuantity);

            if ($(this).is(':checked')) {

                discount.val(0);
                extra_discount.val(0);
                $("#total_amount").val(0);
                discount.prop("disabled", true);
                extra_discount.prop("disabled", true);
                $("#total_amount").prop("disabled", true);
            } else {
                quantityAdd = 0;
                quantity.val('');

                discount.prop("disabled", false);
                extra_discount.prop("disabled", false);
                $("#total_amount").prop("disabled", false);
            }

        });

        function showConfirmation() {
            return confirm("Are you sure to clear this bill?");
        }

        $("#clear_bill").on("click", e => {

            if (showConfirmation()) {
                $.ajax({
                    type: "POST",
                    url: "data.php",
                    data: {
                        "__FILE__": "salesDelete",
                        "invoice_number": $("#invoice_number").val(),
                    },
                    success: function(e) {
                        location.href = "sales.php";
                    }
                });
            }

        });

        $("#manual_customer").change(function() {
            if ($(this).is(":checked")) {
                $("#customer_manual").prop("disabled", false);
                document.getElementById("customer_name").selectedIndex = -1;
                $("#customer_name").prop("disabled", true);

            } else {
                $("#customer_manual").prop("disabled", true);
                $("#customer_manual").val("");
                $("#customer_name").prop("disabled", false);

            }
        });

        $("#customer_name").on("change", e => {
            $("#manual_customer").prop("checked", false);
            $("#customer_manual").prop("disabled", true);

            $("#customer_manual").val("");

        });


        $("#customer_name").on("change", e => {
            $.ajax({
                type: "POST",
                url: "data.php",
                data: {
                    '__FILE__': "showCustomerData",
                    "cusId": e.target.value
                },
                success: e => {
                    $("#customerDataShow").html(e);
                    $(".modalCustomer").modal("show");
                }
            })

        });
        $(document).on('keydown', "#itemAddedtable td", e => {
            if (e.keyCode == 13) {
                console.log(e.target);
                $(e.target.id).focus();
            }
        });
        let focusSet = false;

        $(document).on("blur", "#itemAddedtable td", eTarget => {
            focusSet = false;
            let target = eTarget;



            let inputValue = parseInt(eTarget.target.textContent);
            if (!eTarget.target.id.match(/discountTabledData/) && !eTarget.target.id.match(
                    /extraTabledData/) && !eTarget
                .target.id.match(/percentageTabledData/)) {
                if (inputValue <= 0) {
                    eTarget.target.textContent = 1;
                }
            }



            $.ajax({
                type: "POST",
                url: "data.php",
                data: {
                    "__FILE__": "runtimeTableDataEdit",
                    "target": `{"${eTarget.target.id}": "${eTarget.target.textContent}"}`,
                    "invoice_number": $("#invoice_number").val()
                },
                success: runtimeTableDataEditE => {


                    $.ajax({
                        type: "POST",
                        url: "data.php",
                        data: {
                            "__FILE__": "productFetch",
                            "invoice_number": $("#invoice_number").val(),

                        },
                        complete: (jq) => {
                            focusSet = true;

                        },
                        success: e => {
                            const product = JSON.parse(e);
                            $("#data").html(product[0]);
                            // let html = ;
                            $("#total_items").text(product[1]);
                            $("#total_quantity_added").text(product[
                                2]);
                            finalAmount = product[3];

                            $("#final_amount").val(product[
                                3]);
                            $("#total_payable").val($("#final_amount").val());
                            $("#pending_amount").val($("#final_amount").val());

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

                            //     $("#unit_price").focus();
                            //     focusSet = true;
                            // }

                            // if (target.target.id.match(
                            //         /discountTabledData\d*/) && !focusSet) {
                            //     $(document).find(
                            //         `#${$(html.match(/<td.*?id=['"]percentageTabledData(\d+)['"].*?>.*?<\/td>/)[0]).attr("id")}`
                            //     ).focus();
                            //     $("#unit_price").focus();
                            //     focusSet = true;
                            // }


                            // if (target.target.id.match(
                            //         /quantityTabledData\d*/) && !focusSet) {
                            //     $(document).find(
                            //         `#${$(html.match(/<td.*?id=['"]discountTabledData(\d+)['"].*?>.*?<\/td>/)[0]).attr("id")}`
                            //     ).focus();
                            //     $("#unit_price").focus();
                            //     focusSet = true;
                            // }

                            // if (target.target.id.match(
                            //         /item_priceTabledData\d*/) && !focusSet) {
                            //     $(document).find(
                            //         `#${$(html.match(/<td.*?id=['"]discountTabledData(\d+)['"].*?>.*?<\/td>/)[0]).attr("id")}`
                            //     ).focus();
                            //     $("#unit_price").focus();
                            //     focusSet = true;
                            // }


                            // if (target.target.id.match(
                            //         /percentageTabledData\d*/) && !focusSet) {

                            //     // $(document).find(
                            //     //     `#${$(html.match(/<td.*?id=['"]discountTabledData(\d+)['"].*?>.*?<\/td>/)[0]).attr("id")}`
                            //     // ).focus();

                            //     $("#unit_price").focus();
                            //     focusSet = true;
                            // }

                            // if (target.target.id.match(
                            //         /discountTabledData\d*/) && !focusSet) {
                            //     $(document).find(
                            //         `#${$(html.match(/<td.*?id=['"]percentageTabledData(\d+)['"].*?>.*?<\/td>/)[0]).attr("id")}`
                            //     ).focus();
                            //     $("#unit_price").focus();
                            //     focusSet = true;
                            // }
                            // if (target.target.id.match(
                            //         /quantityTabledData\d*/) && !
                            //     focusSet) {
                            //     $(document).find(
                            //         `#${$(product[0].match(/<td.*?id=['"]percentageTabledData(\d+)['"].*?>.*?<\/td>/)[0]).attr("id")}`
                            //     ).focus();

                            //     $("#unit_price").focus();
                            //     focusSet = true;
                            // }

                            // if (target.target.id.match(
                            //         /item_priceTabledData\d*/) && !
                            //     focusSet) {
                            //     $(document).find(
                            //         `#${$(product[0].match(/<td.*?id=['"]percentageTabledData(\d+)['"].*?>.*?<\/td>/)[0]).attr("id")}`
                            //     ).focus();


                            //     $("#unit_price").focus();
                            //     focusSet = true;
                            // }
                        }
                    });

                }
            });
        });

        $("#customer_name").on("input", e => {

            $("#customer-modal-close-btn").focus();
        });
        $("#customer-modal-close-btn").on("click", e => {
            $("#booker_name").focus();
        })

        $(document).on("change", "#booker_name", e => {
            $("#product").focus();
        });
        $("#product").on("input", e => {
            $("#unit_price").focus();
        });
        $("#unit_price").keydown(e => {
            if (e.keyCode == 13) {
                $("#quantity").focus();
            }
        });
        $("#quantity").keydown(e => {
            if (e.keyCode == 13) {
                if ($("#free_items").is(":checked")) {
                    $("#wholeFormBtn").focus();
                } else {
                    $("#discount").focus();

                }
            }

        });
        $("#discount").keydown(e => {
            if (e.keyCode == 13) {
                $("#extra_discount").focus();
            }
        });

        $("#extra_discount").keydown(e => {
            if (e.keyCode == 13) {
                $("#wholeFormBtn").focus();
            }
        });

        $(document).keydown(e => {
            if (e.keyCode == 27) {
                if ($("#type").val() != "rf") {
                    $("#amount_received").focus();
                } else {
                    $("#details").focus();


                }

            }
        });

        $("#discount_in_amount").keydown(e => {
            if (e.keyCode == 13) {

                $("#amount_received").focus();
            }
        });
        $("#amount_received").keydown(e => {
            if (e.keyCode == 13) {

                $("#details").focus();
            }
        });


        $("#details").keydown(e => {
            if (e.keyCode == 13) {

                $("#pBill").focus();
            }
        });

        $("#password_sales_1").on("change", e => {
            if (e.target.value == "<?php echo $_SESSION['ovalfox_pos_cp_sales_1_password'] ?>") {
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
            <?php if ($user[0]['printing_page_size'] == "large") {
                        ?>
            openPopup(`printinvoice1.php?inv=${$(e.target).data("cus")}`);
            <?php 
                       } else if ($user[0]['printing_page_size'] == "small") {
                        ?>
            openPopup(`printinvoice2.php?inv=${$(e.target).data("cus")}`);

            <?php } ?>
        });

        // $(document).on("click", "#editCustomer", e => {
        //     $.ajax({
        //         type: "POST",
        //         url: "data.php",
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
        //             $("#total_payable").val(+product[1][0]['final_amount']);
        //             $("#amount_received").val(+product[1][0][
        //                 'recevied_amount'
        //             ]);
        //             $("#amount_return").val(+product[1][0]['returned_amount']);
        //             $("#pending_amount").val(+product[1][0]['pending_amount']);
        //             $("#quantity").focus();
        //             $("#pass_sales_div").removeAttr("hidden");
        //         }
        //     });
        // });



    });
    </script>



</body>

</html>