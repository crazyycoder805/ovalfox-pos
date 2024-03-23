<!DOCTYPE html>

<html lang="zxx">
<?php require_once 'assets/includes/head.php'; ?>
<?php

if (isset($_SESSION['ovalfox_pos_access_of']->em) && $_SESSION['ovalfox_pos_role_id'] == 3 && $_SESSION['ovalfox_pos_access_of']->em == 0) {
        header("location:404.php");
    
}

$success = "";
$error = "";
$id = "";

$employees = $pdo->read("employees", ['company_profile_id' => $_SESSION['ovalfox_pos_cp_id']]);
$designations = $pdo->read("designations", ['company_profile_id' => $_SESSION['ovalfox_pos_cp_id']]);

$image_result = '';

if (isset($_POST['add_employee_btn'])) {

    if (!empty($_POST['name']) && !empty($_POST['father_name']) && !empty($_POST['cnic']) && !empty($_POST['cnic']) && !empty($_POST['address1']) && !empty($_POST['address2']) && !empty($_POST['phone1']) && !empty($_POST['phone2']) && !empty($_POST['designation_id'])  && !empty($_POST['designation_name'])  && !empty($_POST['salary']) && !empty($_POST['start_date']) && !empty($_POST['end_date']) && !empty($_POST['end_date']) && !empty($_POST['email'])) {
        if ($pdo->validateInput($_POST['cnic'], 'cnic')) {
            if ($pdo->validateInput($_POST['phone1'], 'phone')) {
                if ($pdo->validateInput($_POST['phone2'], 'phone')) {
                    if ($pdo->validateInput($_POST['email'], 'email')) {


                        if (!empty($_FILES['profile_image']['name'])) {
                            $image_result = $pdo2->upload('profile_image', 'assets/ovalfox/employees/profile_images');
        
                            if ($pdo->create("employees", ['name' => $_POST['name'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id'], 'father_name' => $_POST['father_name'], 'cnic' => $_POST['cnic'], 'address1' => $_POST['address1'], 
                            'address2' => $_POST['address2'], 'phone1' => $_POST['phone1'], 'phone2' => $_POST['phone2'], 'designation_id' => $_POST['designation_id'], 
                            'designation_name' => $_POST['designation_name'], 'salary' => $_POST['salary'], 'start_date' => $_POST['start_date'], 'end_date' => $_POST['end_date'], 
                            'email' => $_POST['email'], 
                            'profile_image' => $image_result['filename']])) {
                                $success = "Employee added.";
                                $pdo->headTo("employees.php");
                            } else {
                                $error = "Something went wrong.";
                            }
                        } else if (!empty($_FILES['cnic_front_pic']['name'])) {
                            $image_result = $pdo2->upload('cnic_front_pic', 'assets/ovalfox/employees/cnic_front_pics');
        
                            if ($pdo->create("employees", ['name' => $_POST['name'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id'], 'father_name' => $_POST['father_name'], 'cnic' => $_POST['cnic'], 'address1' => $_POST['address1'], 
                            'address2' => $_POST['address2'], 'phone1' => $_POST['phone1'], 'phone2' => $_POST['phone2'], 'designation_id' => $_POST['designation_id'], 
                            'designation_name' => $_POST['designation_name'], 'salary' => $_POST['salary'], 'start_date' => $_POST['start_date'], 'end_date' => $_POST['end_date'], 
                            'email' => $_POST['email'], 
                            'cnic_front_pic' => $image_result['filename']])) {
                                $success = "Employee added.";
                                $pdo->headTo("employees.php");
                            } else {
                                $error = "Something went wrong.";
                            }
                        }else if (!empty($_FILES['cnic_back_pic']['name'])) {
                            $image_result = $pdo2->upload('cnic_back_pic', 'assets/ovalfox/employees/cnic_back_pics');
        
                            if ($pdo->create("employees", ['name' => $_POST['name'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id'], 'father_name' => $_POST['father_name'], 'cnic' => $_POST['cnic'], 'address1' => $_POST['address1'], 
                            'address2' => $_POST['address2'], 'phone1' => $_POST['phone1'], 'phone2' => $_POST['phone2'], 'designation_id' => $_POST['designation_id'], 
                            'designation_name' => $_POST['designation_name'], 'salary' => $_POST['salary'], 'start_date' => $_POST['start_date'], 'end_date' => $_POST['end_date'], 
                            'email' => $_POST['email'], 
                            'cnic_back_pic' => $image_result['filename']])) {
                                $success = "Employee added.";
                                $pdo->headTo("employees.php");
                            } else {
                                $error = "Something went wrong.";
                            }
                        } else if (!empty($_FILES['profile_image']['name']) && !empty($_FILES['cnic_back_pic']['name']) && !empty($_FILES['cnic_front_pic']['name'])) {
                            $image_result1 = $pdo2->upload('profile_image', 'assets/ovalfox/employees/profile_image');
                            $image_result2 = $pdo2->upload('cnic_back_pic', 'assets/ovalfox/employees/cnic_back_pics');
                            $image_result3 = $pdo2->upload('cnic_front_pic', 'assets/ovalfox/employees/cnic_front_pics');

                            if ($pdo->create("employees", ['name' => $_POST['name'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id'], 'father_name' => $_POST['father_name'], 'cnic' => $_POST['cnic'], 'address1' => $_POST['address1'], 
                            'address2' => $_POST['address2'], 'phone1' => $_POST['phone1'], 'phone2' => $_POST['phone2'], 'designation_id' => $_POST['designation_id'], 
                            'designation_name' => $_POST['designation_name'], 'salary' => $_POST['salary'], 'start_date' => $_POST['start_date'], 'end_date' => $_POST['end_date'], 
                            'email' => $_POST['email'], 
                            'profile_image' => $image_result1['filename'], 
                            'cnic_back_pic' => $image_result2['filename'],
                            'cnic_front_pic' => $image_result3['filename'], 
                            
                            ])) {
                                $success = "Employee added.";
                                $pdo->headTo("employees.php");
                            } else {
                                $error = "Something went wrong.";
                            }
                        } else {
                            if ($pdo->create("employees", ['name' => $_POST['name'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id'], 'father_name' => $_POST['father_name'], 'cnic' => $_POST['cnic'], 'address1' => $_POST['address1'], 
                            'address2' => $_POST['address2'], 'phone1' => $_POST['phone1'], 'phone2' => $_POST['phone2'], 'designation_id' => $_POST['designation_id'], 
                            'designation_name' => $_POST['designation_name'], 'salary' => $_POST['salary'], 'start_date' => $_POST['start_date'], 'end_date' => $_POST['end_date'], 
                            'email' => $_POST['email'], 
                            
                            ])) {
                                $success = "Employee added.";
                                $pdo->headTo("employees.php");
                            } else {
                                $error = "Something went wrong.";
                            }
                        }
                    } else {
                        $error = "Invalid Email.";
                    }
                } else {
                    $error = "Invalid Phone2.";
                }
            } else {
                $error = "Invalid Phone1.";
            }
        } else {
            $error = "Invalid CNIC.";
        }
    } else {
        $error = "All fields must be filled.";
    }
} else if (isset($_POST['edit_employee_btn'])) {
    if (!empty($_POST['name']) && !empty($_POST['father_name']) && !empty($_POST['cnic']) && !empty($_POST['cnic']) && !empty($_POST['address1']) && !empty($_POST['address2']) && !empty($_POST['phone1']) && !empty($_POST['phone2']) && !empty($_POST['designation_id'])  && !empty($_POST['designation_name'])  && !empty($_POST['salary']) && !empty($_POST['start_date']) && !empty($_POST['end_date']) && !empty($_POST['end_date']) && !empty($_POST['email'])) {
        if ($pdo->validateInput($_POST['cnic'], 'cnic')) {
            if ($pdo->validateInput($_POST['phone1'], 'phone')) {
                if ($pdo->validateInput($_POST['phone2'], 'phone')) {
                    if ($pdo->validateInput($_POST['email'], 'email')) {
                        if (!empty($_FILES['profile_image']['name'])) {
                            $image_result = $pdo2->upload('profile_image', 'assets/ovalfox/employees/profile_images');
        
                            if ($pdo->update("employees", ['id' => $_GET['edit_employee']], ['name' => $_POST['name'], 'father_name' => $_POST['father_name'], 'cnic' => $_POST['cnic'], 
                            'address1' => $_POST['address1'], 'address2' => $_POST['address2'], 'phone1' => $_POST['phone1'], 'phone2' => $_POST['phone2'], 'designation_id' => $_POST['designation_id'], 
                            'designation_name' => $_POST['designation_name'], 'salary' => $_POST['salary'], 
                            'start_date' => $_POST['start_date'], 'end_date' => $_POST['end_date'], 
                            'email' => $_POST['email'], 
                            'profile_image' => $image_result['filename']])) {
                                $success = "Employee updated.";
                                $pdo->headTo("employees.php");
                            } else {
                                $error = "Something went wrong. or can't update this because no changes was found";
                            }
                        } else if (!empty($_FILES['cnic_front_pic']['name'])) {
                            $image_result = $pdo2->upload('cnic_front_pic', 'assets/ovalfox/employees/cnic_front_pics');
        
                            if ($pdo->update("employees", ['id' => $_GET['edit_employee']], ['name' => $_POST['name'], 'father_name' => $_POST['father_name'], 'cnic' => $_POST['cnic'], 
                            'address1' => $_POST['address1'], 'address2' => $_POST['address2'], 'phone1' => $_POST['phone1'], 'phone2' => $_POST['phone2'], 'designation_id' => $_POST['designation_id'], 
                            'designation_name' => $_POST['designation_name'], 'salary' => $_POST['salary'], 
                            'start_date' => $_POST['start_date'], 'end_date' => $_POST['end_date'], 'email' => $_POST['email'], 
                            'cnic_front_pic' => $image_result['filename']])) {
                                $success = "Employee updated.";
                                $pdo->headTo("employees.php");
                            } else {
                                $error = "Something went wrong. or can't update this because no changes was found";
                            }
                        }else if (!empty($_FILES['cnic_back_pic']['name'])) {
                            $image_result = $pdo2->upload('cnic_back_pic', 'assets/ovalfox/employees/cnic_back_pics');
        
                            if ($pdo->update("employees", ['id' => $_GET['edit_employee']], ['name' => $_POST['name'], 'father_name' => $_POST['father_name'], 'cnic' => $_POST['cnic'], 
                            'address1' => $_POST['address1'], 'address2' => $_POST['address2'], 'phone1' => $_POST['phone1'], 'phone2' => $_POST['phone2'], 'designation_id' => $_POST['designation_id'], 
                            'designation_name' => $_POST['designation_name'], 
                            'salary' => $_POST['salary'], 'start_date' => $_POST['start_date'], 
                            'end_date' => $_POST['end_date'], 'email' => $_POST['email'], 
                            'cnic_back_pic' => $image_result['filename']])) {
                                $success = "Employee updated.";
                                $pdo->headTo("employees.php");
                            } else {
                                $error = "Something went wrong. or can't update this because no changes was found";
                            }
                        } else if (!empty($_FILES['profile_image']['name']) && !empty($_FILES['cnic_back_pic']['name']) && !empty($_FILES['cnic_front_pic']['name'])) {
                            $image_result1 = $pdo2->upload('profile_image', 'assets/ovalfox/employees/profile_image');
                            $image_result2 = $pdo2->upload('cnic_back_pic', 'assets/ovalfox/employees/cnic_back_pics');
                            $image_result3 = $pdo2->upload('cnic_front_pic', 'assets/ovalfox/employees/cnic_front_pics');
                            if ($pdo->update("employees", ['id' => $_GET['edit_employee']], ['name' => $_POST['name'], 'father_name' => $_POST['father_name'], 'cnic' => $_POST['cnic'], 
                            'address1' => $_POST['address1'], 'address2' => $_POST['address2'], 'phone1' => $_POST['phone1'], 'phone2' => $_POST['phone2'], 'designation_id' => $_POST['designation_id'], 
                            'designation_name' => $_POST['designation_name'], 'salary' => $_POST['salary'], 
                            'start_date' => $_POST['start_date'], 'end_date' => $_POST['end_date'], 'email' => $_POST['email'],
                            'profile_image' => $image_result1['filename'], 
                            'cnic_back_pic' => $image_result2['filename'],
                            'cnic_front_pic' => $image_result3['filename'], 
                            ])) {
                                $success = "Employee updated.";
                                $pdo->headTo("employees.php");
                            } else {
                                $error = "Something went wrong. or can't update this because no changes was found";
                            }
                            
                        } else {
                            if ($pdo->update("employees", ['id' => $_GET['edit_employee']], ['name' => $_POST['name'], 'father_name' => $_POST['father_name'], 'cnic' => $_POST['cnic'], 
                            'address1' => $_POST['address1'], 'address2' => $_POST['address2'], 'phone1' => $_POST['phone1'], 'phone2' => $_POST['phone2'], 'designation_id' => $_POST['designation_id'], 
                            'designation_name' => $_POST['designation_name'], 'salary' => $_POST['salary'], 
                            'start_date' => $_POST['start_date'], 'end_date' => $_POST['end_date'], 'email' => $_POST['email'],
                            
                            ])) {
                                $success = "Employee updated.";
                                $pdo->headTo("employees.php");
                            } else {
                                $error = "Something went wrong. or can't update this because no changes was found";
                            }
                        }
                        
                    } else {
                        $error = "Invalid Email.";
                    }
                } else {
                    $error = "Invalid Phone2.";
                }
            } else {
                $error = "Invalid Phone1.";
            }
        } else {
            $error = "Invalid CNIC.";
        }
    } else {
        $error = "All fields must be filled.";
    }
} else if (isset($_GET['delete_employee'])) {
    if ($pdo->delete("employees", $_GET['delete_employee'])) {
        $success = "Employee deleted.";
        $pdo->headTo("employees.php");
    } else {
        $error = "Something went wrong.";
    }
}


if (isset($_GET['edit_employee'])) {
    $id = $pdo->read("employees", ['id' => $_GET['edit_employee'], 'company_profile_id' => $_SESSION['ovalfox_pos_cp_id']]);
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
                                <h4 class="page-title">Employee Form</h4>
                            </div>
                            <div class="breadcrumb-list">
                                <ul>
                                    <li class="breadcrumb-link">
                                        <a href="index.php"><i class="fas fa-home mr-2"></i>Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-link active">Employee</li>
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

                                    <form class="separate-form" enctype="multipart/form-data" method="post">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="row">
                                                <div class="col-md">
                                                    <div class="form-group">
                                                        <label for="profile_image" class="col-form-label">Profile
                                                            image</label>
                                                        <input class="form-control" name="profile_image" type="file"
                                                            id="profile_image">

                                                        <?php 
                                                            if (isset($_GET['edit_employee'])) {
                                                            ?>
                                                        Previous image:
                                                        <br />
                                                        <img width="100" height="100"
                                                            src="assets/ovalfox/employees/profile_images/<?php echo $id[0]['profile_image']; ?>"
                                                            alt="" />
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <div class="col-md">

                                                    <div class="form-group">
                                                        <label for="cnic_front_pic" class="col-form-label">CNIC front
                                                            image</label>
                                                        <input class="form-control" name="cnic_front_pic" type="file"
                                                            id="cnic_front_pic">

                                                        <?php 
                                                            if (isset($_GET['edit_employee'])) {
                                                            ?>
                                                        Previous image:
                                                        <br />
                                                        <img width="100" height="100"
                                                            src="assets/ovalfox/employees/cnic_front_pics/<?php echo $id[0]['cnic_front_pic']; ?>"
                                                            alt="" />
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <div class="col-md">

                                                    <div class="form-group">
                                                        <label for="cnic_back_pic" class="col-form-label">CNIC back
                                                            image</label>
                                                        <input class="form-control" name="cnic_back_pic" type="file"
                                                            id="cnic_back_pic">

                                                        <?php 
                                                            if (isset($_GET['edit_employee'])) {
                                                            ?>
                                                        Previous image:
                                                        <br />
                                                        <img width="100" height="100"
                                                            src="assets/ovalfox/employees/cnic_back_pics/<?php echo $id[0]['cnic_back_pics']; ?>"
                                                            alt="" />
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <div class="col-md">

                                                    <div class="form-group">
                                                        <label for="name" class="col-form-label">Name</label>
                                                        <input
                                                            value="<?php echo isset($_GET['edit_employee']) ? $id[0]['name'] : null; ?>"
                                                            class="form-control" name="name" type="text"
                                                            placeholder="Enter Employee Name" id="name">
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="row">
                                                <div class="col-md">

                                                    <div class="form-group">
                                                        <label for="father_name" class="col-form-label">Father
                                                            name</label>
                                                        <input
                                                            value="<?php echo isset($_GET['edit_employee']) ? $id[0]['father_name'] : null; ?>"
                                                            class="form-control" name="father_name" type="text"
                                                            placeholder="Enter Father Name" id="father_name">
                                                    </div>
                                                </div>
                                                <div class="col-md">

                                                    <div class="form-group">
                                                        <label for="cnic" class="col-form-label">Cnic</label>
                                                        <input
                                                            value="<?php echo isset($_GET['edit_employee']) ? $id[0]['cnic'] : null; ?>"
                                                            class="form-control" name="cnic" type="text"
                                                            placeholder="Enter CNIC" id="cnic">
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="row">
                                                <div class="col-md">
                                                    <div class="form-group">
                                                        <label for="address1" class="col-form-label">Address 1</label>
                                                        <textarea class="form-control" placeholder="Address 1"
                                                            name="address1"
                                                            id="address1"><?php echo isset($_GET['edit_employee']) ? $id[0]['address1'] : null; ?></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md">

                                                    <div class="form-group">
                                                        <label for="address2" class="col-form-label">Address 2</label>
                                                        <textarea class="form-control" placeholder="Address 2"
                                                            name="address2"
                                                            id="address2"><?php echo isset($_GET['edit_employee']) ? $id[0]['address2'] : null; ?></textarea>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="row">
                                                <div class="col-md">

                                                    <div class="form-group">
                                                        <label for="phone1" class="col-form-label">Phone 1</label>
                                                        <input
                                                            value="<?php echo isset($_GET['edit_employee']) ? $id[0]['phone1'] : null; ?>"
                                                            class="form-control" name="phone1" type="tel"
                                                            placeholder="Enter Employee Phone 1" id="phone1">
                                                    </div>
                                                </div>
                                                <div class="col-md">

                                                    <div class="form-group">
                                                        <label for="phone2" class="col-form-label">Phone 2</label>
                                                        <input
                                                            value="<?php echo isset($_GET['edit_employee']) ? $id[0]['phone2'] : null; ?>"
                                                            class="form-control" name="phone2" type="tel"
                                                            placeholder="Enter Employee Phone 1" id="phone2">
                                                    </div>
                                                </div>
                                                <div class="col-md">

                                                    <div class="form-group s-opt">
                                                        <label for="designation_id"
                                                            class="col-form-label">Designations</label>
                                                        <select class="select2 form-control select-opt"
                                                            name="designation_id" id="designation_id">
                                                            <?php
                                                            foreach ($designations as $designation) {


                                                            ?>
                                                            <option
                                                                <?php echo isset($_GET['edit_employee']) && $id[0]['designation_id'] == $designation['id'] ? "selected" : null; ?>
                                                                value="<?php echo $designation['id']; ?>">
                                                                <?php echo $designation['name']; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                        <span class="sel_arrow">
                                                            <i class="fa fa-angle-down "></i>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-md">

                                                    <div class="form-group">
                                                        <label for="designation_name" class="col-form-label">Designation
                                                            Name</label>
                                                        <input
                                                            value="<?php echo isset($_GET['edit_employee']) ? $id[0]['designation_name'] : null; ?>"
                                                            class="form-control" name="designation_name" type="text"
                                                            placeholder="Enter Designation Name" id="designation_name">
                                                    </div>
                                                </div>
                                                <div class="col-md">

                                                    <div class="form-group">
                                                        <label for="salary" class="col-form-label">Salary</label>
                                                        <input
                                                            value="<?php echo isset($_GET['edit_employee']) ? $id[0]['salary'] : null; ?>"
                                                            class="form-control" name="salary" type="text"
                                                            placeholder="Enter Salary" id="salary">
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="row">
                                                <div class="col-md">

                                                    <div class="form-group">
                                                        <label for="start_date" class="col-form-label">Start
                                                            date</label>
                                                        <input
                                                            value="<?php echo isset($_GET['edit_employee']) ? $id[0]['start_date'] : null; ?>"
                                                            class="form-control" name="start_date" type="date"
                                                            placeholder="Enter Start Date" id="start_date">
                                                    </div>
                                                </div>
                                                <div class="col-md">

                                                    <div class="form-group">
                                                        <label for="end_date" class="col-form-label">End date</label>
                                                        <input
                                                            value="<?php echo isset($_GET['edit_employee']) ? $id[0]['end_date'] : null; ?>"
                                                            class="form-control" name="end_date" type="date"
                                                            placeholder="Enter End Date" id="end_date">
                                                    </div>
                                                </div>
                                                <div class="col-md">

                                                    <div class="form-group">
                                                        <label for="email" class="col-form-label">Email</label>
                                                        <input
                                                            value="<?php echo isset($_GET['edit_employee']) ? $id[0]['email'] : null; ?>"
                                                            class="form-control" name="email" type="email"
                                                            placeholder="Enter Email" id="email">
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <button class="btn btn-primary" type="reset">reset</button>
                                                        <input
                                                            name="<?php echo isset($_GET['edit_employee']) ? "edit_employee_btn" : "add_employee_btn"; ?>"
                                                            class="btn btn-danger" type="submit">
                                                    </div>

                                                </div>

                                            </div>
                                            <table id="example1"
                                                class="table table-striped table-bordered dt-responsive">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Profile image</th>
                                                        <th>CNIC front image</th>
                                                        <th>CNIC back image</th>

                                                        <th>Name</th>
                                                        <th>Father name</th>
                                                        <th>Cnic</th>
                                                        <th>Address 1</th>
                                                        <th>Address 2</th>
                                                        <th>Phone 1</th>
                                                        <th>Phone 2</th>
                                                        <th>Designation</th>
                                                        <th>Designation name</th>
                                                        <th>Salary</th>
                                                        <th>Start date</th>
                                                        <th>End date</th>
                                                        <th>Email</th>

                                                        <th>Created at</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                            foreach ($employees as $employee) {
                                                                $designation2 = $pdo->read("designations", ['id' => $employee['designation_id']]);

                                                            ?>
                                                    <tr>
                                                        <td><?php echo $employee['id']; ?></td>
                                                        <td><img width="100" height="50"
                                                                src="assets/ovalfox/employees/profile_images/<?php echo $employee['profile_image']; ?>"
                                                                alt="" /></td>
                                                        <td><img width="100" height="50"
                                                                src="assets/ovalfox/employees/cnic_front_pics/<?php echo $employee['cnic_front_pic']; ?>"
                                                                alt="" /></td>
                                                        <td><img width="100" height="50"
                                                                src="assets/ovalfox/employees/cnic_back_pics/<?php echo $employee['cnic_back_pic']; ?>"
                                                                alt="" /></td>
                                                        <td><?php echo $employee['name']; ?></td>
                                                        <td><?php echo $employee['father_name']; ?></td>
                                                        <td><?php echo $employee['cnic']; ?></td>
                                                        <td><?php echo $employee['address1']; ?></td>
                                                        <td><?php echo $employee['address2']; ?></td>

                                                        <td><?php echo $employee['phone1']; ?></td>
                                                        <td><?php echo $employee['phone2']; ?></td>
                                                        <td><?php echo $designation2[0]['name']; ?></td>

                                                        <td><?php echo $employee['designation_name']; ?></td>
                                                        <td><?php echo $employee['salary']; ?></td>
                                                        <td><?php echo $employee['start_date']; ?></td>
                                                        <td><?php echo $employee['end_date']; ?></td>

                                                        <td><?php echo $employee['email']; ?></td>

                                                        <td><?php echo $employee['created_at']; ?></td>
                                                        <td>
                                                            <a class="text-success"
                                                                href="employees.php?edit_employee=<?php echo $employee['id']; ?>">
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                            &nbsp;&nbsp;&nbsp;
                                                            <a class="text-danger"
                                                                href="employees.php?delete_employee=<?php echo $employee['id']; ?>">
                                                                <i class="fa fa-trash"></i>
                                                            </a>
                                                        </td>

                                                    </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>

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