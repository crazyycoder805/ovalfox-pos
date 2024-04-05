<!DOCTYPE html>

<html lang="zxx">
<?php require_once 'assets/includes/head.php'; ?>
<?php
if (isset($_SESSION['ovalfox_pos_access_of']->us) && $_SESSION['ovalfox_pos_role_id'] == 3 && $_SESSION['ovalfox_pos_access_of']->us == 0) {
        header("location:404.php");
    
}
$success = "";
$error = "";
$id = "";

$users = $pdo->read("access", ['company_profile_id' => $_SESSION['ovalfox_pos_cp_id']]);
$roles = $pdo->read("roles", ['company_profile_id' => $_SESSION['ovalfox_pos_cp_id']]);

$image_result = '';


if (isset($_POST['add_user_btn'])) {

    if (!empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['role_id_choose']) && !empty($_POST['email'])) {
        $idset = 0;

        if (isset($_SESSION['ovalfox_pos_role_id']) && $_SESSION['ovalfox_pos_role_id'] == 4) {
            $idset = $_POST['company_id_select'];

        } else if (isset($_SESSION['ovalfox_pos_role_id']) && ($_SESSION['ovalfox_pos_role_id'] == 1 || $_SESSION['ovalfox_pos_role_id'] == 3)) {
            $idset = $_SESSION['ovalfox_pos_cp_id'];

        }
            if (!empty($_FILES['image']['name'])) {
                $image_result = $pdo2->upload('image', 'assets/ovalfox/users');
                if ($image_result && $pdo->create("access", ['username' => $_POST['username'], 'company_profile_id'=>$idset, 
                'password' => $_POST['password'], 'role_id' => $_POST['role_id_choose'], 'email' => $_POST['email'], 'image' => $image_result['filename']])) {
                    $success = "User added.";
                                          header("Location:{$name}");

                } else {
                    $error = "Something went wrong.";
                }
            } else {
                if ($pdo->create("access", ['username' => $_POST['username'], 'company_profile_id'=>$idset , 
                'password' => $_POST['password'], 'role_id' => $_POST['role_id_choose'], 'email' => $_POST['email']])) {
                    $success = "User added.";
                                          header("Location:{$name}");

                } else {
                    $error = "Something went wrong.";
                }
            }
            
        
    } else {
        $error = "All fields must be filled.";
    }
} else if (isset($_POST['edit_user_btn'])) {
    if (!empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['role_id_choose']) && !empty($_POST['email'])) {
        $idset = 0;

        if (isset($_SESSION['ovalfox_pos_role_id']) && $_SESSION['ovalfox_pos_role_id'] == 4) {
            $idset = $_POST['company_id_select'];

        } else if (isset($_SESSION['ovalfox_pos_role_id']) && ($_SESSION['ovalfox_pos_role_id'] == 1 || $_SESSION['ovalfox_pos_role_id'] == 3)) {
            $idset = $_SESSION['ovalfox_pos_cp_id'];

        }
                if (!empty($_FILES['image']['name'])) {
                    $image_result = $pdo2->upload('image', 'assets/ovalfox/users');
                    
                    if ($pdo->update("access", ['id' => $_GET['edit_user']], ['username' => $_POST['username'], 
                    'password' => $_POST['password'], 'role_id' => $_POST['role_id_choose'], 'email' => $_POST['email'], 'company_profile_id'=>$idset, 'image' => $image_result['filename']])) {
                        $success = "User updated.";
                                              header("Location:{$name}");

                    } else {
                        $error = "Something went wrong. or can't update this because no changes was found";
                    }
               
                } else {
                    if ($pdo->update("access", ['id' => $_GET['edit_user']], ['username' => $_POST['username'], 'password' => $_POST['password'], 
                    'role_id' => $_POST['role_id_choose'], 'email' => $_POST['email'], 'company_profile_id'=>$idset])) {
                        $success = "User updated.";
                                              header("Location:{$name}");

                    } else {
                        $error = "Something went wrong. or can't update this because no changes was found";
                    }
               
                }
                
       
    } else {
        $error = "All fields must be filled.";
    }
} else if (isset($_GET['delete_user'])) {
    if ($pdo->delete("access", $_GET['delete_user'])) {
        $success = "User deleted.";
                              header("Location:{$name}");

    } else {
        $error = "Something went wrong.";
    }
}
if (isset($_GET['edit_user'])) {
    $id = $pdo->read("access", ['id' => $_GET['edit_user'], 'company_profile_id' => $_SESSION['ovalfox_pos_cp_id']]);
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
                                                        <label for="image" class="col-form-label">User image</label>
                                                        <input
                                                            value="<?php echo isset($_GET['edit_user']) ? $id[0]['image'] : null; ?>"
                                                            class="form-control" name="image" type="file" id="image">
                                                    </div>
                                                    <?php 
                                                            if (isset($_GET['edit_user'])) {
                                                            ?>
                                                    Previous image:
                                                    <br />
                                                    <img width="100" height="100"
                                                        src="assets/ovalfox/users/<?php echo $id[0]['image']; ?>"
                                                        alt="" />
                                                    <?php } ?>
                                                </div>

                                                <div class="col-md">

                                                    <div class="form-group">
                                                        <label for="username" class="col-form-label">Username</label>
                                                        <input
                                                            value="<?php echo isset($_GET['edit_user']) ? $id[0]['username'] : null; ?>"
                                                            class="form-control" name="username" type="text"
                                                            placeholder="Enter User Name" id="username">
                                                    </div>
                                                </div>
                                                <div class="col-md">

                                                    <div class="form-group">
                                                        <label for="password" class="col-form-label">password</label>
                                                        <input
                                                            value="<?php echo isset($_GET['edit_user']) ? $id[0]['password'] : null; ?>"
                                                            class="form-control" name="password" type="text"
                                                            placeholder="Enter Password" id="password">
                                                    </div>
                                                </div>
                                                <div class="col-md">

                                                    <div class="form-group">
                                                        <label class="col-form-label">Role ID</label>

                                                        <select class="select2 form-control select-opt"
                                                            name="role_id_choose" id="role_id_choose">
                                                            <option></option>
                                                            <option selected value="1">Admin
                                                            </option>
                                                            <option value="2">Booker</option>
                                                            <option value="3">Operator</option>
                                                            <?php 
                                                            foreach ($roles as $index => $role) {
                                                                $index += 4;
                                                            ?>
                                                            <option value="<?php echo $index; ?>">
                                                                <?php echo $role['name']; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md">

                                                    <div class="form-group">
                                                        <label for="email" class="col-form-label">Email</label>
                                                        <input
                                                            value="<?php echo isset($_GET['edit_user']) ? $id[0]['email'] : null; ?>"
                                                            class="form-control" name="email" type="email"
                                                            placeholder="Enter email" id="email">
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <button class="btn btn-primary" type="reset">reset</button>
                                                        <input
                                                            name="<?php echo isset($_GET['edit_user']) ? "edit_user_btn" : "add_user_btn"; ?>"
                                                            class="btn btn-danger" type="submit">
                                                    </div>

                                                </div>



                                            </div>
                                            <?php 
                                            if ($_SESSION['ovalfox_pos_role_id'] == 4) {
                                                $allcmp = $pdo->read("companies_profile");
                                            ?>
                                            <div class="row">
                                                <div class="col-md">
                                                    <div class="col-md">

                                                        <div class="form-group">
                                                            <label class="col-form-label">Role ID</label>

                                                            <select class="select2 form-control select-opt"
                                                                name="company_id_select" id="company_id_select">
                                                                <?php 
                                                                foreach ($allcmp as $cm) {
                                                                    
                                                                ?>
                                                                <option value="<?php echo $cm['id']; ?>">
                                                                    <?php echo $cm['company_name']; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php } ?>
                                            <div class="row">
                                                <div class="col-md">
                                                    <table id="example1"
                                                        class="table table-striped table-bordered dt-responsive">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Profile image</th>
                                                                <th>Username</th>
                                                                <th>Role</th>
                                                                <th>Email</th>

                                                                <th>Created at</th>
                                                                <th>Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            foreach ($users as $user) {


                                                            ?>
                                                            <tr>
                                                                <td><?php echo $user['id']; ?></td>
                                                                <td><img width="100" height="50"
                                                                        src="assets/ovalfox/users/<?php echo $user['image']; ?>"
                                                                        alt="" /></td>

                                                                <td><?php echo $user['username']; ?></td>
                                                                <td><?php echo $user['role_id']; ?></td>
                                                                <td><?php echo $user['email']; ?></td>


                                                                <td><?php echo $user['created_at']; ?></td>
                                                                <td>
                                                                    <a class="text-success"
                                                                        href="users.php?edit_user=<?php echo $user['id']; ?>">
                                                                        <i class="fa fa-edit"></i>
                                                                    </a>
                                                                    &nbsp;&nbsp;&nbsp;
                                                                    <a class="text-danger"
                                                                        href="users.php?delete_user=<?php echo $user['id']; ?>">
                                                                        <i class="fa fa-trash"></i>
                                                                    </a>
                                                                </td>

                                                            </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
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


</body>

</html>