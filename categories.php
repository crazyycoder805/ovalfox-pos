<!DOCTYPE html>

<html lang="zxx">
<?php require_once 'assets/includes/head.php'; ?>
<?php

if (isset($_SESSION['access_of']->pc) && $_SESSION['role_id'] == 3 && $_SESSION['access_of']->pc == 0) {
        header("location:404.php");
    
}

$success = "";
$error = "";
$id = "";

$categories = $pdo->read("categories", ['company_profile_id' => $_SESSION['cp_id']]);
$sub_categories = $pdo->read("sub_categories", ['company_profile_id' => $_SESSION['cp_id']]);



if (isset($_POST['add_category_btn'])) {
    if (!empty($_POST['category'])) {
        if (!$pdo->isDataInserted("categories", ['category' => $_POST['category']])) {
            if ($pdo->create("categories", ['category' => $_POST['category'], 'company_profile_id'=>$_SESSION['cp_id']], "image", ['image'], ['image_type'])) {
                $success = "Category added.";
                $pdo->headTo("categories.php");
            } else {
                $error = "Something went wrong.";
            }
        } else {
            $error = "Category already added.";
        }
    } else {
        $error = "Category name must be filled.";
    }
} else if (isset($_POST['edit_category_btn'])) {
    if (!empty($_POST['category'])) {
        if (!$pdo->isDataInsertedUpdate("categories", ['category' => $_POST['category']])) {
            if (empty($_FILES['image']['name'])) {
                if ($pdo->update("categories", ['id' => $_GET['edit_category']], ['category' => $_POST['category']])) {
                    $success = "Category updated.";
                    $pdo->headTo("categories.php");
                } else {
                    $error = "Something went wrong. or can't update this because no changes was found";
                }
            } else {
                if ($pdo->update("categories", ['id' => $_GET['edit_category']], ['category' => $_POST['category']], "image", ['image'], ['image_type'])) {
                    $success = "Category updated.";
                    $pdo->headTo("categories.php");
                } else {
                    $error = "Something went wrong. or can't update this because no changes was found";
                }
                
            }
        } else {
            $error = "Category already added.";
        }
    } else {
        $error = "Category name must be filled.";
    }
} else if (isset($_GET['delete_category'])) {
    if ($pdo->delete("categories", $_GET['delete_category'])) {
        $success = "Category deleted.";
        $pdo->headTo("categories.php");
    } else {
        $error = "Something went wrong.";
    }
} else if (isset($_POST['add_sub_category_btn'])) {
    if (!empty($_POST['sub_category'])) {
        if (!empty($_POST['category_id'])) {

            if (!$pdo->isDataInserted("sub_categories", ['sub_category' => $_POST['sub_category'], 'category_id' => $_POST['category_id']])) {
                if ($pdo->create("sub_categories", ['sub_category' => $_POST['sub_category'], 'company_profile_id'=>$_SESSION['cp_id'], 'category_id' => $_POST['category_id']], "image", ['image'], ['image_type'])) {
                    $success = "Sub category added.";
                    $pdo->headTo("categories.php");
                } else {
                    $error = "Something went wrong.";
                }
            } else {
                $error = "Sub category already added.";
            }
        } else {
            $error = "Category id name must be filled.";
        }
    } else {
        $error = "Sub category name must be filled.";
    }
} else if (isset($_POST['edit_sub_category_btn'])) {
    if (!empty($_POST['sub_category'])) {
        if (!empty($_POST['category_id'])) {

            if (!$pdo->isDataInsertedUpdate("sub_categories", ['sub_category' => $_POST['sub_category'], 'category_id' => $_POST['category_id']])) {
                if (empty($_FILES['image']['name'])) {
                    if ($pdo->update("sub_categories", ['id'=>$_GET['edit_sub_category']], ['sub_category' => $_POST['sub_category'], 'category_id' => $_POST['category_id']])) {
                        $success = "Sub category updated.";
                        $pdo->headTo("categories.php");
                    } else {
                        $error = "Something went wrong. or can't update this because no changes was found.";
                    }
                } else {
                    if ($pdo->update("sub_categories", ['id'=>$_GET['edit_sub_category']], ['sub_category' => $_POST['sub_category'], 'category_id' => $_POST['category_id']], "image", ['image'], ['image_type'])) {
                        $success = "Sub category updated.";
                        $pdo->headTo("categories.php");
                    } else {
                        $error = "Something went wrong. or can't update this because no changes was found.";
                    }
                }
            } else {
                $error = "Sub category already added.";
            }
        } else {
            $error = "Category id name must be filled.";
        }
    } else {
        $error = "Sub category name must be filled.";
    }
} else if (isset($_GET['delete_sub_category'])) {
    if ($pdo->delete("sub_categories", $_GET['delete_sub_category'])) {
        $success = "Sub category deleted.";
        $pdo->headTo("categories.php");
    } else {
        $error = "Something went wrong.";
    }
}

