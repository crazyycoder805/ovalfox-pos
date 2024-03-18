<!DOCTYPE html>

<html lang="zxx">
<?php require_once 'assets/includes/head.php'; ?>
<?php
if (isset($_SESSION['ovalfox_pos_access_of']->c) && $_SESSION['ovalfox_pos_role_id'] == 3 && $_SESSION['ovalfox_pos_access_of']->c == 0) {
        header("location:404.php");
    
}
$success = "";
$error = "";
$id = "";

$customers = $pdo->read("customers", ['company_profile_id' => $_SESSION['ovalfox_pos_cp_id']]);



if (isset($_POST['add_customer_btn'])) {

    if (!empty($_POST['name']) && !empty($_POST['cnic']) && !empty($_POST['phone']) && !empty($_POST['address']) && !empty($_POST['balance'])  && !empty($_POST['bill_head'])) {
        if ($pdo->validateInput($_POST['cnic'], 'cnic')) {
            if ($pdo->validateInput($_POST['phone'], 'phone')) {

                if ($pdo->create("customers", ['name' => $_POST['name'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id'], 'cnic' => $_POST['cnic'], 'phone' => $_POST['phone'], 'address' => $_POST['address'], 
                'balance' => $_POST['balance'], 'bill_head' => $_POST['bill_head']], "image", ['image'], 'image_type')) {
                    $success = "Customer added.";
                    $pdo->headTo("customers.php");
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
    if (!empty($_POST['name']) && !empty($_POST['cnic']) && !empty($_POST['phone']) && !empty($_POST['address']) && !empty($_POST['balance'])  && !empty($_POST['bill_head'])) {
        if ($pdo->validateInput($_POST['cnic'], 'cnic')) {
            if ($pdo->validateInput($_POST['phone'], 'phone')) {
                if (empty($_FILES['image']['name'])) {

                    if ($pdo->update("customers", ['id' => $_GET['edit_customer']], ['name' => $_POST['name'], 'cnic' => $_POST['cnic'], 'phone' => $_POST['phone'], 'address' => $_POST['address'], 
                    'balance' => $_POST['balance'], 'bill_head' => $_POST['bill_head']])) {
                        $success = "Customer updated.";
                        $pdo->headTo("customers.php");
                    } else {
                        $error = "Something went wrong. or can't update this because no changes was found";
                    }
                } else {
                    if ($pdo->update("customers", ['id' => $_GET['edit_customer']], ['name' => $_POST['name'], 'cnic' => $_POST['cnic'], 'phone' => $_POST['phone'], 
                    'address' => $_POST['address'], 'balance' => $_POST['balance'], 'bill_head' => $_POST['bill_head']], "image", ['image'], 'image_type')) {
                        $success = "Customer updated.";
                        $pdo->headTo("customers.php");
                    } else {
                        $error = "Something went wrong. or can't update this because no changes was found";
                    }
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
    if ($pdo->delete("customers", $_GET['delete_customer'])) {
        $success = "Customer deleted.";
        $pdo->headTo("customers.php");
    } else {
        $error = "Something went wrong.";
    }
}
if (isset($_GET['edit_customer'])) {
    $id = $pdo->read("customers", ['id' => $_GET['edit_customer'], 'company_profile_id' => $_SESSION['ovalfox_pos_cp_id']]);
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

                                    <form class="separate-form" method="post" enctype="multipart/form-data">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="row">
                                                <div class="col-md">
                                                    <div class="form-group">
                                                        <label for="image" class="col-form-label">Customer image</label>
                                                        <input class="form-control" name="image" type="file" id="image">

                                                        <?php 
                                                            if (isset($_GET['edit_customer'])) {
                                                            ?>
                                                        Previous image:
                                                        <br />
                                                        <img width="100" height="100"
                                                            src="display_image.php?t=customers&i=image&it=image_type&id=<?php echo $id[0]['id']; ?>"
                                                            alt="" />
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <div class="col-md">

                                                    <div class="form-group">
                                                        <label for="name" class="col-form-label">Name</label>
                                                        <input
                                                            value="<?php echo isset($_GET['edit_customer']) ? $id[0]['name'] : null; ?>"
                                                            class="form-control" name="name" type="text"
                                                            placeholder="Enter Customer Name" id="name">
                                                    </div>
                                                </div>
                                                <div class="col-md">

                                                    <div class="form-group">
                                                        <label for="cnic" class="col-form-label">Cnic</label>
                                                        <input
                                                            value="<?php echo isset($_GET['edit_customer']) ? $id[0]['cnic'] : null; ?>"
                                                            class="form-control" name="cnic" type="text"
                                                            placeholder="Enter Customer Cnic" id="cnic">
                                                    </div>
                                                </div>
                                                <div class="col-md">

                                                    <div class="form-group">
                                                        <label for="phone" class="col-form-label">Phone</label>
                                                        <input
                                                            value="<?php echo isset($_GET['edit_customer']) ? $id[0]['phone'] : null; ?>"
                                                            class="form-control" name="phone" type="tel"
                                                            placeholder="Enter Customer Phone" id="phone">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="address" class="col-form-label">Address</label>
                                                    <textarea class="form-control" placeholder="Shop Details"
                                                        name="address"
                                                        id="address"><?php echo isset($_GET['edit_customer']) ? $id[0]['address'] : null; ?></textarea>
                                                </div>
                                                <div class="col-md">

                                                    <div class="form-group">
                                                        <label for="balance" class="col-form-label">balance</label>
                                                        <input
                                                            value="<?php echo isset($_GET['edit_customer']) ? $id[0]['balance'] : null; ?>"
                                                            class="form-control" name="balance" type="number"
                                                            placeholder="Enter Customer balance" id="balance">
                                                    </div>
                                                </div>
                                                <div class="col-md">

                                                    <div class="form-group">
                                                        <label for="bill_head" class="col-form-label">Bill head</label>
                                                        <input
                                                            value="<?php echo isset($_GET['edit_customer']) ? $id[0]['bill_head'] : null; ?>"
                                                            class="form-control" name="bill_head" type="text"
                                                            placeholder="Enter Customer Bill Head" id="bill_head">
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <button class="btn btn-primary" type="reset">reset</button>
                                                        <input
                                                            name="<?php echo isset($_GET['edit_customer']) ? "edit_customer_btn" : "add_customer_btn"; ?>"
                                                            class="btn btn-danger" type="submit">
                                                    </div>
                                                </div>

                                                <table id="example1"
                                                    class="table table-striped table-bordered dt-responsive">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Image</th>

                                                            <th>Name</th>
                                                            <th>CNIC</th>
                                                            <th>Phone</th>
                                                            <th>Address</th>
                                                            <th>Balance</th>
                                                            <th>Bill head</th>

                                                            <th>Created at</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            foreach ($customers as $customer) {


                                                            ?>
                                                        <tr>
                                                            <td><?php echo $customer['id']; ?></td>
                                                            <td><img width="100" height="50"
                                                                    src="display_image.php?t=customers&i=image&it=image_type&id=<?php echo $customer['id']; ?>"
                                                                    alt="" /></td>

                                                            <td><?php echo $customer['name']; ?></td>
                                                            <td><?php echo $customer['cnic']; ?></td>
                                                            <td><?php echo $customer['phone']; ?></td>
                                                            <td><?php echo $customer['address']; ?></td>
                                                            <td><?php echo $customer['balance']; ?></td>
                                                            <td><?php echo $customer['bill_head']; ?></td>

                                                            <td><?php echo $customer['created_at']; ?></td>
                                                            <td>
                                                                <a class="text-success"
                                                                    href="customers.php?edit_customer=<?php echo $customer['id']; ?>">
                                                                    <i class="fa fa-edit"></i>
                                                                </a>
                                                                &nbsp;&nbsp;&nbsp;
                                                                <a class="text-danger"
                                                                    href="customers.php?delete_customer=<?php echo $customer['id']; ?>">
                                                                    <i class="fa fa-trash"></i>
                                                                </a>
                                                            </td>

                                                        </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                                <div class="form-group mb-3">
                                                    <button id="printbtncustomer" class="btn btn-danger"
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
    $("#printbtncustomer").on("click", e => {
        location.href = `printreport1.php?s=${searchedValue}&t=customer`;
    });
    </script>

</body>

</html>