<!DOCTYPE html>

<html lang="zxx">
<?php 
require_once 'assets/includes/head.php'; 

?>
<?php 
$comp = $pdo->read("companies_profile");
if (isset($_POST['username'])) { 
    if (!empty($_POST['password']) && !empty($_POST['username'])) {

        $user = $pdo->read('access', ['username'=>$_POST['username'], 'password'=>$_POST['password'], 'company_profile_id'=>$_POST['organization']]);
        
        if (!empty($user)) {
            $comps = $pdo->read("companies_profile", ['id' => $user[0]['company_profile_id']]);

            if (date("Y-m-d") >= $comps[0]['expiry']) {
                $error = "Profile trial is expired. please purchase subscription to proccess further.";

            } else {
                $company = $pdo->read("companies_profile", ['id'=>$_POST['organization']]);

                $_SESSION['ovalfox_pos_user_id'] = $user[0]['id'];
                $_SESSION['ovalfox_pos_cp_id'] = $company[0]['id'];
                $_SESSION['ovalfox_pos_username'] = $user[0]['username'];
                $_SESSION['ovalfox_pos_role_id'] = $user[0]['role_id'];
                $_SESSION['ovalfox_pos_email'] = $user[0]['email'];
                $_SESSION['ovalfox_pos_cp_sales_1_password'] = $company[0]['password_sales_1'];
                if ($user[0]['role_id'] == 3) {
                    $_SESSION['ovalfox_pos_access_of'] = json_decode($user[0]['access_of']);
    
                }
                header('location:index.php');
                

            }
            
        } else {
            $error = "User does'nt exsit";
        }
        
    } else {
        $error = "Username & Password must be filled.";
    }
}
?>


<body>

    <div class="ad-auth-wrapper">

        <div class="ad-auth-box">

            <div class="row align-items-center">

                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                    <div class="ad-auth-img">
                        <img src="assets/images/auth-img1.png" alt="" />
                    </div>
                </div>

                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                    <div class="ad-auth-content">
                        <form method="post">
                            <a href="login.php" class="ad-auth-logo">
                                <img src="assets/images/ovalfox/logo.png" alt="" />
                            </a>


                            <h2><span class="primary">Hello,</span>Welcome!</h2>
                            <p>Please Enter Your Details Below to Continue</p>

                            <div class="ad-auth-form">
                                <div class="ad-auth-feilds mb-30">
                                    <div class="form-group s-opt">
                                        <label for="organization" class="col-form-label">Select organization</label>
                                        <select class="select2 form-control select-opt" name="organization"
                                            id="organization">
                                            <?php
                                                            foreach ($comp as $cmp) {


                                                            ?>
                                            <option value="<?php echo $cmp['id']; ?>">
                                                <?php echo $cmp['company_name']; ?></option>
                                            <?php } ?>
                                        </select>
                                        <span class="sel_arrow">
                                            <i class="fa fa-angle-down "></i>
                                        </span>
                                    </div>

                                </div>

                                <div class="ad-auth-feilds mb-30">
                                    <input type="text" placeholder="Username" name="username" id="username"
                                        class="ad-input" />
                                    <div class="ad-auth-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 483.3 483.3">
                                            <path
                                                d="M424.3,57.75H59.1c-32.6,0-59.1,26.5-59.1,59.1v249.6c0,32.6,26.5,59.1,59.1,59.1h365.1c32.6,0,59.1-26.5,59.1-59.1    v-249.5C483.4,84.35,456.9,57.75,424.3,57.75z M456.4,366.45c0,17.7-14.4,32.1-32.1,32.1H59.1c-17.7,0-32.1-14.4-32.1-32.1v-249.5    c0-17.7,14.4-32.1,32.1-32.1h365.1c17.7,0,32.1,14.4,32.1,32.1v249.5H456.4z"
                                                data-original="#000000" class="active-path" data-old_color="#000000"
                                                fill="#9abeed"></path>
                                            <path
                                                d="M304.8,238.55l118.2-106c5.5-5,6-13.5,1-19.1c-5-5.5-13.5-6-19.1-1l-163,146.3l-31.8-28.4c-0.1-0.1-0.2-0.2-0.2-0.3    c-0.7-0.7-1.4-1.3-2.2-1.9L78.3,112.35c-5.6-5-14.1-4.5-19.1,1.1c-5,5.6-4.5,14.1,1.1,19.1l119.6,106.9L60.8,350.95    c-5.4,5.1-5.7,13.6-0.6,19.1c2.7,2.8,6.3,4.3,9.9,4.3c3.3,0,6.6-1.2,9.2-3.6l120.9-113.1l32.8,29.3c2.6,2.3,5.8,3.4,9,3.4    c3.2,0,6.5-1.2,9-3.5l33.7-30.2l120.2,114.2c2.6,2.5,6,3.7,9.3,3.7c3.6,0,7.1-1.4,9.8-4.2c5.1-5.4,4.9-14-0.5-19.1L304.8,238.55z"
                                                data-original="#000000" class="active-path" data-old_color="#000000"
                                                fill="#9abeed"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="ad-auth-feilds">
                                    <input type="password" placeholder="Password" name="password" id="password"
                                        class="ad-input" />
                                    <div class="ad-auth-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 482.8 482.8">
                                            <path
                                                d="M395.95,210.4h-7.1v-62.9c0-81.3-66.1-147.5-147.5-147.5c-81.3,0-147.5,66.1-147.5,147.5c0,7.5,6,13.5,13.5,13.5    s13.5-6,13.5-13.5c0-66.4,54-120.5,120.5-120.5c66.4,0,120.5,54,120.5,120.5v62.9h-275c-14.4,0-26.1,11.7-26.1,26.1v168.1    c0,43.1,35.1,78.2,78.2,78.2h204.9c43.1,0,78.2-35.1,78.2-78.2V236.5C422.05,222.1,410.35,210.4,395.95,210.4z M395.05,404.6    c0,28.2-22.9,51.2-51.2,51.2h-204.8c-28.2,0-51.2-22.9-51.2-51.2V237.4h307.2L395.05,404.6L395.05,404.6z"
                                                data-original="#000000" class="active-path" data-old_color="#000000"
                                                fill="#9abeed"></path>
                                            <path
                                                d="M241.45,399.1c27.9,0,50.5-22.7,50.5-50.5c0-27.9-22.7-50.5-50.5-50.5c-27.9,0-50.5,22.7-50.5,50.5    S213.55,399.1,241.45,399.1z M241.45,325c13,0,23.5,10.6,23.5,23.5s-10.5,23.6-23.5,23.6s-23.5-10.6-23.5-23.5    S228.45,325,241.45,325z"
                                                data-original="#000000" class="active-path" data-old_color="#000000"
                                                fill="#9abeed"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <div class="ad-auth-btn">
                                <button type="submit" href="javascript:void(0);"
                                    class="ad-btn ad-login-member">Login</button>
                            </div>
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

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="ad-notifications ad-error">
                <p><span>Duhh!</span>Something Went Wrong</p>
            </div>
        </div>
    </div>
</body>

</html>