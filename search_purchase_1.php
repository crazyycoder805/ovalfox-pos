<!DOCTYPE html>

<html lang="zxx">
<?php require_once 'assets/includes/head.php'; ?>
<?php
  if (isset($_SESSION['ovalfox_pos_access_of']->pr1) && $_SESSION['ovalfox_pos_role_id'] == 3 && $_SESSION['ovalfox_pos_access_of']->pr1 == 0) {
        header("location:404.php");
    
}
$suppliers = $pdo->read("suppliers", ['company_profile_id' => $_SESSION['ovalfox_pos_cp_id']]);

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
                                <h4 class="page-title">Purchase 1 Search Form</h4>
                            </div>
                            <div class="breadcrumb-list">
                                <ul>
                                    <li class="breadcrumb-link">
                                        <a href="index.php"><i class="fas fa-home mr-2"></i>Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-link active">Purchase 1 Search</li>
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


                                                        <select class="select2 form-control select-opt" name="product"
                                                            id="product">
                                                            <option selected value="">Select
                                                                Supplier
                                                            </option>
                                                            <?php

foreach ($suppliers as $sp) {

?>
                                                            <option value="<?php echo $sp['id']; ?>">
                                                                <?php echo $sp['name']; ?>
                                                            </option>


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
                                            <div class="form-group mb-">
                                                <button class="btn btn-primary" type="reset">reset</button>
                                                <button name="search" id="search" class="btn btn-danger"
                                                    type="button">Submit</button>
                                            </div>
                                            <div class="row">
                                                <div id="data"></div>

                                            </div>

                                        </div>

                                    </form>
                                    <div class="row">
                                        <div class="col-md">
                                            <div class="form-group mb-3">
                                                <button id="printbtnpurchase1custom" class="btn btn-danger"
                                                    type="button"><i class="fa fa-print"></i> Print</button>

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
        $("#search").on("click", e => {
            $.ajax({
                type: "POST",
                url: "reportingRequests/search_purchase_1.php",
                data: {
                    "__FILE__": "search_purchase_1",
                    "search_purchase_1": e.target.value,
                    "start_date": $("#start_date").val(),
                    "end_date": $("#end_date").val(),
                    "supplier": $("#product").val()

                },
                success: e => {
                    const items = JSON.parse(e);
                    $("#data").html(items[0]);
                    $('#search_table').DataTable();
                    searchedValue = items[1];
                }

            });

        });
        $("#printbtnpurchase1custom").on("click", e => {
            location.href = `printreport1.php?s=${btoa(JSON.stringify(searchedValue))}&t=purchases_1`;
        });
    })
    </script>
</body>

</html>