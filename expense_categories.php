<!DOCTYPE html>

<html lang="zxx">
<?php require_once 'assets/includes/head.php'; ?>
<?php

if (isset($_SESSION['access_of']->ec) && $_SESSION['role_id'] == 3 && $_SESSION['access_of']->ec == 0) {
        header("location:404.php");
    
}

$success = "";
$error = "";
$id = "";

$expense_categories = $pdo->read("expense_categories", ['company_profile_id' => $_SESSION['cp_id']]);



if (isset($_POST['add_expense_category_btn'])) {
    if (!empty($_POST['name'])) {
        if (!$pdo->isDataInserted("expense_categories", ['name' => $_POST['name']])) {
            if ($pdo->create("expense_categories", ['name' => $_POST['name'], 'company_profile_id'=>$_SESSION['cp_id']], "image", ['image'], ['image_type'])) {
                $success = "Expense category added.";
                $pdo->headTo("expense_categories.php");
            } else {
                $error = "Something went wrong.";
            }
        } else {
            $error = "Expense category already added.";
        }
    } else {
        $error = "Expense category must be filled.";
    }
} else if (isset($_POST['edit_expense_category_btn'])) {
    if (!empty($_POST['name'])) {
        if (!$pdo->isDataInsertedUpdate("expense_categories", ['name' => $_POST['name']])) {
            if (empty($_FILES['image']['name'])) {

                if ($pdo->update("expense_categories", ['id' => $_GET['edit_expense_category']], ['name' => $_POST['name']])) {
                    $success = "Expense category updated.";
                    $pdo->headTo("expense_categories.php");
                } else {
                    $error = "Something went wrong. or can't update this because no changes was found";
                }
            } else {
                if ($pdo->update("expense_categories", ['id' => $_GET['edit_expense_category']], ['name' => $_POST['name']], "image", ['image'], ['image_type'])) {
                    $success = "Expense category updated.";
                    $pdo->headTo("expense_categories.php");
                } else {
                    $error = "Something went wrong. or can't update this because no changes was found";
                }
            }
        } else {
            $error = "Expense category already added.";
        }
    } else {
        $error = "Expense category must be filled.";
    }
} else if (isset($_GET['delete_expense_category'])) {
    if ($pdo->delete("expense_categories", $_GET['delete_expense_category'])) {
        $success = "Expense category deleted.";
        $pdo->headTo("expense_categories.php");
    } else {
        $error = "Something went wrong.";
    }
}
if (isset($_GET['edit_expense_category'])) {
    $id = $pdo->read("expense_categories", ['id' => $_GET['edit_expense_category'], 'company_profile_id' => $_SESSION['cp_id']]);
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
                                <h4 class="page-title">Expense Category Form</h4>
                            </div>
                            <div class="breadcrumb-list">
                                <ul>
                                    <li class="breadcrumb-link">
                                        <a href="index.php"><i class="fas fa-home mr-2"></i>Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-link active">Expense Category</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- From Start -->
                <div class="from-wrapper">
                    <div class="row">

                        <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">

                                <div class="card-body">

                                    <form class="separate-form" enctype="multipart/form-data" method="post">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="row">
                                                <div class="col-md">
                                                    <div class="form-group">
                                                        <label for="image" class="col-form-label">Sub category
                                                            image</label>
                                                        <input class="form-control" name="image" type="file" id="image">

                                                        <?php 
                                                            if (isset($_GET['edit_expense_category'])) {
                                                            ?>
                                                        Previous image:
                                                        <br />
                                                        <img width="100" height="100"
                                                            src="display_image.php?t=products&i=image&it=image_type&id=<?php echo $id[0]['id']; ?>"
                                                            alt="" />
                                                        <?php } ?>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="name" class="col-form-label">Expense
                                                            category</label>
                                                        <input
                                                            value="<?php echo isset($_GET['edit_expense_category']) ? $id[0]['name'] : null; ?>"
                                                            class="form-control" name="name" type="text"
                                                            placeholder="Enter Expense Category" id="name">
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <button class="btn btn-primary" type="reset">reset</button>
                                                        <input
                                                            name="<?php echo isset($_GET['edit_expense_category']) ? "edit_expense_category_btn" : "add_expense_category_btn"; ?>"
                                                            class="btn btn-danger" type="submit">
                                                    </div>
                                                    <table id="example1"
                                                        class="table table-striped table-bordered dt-responsive">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Image</th>
                                                                <th>Expense category</th>
                                                                <th>Created at</th>
                                                                <th>Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            foreach ($expense_categories as $expense_category) {


                                                            ?>
                                                            <tr>
                                                                <td><?php echo $expense_category['id']; ?></td>
                                                                <td><img width="100" height="50"
                                                                        src="display_image.php?t=expense_categories&i=image&it=image_type&id=<?php echo $expense_category['id']; ?>"
                                                                        alt="" /></td>
                                                                <td><?php echo $expense_category['name']; ?></td>
                                                                <td><?php echo $expense_category['created_at']; ?></td>
                                                                <td>
                                                                    <a class="text-success"
                                                                        href="expense_categories.php?edit_expense_category=<?php echo $expense_category['id']; ?>">
                                                                        <i class="fa fa-edit"></i>
                                                                    </a>
                                                                    &nbsp;&nbsp;&nbsp;
                                                                    <a class="text-danger"
                                                                        href="expense_categories.php?delete_expense_category=<?php echo $expense_category['id']; ?>">
                                                                        <i class="fa fa-trash"></i>
                                                                    </a>
                                                                </td>

                                                            </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                    <div class="form-group mb-3">
                                                        <button id="printbtnexpensecategory" class="btn btn-danger"
                                                            type="button"><i class="fa fa-print"></i> Print</button>

                                                    </div>
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
    $("#printbtnexpensecategory").on("click", e => {
        location.href = `printreport1.php?s=${searchedValue}&t=expensecategory`;
    });
    </script>

</body>

</html>