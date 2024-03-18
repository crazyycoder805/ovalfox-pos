<!DOCTYPE html>

<html lang="zxx">
<?php require_once 'assets/includes/head.php'; ?>
<?php

if (isset($_SESSION['ovalfox_pos_access_of']->ss) && $_SESSION['ovalfox_pos_role_id'] == 3 && $_SESSION['ovalfox_pos_access_of']->ss == 0) {
        header("location:404.php");
    
}

$success = "";
$error = "";
$id = "";

$suppliers = $pdo->read("suppliers", ['company_profile_id' => $_SESSION['ovalfox_pos_cp_id']]);



if (isset($_POST['add_supplier_btn'])) {

    if (!empty($_POST['name']) && !empty($_POST['dist_name']) && !empty($_POST['cnic']) && !empty($_POST['mobile']) && !empty($_POST['office']) && !empty($_POST['address']) && !empty($_POST['dist_address'])  && !empty($_POST['balanace'])  && !empty($_POST['bill_head'])) {
        if ($pdo->validateInput($_POST['cnic'], 'cnic')) {
            if ($pdo->validateInput($_POST['mobile'], 'phone')) {

                if ($pdo->create("suppliers", ['name' => $_POST['name'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id'], 'dist_name' => $_POST['dist_name'], 'cnic' => $_POST['cnic'], 'mobile' => $_POST['mobile'], 
                'office' => $_POST['office'], 'address' => $_POST['address'], 'dist_address' => $_POST['dist_address'], 'balanace' => $_POST['balanace'], 'bill_head' => $_POST['bill_head']], 
                "image", ['image'], ['image_type'])) {
                    $success = "Supplier added.";
                    $pdo->headTo("suppliers.php");
                } else {
                    $error = "Something went wrong.";
                }
            } else {
                $error = "Invalid Mobile.";
            }
        } else {
            $error = "Invalid CNIC.";
        }
    } else {
        $error = "All fields must be filled.";
    }
} else if (isset($_POST['edit_supplier_btn'])) {
    if (!empty($_POST['name']) && !empty($_POST['dist_name']) && !empty($_POST['cnic']) && !empty($_POST['mobile']) && !empty($_POST['office']) && !empty($_POST['address']) && !empty($_POST['dist_address'])  && !empty($_POST['balanace'])  && !empty($_POST['bill_head'])) {
        if ($pdo->validateInput($_POST['cnic'], 'cnic')) {
            if ($pdo->validateInput($_POST['mobile'], 'phone')) {
                if (empty($_FILES['image']['name'])) {

                    if ($pdo->update("suppliers", ['id' => $_GET['edit_supplier']], ['name' => $_POST['name'], 'dist_name' => $_POST['dist_name'], 'cnic' => $_POST['cnic'], 'mobile' => $_POST['mobile'], 'office' => $_POST['office'], 'address' => $_POST['address'], 'dist_address' => $_POST['dist_address'], 'balanace' => $_POST['balanace'], 'bill_head' => $_POST['bill_head']])) {
                        $success = "Supplier updated.";
                        $pdo->headTo("suppliers.php");
                    } else {
                        $error = "Something went wrong. or can't update this because no changes was found";
                    }
                } else {
                    
                    if ($pdo->update("suppliers", ['id' => $_GET['edit_supplier']], ['name' => $_POST['name'], 'dist_name' => $_POST['dist_name'], 'cnic' => $_POST['cnic'], 
                    'mobile' => $_POST['mobile'], 'office' => $_POST['office'], 'address' => $_POST['address'], 'dist_address' => $_POST['dist_address'], 'balanace' => $_POST['balanace'], 
                    'bill_head' => $_POST['bill_head']], "image", ['image'], ['image_type'])) {
                        $success = "Supplier updated.";
                        $pdo->headTo("suppliers.php");
                    } else {
                        $error = "Something went wrong. or can't update this because no changes was found";
                    }
                }
            } else {
                $error = "Invalid Mobile.";
            }
        } else {
            $error = "Invalid CNIC.";
        }
    } else {
        $error = "All fields must be filled.";
    }
} else if (isset($_GET['delete_supplier'])) {
    if ($pdo->delete("suppliers", $_GET['delete_supplier'])) {
        $success = "Supplier deleted.";
        $pdo->headTo("suppliers.php");
    } else {
        $error = "Something went wrong.";
    }
}
if (isset($_GET['edit_supplier'])) {
    $id = $pdo->read("suppliers", ['id' => $_GET['edit_supplier'], 'company_profile_id' => $_SESSION['ovalfox_pos_cp_id']]);
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
                                <h4 class="page-title">Supplier Form</h4>
                            </div>
                            <div class="breadcrumb-list">
                                <ul>
                                    <li class="breadcrumb-link">
                                        <a href="index.php"><i class="fas fa-home mr-2"></i>Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-link active">Supplier</li>
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

                                    <form enctype="multipart/form-data" class="separate-form" method="post">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="row">
                                                <div class="col-md">
                                                    <div class="form-group">
                                                        <label for="image" class="col-form-label">Supplier
                                                            image</label>
                                                        <input class="form-control" name="image" type="file" id="image">

                                                        <?php 
                                                            if (isset($_GET['edit_supplier'])) {
                                                            ?>
                                                        Previous image:
                                                        <br />
                                                        <img width="100" height="100"
                                                            src="display_image.php?t=suppliers&i=image&it=image_type&id=<?php echo $id[0]['id']; ?>"
                                                            alt="" />
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <div class="col-md">

                                                    <div class="form-group">
                                                        <label for="name" class="col-form-label">Name</label>
                                                        <input
                                                            value="<?php echo isset($_GET['edit_supplier']) ? $id[0]['name'] : null; ?>"
                                                            class="form-control" name="name" type="text"
                                                            placeholder="Enter supplier Name" id="name">
                                                    </div>
                                                </div>
                                                <div class="col-md">

                                                    <div class="form-group">
                                                        <label for="dist_name" class="col-form-label">Dist name</label>
                                                        <input
                                                            value="<?php echo isset($_GET['edit_supplier']) ? $id[0]['dist_name'] : null; ?>"
                                                            class="form-control" name="dist_name" type="text"
                                                            placeholder="Enter Supplier Dist Name" id="dist_name">
                                                    </div>
                                                </div>
                                                <div class="col-md">

                                                    <div class="form-group">
                                                        <label for="cnic" class="col-form-label">Cnic</label>
                                                        <input
                                                            value="<?php echo isset($_GET['edit_supplier']) ? $id[0]['cnic'] : null; ?>"
                                                            class="form-control" name="cnic" type="text"
                                                            placeholder="Enter Supplier Cnic" id="cnic">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md">

                                                    <div class="form-group">
                                                        <label for="mobile" class="col-form-label">Mobile</label>
                                                        <input
                                                            value="<?php echo isset($_GET['edit_supplier']) ? $id[0]['mobile'] : null; ?>"
                                                            class="form-control" name="mobile" type="tel"
                                                            placeholder="Enter Supplier Mobile" id="mobile">
                                                    </div>
                                                </div>
                                                <div class="col-md">

                                                    <div class="form-group">
                                                        <label for="office" class="col-form-label">Office</label>
                                                        <input
                                                            value="<?php echo isset($_GET['edit_supplier']) ? $id[0]['office'] : null; ?>"
                                                            class="form-control" name="office" type="text"
                                                            placeholder="Enter Supplier Office" id="office">
                                                    </div>
                                                </div>

                                                <div class="col-md">

                                                    <div class="form-group">
                                                        <label for="balanace" class="col-form-label">Balanace</label>
                                                        <input
                                                            value="<?php echo isset($_GET['edit_supplier']) ? $id[0]['balanace'] : null; ?>"
                                                            class="form-control" name="balanace" type="number"
                                                            placeholder="Enter supplier Balanace" id="balanace">
                                                    </div>
                                                </div>
                                                <div class="col-md">

                                                    <div class="form-group">
                                                        <label for="bill_head" class="col-form-label">Bill head</label>
                                                        <input
                                                            value="<?php echo isset($_GET['edit_supplier']) ? $id[0]['bill_head'] : null; ?>"
                                                            class="form-control" name="bill_head" type="text"
                                                            placeholder="Enter supplier Bill Head" id="bill_head">
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="row">
                                                <div class="col-md">

                                                    <div class="form-group">
                                                        <label for="address" class="col-form-label">Address</label>
                                                        <textarea class="form-control" placeholder="Address"
                                                            name="address"
                                                            id="address"><?php echo isset($_GET['edit_supplier']) ? $id[0]['address'] : null; ?></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md">

                                                    <div class="form-group">
                                                        <label for="dist_address" class="col-form-label">Dist
                                                            address</label>
                                                        <textarea class="form-control" placeholder="dist_address"
                                                            name="dist_address"
                                                            id="dist_address"><?php echo isset($_GET['edit_supplier']) ? $id[0]['dist_address'] : null; ?></textarea>
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <button class="btn btn-primary" type="reset">reset</button>
                                                        <input
                                                            name="<?php echo isset($_GET['edit_supplier']) ? "edit_supplier_btn" : "add_supplier_btn"; ?>"
                                                            class="btn btn-danger" type="submit">
                                                    </div>
                                                </div>
                                            </div>
                                            <table id="example1"
                                                class="table table-striped table-bordered dt-responsive">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Name</th>
                                                        <th>Image</th>

                                                        <th>Dist name</th>

                                                        <th>CNIC</th>
                                                        <th>Mobile</th>
                                                        <th>Office</th>

                                                        <th>Address</th>
                                                        <th>Dist address</th>

                                                        <th>Balanace</th>
                                                        <th>Bill head</th>

                                                        <th>Created at</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                            foreach ($suppliers as $supplier) {


                                                            ?>
                                                    <tr>
                                                        <td><?php echo $supplier['id']; ?></td>
                                                        <td><?php echo $supplier['name']; ?></td>
                                                        <td><img width="100" height="50"
                                                                src="display_image.php?t=suppliers&i=image&it=image_type&id=<?php echo $supplier['id']; ?>"
                                                                alt="" /></td>
                                                        <td><?php echo $supplier['dist_name']; ?></td>

                                                        <td><?php echo $supplier['cnic']; ?></td>
                                                        <td><?php echo $supplier['mobile']; ?></td>
                                                        <td><?php echo $supplier['office']; ?></td>

                                                        <td><?php echo $supplier['address']; ?></td>
                                                        <td><?php echo $supplier['dist_address']; ?></td>

                                                        <td><?php echo $supplier['balanace']; ?></td>
                                                        <td><?php echo $supplier['bill_head']; ?></td>

                                                        <td><?php echo $supplier['created_at']; ?></td>
                                                        <td>
                                                            <a class="text-success"
                                                                href="suppliers.php?edit_supplier=<?php echo $supplier['id']; ?>">
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                            &nbsp;&nbsp;&nbsp;
                                                            <a class="text-danger"
                                                                href="suppliers.php?delete_supplier=<?php echo $supplier['id']; ?>">
                                                                <i class="fa fa-trash"></i>
                                                            </a>
                                                        </td>

                                                    </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                            <div class="form-group mb-3">
                                                <button id="printbtnsupplier" class="btn btn-danger" type="button"><i
                                                        class="fa fa-print"></i> Print</button>

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
    $("#printbtnsupplier").on("click", e => {
        location.href = `printreport1.php?s=${searchedValue}&t=supplier`;
    });
    </script>

</body>

</html>