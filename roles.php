<!DOCTYPE html>

<html lang="zxx">
<?php require_once 'assets/includes/head.php'; ?>
<?php

if (isset($_SESSION['ovalfox_pos_access_of']->r) && $_SESSION['ovalfox_pos_role_id'] == 3 && $_SESSION['ovalfox_pos_access_of']->r == 0) {
        header("location:404.php");
    
}

$success = "";
$error = "";
$id = "";

$roles = $pdo->read("roles", ['company_profile_id' => $_SESSION['ovalfox_pos_cp_id']]);
$operators = $pdo->read("access", ['role_id'=>'3', 'company_profile_id' => $_SESSION['ovalfox_pos_cp_id']]);



if (isset($_POST['add_role_btn'])) {
    if (!empty($_POST['name'])) {
        if (!$pdo->isDataInserted("roles", ['name' => $_POST['name']])) {
            if ($pdo->create("roles", ['name' => $_POST['name'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']])) {
                $success = "Role added.";
                                      header("Location:{$name}");

            } else {
                $error = "Something went wrong.";
            }
        } else {
            $error = "Role already added.";
        }
    } else {
        $error = "Role must be filled.";
    }
} else if (isset($_POST['edit_role_btn'])) {
    if (!empty($_POST['name'])) {
        if (!$pdo->isDataInsertedUpdate("roles", ['name' => $_POST['name']])) {
            if ($pdo->update("roles", ['id' => $_GET['edit_role']], ['name' => $_POST['name']])) {
                $success = "Role updated.";
                                      header("Location:{$name}");

            } else {
                $error = "Something went wrong. or can't update this because no changes was found";
            }
        } else {
            $error = "Role already added.";
        }
    } else {
        $error = "Role must be filled.";
    }
} else if (isset($_GET['delete_role'])) {
    if ($pdo->delete("roles", $_GET['delete_role'])) {
        $success = "Role deleted.";
                              header("Location:{$name}");

    } else {
        $error = "Something went wrong.";
    }
} else if (isset($_POST["update_role_btn"])) {
    
    if (!empty($_POST['username'])) {

        $dashboard = isset($_POST['dashboard']) && $_POST['dashboard'] != null ? $_POST['dashboard'] : 0;
        $sales = isset($_POST['sales']) && $_POST['sales'] != null ? $_POST['sales'] : 0;
        $gernel_expenses = isset($_POST['gernel_expenses']) && $_POST['gernel_expenses'] != null ? $_POST['gernel_expenses'] : 0;
        $ledger = isset($_POST['ledger']) && $_POST['ledger'] != null ? $_POST['ledger'] : 0;
        $stores = isset($_POST['stores']) && $_POST['stores'] != null ? $_POST['stores'] : 0;
        $purchase = isset($_POST['prc']) && $_POST['prc'] != null ? $_POST['prc'] : 0;

        $designations = isset($_POST['designations']) && $_POST['designations'] != null ? $_POST['designations'] : 0;
        $product_categories = isset($_POST['product_categories']) && $_POST['product_categories'] != null ? $_POST['product_categories'] : 0;
        $products = isset($_POST['products']) && $_POST['products'] != null ? $_POST['products'] : 0;
        $customers = isset($_POST['customers']) && $_POST['customers'] != null ? $_POST['customers'] : 0;
        $expense_category = isset($_POST['expense_category']) && $_POST['expense_category'] != null ? $_POST['expense_category'] : 0;
        $suppliers = isset($_POST['suppliers']) && $_POST['suppliers'] != null ? $_POST['suppliers'] : 0;
        $companies = isset($_POST['companies']) && $_POST['companies'] != null ? $_POST['companies'] : 0;
        $employees = isset($_POST['employees']) && $_POST['employees'] != null ? $_POST['employees'] : 0;
        $roles = isset($_POST['roles']) && $_POST['roles'] != null ? $_POST['roles'] : 0;
        $users = isset($_POST['users']) && $_POST['users'] != null ? $_POST['users'] : 0;
        $sales_1 = isset($_POST['sales_1']) && $_POST['sales_1'] != null ? $_POST['sales_1'] : 0;
        $sales_2 = isset($_POST['sales_2']) && $_POST['sales_2'] != null ? $_POST['sales_2'] : 0;
        $purchase_1 = isset($_POST['purchase_1']) && $_POST['purchase_1'] != null ? $_POST['purchase_1'] : 0;
        $purchase_2 = isset($_POST['purchase_2']) && $_POST['purchase_2'] != null ? $_POST['purchase_2'] : 0;
        $ledger_report = isset($_POST['lgr']) && $_POST['lgr'] != null ? $_POST['lgr'] : 0;
        $profile_eidt = isset($_POST['lgr']) && $_POST['pe'] != null ? $_POST['pe'] : 0;

        $rolesAll = json_encode(["d"=>$dashboard, "s"=>$sales, "g"=>$gernel_expenses, "l"=>$ledger, "st"=>$stores, 
        "ds"=>$designations, "pc"=>$product_categories, "p"=>$products, "c"=>$customers, "ec"=>$expense_category, "ss"=>$suppliers,
        "cp"=>$companies, "em"=>$employees, "pe"=>$profile_eidt, "r"=>$roles, "us"=>$users, "prc"=>$purchase, "sr1"=>$sales_1, "sr2"=>$sales_2, "pr1"=>$sales_1, "pr2"=>$purchase_2, "lgr"=>$ledger_report]);
        if ($pdo->update("access", ['id'=>$_POST['username']], ['access_of' => $rolesAll])) {
            $success = "Roles added.";
                                  header("Location:{$name}");

        } else {
            $error = "Something went wrong.";
        }
    } else {
        $error = "Username is required.";
    }
}


$rolesA = "";
if (isset($_GET['edit_role'])) {
    $id = $pdo->read("roles", ['id' => $_GET['edit_role'], 'company_profile_id' => $_SESSION['ovalfox_pos_cp_id']]);
} else if (isset($_GET['update_role'])) {
    $id = $pdo->read("access", ['id' => $_GET['update_role'], 'company_profile_id' => $_SESSION['ovalfox_pos_cp_id']]);
    $rolesA = json_decode($id[0]['access_of']);
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
                                <h4 class="page-title">Role Form</h4>
                            </div>
                            <div class="breadcrumb-list">
                                <ul>
                                    <li class="breadcrumb-link">
                                        <a href="index.php"><i class="fas fa-home mr-2"></i>Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-link active">Role</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- From Start -->
                <div class="from-wrapper">
                    <div class="row">

                        <div class="col-xl-5 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">

                                <div class="card-body">

                                    <form class="separate-form" method="post">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="row">
                                                <div class="col-md">
                                                    <div class="form-group">
                                                        <label for="name" class="col-form-label">Role</label>
                                                        <input
                                                            value="<?php echo isset($_GET['edit_role']) ? $id[0]['name'] : null; ?>"
                                                            class="form-control" name="name" type="text"
                                                            placeholder="Enter Role Name" id="name">
                                                    </div>

                                                    <table id="example1"
                                                        class="table table-striped table-bordered dt-responsive">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Role</th>
                                                                <th>Created at</th>
                                                                <th>Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            foreach ($roles as $role) {


                                                            ?>
                                                            <tr>
                                                                <td><?php echo $role['id']; ?></td>
                                                                <td><?php echo $role['name']; ?></td>
                                                                <td><?php echo $role['created_at']; ?></td>
                                                                <td>
                                                                    <a class="text-success"
                                                                        href="roles.php?edit_role=<?php echo $role['id']; ?>">
                                                                        <i class="fa fa-edit"></i>
                                                                    </a>
                                                                    &nbsp;&nbsp;&nbsp;
                                                                    <a class="text-danger"
                                                                        href="roles.php?delete_role=<?php echo $role['id']; ?>">
                                                                        <i class="fa fa-trash"></i>
                                                                    </a>
                                                                </td>

                                                            </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div>
                                            <div class="form-group mb-0">
                                                <button class="btn btn-primary" type="reset">reset</button>
                                                <input
                                                    name="<?php echo isset($_GET['edit_role']) ? "edit_role_btn" : "add_role_btn"; ?>"
                                                    class="btn btn-danger" type="submit">
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-7 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">

                                <div class="card-body">

                                    <form class="separate-form" method="post">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="row">
                                                <div class="col-md">
                                                    <div class="form-group">
                                                        <label class="col-form-label">Select operator</label>

                                                        <select class="select2 form-control select-opt" name="username"
                                                            id="username">
                                                            <?php 
                                                            foreach ($operators as $operator) {
                                                               
                                                            ?>
                                                            <option
                                                                <?php echo isset($_GET['update_role']) && $id[0]['id'] == $operator['id'] ? "selected" : null; ?>
                                                                value="<?php echo $operator['id']; ?>">
                                                                <?php echo $operator['username']; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md">
                                                                <div class="checkbox">
                                                                    <input
                                                                        <?php echo isset($_GET['update_role']) && $rolesA->d != 0 ? "checked" : null; ?>
                                                                        value="dashboard" id="dashboard"
                                                                        name="dashboard" type="checkbox">
                                                                    <label style="font-size: 10px;" for="dashboard">Dashboard</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md">
                                                                <div class="checkbox">
                                                                    <input
                                                                        <?php echo isset($_GET['update_role']) && $rolesA->s != 0 ? "checked" : null; ?>
                                                                        value="sales" id="sales" name="sales"
                                                                        type="checkbox">
                                                                    <label style="font-size: 10px;" for="sales">Sales</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md">
                                                                <div class="checkbox">
                                                                    <input
                                                                        <?php echo isset($_GET['update_role']) && $rolesA->g != 0 ? "checked" : null; ?>
                                                                        value="gernel_expenses" id="gernel_expenses"
                                                                        name="gernel_expenses" type="checkbox">
                                                                    <label style="font-size: 10px;" for="gernel_expenses">Gernel Expenses</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md">
                                                                <div class="checkbox">
                                                                    <input
                                                                        <?php echo isset($_GET['update_role']) && $rolesA->l != 0 ? "checked" : null; ?>
                                                                        value="ledger" id="ledger" name="ledger"
                                                                        type="checkbox">
                                                                    <label style="font-size: 10px;" for="ledger">Ledger</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md">
                                                                <div class="checkbox">
                                                                    <input
                                                                        <?php echo isset($_GET['update_role']) && $rolesA->st != 0 ? "checked" : null; ?>
                                                                        value="stores" id="stores" name="stores"
                                                                        type="checkbox">
                                                                    <label style="font-size: 10px;" for="stores">Stores</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md">
                                                                <div class="checkbox">
                                                                    <input
                                                                        <?php echo isset($_GET['update_role']) && $rolesA->ds != 0 ? "checked" : null; ?>
                                                                        value="designations" id="designations"
                                                                        name="designations" type="checkbox">
                                                                    <label style="font-size: 10px;" for="designations">Designations</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md">
                                                                <div class="checkbox">
                                                                    <input
                                                                        <?php echo isset($_GET['update_role']) && $rolesA->pc != 0 ? "checked" : null; ?>
                                                                        value="product_categories"
                                                                        id="product_categories"
                                                                        name="product_categories" type="checkbox">
                                                                    <label style="font-size: 10px;" for="product_categories">Product
                                                                        Categories</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md">
                                                                <div class="checkbox">
                                                                    <input
                                                                        <?php echo isset($_GET['update_role']) && $rolesA->p != 0 ? "checked" : null; ?>
                                                                        value="products" id="products" name="products"
                                                                        type="checkbox">
                                                                    <label style="font-size: 10px;" for="products">Products</label>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md">
                                                                <div class="checkbox">
                                                                    <input
                                                                        <?php echo isset($_GET['update_role']) && $rolesA->c != 0 ? "checked" : null; ?>
                                                                        value="customers" id="customers"
                                                                        name="customers" type="checkbox">
                                                                    <label style="font-size: 10px;" for="customers">Customers</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md">
                                                                <div class="checkbox">
                                                                    <input
                                                                        <?php echo isset($_GET['update_role']) && $rolesA->ec != 0 ? "checked" : null; ?>
                                                                        value="expense_category" id="expense_category"
                                                                        name="expense_category" type="checkbox">
                                                                    <label style="font-size: 10px;" for="expense_category">Expenses
                                                                        Category</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md">

                                                                <div class="checkbox">
                                                                    <input
                                                                        <?php echo isset($_GET['update_role']) && $rolesA->ss != 0 ? "checked" : null; ?>
                                                                        value="suppliers" id="suppliers"
                                                                        name="suppliers" type="checkbox">
                                                                    <label style="font-size: 10px;" for="suppliers">Suppliers</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md">

                                                                <div class="checkbox">
                                                                    <input
                                                                        <?php echo isset($_GET['update_role']) && $rolesA->cp != 0 ? "checked" : null; ?>
                                                                        value="companies" id="companies"
                                                                        name="companies" type="checkbox">
                                                                    <label style="font-size: 10px;" for="companies">Companies</label>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md">

                                                                <div class="checkbox">
                                                                    <input
                                                                        <?php echo isset($_GET['update_role']) && $rolesA->em != 0 ? "checked" : null; ?>
                                                                        value="employees" id="employees"
                                                                        name="employees" type="checkbox">
                                                                    <label style="font-size: 10px;" for="employees">Employees</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md">

                                                                <div class="checkbox">
                                                                    <input
                                                                        <?php echo isset($_GET['update_role']) && $rolesA->r != 0 ? "checked" : null; ?>
                                                                        value="roles" id="roles" name="roles"
                                                                        type="checkbox">
                                                                    <label style="font-size: 10px;" for="roles">Roles</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md">
                                                                <div class="checkbox">
                                                                    <input
                                                                        <?php echo isset($_GET['update_role']) && $rolesA->us != 0 ? "checked" : null; ?>
                                                                        value="users" id="users" name="users"
                                                                        type="checkbox">
                                                                    <label style="font-size: 10px;" for="users">Users</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md">
                                                                <div class="checkbox">
                                                                    <input
                                                                        <?php echo isset($_GET['update_role']) && $rolesA->sr1 != 0 ? "checked" : null; ?>
                                                                        value="sales_1" id="sales_1" name="sales_1"
                                                                        type="checkbox">
                                                                    <label style="font-size: 10px;" for="sales_1">Sales 1</label>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md">
                                                                <div class="checkbox">
                                                                    <input
                                                                        <?php echo isset($_GET['update_role']) && $rolesA->sr2 != 0 ? "checked" : null; ?>
                                                                        value="sales_2" id="sales_2" name="sales_2"
                                                                        type="checkbox">
                                                                    <label style="font-size: 10px;" for="sales_2">Sales 2</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md">


                                                                <div class="checkbox">
                                                                    <input
                                                                        <?php echo isset($_GET['update_role']) && $rolesA->pr1 != 0 ? "checked" : null; ?>
                                                                        value="purchase_1" id="purchase_1"
                                                                        name="purchase_1" type="checkbox">
                                                                    <label style="font-size: 10px;" for="purchase_1">Purchases 1</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md">
                                                                <div class="checkbox">
                                                                    <input
                                                                        <?php echo isset($_GET['update_role']) && $rolesA->pr2 != 0 ? "checked" : null; ?>
                                                                        value="purchase_2" id="purchase_2"
                                                                        name="purchase_2" type="checkbox">
                                                                    <label style="font-size: 10px;" for="purchase_2">Purchases 2</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md">

                                                                <div class="checkbox">
                                                                    <input
                                                                        <?php echo isset($_GET['update_role']) && $rolesA->lgr != 0 ? "checked" : null; ?>
                                                                        value="lgr" id="lgr" name="lgr" type="checkbox">
                                                                    <label style="font-size: 10px;" for="lgr">Legder Report</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md">
                                                                <div class="checkbox">
                                                                    <input
                                                                        <?php echo isset($_GET['update_role']) && $rolesA->prc != 0 ? "checked" : null; ?>
                                                                        value="prc" id="prc" name="prc" type="checkbox">
                                                                    <label style="font-size: 10px;" for="prc">Purchase</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md">
                                                                <div class="checkbox">
                                                                    <input
                                                                        <?php echo isset($_GET['update_role']) && $rolesA->pe != 0 ? "checked" : null; ?>
                                                                        value="pe" id="pe" name="pe" type="checkbox">
                                                                    <label style="font-size: 10px;" for="pe">Profile Edit</label>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <table id="example9"
                                                        class="table table-striped table-bordered dt-responsive">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Username</th>
                                                                <th>Access of</th>

                                                                <th>Created at</th>
                                                                <th>Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            foreach ($operators as $ope) {


                                                            ?>
                                                            <tr>
                                                                <td><?php echo $ope['id']; ?></td>
                                                                <td><?php echo $ope['username']; ?></td>
                                                                <td><?php echo $ope['access_of']; ?></td>

                                                                <td><?php echo $ope['created_at']; ?></td>
                                                                <td>
                                                                    <a class="text-success"
                                                                        href="roles.php?update_role=<?php echo $ope['id']; ?>">
                                                                        <i class="fa fa-edit"></i>
                                                                    </a>
                                                                    &nbsp;&nbsp;&nbsp;
                                                                    <a class="text-danger"
                                                                        href="roles.php?delete_update_role=<?php echo $ope['id']; ?>">
                                                                        <i class="fa fa-trash"></i>
                                                                    </a>
                                                                </td>

                                                            </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div>
                                            <div class="form-group mb-0">
                                                <button class="btn btn-primary" type="reset">reset</button>
                                                <input
                                                    name="<?php echo isset($_GET['update_role']) ? "update_role_btn" : "update_role_btn"; ?>"
                                                    class="btn btn-danger" type="submit">
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


</body>

</html>