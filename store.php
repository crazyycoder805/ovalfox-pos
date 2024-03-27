<!DOCTYPE html>

<html lang="zxx">
<?php require_once 'assets/includes/head.php'; ?>
<?php
  if (isset($_SESSION['ovalfox_pos_access_of']->st) && $_SESSION['ovalfox_pos_role_id'] == 3 && $_SESSION['ovalfox_pos_access_of']->st == 0) {
        header("location:404.php");
    
}
$success = "";
$error = "";
$id = "";

$stores = $pdo->read("stores", ['company_profile_id' => $_SESSION['ovalfox_pos_cp_id']]);


if (isset($_POST['add_store_btn'])) {
    if (!empty($_POST['store_name'])) {
        if (!$pdo->isDataInserted("stores", ['store_name' => $_POST['store_name']])) {
            if ($pdo->create("stores", ['store_name' => $_POST['store_name'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id'], 'store_details' => empty($_POST['store_details']) ? "" : $_POST['store_details']])) {
                $success = "Store added.";
                                      header("Location:{$name}");

            } else {
                $error = "Something went wrong.";
            }
        } else {
            $error = "Store name already added.";
        }
    } else {
        $error = "Store name must be filled.";
    }
} else if (isset($_POST['edit_store_btn'])) {
    if (!empty($_POST['store_name'])) {
        if (!$pdo->isDataInsertedUpdate("stores", ['store_name' => $_POST['store_name']])) {
            if ($pdo->update("stores", ['id' => $_GET['edit_store']], ['store_name' => $_POST['store_name'], 'store_details' => empty($_POST['store_details']) ? null : $_POST['store_details']])) {
                $success = "Store updated.";
                                      header("Location:{$name}");

            } else {
                $error = "Something went wrong. or can't update this because no changes was found";
            }
        } else {
            $error = "Store name already added.";
        }
    } else {
        $error = "Store name must be filled.";
    }
} else if (isset($_GET['delete_store'])) {
    if ($pdo->delete("stores", $_GET['delete_store'])) {
        $success = "Store deleted.";
                              header("Location:{$name}");

    } else {
        $error = "Something went wrong.";
    }
}
if (isset($_GET['edit_store'])) {
    $id = $pdo->read("stores", ['id' => $_GET['edit_store'], 'company_profile_id' => $_SESSION['ovalfox_pos_cp_id']]);
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

                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">

                                <div class="card-body">

                                    <form class="separate-form" method="post">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="row">
                                                <div class="col-md">
                                                    <div class="form-group">
                                                        <label for="store_name" class="col-form-label">Store</label>
                                                        <input
                                                            value="<?php echo isset($_GET['edit_store']) ? $id[0]['store_name'] : null; ?>"
                                                            class="form-control" name="store_name" type="text"
                                                            placeholder="Enter Store Name" id="store_name">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="store_details" class="col-form-label">Shop Details
                                                            (Optional)</label>
                                                        <textarea class="form-control" placeholder="Shop Details"
                                                            name="store_details"
                                                            id="store_details"><?php echo isset($_GET['edit_store']) ? $id[0]['store_details'] : null; ?></textarea>
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <button class="btn btn-primary" type="reset">reset</button>
                                                        <input
                                                            name="<?php echo isset($_GET['edit_store']) ? "edit_store_btn" : "add_store_btn"; ?>"
                                                            class="btn btn-danger" type="submit">
                                                    </div>
                                                    <table id="example1"
                                                        class="table table-striped table-bordered dt-responsive">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Store name</th>
                                                                <th>Store details</th>

                                                                <th>Created at</th>
                                                                <th>Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            foreach ($stores as $store) {


                                                            ?>
                                                            <tr>
                                                                <td><?php echo $store['id']; ?></td>
                                                                <td><?php echo $store['store_name']; ?></td>
                                                                <td><?php echo $store['store_details']; ?></td>

                                                                <td><?php echo $store['created_at']; ?></td>
                                                                <td>
                                                                    <a class="text-success"
                                                                        href="store.php?edit_store=<?php echo $store['id']; ?>">
                                                                        <i class="fa fa-edit"></i>
                                                                    </a>
                                                                    &nbsp;&nbsp;&nbsp;
                                                                    <a class="text-danger"
                                                                        href="store.php?delete_store=<?php echo $store['id']; ?>">
                                                                        <i class="fa fa-trash"></i>
                                                                    </a>
                                                                </td>

                                                            </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                    <div class="form-group mb-3">
                                                        <button id="printbtnstore" class="btn btn-danger"
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

    $(document).on("", "input", e => {
        searchedValue = e.target.value;
    })
    $("#printbtnstore").on("click", e => {
        location.href = `printreport1.php?s=${searchedValue}&t=store`;
    });
    </script>

</body>

</html>