<!DOCTYPE html>

<html lang="zxx">

<?php require_once 'assets/includes/head.php'; 
if (isset($_GET['theme']) && $_GET['theme'] == "dark") {
    $pdo->update("settings", ['id'=>1], ['theme'=>"dark"]);
    header("location:index.php");
} else if(isset($_GET['theme']) && $_GET['theme'] == "light") {
    $pdo->update("settings", ['id'=>1], ['theme'=>"light"]);
    header("location:index.php");

}else if(isset($_GET['theme']) && $_GET['theme'] == "full_white") {
    $pdo->update("settings", ['id'=>1], ['theme'=>"full_white"]);
    header("location:index.php");

}


$today_orders = count($pdo->customQuery("SELECT * FROM sales_2 WHERE status = 'Unpaid' OR status = 'Incomplete' AND id = {$_SESSION['ovalfox_pos_user_id']} AND company_profile_id = {$_SESSION['ovalfox_pos_cp_id']} AND created_at >= '".date("Y-m-d 00:00:00")."' AND created_at <= '".date("Y-m-d 23:59:59")."'"));

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
                    <div class="colxl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="page-title-wrapper">
                            <div class="page-title-box">
                                <h4 class="page-title bold">Dashboard</h4>
                            </div>
                            <div class="breadcrumb-list">
                                <ul>
                                    <li class="breadcrumb-link">
                                        <a href="index.php"><i class="fas fa-home mr-2"></i>Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-link active">Admin</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <h1>Welcome, to Point Of Sale.</h1>
                <!-- Revanue Status Start -->
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12">
                        <div class="card chart-card">
                            <div class="card-header">
                                <h4 class="has-btn">Current Orders <span></span></h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12 col-md-12">
                                        <table id="example1" class="table table-striped table-bordered dt-responsive ">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Inv number</th>
                                                    <th>Customer</th>
                                                    <th>Booker</th>

                                                    <th>Status</th>

                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                            foreach ($pdo->customQuery("SELECT * FROM sales_2 WHERE status = 'Unpaid' OR status = 'Incomplete' AND company_profile_id = {$_SESSION['ovalfox_pos_cp_id']} AND created_at >= '".date("Y-m-d 00:00:00")."' AND created_at <= '".date("Y-m-d 23:59:59")."'") as $index => $order) {
                                                                $index += 1;
                                                                $booker = $pdo->read("access", ['id' => $order['booker_name']]);
                                                                $customer = $pdo->read("customers", ['id' => $order['customer_name']]);

                                                            ?>
                                                <tr>
                                                    <td><?php echo $index; ?></td>
                                                    <td><?php echo $order['invoice_number']; ?></td>
                                                    <td><?php echo $customer[0]['name']; ?></td>

                                                    <td><?php echo $booker[0]['username']; ?></td>

                                                    <td><?php echo $order['status']; ?></td>

                                                    <td>
                                                        <a class="text-success"
                                                            href="sales.php?inv_num=<?php echo $order['invoice_number']; ?>">
                                                            <i class="fa fa-edit"></i>
                                                        </a>

                                                    </td>

                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Products Orders Start -->

                <?php require_once 'assets/includes/footer.php'; ?>
            </div>
        </div>
    </div>


    <!-- Preview Setting Box -->
    <?php require_once 'assets/includes/settings-sidebar.php'; ?>
    <!-- Preview Setting -->
    <?php require_once 'assets/includes/javascript.php'; ?>
</body>


</html>