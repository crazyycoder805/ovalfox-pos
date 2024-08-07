<!DOCTYPE html>

<html lang="zxx">
<?php require_once 'assets/includes/head.php'; ?>
<?php
if (isset($_SESSION['ovalfox_pos_access_of']->l) && $_SESSION['ovalfox_pos_role_id'] == 3 && $_SESSION['ovalfox_pos_access_of']->l == 0) {

    header("location:404.php");
    
}
$success = "";
$error = "";
$id = "";

$ledger = $pdo->read("ledger", ['company_profile_id' => $_SESSION['ovalfox_pos_cp_id']]);

$customers = $pdo->read("customers", ['company_profile_id' => $_SESSION['ovalfox_pos_cp_id']]);


if (isset($_POST['add_ledger_btn'])) {

    // if (!empty($_POST['date']) && !empty($_POST['payment_type']) && !empty($_POST['total_amount']) && !empty($_POST['recevied_amount']) && !empty($_POST['details']) && !empty($_POST['payment_from']) && !empty($_POST['dr']) && !empty($_POST['cr']) && !empty($_POST['remaining_amount'])) {

        if (



            $pdo->create("ledger", ['date' => $_POST['date'], 'payment_type' => $_POST['payment_type'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id'], 'total_amount' => $_POST['total_amount'], 'recevied_amount' => $_POST['recevied_amount'], 'details' => $_POST['details'], 'payment_from' => $_POST['payment_from'], 'dr' => $_POST['dr'], 'cr' => $_POST['cr'], 'remaining_amount' => $_POST['remaining_amount']])


        ) {
            $success = "Ledger added.";
                                  header("Location:{$name}");

        } else {
            $error = "Something went wrong.";
        }
    // } else {
    //     $error = "All fields must be filled.";
    // }
} else if (isset($_POST['edit_ledger_btn'])) {
    // if (!empty($_POST['date']) && !empty($_POST['payment_type']) && !empty($_POST['total_amount']) && !empty($_POST['recevied_amount']) && !empty($_POST['details']) && !empty($_POST['payment_from']) && !empty($_POST['dr']) && !empty($_POST['cr']) && !empty($_POST['remaining_amount'])) {


        if (




            $pdo->update("ledger", ['id' => $_GET['edit_ledger']], ['date' => $_POST['date'], 'payment_type' => $_POST['payment_type'], 'total_amount' => $_POST['total_amount'], 'recevied_amount' => $_POST['recevied_amount'], 'details' => $_POST['details'], 'payment_from' => $_POST['payment_from'], 'dr' => $_POST['dr'], 'cr' => $_POST['cr'], 'remaining_amount' => $_POST['remaining_amount']])




        ) {
            $success = "Ledger updated.";
                                  header("Location:{$name}");

        } else {
            $error = "Something went wrong. or can't update this because no changes was found";
        }
    // } else {
    //     $error = "All fields must be filled.";
    // }
} else if (isset($_GET['delete_ledger'])) {
    if ($pdo->delete("ledger", $_GET['delete_ledger'])) {
        $success = "Ledger deleted.";
                              header("Location:{$name}");

    } else {
        $error = "Something went wrong.";
    }
}
if (isset($_GET['edit_ledger'])) {
    $id = $pdo->read("ledger", ['id' => $_GET['edit_ledger'], 'company_profile_id' => $_SESSION['ovalfox_pos_cp_id']]);
}
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
                                <h4 class="page-title">Ledger Form</h4>
                            </div>
                            <div class="breadcrumb-list">
                                <ul>
                                    <li class="breadcrumb-link">
                                        <a href="index.php"><i class="fas fa-home mr-2"></i>Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-link active">Ledger</li>
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
                                                        <label for="date" class="col-form-label">Date</label>
                                                        <input
                                                            value="<?php echo isset($_GET['edit_ledger']) ? $id[0]['date'] : null; ?>"
                                                            class="form-control" name="date" type="date"
                                                            placeholder="Enter ledge date" id="date">
                                                    </div>


                                                </div>
                                                <div class="col-md">

                                                    <div class="form-group s-opt">
                                                        <label for="payment_type"
                                                            class="col-form-label">Categories</label>
                                                        <select class="select2 form-control select-opt"
                                                            name="payment_type" id="payment_type">

                                                            <option value="cash_on_delivery">Cash on delivery</option>
                                                            <option value="online">Online</option>
                                                        </select>
                                                        <span class="sel_arrow">
                                                            <i class="fa fa-angle-down "></i>
                                                        </span>
                                                    </div>
                                                </div>



                                                <div class="col-md">

                                                    <div class="form-group">
                                                        <label class="col-form-label">Customer name</label>
                                                        <select class="select2 form-control select-opt customer-select"
                                                            name="payment_from" id="payment_from">
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
                                                    </div>
                                                </div>







                                            </div>

                                            <div class="row">
                                                <div class="col-md">
                                                    <div class="form-group">
                                                        <label for="remaining_amount" class="col-form-label">Recevied
                                                            amount</label>
                                                        <input
                                                            value="<?php echo isset($_GET['edit_ledger']) ? $id[0]['remaining_amount'] : null; ?>"
                                                            class="form-control" name="remaining_amount" type="number"
                                                            placeholder="Enter ledger Recevied amount"
                                                            id="remaining_amount">
                                                    </div>

                                                </div>

                                                <div class="col-md">
                                                    <div class="form-group">
                                                        <label class="col-form-label">Payment
                                                            type</label>

                                                        <select class="select2 form-control select-opt"
                                                            name="payment_type" id="payment_type">

                                                            <option value="dr">Debit
                                                            </option>
                                                            <option value="cr">Credit
                                                            </option>


                                                        </select>
                                                    </div>
                                                </div>


                                            </div>

                                            <div class="row">
                                                <div class="col-md">
                                                    <div class="col-md">

                                                        <div class="form-group">
                                                            <label for="details" class="col-form-label">Details</label>
                                                            <textarea rows="1" cols="1" class="form-control"
                                                                name="details" id="details"
                                                                placeholder="Details"><?php echo isset($_GET['edit_ledger']) ? $id[0]['details'] : null; ?></textarea>
                                                        </div>
                                                        <div class="form-group mt-3">
                                                            <button class="btn btn-primary" type="reset">reset</button>
                                                            <input
                                                                name="<?php echo isset($_GET['edit_ledger']) ? "edit_ledger_btn" : "add_ledger_btn"; ?>"
                                                                class="btn btn-danger" type="submit">
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="row">
                                                <table id="example1"
                                                    class="table table-striped table-bordered dt-responsive">
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
                                                            <th>Status</th>

                                                            <th>Created at</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            foreach ($ledger as $ledge) {


                                                            ?>
                                                        <tr>
                                                            <td><?php echo $ledge['id']; ?></td>
                                                            <td><?php echo $ledge['date']; ?></td>
                                                            <td><?php echo $ledge['payment_type']; ?></td>
                                                            <td><?php echo $ledge['total_amount']; ?></td>
                                                            <td><?php echo $ledge['recevied_amount']; ?></td>
                                                            <td><?php echo $ledge['details']; ?></td>
                                                            <td><?php echo $ledge['payment_from']; ?></td>
                                                            <td><?php echo $ledge['dr']; ?></td>
                                                            <td><?php echo $ledge['cr']; ?></td>
                                                            <td><?php echo $ledge['remaining_amount']; ?></td>
                                                            <td><?php echo $ledge['status']; ?></td>

                                                            <td><?php echo $ledge['created_at']; ?></td>
                                                            <td>
                                                                <a class="text-success"
                                                                    href="ledger.php?edit_ledger=<?php echo $ledge['id']; ?>">
                                                                    <i class="fa fa-edit"></i>
                                                                </a>
                                                                &nbsp;&nbsp;&nbsp;
                                                                <a class="text-danger"
                                                                    href="ledger.php?delete_ledger=<?php echo $ledge['id']; ?>">
                                                                    <i class="fa fa-trash"></i>
                                                                </a>
                                                            </td>

                                                        </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                                <div class="form-group mb-3">
                                                    <button id="printbtnledger" class="btn btn-danger" type="button"><i
                                                            class="fa fa-print"></i> Print</button>

                                                </div>
                                            </div>
                                        </div>


                                    </form>
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

    $(document).on("input", e => {
        searchedValue = e.target.value;
    })
    $("#printbtnledger").on("click", e => {
        location.href = `printreport1.php?s=${searchedValue}&t=ledger`;
    });
    </script>
</body>

</html>