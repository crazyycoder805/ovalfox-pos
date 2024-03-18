<!DOCTYPE html>

<html lang="zxx">
<?php require_once 'assets/includes/head.php'; ?>
<?php

if (isset($_SESSION['access_of']->ds) && $_SESSION['role_id'] == 3 && $_SESSION['access_of']->ds == 0) {
        header("location:404.php");
    
}

$success = "";
$error = "";
$id = "";

$designations = $pdo->read("designations", ['company_profile_id' => $_SESSION['cp_id']]);



if (isset($_POST['add_designation_btn'])) {
    if (!empty($_POST['name'])) {
        if (!$pdo->isDataInserted("designations", ['name' => $_POST['name']])) {
            if ($pdo->create("designations", ['name' => $_POST['name'], 'company_profile_id'=>$_SESSION['cp_id']])) {
                $success = "Designation added.";
                $pdo->headTo("designations.php");
            } else {
                $error = "Something went wrong.";
            }
        } else {
            $error = "Designation already added.";
        }
    } else {
        $error = "Designation must be filled.";
    }
} else if (isset($_POST['edit_designation_btn'])) {
    if (!empty($_POST['name'])) {
        if (!$pdo->isDataInsertedUpdate("designations", ['name' => $_POST['name']])) {
            if ($pdo->update("designations", ['id' => $_GET['edit_designation']], ['name' => $_POST['name']])) {
                $success = "Designation updated.";
                $pdo->headTo("designations.php");
            } else {
                $error = "Something went wrong. or can't update this because no changes was found";
            }
        } else {
            $error = "Designation already added.";
        }
    } else {
        $error = "Designation must be filled.";
    }
} else if (isset($_GET['delete_designation'])) {
    if ($pdo->delete("designations", $_GET['delete_designation'])) {
        $success = "Designation deleted.";
        $pdo->headTo("designations.php");
    } else {
        $error = "Something went wrong.";
    }
}
if (isset($_GET['edit_designation'])) {
    $id = $pdo->read("designations", ['id' => $_GET['edit_designation'], 'company_profile_id' => $_SESSION['cp_id']]);
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
                                <h4 class="page-title">Designation Form</h4>
                            </div>
                            <div class="breadcrumb-list">
                                <ul>
                                    <li class="breadcrumb-link">
                                        <a href="index.php"><i class="fas fa-home mr-2"></i>Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-link active">Designation</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- From Start -->
                <div class="from-wrapper">
                    <div class="row">

                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">

                                <div class="card-body">

                                    <form class="separate-form" method="post">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="row">
                                                <div class="col-md">
                                                    <div class="form-group">
                                                        <label for="name" class="col-form-label">Designation</label>
                                                        <input
                                                            value="<?php echo isset($_GET['edit_designation']) ? $id[0]['name'] : null; ?>"
                                                            class="form-control" name="name" type="text"
                                                            placeholder="Enter Designation" id="name">
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <button class="btn btn-primary" type="reset">reset</button>
                                                        <input
                                                            name="<?php echo isset($_GET['edit_designation']) ? "edit_designation_btn" : "add_designation_btn"; ?>"
                                                            class="btn btn-danger" type="submit">
                                                    </div>
                                                    <table id="example1"
                                                        class="table table-striped table-bordered dt-responsive">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Designation</th>
                                                                <th>Created at</th>
                                                                <th>Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            foreach ($designations as $designation) {


                                                            ?>
                                                            <tr>
                                                                <td><?php echo $designation['id']; ?></td>
                                                                <td><?php echo $designation['name']; ?></td>
                                                                <td><?php echo $designation['created_at']; ?></td>
                                                                <td>
                                                                    <a class="text-success"
                                                                        href="designations.php?edit_designation=<?php echo $designation['id']; ?>">
                                                                        <i class="fa fa-edit"></i>
                                                                    </a>
                                                                    &nbsp;&nbsp;&nbsp;
                                                                    <a class="text-danger"
                                                                        href="designations.php?delete_designation=<?php echo $designation['id']; ?>">
                                                                        <i class="fa fa-trash"></i>
                                                                    </a>
                                                                </td>

                                                            </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                    <div class="form-group mb-3">
                                                        <button id="printbtndesignation" class="btn btn-danger"
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
    $("#printbtndesignation").on("click", e => {
        location.href = `printreport1.php?s=${searchedValue}&t=designation`;
    });
    </script>
</body>

</html>