<!DOCTYPE html>
<?php 
require_once 'assets/includes/head.php';
?>
<?php 
if (isset($_SESSION['ovalfox_pos_access_of']->pe) && $_SESSION['ovalfox_pos_role_id'] == 3 && $_SESSION['ovalfox_pos_access_of']->pe == 0) {
    header("location:404.php");

}
$user = $pdo->read("access", ['id' => $_SESSION['ovalfox_pos_user_id']]);
$success = "";
$error = "";


$image_result = '';
if (isset($_POST['user_update'])) {
    if (!empty($_POST['email']) && !empty($_POST['printing_page_size'])) {
        if ($pdo->validateInput($_POST['email'], 'email')) {
            if (!$pdo->isDataInsertedUpdate("access", ['email' => $_POST['email']])) {
                if (!empty($_FILES['image']['tmp_name'])) {
                    $image_result = $pdo2->upload('image', 'assets/ovalfox/users');
    
                    if ($image_result && $pdo->update("access", ['id' => $_SESSION['ovalfox_pos_user_id']], ['email' => $_POST['email'], 
                    'printing_page_size' => $_POST['printing_page_size'], 'image' => $image_result['filename']])) {
                        $success = "Profile updated.";
                            session_unset();
                            session_destroy();
                            header("location:login.php");
                        
                    } else {
                        $error = "Something went wrong. or can't update this because no changes was found";
                    }
                } else {
                    if ($pdo->update("access", ['id' => $_SESSION['ovalfox_pos_user_id']], ['email' => $_POST['email'], 'printing_page_size' => $_POST['printing_page_size']])) {
                        $success = "Profile updated.";
                        
                        session_unset();
                        session_destroy();
                        header("location:login.php");
                    } else {
                        $error = "Something went wrong. or can't update this because no changes was found";
                    }
                    
                }
            } else {
                $error = "Email already added.";
            }
        } else {
            $error = "Invalid email format.";

        }
    } else {
        $error = "Email & Printing page size must be filled.";
    }
} else if (isset($_POST['company_update'])) {
    if (!empty($_POST['company_name']) && !empty($_POST['registration_id']) && !empty($_POST['tax_no']) && !empty($_POST['phone1']) && !empty($_POST['phone2']) && 
    !empty($_POST['address']) && !empty($_POST['email'])) {
        if ($pdo->validateInput($_POST['email'], 'email')) {
            if ($pdo->validateInput($_POST['phone1'], 'phone')) {
                if ($pdo->validateInput($_POST['phone2'], 'phone')) {
                    if ($pdo->validateInput($_POST['phone3'], 'phone')) {

                    if (!empty($_FILES['image']['tmp_name'])) {
                        $image_result = $pdo2->upload('image', 'assets/ovalfox/companies_profile');
        
                        if ($image_result && $pdo->update("companies_profile", ['id' => $_SESSION['ovalfox_pos_cp_id']], ['company_name' => $_POST['company_name'], 'registration_id' => $_POST['registration_id'], 
                        'tax_no' => $_POST['tax_no'], 'phone1' => $_POST['phone1'], 'phone2' => $_POST['phone2'], 'phone3' => $_POST['phone3'], 'terms_cond' => $_POST['terms_cond'], 'address' => $_POST['address'], 'email' => $_POST['email'], 
                        'image' => $image_result['filename']])) {
                            $success = "Company updated.";
                                         session_unset();
                        session_destroy();
                        header("location:login.php");
                        } else {
                            $error = "Something went wrong. or can't update this because no changes was found";
                        }
                    } else {
                        if ($pdo->update("companies_profile", ['id' => $_SESSION['ovalfox_pos_cp_id']], ['company_name' => $_POST['company_name'], 'registration_id' => $_POST['registration_id'], 
                        'tax_no' => $_POST['tax_no'], 'phone1' => $_POST['phone1'], 'phone2' => $_POST['phone2'], 'phone3' => $_POST['phone3'], 'terms_cond' => $_POST['terms_cond'], 'address' => $_POST['address'], 'email' => $_POST['email']])) {
                            $success = "Company updated.";
                                         session_unset();
                        session_destroy();
                        header("location:login.php");
                        } else {
                            $error = "Something went wrong. or can't update this because no changes was found";
                        }
                    }
                } else {
                    $error = "Invalid Phone3.";
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
                    <div class="col xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

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
                                <h4 class="page-title">User Profile</h4>
                            </div>
                            <div class="breadcrumb-list">
                                <ul>
                                    <li class="breadcrumb-link">
                                        <a href="index.html"><i class="fas fa-home mr-2"></i>Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-link active">User Profile</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Products view Start -->
                <div class="row">
                    <div class="col-xl-4">
                        <div class="card">
                            <grammarly-extension data-grammarly-shadow-root="true"
                                style="position: absolute; top: 0px; left: 0px; pointer-events: none;" class="cGcvT">
                            </grammarly-extension>
                            <div class="card-header">
                                <h4 class="card-title mb-0">My Profile</h4>
                                <div class="card-options"><a class="card-options-collapse" href="javascript:;"
                                        data-bs-toggle="card-collapse" data-bs-original-title="" title=""><i
                                            class="fe fe-chevron-up"></i></a><a class="card-options-remove"
                                        href="javascript:;" data-bs-toggle="card-remove" data-bs-original-title=""
                                        title=""><i class="fe fe-x"></i></a></div>
                            </div>
                            <div class="card-body">
                                <form method="post" enctype="multipart/form-data">
                                    <div class="profile-title">
                                        <div class="media splash-profile2-img">
                                            <?php 
                                            if (!empty($user[0]['image'])) {
                                            ?>
                                            <img alt="" src="assets/ovalfox/users/<?php echo $user[0]['image']; ?>">
                                            <?php } else { ?>
                                            <img alt="" src="assets/images/du.jpg">
                                            <?php } ?>
                                            <div class="media-body">
                                                <h5 class="mb-1"><?php 
                                                echo $_SESSION['ovalfox_pos_username'];
                                                
                                                ?></h5>
                                                <p><?php 
                                                echo "CLIENT";
                                                
                                                ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Profile image</label>
                                        <input name="image" id="image" type="file" class="form-control"
                                            data-bs-original-title="" title="">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Printing page size</label>
                                        <select class="form-control btn-square form-btn" name="printing_page_size"
                                            id="printing_page_size">
                                            <?php 
                                                        $sizes = ['small', 'medium', 'large'];
                                                        foreach ($sizes as $printing_page_size) {
                                                            
                                                        ?>
                                            <option
                                                <?php echo isset($_SESSION['ovalfox_pos_cp_id']) && $user[0]['printing_page_size'] == $printing_page_size ? "selected" : null; ?>
                                                value="<?php echo $printing_page_size; ?>">
                                                <?php echo $printing_page_size; ?></option>


                                            <?php } ?>
                                        </select>

                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Email-Address</label>
                                        <input type="email" class="form-control"
                                            value="<?php echo $_SESSION['ovalfox_pos_email']; ?>"
                                            placeholder="your-email@domain.com" data-bs-original-title="" name="email"
                                            title="">
                                    </div>
                                    <!-- <div class="mb-3">
                                        <label class="form-label">Password</label>
                                        <input class="form-control" type="password" value="password"
                                            data-bs-original-title="" title="">
                                    </div> -->

                                    <div class="form-footer">
                                        <button id="user_update" name="user_update" class="btn btn-primary squer-btn"
                                            data-bs-original-title="" title="">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <?php if (isset($_SESSION['ovalfox_pos_role_id']) && $_SESSION['ovalfox_pos_role_id'] == 1) { ?>
                    <?php 
                                            $company = $pdo->read("companies_profile", ['id' => $_SESSION['ovalfox_pos_cp_id']]);
                                            ?>
                    <div class="col-xl-8">
                        <form class="card" method="post" enctype="multipart/form-data">

                            <div class="card-header">
                                <h4 class="card-title mb-0">Edit Company Profile</h4>
                                <div class="card-options"><a class="card-options-collapse" href="javascript:;"
                                        data-bs-toggle="card-collapse" data-bs-original-title="" title=""><i
                                            class="fe fe-chevron-up"></i></a><a class="card-options-remove"
                                        href="javascript:;" data-bs-toggle="card-remove" data-bs-original-title=""
                                        title=""><i class="fe fe-x"></i></a></div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md">
                                        <div class="profile-title">
                                            <div class="media splash-profile2-img">
                                                <?php 
                                            if (!empty($company[0]['image'])) {
                                            ?>
                                                <img alt=""
                                                    src="assets/ovalfox/companies_profile/<?php echo $company[0]['image']; ?>">
                                                <?php } else { ?>
                                                <img alt="" src="assets/images/du.jpg">
                                                <?php } ?>
                                                <div class="media-body">
                                                    <h5 class="mb-1"><?php 
                                                echo $company[0]['company_name'];
                                                
                                                ?></h5>
                                                    <p><?php 
                                                echo "CLIENT";
                                                
                                                ?></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Company profile image</label>
                                            <input name="image" id="image" type="file" class="form-control"
                                                data-bs-original-title="" title="">
                                        </div>
                                        <div class="mb-3">

                                            <label class="form-label">Company Email</label>
                                            <input id="email" name="email" class="form-control"
                                                value="<?php echo $company[0]['email']; ?>" type="email"
                                                placeholder="Company Email" data-bs-original-title="" title="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md">
                                        <div class="mb-3">

                                            <label class="form-label">Company</label>
                                            <input id="company_name" name="company_name" class="form-control"
                                                value="<?php echo $company[0]['company_name']; ?>" type="text"
                                                placeholder="Company" data-bs-original-title="" title="">
                                        </div>
                                    </div>
                                    <div class="col-md">
                                        <div class="mb-3">

                                            <label class="form-label">Registration ID</label>
                                            <input id="registration_id" name="registration_id" class="form-control"
                                                value="<?php echo $company[0]['registration_id']; ?>" type="text"
                                                placeholder="Company Registration ID" data-bs-original-title=""
                                                title="">
                                        </div>
                                    </div>

                                    <div class="col-md">
                                        <div class="mb-3">

                                            <label class="form-label">Tax No.</label>
                                            <input id="tax_no" name="tax_no" class="form-control"
                                                value="<?php echo $company[0]['tax_no']; ?>" type="text"
                                                placeholder="Company Tax No." data-bs-original-title="" title="">
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md">
                                        <div class="mb-3">

                                            <label class="form-label">Phone 1</label>
                                            <input id="phone1" name="phone1" class="form-control"
                                                value="<?php echo $company[0]['phone1']; ?>" type="text"
                                                placeholder="Company Phone 1" data-bs-original-title="" title="">
                                        </div>
                                    </div>
                                    <div class="col-md">
                                        <div class="mb-3">

                                            <label class="form-label">Phone 2</label>
                                            <input id="phone2" name="phone2" class="form-control"
                                                value="<?php echo $company[0]['phone2']; ?>" type="text"
                                                placeholder="Company Phone 2" data-bs-original-title="" title="">
                                        </div>
                                    </div>



                                </div>
                                <div class="row">
                                    <div class="col-md">
                                        <div class="mb-3">

                                            <label class="form-label">Phone 3</label>
                                            <input id="phone3" name="phone3" class="form-control"
                                                value="<?php echo $company[0]['phone3']; ?>" type="text"
                                                placeholder="Company Phone 3" data-bs-original-title="" title="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md">
                                        <textarea name="address" id="address" class="form-control" cols="30"
                                            rows="10"><?php echo $company[0]['address']; ?></textarea>

                                    </div>
                                    <div class="col-md">
                                        <textarea name="terms_cond" id="terms_cond" class="form-control" cols="30"
                                            rows="10"><?php echo $company[0]['terms_cond']; ?></textarea>

                                    </div>
                                </div>
                                <button id="company_update" name="company_update" class="btn btn-primary squer-btn"
                                    type="submit" data-bs-original-title="" title="">Update Profile</button>
                            </div>
                        </form>
                    </div>
                    <?php } ?>
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