<!DOCTYPE html>

<html lang="zxx">
<?php require_once 'assets/includes/head.php'; ?>
<?php
 if (isset($_SESSION['ovalfox_pos_access_of']->g) && $_SESSION['ovalfox_pos_role_id'] == 3 && $_SESSION['ovalfox_pos_access_of']->g == 0) {
        header("location:404.php");
    
}
$success = "";
$error = "";
$id = "";

$expense_categories = $pdo->read("expense_categories", ['company_profile_id' => $_SESSION['ovalfox_pos_cp_id']]);
$gernel_expenses = $pdo->read("gernel_expenses", ['company_profile_id' => $_SESSION['ovalfox_pos_cp_id']]);



if (isset($_POST['add_customer_btn'])) {

    if (!empty($_POST['expense_category_id']) && !empty($_POST['expense_name']) && !empty($_POST['paid_by']) && !empty($_POST['paid_to'])  && !empty($_POST['amount'])) {

        if (


            $pdo->create("gernel_expenses", ['expense_category_id' => $_POST['expense_category_id'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id'], 'expense_name' => $_POST['expense_name'], 'date' => $_POST['date'], 
            'paid_by' => $_POST['paid_by'], 'paid_to' => $_POST['paid_to'], 'amount' => $_POST['amount']])
&&             $pdo->create("ledger", ['date' => $_POST['date'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id'], 'payment_type' => $_POST['expense_name'], 'total_amount' => $_POST['amount'], 'dr' => $_POST['amount'],
'status' => "GERNEL_EXPENSE"])



        ) {
            $success = "Gernel expense added.";
                                  header("Location:{$name}");

        } else {
            $error = "Something went wrong.";
        }
    } else {
        $error = "All fields must be filled.";
    }
} else if (isset($_POST['edit_gernel_expense_btn'])) {
    if (!empty($_POST['expense_category_id']) && !empty($_POST['expense_name']) && !empty($_POST['paid_by']) && !empty($_POST['paid_to'])  && !empty($_POST['amount'])) {


        if (

            $pdo->update("gernel_expenses", ['id' => $_GET['edit_gernel_expense']], ['expense_category_id' => $_POST['expense_category_id'], 'expense_name' => $_POST['expense_name'], 'date' => $_POST['date'], 'paid_by' => $_POST['paid_by'], 'paid_to' => $_POST['paid_to'], 'amount' => $_POST['amount']])
        ) {
            $success = "Gernel expense updated.";
                                  header("Location:{$name}");

        } else {
            $error = "Something went wrong. or can't update this because no changes was found";
        }
    } else {
        $error = "All fields must be filled.";
    }
} else if (isset($_GET['delete_gernel_expense'])) {
    if ($pdo->delete("gernel_expenses", $_GET['delete_gernel_expense'])) {
        $success = "Gernel expense deleted.";
                              header("Location:{$name}");

    } else {
        $error = "Something went wrong.";
    }
}
if (isset($_GET['edit_gernel_expense'])) {
    $id = $pdo->read("gernel_expenses", ['id' => $_GET['edit_gernel_expense'], 'company_profile_id' => $_SESSION['ovalfox_pos_cp_id']]);
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
                                <h4 class="page-title">Gernel expense Form</h4>
                            </div>
                            <div class="breadcrumb-list">
                                <ul>
                                    <li class="breadcrumb-link">
                                        <a href="index.php"><i class="fas fa-home mr-2"></i>Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-link active">Gernel expense</li>
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
                                                    <div class="form-group s-opt">
                                                        <label for="expense_category_id"
                                                            class="col-form-label">Categories</label>
                                                        <select class="select2 form-control select-opt"
                                                            name="expense_category_id" id="expense_category_id">
                                                            <?php
                                                            foreach ($expense_categories as $expense_category) {


                                                            ?>
                                                            <option
                                                                <?php echo isset($_GET['edit_gernel_expense']) && $id[0]['expense_category_id'] == $expense_category['id'] ? "selected" : null; ?>
                                                                value="<?php echo $expense_category['id']; ?>">
                                                                <?php echo $expense_category['name']; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                        <span class="sel_arrow">
                                                            <i class="fa fa-angle-down "></i>
                                                        </span>
                                                    </div>


                                                </div>

                                                <div class="col-md">

                                                    <div class="form-group">
                                                        <label for="expense_name" class="col-form-label">Expense
                                                            name</label>
                                                        <input
                                                            value="<?php echo isset($_GET['edit_gernel_expense']) ? $id[0]['expense_name'] : null; ?>"
                                                            class="form-control" name="expense_name" type="text"
                                                            placeholder="Enter Customer Expense Name" id="expense_name">
                                                    </div>
                                                </div>
                                                <div class="col-md">

                                                    <div class="form-group">
                                                        <label for="date" class="col-form-label">Date</label>
                                                        <input
                                                            value="<?php echo isset($_GET['edit_gernel_expense']) ? $id[0]['date'] : null; ?>"
                                                            class="form-control" name="date" type="date"
                                                            placeholder="Enter Customer date" id="date">
                                                    </div>
                                                </div>
                                                <div class="col-md">

                                                    <div class="form-group">
                                                        <label for="paid_by" class="col-form-label">Paid by</label>
                                                        <input
                                                            value="<?php echo isset($_GET['edit_gernel_expense']) ? $id[0]['paid_by'] : null; ?>"
                                                            class="form-control" name="paid_by" type="text"
                                                            placeholder="Enter Paid By" id="paid_by">
                                                    </div>
                                                </div>
                                                <div class="col-md">

                                                    <div class="form-group">
                                                        <label for="paid_to" class="col-form-label">Paid to</label>
                                                        <input
                                                            value="<?php echo isset($_GET['edit_gernel_expense']) ? $id[0]['paid_to'] : null; ?>"
                                                            class="form-control" name="paid_to" type="text"
                                                            placeholder="Enter Paid To" id="paid_to">
                                                    </div>
                                                </div>
                                                <div class="col-md">

                                                    <div class="form-group">
                                                        <label for="amount" class="col-form-label">Amount</label>
                                                        <input
                                                            value="<?php echo isset($_GET['edit_gernel_expense']) ? $id[0]['amount'] : null; ?>"
                                                            class="form-control" name="amount" type="number"
                                                            placeholder="Enter Amount" id="amount">
                                                    </div>
                                                    <div class="form-group mt-3">
                                                        <button class="btn btn-primary" type="reset">reset</button>
                                                        <input
                                                            name="<?php echo isset($_GET['edit_gernel_expense']) ? "edit_gernel_expense_btn" : "add_customer_btn"; ?>"
                                                            class="btn btn-danger" type="submit">
                                                    </div>
                                                </div>



                                                <table id="example1"
                                                    class="table table-striped table-bordered dt-responsive">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Expense category</th>
                                                            <th>Expense name</th>
                                                            <th>Date</th>
                                                            <th>Paid by</th>
                                                            <th>Paid to</th>
                                                            <th>Amount</th>

                                                            <th>Created at</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            foreach ($gernel_expenses as $gernel_expense) {
                                                                $expense_category2 = $pdo->read("expense_categories", ['id' => $gernel_expense['expense_category_id'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']]);
                                                            ?>
                                                        <tr>
                                                            <td><?php echo $gernel_expense['id']; ?></td>
                                                            <td><?php echo $expense_category2[0]['name']; ?></td>
                                                            <td><?php echo $gernel_expense['expense_name']; ?></td>
                                                            <td><?php echo $gernel_expense['date']; ?></td>
                                                            <td><?php echo $gernel_expense['paid_by']; ?></td>
                                                            <td><?php echo $gernel_expense['paid_to']; ?></td>
                                                            <td><?php echo $gernel_expense['amount']; ?></td>

                                                            <td><?php echo $gernel_expense['created_at']; ?></td>
                                                            <td>
                                                                <a class="text-success"
                                                                    href="gernel_expenses.php?edit_gernel_expense=<?php echo $gernel_expense['id']; ?>">
                                                                    <i class="fa fa-edit"></i>
                                                                </a>
                                                                &nbsp;&nbsp;&nbsp;
                                                                <a class="text-danger"
                                                                    href="gernel_expenses.php?delete_gernel_expense=<?php echo $gernel_expense['id']; ?>">
                                                                    <i class="fa fa-trash"></i>
                                                                </a>
                                                            </td>

                                                        </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                                <div class="form-group mb-3">
                                                    <button id="printbtngernelexpense" class="btn btn-danger"
                                                        type="button"><i class="fa fa-print"></i> Print</button>

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
    $("#printbtngernelexpense").on("click", e => {
        location.href = `printreport1.php?s=${searchedValue}&t=gernelexpense`;
    });
    </script>

</body>

</html>