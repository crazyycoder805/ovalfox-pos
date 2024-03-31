<!DOCTYPE html>

<html lang="zxx">
<?php require_once 'assets/includes/head.php';  
$categories = $pdo->read('categories', ['company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']]);

?>


<body>
    <?php require_once 'assets/includes/preloader.php'; ?>

    <!-- Main Body -->
    <div class="page-wrapper">
        <!-- Header Start -->
        <?php require_once 'assets/includes/navbar.php'; ?>
        <!-- Sidebar Start -->
        <?php require_once 'assets/includes/sidebar.php'; ?>
        <!-- Container Start -->
        <!-- Container Start -->
        <div class="page-wrapper">
            <div class="main-content">
                <!-- Page Title Start -->
                <div class="row">
                    <div class="col xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="page-title-wrapper">
                            <div class="page-title-box">
                                <h4 class="page-title">Starter Page</h4>
                            </div>
                            <div class="breadcrumb-list">
                                <ul>
                                    <li class="breadcrumb-link">
                                        <a href="index-2.html"><i class="fas fa-home mr-2"></i>Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-link active">Starter Page</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md">
                        <ul class="nav nav-pills flex-nowrap mb-3" id="pills-tab" role="tablist"
                            style="overflow-x: scroll;">
                            <?php foreach ($categories as $category) { ?>
                            <li class="nav-item mb-3">
                                <a class="nav-link <?php echo $category['id'] == 1 ? "active" : null ?>"
                                    id="pills-<?php echo $pdo->mergeStrings($category['category']); ?>-tab"
                                    data-bs-toggle="pill"
                                    href="#pills-<?php echo $pdo->mergeStrings($category['category']); ?>" role="tab"
                                    aria-controls="pills-<?php echo $pdo->mergeStrings($category['category']); ?>"
                                    aria-selected="true"><?php echo $category['category']; ?></a>
                            </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
                <!-- Products view Start -->
                <div class="row">
                    <div class="col-xl">
                        <div class="card">
                            <!-- <div class="card-header pb-0">
                                <h4 class="card-title">Justify Tabs</h4>
                            </div> -->
                            <div class="card-content">
                                <div class="card-body">




                                    <div class="tab-content" id="pills-tabContent">
                                        <?php
                                 

                                    
                                    foreach ($categories as $ca) {
                                        $product = $pdo->read('products', ['category_id' => $ca['id'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']]);
                                        
                                    ?>
                                        <div style="height: 700px;"
                                            class="tab-pane <?php  echo !empty($product[0]) && $product[0]['id'] == 7 ? "active" : null ?> fade show"
                                            id="pills-<?php echo $pdo->mergeStrings($ca['category']); ?>"
                                            role="tabpanel">
                                            <div class="row">
                                                <?php 
                                               foreach ($product as $p) {
                                                
                                               ?>
                                                <div class="col-md-6">
                                                    <div class="prooduct-details-box">
                                                        <div class="media">
                                                            <img src="assets/images/product.png" alt="">
                                                            <div class="media-body ms-3">
                                                                <div class="product-name">
                                                                    <h6><a href="javascript:;"
                                                                            title=""><?php echo $p['product_name']; ?></a>
                                                                    </h6>
                                                                </div>
                                                                <!-- <div class="rating"><i class="fa fa-star"></i><i
                                                                        class="fa fa-star"></i><i
                                                                        class="fa fa-star"></i><i
                                                                        class="fa fa-star"></i><i
                                                                        class="fa fa-star"></i>
                                                                </div> -->
                                                                <div class="price">
                                                                    <div class="text-muted me-2">
                                                                        Price: Rs
                                                                        <?php echo $p['purchase_per_unit_price']; ?>
                                                                    </div>
                                                                </div>
                                                                <div class="avaiabilty">
                                                                    <div class="text-success">
                                                                        Available quantity:
                                                                        <?php echo $p['total_quantity']; ?></div>
                                                                    <button type="button"
                                                                        class="btn btn-primary squer-btn sm-btn mt-2 mr-2"
                                                                        data-pid="<?php echo $p['id']; ?>"
                                                                        data-price="<?php echo $p['purchase_per_unit_price']; ?>"
                                                                        data-quantity="<?php echo $p['total_quantity']; ?>"
                                                                        data-item_code="<?php echo $p['item_code']; ?>"
                                                                        data-item_name="<?php echo $p['item_code']; ?>"

                                                                        id="cart-btn">Move
                                                                        to Cart</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <?php } ?>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl">
                        <div class="int-blog-sidebar">
                            <div class="row">
                                <!-- Styled Table Card-->
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="card table-card">
                                        <div class="card-header pb-0">
                                            <h4>Cart</h4>
                                        </div>
                                        <div class="card-body pb-4">
                                            <div class="chart-holder">
                                                <div class="table-responsive">
                                                    <table class="table table-styled mb-0">
                                                        <thead>
                                                            <tr>
                                                                <th>Prdouct</th>
                                                                <th>Prdouct Name</th>
                                                                <th>Price</th>
                                                                <th>Quantity</th>
                                                                <th>Action</th>
                                                                <th>Total</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="data">



                                                        </tbody>

                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <div class="ad-breadcrumb ad-breadcrumb2 dd-flex"
                                                                        style="visibility: hidden;">
                                                                        <div class="form-group">
                                                                            <div class="ad-user-btn">
                                                                                <input class="form-control" type="text"
                                                                                    placeholder="Enter Coupan Code">
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group ad-apply-cart">
                                                                            <a class="ad-btn">Apply</a>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>&nbsp;</td>
                                                                <td>&nbsp;</td>
                                                                <td>&nbsp;</td>
                                                                <td><b>Total Price :</b></td>
                                                                <td>Rs <span id="finalPrice">0.0</span></td>
                                                            </tr>
                                                            <tr>
                                                                <td>&nbsp;</td>
                                                                <td>&nbsp;</td>
                                                                <td>&nbsp;</td>
                                                                <td>&nbsp;</td>
                                                                <td><a href="all-product.html"
                                                                        class="btn btn-danger squer-btn mt-2 mr-2">Continue
                                                                        Shopping</a></td>
                                                                <td><a href="checkout.html"
                                                                        class="btn btn-success squer-btn mt-2 mr-2">Checkout</a>
                                                                </td>
                                                            </tr>
                                                        </tbody>
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

                <?php require_once 'assets/includes/footer.php'; ?>

            </div>
        </div>
    </div>



    <!-- Preview Setting Box -->
    <?php require_once 'assets/includes/settings-sidebar.php'; ?>
    <!-- Preview Setting -->
    <?php require_once 'assets/includes/javascript.php'; ?>

    <script>
    $(document).ready(e => {
        const dataHtml = $("#data");
        const finalprice = parseInt($("#finalPrice").text());
        var quantity = 0;
        let totalAmount = 0;
        let totalp = 0;
        let totalQauntity = 0;
        let invoice_number = +
            <?php echo $maxedInvoiceNumber = $pdo->customQuery("SELECT MAX(invoice_number) AS maxedInvoiceNumber FROM sales_2")[0]['maxedInvoiceNumber'] + 1; ?>;
        var pidValue = 0;
        $(document).on("click", "#cart-btn", function() {
            pidValue = $(this).data("pid");


            $.ajax({
                type: "POST",
                url: "data.php",
                data: {
                    "__FILE__": "foodProduct",
                    pid: pidValue,
                    "invoice_number": invoice_number

                },
                success: e => {

                    let pd = JSON.parse(e);
                    totalp = parseInt(pd[0]) * totalQauntity;

                    totalAmount += parseInt(pd[0]);
                    $("#finalPrice").text(totalAmount);
                    $.ajax({
                        type: 'POST',
                        url: "data.php",
                        data: {
                            '__FILE__': "foodFetch",

                            pid: pidValue,
                            "invoice_number": invoice_number,
                            "amount" : 

                        },
                        success: e => {
                            dataHtml.html(e);

                        }
                    })
                }
            });


        });

        $(document).on('click', '.quantity-plus', function(e) {
            e.preventDefault();

            quantity = parseInt($(this).siblings('.quantity').val());
            $(this).siblings('.quantity').val(quantity + 1);

            let itemPrice = parseInt($(this).closest("#parentElement").find("#itemp").text());
            let price = parseInt($(this).closest("#parentElement").find("#itemtotalp").text());
            totalp = +itemPrice * +totalQauntity;
            totalAmount += +itemPrice;
            totalQauntity = quantity + 1;
            $.ajax({
                type: "POST",
                url: "data.php",
                data: {
                    '__FILE__': "foodProduct",
                    "value": "plus",
                    "invoice_number": invoice_number,
                    "quantity": totalQauntity,
                    "amount" : price,
                    pid: pidValue,

                },
                success: e => {}
            });
            

            $(this).closest("#parentElement").find("#itemtotalp").text(totalp);


            $("#finalPrice").text(totalAmount);
        });
        $(document).on('click', '.quantity-minus', function(e) {
            e.preventDefault();
            quantity = parseInt($(this).siblings('.quantity').val());

            if (quantity - 1 > 0) {
                $(this).siblings('.quantity').val(quantity - 1);

                let itemPrice = parseInt($(this).closest("#parentElement").find("#itemp").text());
                let totalQuantity = quantity - 1;
                $(this).closest("#parentElement").find("#itemtotalp").text(+itemPrice * +totalQuantity);
                totalAmount -= +itemPrice;
                $("#finalPrice").text(totalAmount);
                $.ajax({
                    type: "POST",
                    url: "data.php",
                    data: {
                        '__FILE__': "foodProduct",
                        "value": "minus", // Updated value for subtraction
                        "invoice_number": invoice_number,
                        "quantity": totalQuantity,
                        "amount" : price,

                        pid: pidValue,
                    },
                    success: e => {}
                });

              
            }
        });
        $(document).on('input', '.quantity', function(e) {
            e.preventDefault();
            let inputValue = parseInt(e.target.value);

            if (inputValue <= 0) {
                $(this).val(1);
                inputValue = 1;
            }

            let itemPrice = parseInt($(this).closest("#parentElement").find("#itemp").text());
            $(this).closest("#parentElement").find("#itemtotalp").text(+itemPrice * inputValue);
            totalAmount += +itemPrice * inputValue;
            $("#finalPrice").text(totalAmount);

        });

    });
    </script>
</body>



</html>