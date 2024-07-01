<header class="header-wrapper main-header">
    <div class="header-inner-wrapper">
        <div class="header-right">
            <div class="serch-wrapper">
                <form>
                    <input type="text" placeholder="Search Here...">
                </form>
                <a class="search-close" href="javascript:void(0);"><span class="icofont-close-line"></span></a>
            </div>
            <div class="header-left">
                <div class="header-links">
                    <a href="javascript:void(0);" class="toggle-btn">
                        <span></span>
                    </a>
                </div>

            </div>
            <div class="header-controls">

                <?php 
                $user = $pdo->read("access", ['id' => $_SESSION['ovalfox_pos_user_id']]);
                ?>
                <div class="user-info-wrapper header-links">
                    <a href="javascript:void(0);" class="user-info">
                        <?php 
                                            if (!empty($user[0]['image'])) {
                                            ?>
                        <img class="user-img" alt="" src="assets/ovalfox/users/<?php echo $user[0]['image']; ?>">
                        <?php } else { ?>
                        <img class="user-img" alt="" src="assets/images/du.jpg">
                        <?php } ?>
                        <div class="blink-animation">
                            <span class="blink-circle"></span>
                            <span class="main-circle"></span>
                        </div>
                    </a>
                    <div class="user-info-box">
                        <div class="drop-down-header">
                            <h4><?php echo $user[0]['username']; ?></h4>
                            <p>CLIENT</p>
                        </div>
                        <ul>
                            <?php 
            if (isset($_SESSION['ovalfox_pos_access_of']->pe) && $_SESSION['ovalfox_pos_role_id'] == 3 && $_SESSION['ovalfox_pos_access_of']->pe != 0) {
            ?>
                            <li>
                                <a href="profile-edit.php">
                                    <i class="far fa-edit"></i> Edit Profile
                                </a>
                            </li>
                            <?php } else if (isset($_SESSION['ovalfox_pos_role_id']) && $_SESSION['ovalfox_pos_role_id'] == 1) { ?>
                            <li>
                                <a href="profile-edit.php">
                                    <i class="far fa-edit"></i> Edit Profile
                                </a>
                            </li>
                            <?php } ?>
                            <!-- <li>
                                <a href="setting.html">
                                    <i class="fas fa-cog"></i> Settings
                                </a>
                            </li> -->
                            <li>
                                <form method="post">
                                    <button type="submit" name="logout" id="logout" style="color: black !important;"><i
                                            class="fas fa-sign-out-alt"></i> logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>