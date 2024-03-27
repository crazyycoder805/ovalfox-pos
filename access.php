<!DOCTYPE html>

<html lang="zxx">
<?php require_once 'assets/includes/head.php'; ?>
<?php
if(isset($_SESSION['access_of']->d) && $_SESSION['ovalfox_pos_access_of']->d != 0) {

}
$success = "";
$error = "";
$id = "";

$access = $pdo->read("access", ['company_profile_id' => $_SESSION['ovalfox_pos_cp_id']]);



if (isset($_POST['add_customer_btn'])) {

    if (!empty($_POST['name']) && !empty($_POST['cnic']) && !empty($_POST['phone']) && !empty($_POST['address']) && !empty($_POST['balanace'])  && !empty($_POST['bill_head'])) {
        if ($pdo->validateInput($_POST['cnic'], 'cnic')) {
            if ($pdo->validateInput($_POST['phone'], 'phone')) {

                if ($pdo->create("access", ['name' => $_POST['name'], 'cnic' => $_POST['cnic'], 'phone' => $_POST['phone'], 'address' => $_POST['address'], 'company_profile_id'=>$_SESSION['cp_id'], 'balanace' => $_POST['balanace'], 'bill_head' => $_POST['bill_head']])) {
                    $success = "Customer added.";
                     header("Location:{$name}");
                } else {
                    $error = "Something went wrong.";
                }
            } else {
                $error = "Invalid Phone.";
            }
        } else {
            $error = "Invalid CNIC.";
        }
    } else {
        $error = "All fields must be filled.";
    }
} else if (isset($_POST['edit_customer_btn'])) {
    if (!empty($_POST['name']) && !empty($_POST['cnic']) && !empty($_POST['phone']) && !empty($_POST['address']) && !empty($_POST['balanace'])  && !empty($_POST['bill_head'])) {
        if ($pdo->validateInput($_POST['cnic'], 'cnic')) {
            if ($pdo->validateInput($_POST['phone'], 'phone')) {

                if ($pdo->update("access", ['id' => $_GET['edit_customer']], ['name' => $_POST['name'], 'cnic' => $_POST['cnic'], 'phone' => $_POST['phone'], 'address' => $_POST['address'], 'balanace' => $_POST['balanace'], 'bill_head' => $_POST['bill_head']])) {
                    $success = "Customer updated.";
                     header("Location:{$name}");
                } else {
                    $error = "Something went wrong. or can't update this because no changes was found";
                }
            } else {
                $error = "Invalid Phone.";
            }
        } else {
            $error = "Invalid CNIC.";
        }
    } else {
        $error = "All fields must be filled.";
    }
} else if (isset($_GET['delete_customer'])) {
    if ($pdo->delete("access", $_GET['delete_customer'])) {
        $success = "Customer deleted.";
         header("Location:{$name}");
    } else {
        $error = "Something went wrong.";
    }
}
if (isset($_GET['edit_customer'])) {
    $id = $pdo->read("access", ['id' => $_GET['edit_customer'], 'company_profile_id' => $_SESSION['ovalfox_pos_cp_id']]);
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
                                <h4 class="page-title">Store Form</h4>
                            </div>
                            <div class="breadcrumb-list">
                                <ul>
                                    <li class="breadcrumb-link">
                                        <a href="index.php"><i class="fas fa-home mr-2"></i>Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-link active">Store</li>
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
                                                        <label for="name" class="col-form-label">Name</label>
                                                        <input
                                                            value="<?php echo isset($_GET['edit_customer']) ? $id[0]['name'] : null; ?>"
                                                            class="form-control" name="name" type="text"
                                                            placeholder="Enter Customer Name" id="name">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="cnic" class="col-form-label">Cnic</label>
                                                        <input
                                                            value="<?php echo isset($_GET['edit_customer']) ? $id[0]['cnic'] : null; ?>"
                                                            class="form-control" name="cnic" type="text"
                                                            placeholder="Enter Customer Cnic" id="cnic">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="phone" class="col-form-label">Phone</label>
                                                        <input
                                                            value="<?php echo isset($_GET['edit_customer']) ? $id[0]['phone'] : null; ?>"
                                                            class="form-control" name="phone" type="tel"
                                                            placeholder="Enter Customer Phone" id="phone">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="address" class="col-form-label">Address</label>
                                                        <textarea class="form-control" placeholder="Shop Details"
                                                            name="address"
                                                            id="address"><?php echo isset($_GET['edit_customer']) ? $id[0]['address'] : null; ?></textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="balanace" class="col-form-label">Balanace</label>
                                                        <input
                                                            value="<?php echo isset($_GET['edit_customer']) ? $id[0]['balanace'] : null; ?>"
                                                            class="form-control" name="balanace" type="number"
                                                            placeholder="Enter Customer Balanace" id="balanace">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="bill_head" class="col-form-label">Bill head</label>
                                                        <input
                                                            value="<?php echo isset($_GET['edit_customer']) ? $id[0]['bill_head'] : null; ?>"
                                                            class="form-control" name="bill_head" type="text"
                                                            placeholder="Enter Customer Bill Head" id="bill_head">
                                                    </div>
                                                    <table id="example1"
                                                        class="table table-striped table-bordered dt-responsive">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Name</th>
                                                                <th>CNIC</th>
                                                                <th>Phone</th>
                                                                <th>Address</th>
                                                                <th>Balanace</th>
                                                                <th>Bill head</th>

                                                                <th>Created at</th>
                                                                <th>Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            foreach ($access as $customer) {


                                                            ?>
                                                            <tr>
                                                                <td><?php echo $customer['id']; ?></td>
                                                                <td><?php echo $customer['name']; ?></td>
                                                                <td><?php echo $customer['cnic']; ?></td>
                                                                <td><?php echo $customer['phone']; ?></td>
                                                                <td><?php echo $customer['address']; ?></td>
                                                                <td><?php echo $customer['balanace']; ?></td>
                                                                <td><?php echo $customer['bill_head']; ?></td>

                                                                <td><?php echo $customer['created_at']; ?></td>
                                                                <td>
                                                                    <a class="text-success"
                                                                        href="access.php?edit_customer=<?php echo $customer['id']; ?>">
                                                                        <i class="fa fa-edit"></i>
                                                                    </a>
                                                                    &nbsp;&nbsp;&nbsp;
                                                                    <a class="text-danger"
                                                                        href="access.php?delete_customer=<?php echo $customer['id']; ?>">
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
                                                    name="<?php echo isset($_GET['edit_customer']) ? "edit_customer_btn" : "add_customer_btn"; ?>"
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