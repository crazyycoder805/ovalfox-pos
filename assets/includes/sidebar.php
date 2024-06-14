<aside class="sidebar-wrapper">
    <div class="logo-wrapper">
        <a href="index.php" class="admin-logo">
            <img src="assets/images/ovalfox/logo.png" alt="" class="sp_logo">
            <img src="assets/images/ovalfox/icon.png" alt="" class="sp_mini_logo">
        </a>
    </div>
    <div class="side-menu-wrap">
        <ul class="main-menu">


            <?php 
            if (isset($_SESSION['ovalfox_pos_access_of']->d) && $_SESSION['ovalfox_pos_role_id'] == 3 && $_SESSION['ovalfox_pos_access_of']->d != 0) {
            ?>
            <li>
                <a href="index.php">
                    <span class="icon-menu feather-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-home">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg>
                    </span>
                    <span class="menu-text">
                        Dashboard
                    </span>
                </a>
            </li>
            <?php } else if (isset($_SESSION['ovalfox_pos_role_id']) && $_SESSION['ovalfox_pos_role_id'] == 1) { ?>
            <li>
                <a href="index.php">
                    <span class="icon-menu feather-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-home">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg>
                    </span>
                    <span class="menu-text">
                        Dashboard
                    </span>
                </a>
            </li>
            <?php } ?>
            <?php 
            if (isset($_SESSION['ovalfox_pos_access_of']->s) && $_SESSION['ovalfox_pos_role_id'] == 3 && $_SESSION['ovalfox_pos_access_of']->s != 0) {
            ?>
            <li>
                <a href="sales.php">
                    <span class="icon-menu feather-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-home">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg>
                    </span>
                    <span class="menu-text">
                        Sales
                    </span>
                </a>
            </li>
            <?php } else if (isset($_SESSION['ovalfox_pos_role_id']) && $_SESSION['ovalfox_pos_role_id'] == 1) { ?>
            <li>
                <a href="sales.php">
                    <span class="icon-menu feather-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-home">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg>
                    </span>
                    <span class="menu-text">
                        Sales
                    </span>
                </a>
            </li>
            <?php } ?>


            <?php 
            if (isset($_SESSION['ovalfox_pos_access_of']->prc) && $_SESSION['ovalfox_pos_role_id'] == 3 && $_SESSION['ovalfox_pos_access_of']->prc != 0) {
            ?>
            <li>
                <a href="purchase.php">
                    <span class="icon-menu feather-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-home">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg>
                    </span>
                    <span class="menu-text">
                        Purchase
                    </span>
                </a>
            </li>
            <?php } else if (isset($_SESSION['ovalfox_pos_role_id']) && $_SESSION['ovalfox_pos_role_id'] == 1) { ?>
            <li>
                <a href="purchase.php">
                    <span class="icon-menu feather-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-home">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg>
                    </span>
                    <span class="menu-text">
                        Purchase
                    </span>
                </a>
            </li>
            <?php } ?>
            <?php 
            if (isset($_SESSION['ovalfox_pos_access_of']->g) && $_SESSION['ovalfox_pos_role_id'] == 3 && $_SESSION['ovalfox_pos_access_of']->g != 0) {
            ?>
            <li>
                <a href="gernel_expenses.php">
                    <span class="icon-menu feather-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-home">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg>
                    </span>
                    <span class="menu-text">
                        Gernel Expenses
                    </span>
                </a>
            </li>
            <?php } else if (isset($_SESSION['ovalfox_pos_role_id']) && $_SESSION['ovalfox_pos_role_id'] == 1) { ?>
            <li>
                <a href="gernel_expenses.php">
                    <span class="icon-menu feather-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-home">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg>
                    </span>
                    <span class="menu-text">
                        Gernel Expenses
                    </span>
                </a>
            </li>
            <?php } ?>
            <?php 
            if (isset($_SESSION['ovalfox_pos_access_of']->l) && $_SESSION['ovalfox_pos_role_id'] == 3 && $_SESSION['ovalfox_pos_access_of']->l != 0) {
            ?>
            <li>
                <a href="ledger.php">
                    <span class="icon-menu feather-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-home">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg>
                    </span>
                    <span class="menu-text">
                        Ledger
                    </span>
                </a>
            </li>
            <?php } else if (isset($_SESSION['ovalfox_pos_role_id']) && $_SESSION['ovalfox_pos_role_id'] == 1) { ?>
            <li>
                <a href="ledger.php">
                    <span class="icon-menu feather-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-home">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg>
                    </span>
                    <span class="menu-text">
                        Ledger
                    </span>
                </a>
            </li>
            <?php } ?>
            <?php 
            if (isset($_SESSION['ovalfox_pos_access_of']->s) && $_SESSION['ovalfox_pos_role_id'] == 3 && $_SESSION['ovalfox_pos_access_of']->st != 0) {
            ?>
            <li>
                <a href="store.php">
                    <span class="icon-menu feather-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-home">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg>
                    </span>
                    <span class="menu-text">
                        Stores
                    </span>
                </a>
            </li>
            <?php } else if (isset($_SESSION['ovalfox_pos_role_id']) && $_SESSION['ovalfox_pos_role_id'] == 1) { ?>
            <li>
                <a href="store.php">
                    <span class="icon-menu feather-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-home">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg>
                    </span>
                    <span class="menu-text">
                        Stores
                    </span>
                </a>
            </li>
            <?php } ?>
            <?php 
            if (isset($_SESSION['ovalfox_pos_access_of']->d) && $_SESSION['ovalfox_pos_role_id'] == 3 && $_SESSION['ovalfox_pos_access_of']->ds != 0) {
            ?>
            <li>
                <a href="designations.php">
                    <span class="icon-menu feather-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-home">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg>
                    </span>
                    <span class="menu-text">
                        Designations
                    </span>
                </a>
            </li>
            <?php } else if (isset($_SESSION['ovalfox_pos_role_id']) && $_SESSION['ovalfox_pos_role_id'] == 1) { ?>
            <li>
                <a href="designations.php">
                    <span class="icon-menu feather-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-home">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg>
                    </span>
                    <span class="menu-text">
                        Designations
                    </span>
                </a>
            </li>
            <?php } ?>

            <li>
                <a href="javascript:void(0);" class="">
                    <span class="icon-menu feather-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-home">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg>
                    </span>
                    <span class="menu-text">
                        Products
                    </span>
                </a>
                <ul class="sub-menu">
                    <?php 
                    if (isset($_SESSION['ovalfox_pos_access_of']->p) && $_SESSION['ovalfox_pos_role_id'] == 3 && $_SESSION['ovalfox_pos_access_of']->pc != 0) {
                    ?>
                    <li>
                        <a href="categories.php">
                            <span class="icon-dash">
                            </span>
                            <span class="menu-text">
                                Manage categories
                            </span>
                        </a>
                    </li>
                    <?php } else if (isset($_SESSION['ovalfox_pos_role_id']) && $_SESSION['ovalfox_pos_role_id'] == 1) { ?>
                    <li>
                        <a href="categories.php">
                            <span class="icon-dash">
                            </span>
                            <span class="menu-text">
                                Manage categories
                            </span>
                        </a>
                    </li>
                    <?php } ?>
                    <?php 
                    if (isset($_SESSION['ovalfox_pos_access_of']->p) && $_SESSION['ovalfox_pos_role_id'] == 3 && $_SESSION['ovalfox_pos_access_of']->p != 0) {
                    ?>
                    <li>
                        <a href="products.php">
                            <span class="icon-dash">
                            </span>
                            <span class="menu-text">
                                Manage products
                            </span>
                        </a>
                    </li>
                    <?php } else if (isset($_SESSION['ovalfox_pos_role_id']) && $_SESSION['ovalfox_pos_role_id'] == 1) { ?>
                    <li>
                        <a href="products.php">
                            <span class="icon-dash">
                            </span>
                            <span class="menu-text">
                                Manage products
                            </span>
                        </a>
                    </li>
                    <?php } ?>

                </ul>
            </li>


            <li>
                <a href="javascript:void(0);" class="">
                    <span class="icon-menu feather-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-home">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg>
                    </span>
                    <span class="menu-text">
                        Customers
                    </span>
                </a>
                <ul class="sub-menu">
                    <?php 
                    if (isset($_SESSION['ovalfox_pos_access_of']->c) && $_SESSION['ovalfox_pos_role_id'] == 3 && $_SESSION['ovalfox_pos_access_of']->c != 0) {
                    ?>
                    <li>
                        <a href="customers.php">
                            <span class="icon-dash">
                            </span>
                            <span class="menu-text">
                                Manage customers
                            </span>
                        </a>
                    </li>
                    <?php } else if (isset($_SESSION['ovalfox_pos_role_id']) && $_SESSION['ovalfox_pos_role_id'] == 1) { ?>
                    <li>
                        <a href="customers.php">
                            <span class="icon-dash">
                            </span>
                            <span class="menu-text">
                                Manage customers
                            </span>
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </li>


            <li>
                <a href="javascript:void(0);" class="">
                    <span class="icon-menu feather-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-home">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg>
                    </span>
                    <span class="menu-text">
                        Expenses
                    </span>
                </a>
                <ul class="sub-menu">
                    <?php 
                    if (isset($_SESSION['ovalfox_pos_access_of']->e) && $_SESSION['ovalfox_pos_role_id'] == 3 && $_SESSION['ovalfox_pos_access_of']->ec != 0) {
                    ?>
                    <li>
                        <a href="expense_categories.php">
                            <span class="icon-dash">
                            </span>
                            <span class="menu-text">
                                Manage expense category
                            </span>
                        </a>
                    </li>
                    <?php } else if (isset($_SESSION['ovalfox_pos_role_id']) && $_SESSION['ovalfox_pos_role_id'] == 1) { ?>
                    <li>
                        <a href="expense_categories.php">
                            <span class="icon-dash">
                            </span>
                            <span class="menu-text">
                                Manage expense category
                            </span>
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <li>
                <a href="javascript:void(0);" class="">
                    <span class="icon-menu feather-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-home">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg>
                    </span>
                    <span class="menu-text">
                        Suppliers
                    </span>
                </a>
                <ul class="sub-menu">
                    <?php 
                    if (isset($_SESSION['ovalfox_pos_access_of']->s) && $_SESSION['ovalfox_pos_role_id'] == 3 && $_SESSION['ovalfox_pos_access_of']->ss != 0) {
                    ?>
                    <li>
                        <a href="suppliers.php">
                            <span class="icon-dash">
                            </span>
                            <span class="menu-text">
                                Manage suppliers
                            </span>
                        </a>
                    </li>
                    <?php } else if (isset($_SESSION['ovalfox_pos_role_id']) && $_SESSION['ovalfox_pos_role_id'] == 1) { ?>
                    <li>
                        <a href="suppliers.php">
                            <span class="icon-dash">
                            </span>
                            <span class="menu-text">
                                Manage suppliers
                            </span>
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <?php 
            
                    if ($_SESSION['ovalfox_pos_role_id'] == 4 ) {
                    ?>
            <li>
                <a href="javascript:void(0);" class="">
                    <span class="icon-menu feather-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-home">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg>
                    </span>
                    <span class="menu-text">
                        Companies
                    </span>
                </a>
                <ul class="sub-menu">

                    <li>
                        <a href="companies_profile.php">
                            <span class="icon-dash">
                            </span>
                            <span class="menu-text">
                                Manage companies
                            </span>
                        </a>
                    </li>


                </ul>
            </li>
            <?php } ?>

            <li>
                <a href="javascript:void(0);" class="">
                    <span class="icon-menu feather-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-home">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg>
                    </span>
                    <span class="menu-text">
                        Employees
                    </span>
                </a>
                <ul class="sub-menu">
                    <?php 
                    if (isset($_SESSION['ovalfox_pos_access_of']->e) && $_SESSION['ovalfox_pos_role_id'] == 3 && $_SESSION['ovalfox_pos_access_of']->em != 0) {
                    ?>
                    <li>
                        <a href="employees.php">
                            <span class="icon-dash">
                            </span>
                            <span class="menu-text">
                                Manage employees
                            </span>
                        </a>
                    </li>
                    <?php } else if (isset($_SESSION['ovalfox_pos_role_id']) && $_SESSION['ovalfox_pos_role_id'] == 1) { ?>
                    <li>
                        <a href="employees.php">
                            <span class="icon-dash">
                            </span>
                            <span class="menu-text">
                                Manage employees
                            </span>
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <li>
                <a href="javascript:void(0);" class="">
                    <span class="icon-menu feather-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-home">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg>
                    </span>
                    <span class="menu-text">
                        Login
                    </span>
                </a>
                <ul class="sub-menu">

                    <?php 
                    if (isset($_SESSION['ovalfox_pos_access_of']->r) && $_SESSION['ovalfox_pos_role_id'] == 3 && $_SESSION['ovalfox_pos_access_of']->r != 0) {
                    ?>
                    <li>
                        <a href="roles.php">
                            <span class="icon-dash">
                            </span>
                            <span class="menu-text">
                                Manage roles
                            </span>
                        </a>
                    </li>
                    <?php } else if (isset($_SESSION['ovalfox_pos_role_id']) && $_SESSION['ovalfox_pos_role_id'] == 1) { ?>
                    <li>
                        <a href="roles.php">
                            <span class="icon-dash">
                            </span>
                            <span class="menu-text">
                                Manage roles
                            </span>
                        </a>
                    </li>
                    <?php } else if (isset($_SESSION['ovalfox_pos_role_id']) && $_SESSION['ovalfox_pos_role_id'] == 4) { ?>
                    <li>
                        <a href="roles.php">
                            <span class="icon-dash">
                            </span>
                            <span class="menu-text">
                                Manage roles
                            </span>
                        </a>
                    </li>
                    <?php } ?>



                    <?php 
                    if (isset($_SESSION['ovalfox_pos_access_of']->us) && $_SESSION['ovalfox_pos_role_id'] == 3 && $_SESSION['ovalfox_pos_access_of']->us != 0) {
                    ?>
                    <li>
                        <a href="users.php">
                            <span class="icon-dash">
                            </span>
                            <span class="menu-text">
                                Manage users
                            </span>
                        </a>
                    </li>
                    <?php } else if (isset($_SESSION['ovalfox_pos_role_id']) && $_SESSION['ovalfox_pos_role_id'] == 1) { ?>
                    <li>
                        <a href="users.php">
                            <span class="icon-dash">
                            </span>
                            <span class="menu-text">
                                Manage users
                            </span>
                        </a>
                    </li>
                    <?php } else if (isset($_SESSION['ovalfox_pos_role_id']) && $_SESSION['ovalfox_pos_role_id'] == 4) { ?>
                    <li>
                        <a href="users.php">
                            <span class="icon-dash">
                            </span>
                            <span class="menu-text">
                                Manage users
                            </span>
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <li>
                <a href="javascript:void(0);" class="">
                    <span class="icon-menu feather-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-home">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg>
                    </span>
                    <span class="menu-text">
                        Reporting
                    </span>
                </a>
                <ul class="sub-menu">
                    <?php 
                    if (isset($_SESSION['ovalfox_pos_access_of']->sr1) && $_SESSION['ovalfox_pos_role_id'] == 3 && $_SESSION['ovalfox_pos_access_of']->sr1 != 0) {
                    ?>
                    <li>
                        <a href="search_sales_1.php">
                            <span class="icon-dash">
                            </span>
                            <span class="menu-text">
                                Sales 1
                            </span>
                        </a>
                    </li>
                    <?php } else if (isset($_SESSION['ovalfox_pos_role_id']) && $_SESSION['ovalfox_pos_role_id'] == 1) { ?>
                    <li>
                        <a href="search_sales_1.php">
                            <span class="icon-dash">
                            </span>
                            <span class="menu-text">
                                Sales 1
                            </span>
                        </a>
                    </li>
                    <?php } ?>


                    <?php 
                    if (isset($_SESSION['ovalfox_pos_access_of']->sr2) && $_SESSION['ovalfox_pos_role_id'] == 3 && $_SESSION['ovalfox_pos_access_of']->sr2 != 0) {
                    ?>
                    <li>
                        <a href="search_sales_2.php">
                            <span class="icon-dash">
                            </span>
                            <span class="menu-text">
                                Sales 2
                            </span>
                        </a>
                    </li>
                    <?php } else if (isset($_SESSION['ovalfox_pos_role_id']) && $_SESSION['ovalfox_pos_role_id'] == 1) { ?>
                    <li>
                        <a href="search_sales_2.php">
                            <span class="icon-dash">
                            </span>
                            <span class="menu-text">
                                Sales 2
                            </span>
                        </a>
                    </li>
                    <?php } ?>





                    <?php 
                    if (isset($_SESSION['ovalfox_pos_access_of']->pr1) && $_SESSION['ovalfox_pos_role_id'] == 3 && $_SESSION['ovalfox_pos_access_of']->pr1 != 0) {
                    ?>
                    <li>
                        <a href="search_purchase_1.php">
                            <span class="icon-dash">
                            </span>
                            <span class="menu-text">
                                Purchase 1
                            </span>
                        </a>
                    </li>
                    <?php } else if (isset($_SESSION['ovalfox_pos_role_id']) && $_SESSION['ovalfox_pos_role_id'] == 1) { ?>
                    <li>
                        <a href="search_purchase_1.php">
                            <span class="icon-dash">
                            </span>
                            <span class="menu-text">
                                Purchase 1
                            </span>
                        </a>
                    </li>
                    <?php } ?>


                    <?php 
                    if (isset($_SESSION['ovalfox_pos_access_of']->pr2) && $_SESSION['ovalfox_pos_role_id'] == 3 && $_SESSION['ovalfox_pos_access_of']->pr2 != 0) {
                    ?>
                    <li>
                        <a href="search_purchase_2.php">
                            <span class="icon-dash">
                            </span>
                            <span class="menu-text">
                                Purchase 2
                            </span>
                        </a>
                    </li>
                    <?php } else if (isset($_SESSION['ovalfox_pos_role_id']) && $_SESSION['ovalfox_pos_role_id'] == 1) { ?>
                    <li>
                        <a href="search_purchase_2.php">
                            <span class="icon-dash">
                            </span>
                            <span class="menu-text">
                                Purchase 2
                            </span>
                        </a>
                    </li>
                    <?php } ?>



                    <?php 
                    if (isset($_SESSION['ovalfox_pos_access_of']->lgr) && $_SESSION['ovalfox_pos_role_id'] == 3 && $_SESSION['ovalfox_pos_access_of']->lgr != 0) {
                    ?>
                    <li>
                        <a href="search_ledger.php">
                            <span class="icon-dash">
                            </span>
                            <span class="menu-text">
                                Ledger
                            </span>
                        </a>
                    </li>
                    <?php } else if (isset($_SESSION['ovalfox_pos_role_id']) && $_SESSION['ovalfox_pos_role_id'] == 1) { ?>
                    <li>
                        <a href="search_ledger.php">
                            <span class="icon-dash">
                            </span>
                            <span class="menu-text">
                                Ledger
                            </span>
                        </a>
                    </li>
                    <?php } ?>
                    <li>
                        <a href="search_daily.php">
                            <span class="icon-dash">
                            </span>
                            <span class="menu-text">
                                Daily Report
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="search_item_wise.php">
                            <span class="icon-dash">
                            </span>
                            <span class="menu-text">
                                Item Wise Report
                            </span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</aside>