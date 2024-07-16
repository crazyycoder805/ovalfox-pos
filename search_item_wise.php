<!DOCTYPE html>

<html lang="zxx">
<?php require_once 'assets/includes/head.php'; ?>
<?php
  if (isset($_SESSION['ovalfox_pos_access_of']->sr1) && $_SESSION['ovalfox_pos_role_id'] == 3 && $_SESSION['ovalfox_pos_access_of']->sr1 == 0) {
        header("location:404.php");
    
}


$bookers = $pdo->read("access", ['company_profile_id' => $_SESSION['ovalfox_pos_cp_id']]);
$customers = $pdo->read("customers", ['company_profile_id' => $_SESSION['ovalfox_pos_cp_id']]);
$products = $pdo->read("products", ['company_profile_id' => $_SESSION['ovalfox_pos_cp_id']]);

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
                                <h4 class="page-title">Item Wise Form</h4>
                            </div>
                            <div class="breadcrumb-list">
                                <ul>
                                    <li class="breadcrumb-link">
                                        <a href="index.php"><i class="fas fa-home mr-2"></i>Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-link active">Item Wise</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- From Start -->
                <div class="from-wrapper">
                    <div class="row">

                        <div class="col-xl col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">

                                <div class="card-body">

                                    <form class="separate-form" method="post">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="row">
                                                <div class="col-md">
                                                    <div class="form-group">
                                                        <!-- <label class="col-form-label">Product name</label> -->


                                                        <select class="select2 form-control  select-opt" name="product"
                                                            id="product">
                                                            <option selected value="">Select
                                                                product
                                                            </option>
                                                            <?php

foreach ($products as $product) {

?>
                                                            <option value="<?php echo $product['item_code']; ?>">
                                                                <?php echo $product['product_name']; ?>
                                                            </option>


                                                            <?php } ?>
                                                        </select>
                                                    </div>

                                                </div>
                                                <div class="col-md">
                                                    <div class="form-group">

                                                        <label class="col-form-label">Booker Name</label>

                                                        <select class="select booker-select select-opt" name="booker_name"
                                                            id="booker_name">
                                                            <option disabled selected value="">Select Booker
                                                            </option>
                                                            <?php

                                                            foreach ($bookers as $booker) {

                                                            ?>
                                                            <option value="<?php echo $booker['id']; ?>">
                                                                <?php echo $booker['username']; ?></option>


                                                            <?php } ?>
                                                        </select>
                                                    </div>



                                                </div>
                                                <div class="col-md">
                                                    <div class="form-group">

                                                        <label class="col-form-label">Customer Name</label>

                                                        <select class="select customer-select select-opt" name="customer" id="customer">
                                                            <option disabled selected value="">Select Customer
                                                            </option>
                                                            <?php

                                                            foreach ($customers as $customer) {

                                                            ?>
                                                            <option value="<?php echo $customer['id']; ?>">
                                                                <?php echo $customer['name']; ?></option>


                                                            <?php } ?>
                                                        </select>
                                                    </div>



                                                </div>

                                            </div>
                                            <div class="row">
                                                <div class="col-md">
                                                    <div class="form-group">
                                                        <label for="start_date" class="col-form-label">Start
                                                            date</label>
                                                        <input class="form-control" name="start_date" type="date"
                                                            placeholder="Search..." id="start_date">
                                                    </div>
                                                </div>
                                                <div class="col-md">

                                                    <div class="form-group">
                                                        <label for="end_date" class="col-form-label">End
                                                            date</label>
                                                        <input class="form-control" name="end_date" type="date"
                                                            placeholder="Search..." id="end_date">
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                        <br />

                                        <div class="form-group mb-">
                                            <button class="btn btn-primary" type="reset">reset</button>
                                            <button name="search" id="search" class="btn btn-danger"
                                                type="button">Submit</button>
                                        </div>
                                        <div class="row">
                                            <div id="data"></div>

                                        </div>

                                    </form>
                                    <div class="row">
                                        <div class="col-md">
                                            <div class="form-group mb-3">
                                                <form method="post" action="printreport1.php">
                                                    <button id="printbtnsales1itemwise" class="btn btn-danger"
                                                        type="submit"><i class="fa fa-print"></i> Print</button>
                                                    <input hidden type="text" name="s" id="s" />
                                                    <input hidden type="text" name="t" id="t" value="search_item_wise" />
                                                </form>

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
    let searchedValue = "";

    $(document).ready(e => {
        $("#search").on("click", e => {
            $.ajax({
                type: "POST",
                url: "reportingRequests/search_item_wise.php",
                data: {
                    "__FILE__": "search_item_wise",
                    "search_item_wise": e.target.value,
                    "start_date": $("#start_date").val(),
                    "end_date": $("#end_date").val(),
                    "booker_name": $("#booker_name").val(),
                    "product_name": $("#product").val(),
                    "customer_name": $("#customer").val()



                },
                success: e => {
                    const items = JSON.parse(e);
                    $("#data").html(items[0]);
                    $('#search_table').DataTable();
                    searchedValue = items[1];
                    $("#s").val(btoa(JSON.stringify(searchedValue)));
                }

            });

        });


        // $("#printbtnsales1itemwise").on("click", e => {
        //     location.href =
        //         `printreport1.php?s=${btoa(JSON.stringify(searchedValue))}&t=search_item_wise`;
        // });
    });
    </script>
</body>

</html>