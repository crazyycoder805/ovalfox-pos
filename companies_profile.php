<!DOCTYPE html>

<html lang="zxx">
<?php require_once 'assets/includes/head.php'; ?>
<?php

if (isset($_SESSION['ovalfox_pos_access_of']->cp) && $_SESSION['ovalfox_pos_role_id'] == 3 && $_SESSION['ovalfox_pos_access_of']->cp == 0) {
        header("location:404.php");
    
}

$success = "";
$error = "";
$id = "";

$companies_profile = $pdo->read("companies_profile");

$image_result = '';

if (isset($_POST['add_company_btn'])) {

    if (!empty($_POST['company_name']) && !empty($_POST['registration_id']) && !empty($_POST['tax_no']) && !empty($_POST['phone1']) && !empty($_POST['phone2']) && !empty($_POST['address']) && !empty($_POST['email'])) {
        if ($pdo->validateInput($_POST['email'], 'email')) {
            if ($pdo->validateInput($_POST['phone1'], 'phone')) {
                if ($pdo->validateInput($_POST['phone2'], 'phone')) {
                    if (!empty($_FILES['image']['name'])) {
                        $image_result = $pdo2->upload('image', 'assets/ovalfox/companies_profile');
    
                        if ($image_result && $pdo->create("companies_profile", ['company_name' => $_POST['company_name'], 'registration_id' => $_POST['registration_id'], 'tax_no' => $_POST['tax_no'], 
                        'phone1' => $_POST['phone1'], 'phone2' => $_POST['phone2'], 'address' => $_POST['address'], 'email' => $_POST['email'], 'image' => $image_result['filename']])) {
                            $success = "Company added.";
                                         header("Location:{$name}");
                        } else {
                            $error = "Something went wrong.";
                        }
                    } else {
                        if ($pdo->create("companies_profile", ['company_name' => $_POST['company_name'], 'registration_id' => $_POST['registration_id'], 'tax_no' => $_POST['tax_no'], 
                        'phone1' => $_POST['phone1'], 'phone2' => $_POST['phone2'], 'address' => $_POST['address'], 'email' => $_POST['email']])) {
                            $success = "Company added.";
                                         header("Location:{$name}");
                        } else {
                            $error = "Something went wrong.";
                        }
                    }
                } else {
                    $error = "Invalid Phone2.";
                }
            } else {
                $error = "Invalid Phone1.";
            }
        } else {
            $error = "Invalid Email.";
        }
    } else {
        $error = "All fields must be filled.";
    }
} else if (isset($_POST['edit_company_btn'])) {
    if (!empty($_POST['company_name']) && !empty($_POST['registration_id']) && !empty($_POST['tax_no']) && !empty($_POST['phone1']) && !empty($_POST['phone2']) && !empty($_POST['address']) && !empty($_POST['email'])) {
        if ($pdo->validateInput($_POST['email'], 'email')) {
            if ($pdo->validateInput($_POST['phone1'], 'phone')) {
                if ($pdo->validateInput($_POST['phone2'], 'phone')) {
                    if (!empty($_FILES['image']['name'])) {
                        $image_result = $pdo2->upload('image', 'assets/ovalfox/companies_profile');
        
                        if ($image_result && $pdo->update("companies_profile", ['id' => $_GET['edit_company']], ['company_name' => $_POST['company_name'], 'registration_id' => $_POST['registration_id'], 
                        'tax_no' => $_POST['tax_no'], 'phone1' => $_POST['phone1'], 'phone2' => $_POST['phone2'], 'address' => $_POST['address'], 'email' => $_POST['email'], 
                        'image' => $image_result['filename']])) {
                            $success = "Company updated.";
                                         header("Location:{$name}");
                        } else {
                            $error = "Something went wrong. or can't update this because no changes was found";
                        }
                    } else {
                        if ($pdo->update("companies_profile", ['id' => $_GET['edit_company']], ['company_name' => $_POST['company_name'], 'registration_id' => $_POST['registration_id'], 
                        'tax_no' => $_POST['tax_no'], 'phone1' => $_POST['phone1'], 'phone2' => $_POST['phone2'], 'address' => $_POST['address'], 'email' => $_POST['email']])) {
                            $success = "Company updated.";
                                         header("Location:{$name}");
                        } else {
                            $error = "Something went wrong. or can't update this because no changes was found";
                        }
                    }
                } else {
                    $error = "Invalid Phone2.";
                }
            } else {
                $error = "Invalid Phone1.";
            }
        } else {
            $error = "Invalid Email.";
        }
    } else {
        $error = "All fields must be filled.";
    }
} else if (isset($_GET['delete_company'])) {
    if ($pdo->delete("companies_profile", $_GET['delete_company'])) {
        $success = "Company deleted.";
                     header("Location:{$name}");
    } else {
        $error = "Something went wrong.";
    }
}