if (isset($_GET['edit_category'])) {
    $id = $pdo->read("categories", ['id' => $_GET['edit_category'], 'company_profile_id' => $_SESSION['cp_id']]);
} else if (isset($_GET['edit_sub_category'])) {
    $id = $pdo->read("sub_categories", ['id' => $_GET['edit_sub_category'], 'company_profile_id' => $_SESSION['cp_id']]);
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
                                <h4 class="page-title">Category Form</h4>
                            </div>
                            <div class="breadcrumb-list">
                                <ul>
                                    <li class="breadcrumb-link">
                                        <a href="index.php"><i class="fas fa-home mr-2"></i>Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-link active">Category</li>
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

                                    <form class="separate-form" method="post" enctype="multipart/form-data">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="row">
                                                <div class="col-md">
                                                    <div class="form-group">
                                                        <label for="image" class="col-form-label">Category image</label>
                                                        <input class="form-control" name="image" type="file" id="image">

                                                        <?php 
                                                            if (isset($_GET['edit_category'])) {
                                                            ?>
                                                        Previous image:
                                                        <br />
                                                        <img width="100" height="100"
                                                            src="display_image.php?t=categories&i=image&it=image_type&id=<?php echo $id[0]['id']; ?>"
                                                            alt="" />
                                                        <?php } ?>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="category" class="col-form-label">Category</label>
                                                        <input
                                                            value="<?php echo isset($_GET['edit_category']) ? $id[0]['category'] : null; ?>"
                                                            class="form-control" name="category" type="text"
                                                            placeholder="Enter Category Name" id="category">
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <button class="btn btn-primary" type="reset">reset</button>
                                                        <input
                                                            name="<?php echo isset($_GET['edit_category']) ? "edit_category_btn" : "add_category_btn"; ?>"
                                                            class="btn btn-danger" type="submit">
                                                    </div>
                                                    <table id="example1"
                                                        class="table table-striped table-bordered dt-responsive">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Category name</th>
                                                                <th>Image</th>

                                                                <th>Created at</th>
                                                                <th>Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            foreach ($categories as $category) {


                                                            ?>
                                                            <tr>
                                                                <td><?php echo $category['id']; ?></td>
                                                                <td><img width="100" height="50"
                                                                        src="display_image.php?t=categories&i=image&it=image_type&id=<?php echo $category['id']; ?>"
                                                                        alt="" /></td>
                                                                <td><?php echo $category['category']; ?></td>

                                                                <td><?php echo $category['created_at']; ?></td>
                                                                <td>
                                                                    <a class="text-success"
                                                                        href="categories.php?edit_category=<?php echo $category['id']; ?>">
                                                                        <i class="fa fa-edit"></i>
                                                                    </a>
                                                                    &nbsp;&nbsp;&nbsp;
                                                                    <a class="text-danger"
                                                                        href="categories.php?delete_category=<?php echo $category['id']; ?>">
                                                                        <i class="fa fa-trash"></i>
                                                                    </a>
                                                                </td>

                                                            </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                    <div class="form-group mb-3">
                                                        <button id="printbtncategory" class="btn btn-danger" type="button"><i class="fa fa-print"></i> Print</button>
                                                        
                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>



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
                                                            if (isset($_GET['edit_sub_category'])) {
                                                            ?>
                                                        Previous image:
                                                        <br />
                                                        <img width="100" height="100"
                                                            src="display_image.php?t=sub_categories&i=image&it=image_type&id=<?php echo $id[0]['id']; ?>"
                                                            alt="" />
                                                        <?php } ?>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="sub_category" class="col-form-label">Sub
                                                            category</label>
                                                        <input
                                                            value="<?php echo isset($_GET['edit_sub_category']) ? $id[0]['sub_category'] : null; ?>"
                                                            class="form-control" name="sub_category" type="text"
                                                            placeholder="Enter Sub Category Name" id="sub_category">
                                                    </div>
                                                    <div class="form-group s-opt">
                                                        <label for="category_id"
                                                            class="col-form-label">Categories</label>
                                                        <select name="category_id"
                                                            class="select2 form-control select-opt" id="category_id">
                                                            <?php
                                                            foreach ($categories as $category2) {


                                                            ?>
                                                            <option value="<?php echo $category2['id']; ?>">
                                                                <?php echo $category2['category']; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                        <span class="sel_arrow">
                                                            <i class="fa fa-angle-down "></i>
                                                        </span>
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <button class="btn btn-primary" type="reset">reset</button>
                                                        <input
                                                            name="<?php echo isset($_GET['edit_sub_category']) ? "edit_sub_category_btn" : "add_sub_category_btn"; ?>"
                                                            class="btn btn-danger" type="submit">
                                                    </div>
                                                    <table id="example2"
                                                        class="table table-striped table-bordered dt-responsive ">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Image</th>
                                                                <th>Category name</th>
                                                                <th>Sub category name</th>

                                                                <th>Created at</th>
                                                                <th>Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            foreach ($sub_categories as $sub_category) {
                                                                $category_inner = $pdo->read("categories", ['id' => $sub_category['category_id'], 'company_profile_id' => $_SESSION['cp_id']]);
                                                            ?>
                                                            <tr>
                                                                <td><?php echo $sub_category['id']; ?></td>
                                                                <td><img width="100" height="50"
                                                                        src="display_image.php?t=sub_categories&i=image&it=image_type&id=<?php echo $sub_category['id']; ?>"
                                                                        alt="" /></td>
                                                                <td><?php echo $category_inner[0]['category']; ?></td>


                                                                <td><?php echo $sub_category['sub_category']; ?></td>
                                                                <td><?php echo $sub_category['created_at']; ?></td>
                                                                <td>
                                                                    <a class="text-success"
                                                                        href="categories.php?edit_sub_category=<?php echo $sub_category['id']; ?>">
                                                                        <i class="fa fa-edit"></i>
                                                                    </a>
                                                                    &nbsp;&nbsp;&nbsp;
                                                                    <a class="text-danger"
                                                                        href="categories.php?delete_sub_category=<?php echo $sub_category['id']; ?>">
                                                                        <i class="fa fa-trash"></i>
                                                                    </a>
                                                                </td>

                                                            </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                    <div class="form-group mb-3">
                                                        <button id="printbtnsubcategory" class="btn btn-danger" type="button"><i class="fa fa-print"></i> Print</button>
                                                        
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

        $(document).on("input", e=>{
            searchedValue = e.target.value;
        })
        $("#printbtncategory").on("click", e=>{
            location.href = `printreport1.php?s=${searchedValue}&t=category`;
        });

        $("#printbtnsubcategory").on("click", e=>{
            location.href = `printreport1.php?s=${searchedValue}&t=subcategory`;
        });
    </script>

</body>

</html>