<!DOCTYPE html>

<html lang="zxx">
<?php require_once 'assets/includes/head.php'; ?>
<?php

$success = "";
$error = "";
$id = "";

$sales_2 = $pdo->read("sales_2", ['company_profile_id' => $_SESSION['cp_id']]);
$products = $pdo->read("products", ['company_profile_id' => $_SESSION['cp_id']]);
$suppliers = $pdo->read("suppliers", ['company_profile_id' => $_SESSION['cp_id']]);


$billNumber = 0;
if (!empty($pdo->read("sales_2", ['company_profile_id' => $_SESSION['cp_id']]))) {

    $billNumber = $pdo->customQuery("SELECT MAX(bill_number) AS billNumber FROM sales_2 WHERE 'company_profile_id' = {$_SESSION['cp_id']}")[0]['billNumber'] + 1;
}
$customers = $pdo->read("customers", ['company_profile_id' => $_SESSION['cp_id']]);




?>

<body>
    <?php require_once 'assets/includes/preloader.php'; ?>

    <div class="page-wrapper">

        <!-- Header Start -->
        <?php require_once 'assets/includes/navbar.php'; ?>
        <!-- Sidebar Start -->
        <?php require_once 'assets/includes/sidebar.php'; ?>
        <!-- Container Start -->
        <div class="page-wrapper">
            <div class="main-content">
                <!-- Page Title Start -->
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                        <?php
                if (!empty($success)) {
                ?>
                        <div class="alert alert-success alert-dismissible fade show">
                            <button type="button" class="close" data-bs-dismiss="alert">&times;</button>
                            <?php echo $success; ?>
                        </div>
                        <?php } else if (!empty($error)) { ?>
                        <div class="alert alert-danger alert-dismissible fade show">
                            <button type="button" class="close" data-bs-dismiss="alert">&times;</button>
                            <?php echo $error; ?>
                        </div>

                        <?php } ?>
                        <div class="page-title-wrapper">
                            <div class="page-title-box">
                                <h4 class="page-title">Purchase Form</h4>
                            </div>
                            <div class="breadcrumb-list">
                                <ul>
                                    <li class="breadcrumb-link">
                                        <a href="index.php"><i class="fas fa-home mr-2"></i>Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-link active">Purchase</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="from-wrapper">
                    <div class="row">

                        <div class="col-xl-3 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">

                                <div class="card-body">

                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">


                                        <div class="row">
                                            <div class="col-md">
                                                <div class="form-group">
                                                    <label class="col-form-label">Order
                                                        No.</label>

                                                    <input class="form-control" name="order_number" type="number"
                                                        placeholder="Enter Order No." id="order_number">
                                                    <label class="col-form-label">Bill
                                                        No.</label>

                                                    <input class="form-control" name="bill_number" type="number"
                                                        placeholder="Enter Bill No." id="bill_number">
                                                    <label class="col-form-label">Customer
                                                        ID</label>

                                                    <input class="form-control" name="customer_id" type="number"
                                                        placeholder="Enter Customer ID." id="customer_id">
                                                    <label class="col-form-label">Date</label>

                                                    <input class="form-control" name="date" type="date"
                                                        placeholder="Enter Date" id="date">
                                                    <label class="col-form-label">Company
                                                        Name</label>

                                                    <select class="select2 form-control select-opt" name="company_name"
                                                        id="company_name">

                                                        <?php

                            foreach ($suppliers as $supplier) {

                            ?>
                                                        <option value="<?php echo $supplier['id']; ?>">
                                                            <?php echo $supplier['name']; ?>
                                                        </option>


                                                        <?php } ?>
                                                    </select>

                                                </div>
                                            </div>


                                        </div>
                                    </div>






                                </div>




                            </div>


                        </div>
                        <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">

                                <div class="card-body">

                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <div class="row">
                                            <div class="col-md">
                                                <h6>Item information:</h6>

                                                <div class="form-group">

                                                    <label class="col-form-label">Item
                                                        Name</label>

                                                    <select class="select2 form-control select-opt" name="item_names"
                                                        id="item_names">
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

                                        </div>
                                        <div class="row">
                                            <div class="col-md">
                                                <div class="form-group">
                                                    <label class="col-form-label">Quantity per box</label>

                                                    <input class="form-control" name="quantity_per_box" type="number"
                                                        placeholder="Enter Quantity per box" id="quantity_per_box">
                                                </div>
                                            </div>
                                            <div class="col-md">
                                                <div class="form-group">
                                                    <label class="col-form-label">Box quantity</label>

                                                    <input class="form-control" name="box_quantity" type="number"
                                                        placeholder="Enter Quantity" id="box_quantity">
                                                </div>
                                            </div>
                                            <div class="col-md">
                                                <div class="form-group">
                                                    <label class="col-form-label">Total quantity</label>

                                                    <input disabled class="form-control" name="total_quantity" type="number"
                                                        placeholder="Enter Quantity" id="total_quantity">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md">
                                                <div class="form-group">
                                                    <label class="col-form-label">Expiry
                                                        Date</label>

                                                    <input class="form-control" name="expiry_date" type="date"
                                                        placeholder="Enter Expiry Date" id="expiry_date">

                                                </div>
                                            </div>
                                            <div class="col-md">
                                                <div class="form-group">
                                                    <label class="col-form-label">Purchase
                                                        Price</label>

                                                    <input class="form-control" name="purchase_price" type="number"
                                                        placeholder="Enter Purchase Pirce" id="purchase_price">


                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">

                                            <div class="col-md">
                                                <div class="form-group">
                                                    <label class="col-form-label">Trades
                                                        Price</label>

                                                    <input class="form-control" name="trades_price" type="number"
                                                        placeholder="Enter Trades Pirce" id="trades_price">


                                                </div>
                                            </div>
                                            <div class="col-md">
                                                <label class="col-form-label ">Wholesale
                                                    Price</label>
                                                <input class="form-control" name="wholesale_price" type="number"
                                                    placeholder="Enter Wholesale Pirce" id="wholesale_price">
                                            </div>

                                        </div>
                                        <div class="row">

                                            <div class="col-md">
                                                <div class="form-group mt-4">
                                                    <button id="add_item" style="border-radius: 0px;"
                                                        class="btn col-md-12 btn-lg btn-success">Add
                                                        Item</button>
                                                </div>
                                            </div>

                                        </div>




                                    </div>






                                </div>




                            </div>



                        </div>
                        <div class="col-xl-5 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">

                                <div class="card-body">

                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                                        <div class="row">
                                            <div class="col-md">
                                                <div class="form-group">
                                                    <label class="col-form-label">Net
                                                        Payable
                                                        Amount</label>

                                                    <input disabled class="form-control" name="net_payable_amount"
                                                        type="number" placeholder="Enter Net Payable Amount"
                                                        id="net_payable_amount">
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

                                            <div class="form-group">
                                                <label class="col-form-label">Details</label>
                                                <textarea name="details" class="form-control" id="details"
                                                    placeholder="Enter Details"></textarea>
                                            </div>



                                        </div>
                                        <div class="row">
                                            <div class="col-md">

                                                <div class="form-group">
                                                    <label class="col-form-label">Discount</label>

                                                    <input class="form-control" name="discount" type="number"
                                                        placeholder="Enter Discount" id="discount">
                                                </div>
                                            </div>
                                            <div class="col-md">

                                                <div class="form-group">
                                                    <label class="col-form-label">Amount
                                                        Paid</label>

                                                    <input class="form-control" name="amount_paid" type="number"
                                                        placeholder="Enter Amount Paid" id="amount_paid">
                                                </div>
                                            </div>
                                            <div class="col-md">

                                                <div class="form-group">
                                                    <label class="col-form-label">Pending</label>

                                                    <input disabled class="form-control" name="amount_pending"
                                                        type="number" placeholder="Enter Pending" id="amount_pending">
                                                    <div class="form-group mt-5">
                                                        <button id="complete_bill" style="border-radius: 0px;"
                                                            class="btn col-md-12 btn-lg btn-primary">Complete
                                                            Bill</button>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>


                                    </div>


                                </div>






                            </div>




                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card" style="overflow: scroll; height: 500px;">

                                <div class="card-body">

                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <div class="row">
                                            <div class="col-md">
                                                <table id="" class="table table-striped table-bordered dt-responsive ">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>

                                                            <th>OrderNo</th>

                                                            <th>BillNo</th>

                                                            <th>Item</th>
                                                            <th>qty</th>
                                                            <th>Expiry</th>
                                                            <th>Trade Price</th>
                                                            <th>Total Amount</th>
                                                            <th>Sale Amount</th>

                                                            <th>Remove</th>

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
            </div>
        </div>
        <?php require_once 'assets/includes/footer.php'; ?>

    </div>









    <!-- Preview Setting Box -->
    <?php require_once 'assets/includes/settings-sidebar.php'; ?>
    <!-- Preview Setting -->
    <?php require_once 'assets/includes/javascript.php'; ?>
    <script>
    $(document).ready(() => {
        const order_no = $("#order_number");
        const bill_number = $("#bill_number");
        const customer_id = $("#customer_id");
        const date = $("#date");
        const discount = $("#discount");

        const company_name = $("#company_name");
        const item_name = $("#item_names");
        const quantity = $("#quantity");
        const expiry_date = $("#expiry_date");
        const purchase_price = $("#purchase_price");
        const total_price_purchase = $("#net_payable_amount");
        const trades_price = $("#trades_price");
        const wholesale_price = $("#wholesale_price");
        const pending_price = $("#amount_pending");
        const amount_paid = $("#amount_paid");
        const details = $("#details");


        const payment_type = $("#payment_type");

        let total_balance = 0;
        let discounted_value = 0;
        $("#add_item").on("click", e => {
            $.ajax({
                type: "POST",
                url: "data.php",
                data: {
                    "__FILE__": "purchaseDataAdd",

                    "order_no": order_no.val(),
                    "bill_number": bill_number.val(),
                    "date": date.val(),
                    "company_name": company_name.val(),

                    "discount": discount.val(),

                    "item_name": item_name.val(),
                    "quantity": quantity.val(),
                    "expiry_date": expiry_date.val(),
                    "purchase_price": purchase_price.val(),
                    "pending_amount": pending_price.val(),

                    "net_payable_amount": total_price_purchase.val(),
                    "trades_price": trades_price.val(),
                    "wholesale_price": wholesale_price.val(),
                    "customer_id": customer_id.val(),
                    "quantity_per_box": $("#quantity_per_box").val(),
                    "total_quantity": $("#total_quantity").val(), 
                    "box_quantity": $("#box_quantity").val()

                },
                success: e => {
                    console.log(e);
                    if (e != "") {
                        const item = JSON.parse(e);
                        total_balance += item[0];

                    } else {
                        total_balance += +purchase_price.val();
                    }
                    total_price_purchase.val(total_balance);
                    quantity.val('');
                    expiry_date.val('');
                    purchase_price.val('');

                    trades_price.val('');
                    wholesale_price.val('');
                    quantity.focus();

                    $.ajax({
                        type: "POST",
                        url: "data.php",
                        data: {
                            "__FILE__": "purchaseFetch",
                            "order_no": order_no.val(),

                        },
                        success: e => {
                            $("#data").html(e);
                        }
                    });
                }
            });

            discount.on("input", e => {
                let discountVal = parseInt(e.target.value) || 0;
                total_price_purchase.val(total_balance - discountVal);
                discounted_value = total_balance - discountVal;
                amount_paid.val('');
                pending_price.val('');
            });

            amount_paid.on("input", e => {


                if (discounted_value != 0) {
                    pending_price.val(+discounted_value - +parseInt(e.target.value || 0));

                } else {
                    pending_price.val(+total_balance - +parseInt(e.target.value || 0));

                }


            });



        });

        $("#quantity_per_box").on("input", e=>{
            $("#box_quantity").val('');
            $("#total_quantity").val('');

        });
        $("#box_quantity").on("input", e=>{
            $("#total_quantity").val(+$("#quantity_per_box").val() * +$("#box_quantity").val());
        });
        $("#complete_bill").on("click", e => {
            $.ajax({
                type: "POST",
                url: "data.php",
                data: {
                    "__FILE__": "purchase2",

                    "order_no": order_no.val(),

                    "discount": discount.val(),

                    "pending_amount": pending_price.val(),
                    "amount_paid": amount_paid.val(),

                    "net_payable_amount": total_price_purchase.val(),
                    "payment_type": payment_type.val(),
                    "details": details.val(),
                    "company_id": company_name.val(),
                    "date": date.val()

                },
                success: e => {
                    location.href = "purchase.php";


                }
            });

        });
        $(document).on("click", "#removeItem", e => {
            $.ajax({
                type: "POST",
                url: "data.php",
                data: {
                    "__FILE__": "deletePurchase",
                    "purchaseId": e.target.value,

                },
                success: e => {
                    const item = JSON.parse(e);
                    total_price_purchase.val(total_balance - item[0]);

                    $.ajax({
                        type: "POST",
                        url: "data.php",
                        data: {
                            "__FILE__": "purchaseFetch",
                            "order_no": order_no.val(),

                        },
                        success: e => {
                            htmlAppend = e;
                            $("#data").html(e);
                        }
                    });
                }
            });
        });

    });
    </script>

</body>

</html>