if (isset($_GET['edit_company'])) {
    $id = $pdo->read("companies_profile", ['id' => $_GET['edit_company']]);
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
                                <h4 class="page-title">Company Form</h4>
                            </div>
                            <div class="breadcrumb-list">
                                <ul>
                                    <li class="breadcrumb-link">
                                        <a href="index.php"><i class="fas fa-home mr-2"></i>Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-link active">Company</li>
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
                                                        <label for="image" class="col-form-label">Company profile image</label>
                                                        <input class="form-control" name="image" type="file" id="image">

                                                        <?php 
                                                            if (isset($_GET['edit_company'])) {
                                                            ?>
                                                        Previous image:
                                                        <br />
                                                        <img width="100" height="100"
                                                            src="assets/ovalfox/companies_profile/<?php echo $id[0]['image']; ?>"
                                                            alt="" />
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <div class="col-md">

                                                    <div class="form-group">
                                                        <label for="company_name" class="col-form-label">Company
                                                            name</label>
                                                        <input
                                                            value="<?php echo isset($_GET['edit_company']) ? $id[0]['company_name'] : null; ?>"
                                                            class="form-control" name="company_name" type="text"
                                                            placeholder="Enter company name" id="company_name">
                                                    </div>
                                                </div>
                                                <div class="col-md">

                                                    <div class="form-group">
                                                        <label for="registration_id" class="col-form-label">Registration
                                                            id</label>
                                                        <input
                                                            value="<?php echo isset($_GET['edit_company']) ? $id[0]['registration_id'] : null; ?>"
                                                            class="form-control" name="registration_id" type="text"
                                                            placeholder="Enter company Registration ID"
                                                            id="registration_id">
                                                    </div>
                                                </div>
                                                <div class="col-md">

                                                    <div class="form-group">
                                                        <label for="tax_no" class="col-form-label">Tax no</label>
                                                        <input
                                                            value="<?php echo isset($_GET['edit_company']) ? $id[0]['tax_no'] : null; ?>"
                                                            class="form-control" name="tax_no" type="text"
                                                            placeholder="Enter Company Tax No" id="tax_no">
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md">

                                                        <div class="form-group">
                                                            <label for="phone1" class="col-form-label">Phone 1</label>
                                                            <input
                                                                value="<?php echo isset($_GET['edit_company']) ? $id[0]['phone1'] : null; ?>"
                                                                class="form-control" name="phone1" type="tel"
                                                                placeholder="Enter Company Phone 1" id="phone1">
                                                        </div>
                                                    </div>
                                                    <div class="col-md">

                                                        <div class="form-group">
                                                            <label for="phone2" class="col-form-label">Phone 2</label>
                                                            <input
                                                                value="<?php echo isset($_GET['edit_company']) ? $id[0]['phone2'] : null; ?>"
                                                                class="form-control" name="phone2" type="tel"
                                                                placeholder="Enter Company Phone 1" id="phone2">
                                                        </div>
                                                    </div>

                                                    <div class="col-md">
                                                        <div class="form-group">
                                                            <label for="email" class="col-form-label">Email</label>
                                                            <input
                                                                value="<?php echo isset($_GET['edit_company']) ? $id[0]['email'] : null; ?>"
                                                                class="form-control" name="email" type="email"
                                                                placeholder="Enter Company Email" id="email">
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="row">
                                                    <div class="col-md">
                                                        <div class="form-group">
                                                            <label for="address" class="col-form-label">Address</label>
                                                            <textarea class="form-control" placeholder="Address"
                                                                name="address"
                                                                id="address"><?php echo isset($_GET['edit_company']) ? $id[0]['address'] : null; ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <button class="btn btn-primary" type="reset">reset</button>
                                                        <input
                                                            name="<?php echo isset($_GET['edit_company']) ? "edit_company_btn" : "add_company_btn"; ?>"
                                                            class="btn btn-danger" type="submit">
                                                    </div>
                                                </div>


                                                <table id="example1"
                                                    class="table table-striped table-bordered dt-responsive">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Image</th>

                                                            <th>Company name</th>
                                                            <th>Registration ID</th>
                                                            <th>Tax no</th>
                                                            <th>Phone 1</th>
                                                            <th>Phone 2</th>
                                                            <th>Address</th>
                                                            <th>Email</th>

                                                            <th>Created at</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            foreach ($companies_profile as $company) {


                                                            ?>
                                                        <tr>
                                                            <td><?php echo $company['id']; ?></td>
                                                            <td><img width="100" height="50"
                                                                    src="assets/ovalfox/companies_profile/<?php echo $company['image']; ?>"
                                                                    alt="" /></td>
                                                            <td><?php echo $company['company_name']; ?></td>
                                                            <td><?php echo $company['registration_id']; ?></td>
                                                            <td><?php echo $company['tax_no']; ?></td>
                                                            <td><?php echo $company['phone1']; ?></td>
                                                            <td><?php echo $company['phone2']; ?></td>
                                                            <td><?php echo $company['address']; ?></td>
                                                            <td><?php echo $company['email']; ?></td>

                                                            <td><?php echo $company['created_at']; ?></td>
                                                            <td>
                                                                <a class="text-success"
                                                                    href="companies_profile.php?edit_company=<?php echo $company['id']; ?>">
                                                                    <i class="fa fa-edit"></i>
                                                                </a>
                                                                &nbsp;&nbsp;&nbsp;
                                                                <a class="text-danger"
                                                                    href="companies_profile.php?delete_company=<?php echo $company['id']; ?>">
                                                                    <i class="fa fa-trash"></i>
                                                                </a>
                                                            </td>

                                                        </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
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