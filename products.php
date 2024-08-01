<!DOCTYPE html>

<html lang="zxx">
<?php require_once 'assets/includes/head.php'; ?>
<?php
if (isset($_SESSION['ovalfox_pos_access_of']->p) && $_SESSION['ovalfox_pos_role_id'] == 3 && $_SESSION['ovalfox_pos_access_of']->p == 0) {
    header("location:404.php");
}
$lowercaseAlphabet = range('a', 'z');

$uppercaseAlphabet = range('A', 'Z');

$numbers = range(1, 10);

$abc = array_merge($lowercaseAlphabet, $uppercaseAlphabet, $numbers);

$randomOrderId = $abc[rand(19, 21)] . rand(0, 2) . $abc[rand(0, 2)] . $abc[rand(16, 19)]  . rand(5, 3432) . $abc[rand(5, 10)] . $abc[rand(10, 15)];
$success = "";
$error = "";
$id = "";

$categories = $pdo->read("categories", ['company_profile_id' => $_SESSION['ovalfox_pos_cp_id']]);
$sub_categories = $pdo->read("sub_categories", ['company_profile_id' => $_SESSION['ovalfox_pos_cp_id']]);
$stores = $pdo->read("stores", ['company_profile_id' => $_SESSION['ovalfox_pos_cp_id']]);

$image_result = '';

if (isset($_POST['add_product_btn'])) {

        if (
        !empty($_POST['item_code']) && 
        !empty($_POST['category_id']) && 
        !empty($_POST['sub_category_id']) && 
        !empty($_POST['product_name']) && 
        !empty($_POST['product_details'])  && 
        !empty($_POST['purchase_per_unit_price']) && 
        !empty($_POST['whole_sale_price']) && 
        !empty($_POST['trade_unit_price']) && 
        !empty($_POST['quantity_per_box']) && 
        !empty($_POST['total_quantity']) 
        
        // && 
        // !empty($_POST['store_id'])
        
        ) {
            
            if (!$pdo->isDataInserted("products", ['item_code' => $_POST['item_code'], 'product_name' => $_POST['product_name']])) {
                if (!empty($_FILES['image']['name'])) {
                    $image_result = $pdo2->upload('image', 'assets/ovalfox/products');
                        if ($image_result && $pdo->create("products", [
                        'item_code' => $_POST['item_code'], 
                        'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id'], 
                        'category_id' => $_POST['category_id'], 
                        'sub_category_id' => $_POST['sub_category_id'], 
                        'product_name' => $_POST['product_name'], 
                        'product_details' => $_POST['product_details'], 
                        'purchase_per_unit_price' => $_POST['purchase_per_unit_price'], 
                        'whole_sale_price' => $_POST['whole_sale_price'], 
                        'trade_unit_price' => $_POST['trade_unit_price'], 
                    'quantity_per_box' => $_POST['quantity_per_box'], 
                    'total_quantity' => $_POST['total_quantity'], 
                    'store_id' => $_POST['store_id'], 
                    'image' => $image_result['filename']])) {
                        $success = "Product added.";
                                              header("Location:{$name}");

                    } else {
                        $error = "Something went wrong.";
                    }
                } else {
                    if ($pdo->create("products", ['item_code' => $_POST['item_code'], 
                    'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id'], 
                    'category_id' => $_POST['category_id'], 
                    'sub_category_id' => $_POST['sub_category_id'], 
                    'product_name' => $_POST['product_name'], 
                    'product_details' => $_POST['product_details'], 
                    'purchase_per_unit_price' => $_POST['purchase_per_unit_price'], 
                    'whole_sale_price' => $_POST['whole_sale_price'], 
                    'trade_unit_price' => $_POST['trade_unit_price'], 
                    'quantity_per_box' => $_POST['quantity_per_box'], 
                    'total_quantity' => $_POST['total_quantity'], 
                    'store_id' => $_POST['store_id'], 
                    
                    ])) {
                        $success = "Product added.";
                                              header("Location:{$name}");

                    } else {
                        $error = "Something went wrong.";
                    }
                }
                
            } else {
                $error = "Product already added.";
            }
        } else {
            $error = "All fields must be filled.";
        }
      
} else if (isset($_POST['edit_product_btn'])) {

    if (
        !empty($_POST['item_code']) && 
        !empty($_POST['category_id']) && 
        !empty($_POST['sub_category_id']) && 
        !empty($_POST['product_name']) && 
        !empty($_POST['product_details'])  && 
        !empty($_POST['purchase_per_unit_price']) && 
        !empty($_POST['whole_sale_price']) && 
        !empty($_POST['trade_unit_price']) && 
        !empty($_POST['quantity_per_box']) && 
        !empty($_POST['total_quantity']) 
        
        // && 
        // !empty($_POST['store_id'])
    
    ) {
        if (!$pdo->isDataInsertedUpdate("products", ['item_code' => $_POST['item_code'], 'product_name' => $_POST['product_name']])) {
            if (!empty($_FILES['image']['name'])) {
                $image_result = $pdo2->upload('image', 'assets/ovalfox/products');

                if ($image_result && $pdo->update("products", ['id' => $_GET['edit_product']], [
                'item_code' => $_POST['item_code'], 
                'category_id' => $_POST['category_id'], 
                'sub_category_id' => $_POST['sub_category_id'], 
                'product_name' => $_POST['product_name'],
                'product_details' => $_POST['product_details'], 
                'purchase_per_unit_price' => $_POST['purchase_per_unit_price'], 
                'whole_sale_price' => $_POST['whole_sale_price'], 
                'trade_unit_price' => $_POST['trade_unit_price'],
                'quantity_per_box' => $_POST['quantity_per_box'], 
                'total_quantity' => $_POST['total_quantity'], 
                'store_id' => $_POST['store_id'], 
                'image' => $image_result['filename']])) {
                    $success = "Product updated.";
                                          header("Location:{$name}");

                } else {
                    $error = "Something went wrong. or can't update this because no changes was found";
                }
            } else {
                if ($pdo->update("products", ['id' => $_GET['edit_product']], [
                'item_code' => $_POST['item_code'], 
                'category_id' => $_POST['category_id'], 
                'sub_category_id' => $_POST['sub_category_id'], 
                'product_name' => $_POST['product_name'], 
                'product_details' => $_POST['product_details'], 
                'purchase_per_unit_price' => $_POST['purchase_per_unit_price'], 
                'whole_sale_price' => $_POST['whole_sale_price'], 
                'trade_unit_price' => $_POST['trade_unit_price'], 
                'quantity_per_box' => $_POST['quantity_per_box'], 
                'total_quantity' => $_POST['total_quantity'], 
                'store_id' => $_POST['store_id'], 
                
                ])) {
                    $success = "Product updated.";
                                          header("Location:{$name}");

                } else {
                    $error = "Something went wrong. or can't update this because no changes was found";
                }
            }
        } else {
            $error = "Product already added.";
        }
    } else {
        $error = "All fields must be filled.";
    }
} else if (isset($_GET['delete_product'])) {
    if ($pdo->delete("products", $_GET['delete_product'])) {
        $success = "Product deleted.";
                              header("Location:{$name}");

    } else {
        $error = "Something went wrong.";
    }
}
if (isset($_GET['edit_product'])) {
    $id = $pdo->read("products", ['id' => $_GET['edit_product'], 'company_profile_id' => $_SESSION['ovalfox_pos_cp_id']]);
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
                                <h4 class="page-title">Product Form</h4>
                            </div>
                            <div class="breadcrumb-list">
                                <ul>
                                    <li class="breadcrumb-link">
                                        <a href="index.php"><i class="fas fa-home mr-2"></i>Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-link active">Product</li>
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
                                                        <label for="product_name" class="col-form-label">Product
                                                            Name</label>
                                                        <select class="select2 form-control select-opt" name="product_name"
                                                            id="product-select">

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md">
                                                    <div class="form-group">
                                                        <label for="image" class="col-form-label">Product</label>
                                                        <input class="form-control" name="image" type="file" id="image">

                                                        <?php 
                                                            if (isset($_GET['edit_product'])) {
                                                            ?>
                                                        Previous image:
                                                        <br />
                                                        <img width="100" height="100"
                                                            src="assets/ovalfox/products/<?php echo $id[0]['image']; ?>"
                                                            alt="" />
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <div class="col-md">

                                                    <div class="form-group">
                                                        <label for="item_code" class="col-form-label">Item code</label>
                                                        <input
                                                            value="<?php echo isset($_GET['edit_product']) ? $id[0]['item_code'] : $randomOrderId; ?>"
                                                            class="form-control" name="item_code" type="text"
                                                            placeholder="Enter Item Code" id="item_code">
                                                    </div>
                                                </div>
                                                <div class="col-md">

                                                    <div class="form-group s-opt">
                                                        <label for="category_id"
                                                            class="col-form-label">Categories</label>
                                                        <select class="select2 form-control select-opt"
                                                            name="category_id" id="category_id">
                                                            <?php
                                                            foreach ($categories as $category) {


                                                            ?>
                                                            <option
                                                                <?php echo isset($_GET['edit_product']) && $id[0]['category_id'] == $category['id'] ? "selected" : null; ?>
                                                                value="<?php echo $category['id']; ?>">
                                                                <?php echo $category['category']; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                        <span class="sel_arrow">
                                                            <i class="fa fa-angle-down "></i>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-md">

                                                    <div class="form-group s-opt">
                                                        <label for="sub_category_id" class="col-form-label">Sub
                                                            categories</label>
                                                        <select class="select2 form-control select-opt"
                                                            name="sub_category_id" id="sub_category_id">
                                                            <?php
                                                            foreach ($sub_categories as $sub_category) {


                                                            ?>
                                                            <option
                                                                <?php echo isset($_GET['edit_product']) && $id[0]['sub_category_id'] == $sub_category['id'] ? "selected" : null; ?>
                                                                value="<?php echo $sub_category['id']; ?>">
                                                                <?php echo $sub_category['sub_category']; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                        <span class="sel_arrow">
                                                            <i class="fa fa-angle-down "></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="row">
                                                <div class="form-group">
                                                    <label for="product_details" class="col-form-label">Product
                                                        details</label>
                                                    <textarea class="form-control" placeholder="Product Details"
                                                        name="product_details"
                                                        id="product_details"><?php echo isset($_GET['edit_product']) ? $id[0]['product_details'] : null; ?></textarea>
                                                </div>
                                                <div class="col-md">

                                                    <div class="form-group">
                                                        <label for="purchase_per_unit_price" class="col-form-label">Per
                                                            unit
                                                            price</label>
                                                        <input
                                                            value="<?php echo isset($_GET['edit_product']) ? $id[0]['purchase_per_unit_price'] : null; ?>"
                                                            class="form-control" name="purchase_per_unit_price"
                                                            type="number" placeholder="Enter Per Unit Price"
                                                            id="purchase_per_unit_price">
                                                    </div>
                                                </div>
                                                <!-- <div class="col-md">

                                                    <div class="form-group">
                                                        <label for="purchase_per_box_price" class="col-form-label">Per
                                                            box
                                                            price</label>
                                                        <input
                                                            value="<?php echo isset($_GET['edit_product']) ? $id[0]['purchase_per_box_price'] : null; ?>"
                                                            class="form-control" name="purchase_per_box_price"
                                                            type="number" placeholder="Enter Per Box Price"
                                                            id="purchase_per_box_price">
                                                    </div>
                                                </div> -->
                                                <div class="col-md">

                                                    <div class="form-group">
                                                        <label for="whole_sale_price" class="col-form-label">Whole sale
                                                            price</label>
                                                        <input
                                                            value="<?php echo isset($_GET['edit_product']) ? $id[0]['whole_sale_price'] : null; ?>"
                                                            class="form-control" name="whole_sale_price" type="number"
                                                            placeholder="Enter Per Box Price" id="whole_sale_price">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md">

                                                    <div class="form-group">
                                                        <label for="trade_unit_price" class="col-form-label">Trade unit
                                                            price</label>
                                                        <input
                                                            value="<?php echo isset($_GET['edit_product']) ? $id[0]['trade_unit_price'] : null; ?>"
                                                            class="form-control" name="trade_unit_price" type="number"
                                                            placeholder="Enter Trade Unit Price" id="trade_unit_price">
                                                    </div>
                                                </div>
                                                <!-- <div class="col-md">

                                                    <div class="form-group">
                                                        <label for="trade_box_price" class="col-form-label">Trade box
                                                            price</label>
                                                        <input
                                                            value="<?php echo isset($_GET['edit_product']) ? $id[0]['trade_box_price'] : null; ?>"
                                                            class="form-control" name="trade_box_price" type="number"
                                                            placeholder="Enter Trade Box Price" id="trade_box_price">
                                                    </div>
                                                </div> -->
                                                <!-- <div class="col-md">

                                                    <div class="form-group">
                                                        <label for="whole_sale_box_price" class="col-form-label">Whole
                                                            sale box price</label>
                                                        <input
                                                            value="<?php echo isset($_GET['edit_product']) ? $id[0]['whole_sale_box_price'] : null; ?>"
                                                            class="form-control" name="whole_sale_box_price"
                                                            type="number" placeholder="Enter Whole Sale Box Price"
                                                            id="whole_sale_box_price">
                                                    </div>
                                                </div> -->
                                            </div>
                                            <div class="row">
                                                <div class="col-md">

                                                    <div class="form-group">
                                                        <label for="quantity_per_box" class="col-form-label">Quantity
                                                            per box</label>
                                                        <input
                                                            value="<?php echo isset($_GET['edit_product']) ? $id[0]['quantity_per_box'] : null; ?>"
                                                            class="form-control" name="quantity_per_box" type="number"
                                                            placeholder="Enter Quantity Per Box" id="quantity_per_box">
                                                    </div>
                                                </div>
                                                <div class="col-md">

                                                    <div class="form-group">
                                                        <label for="total_quantity" class="col-form-label">Total
                                                            quantity</label>
                                                        <input
                                                            value="<?php echo isset($_GET['edit_product']) ? $id[0]['total_quantity'] : null; ?>"
                                                            class="form-control" name="total_quantity" type="number"
                                                            placeholder="Enter Total Quantity" id="total_quantity">
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-md">

                                                <div class="form-group s-opt">
                                                    <label for="store_id" class="col-form-label">Store</label>
                                                    <select class="select2 form-control select-opt" name="store_id"
                                                        id="store_id">
                                                        <?php
                                                            foreach ($stores as $store) {


                                                            ?>
                                                        <option
                                                            <?php echo isset($_GET['edit_product']) && $id[0]['store_id'] == $store['id'] ? "selected" : null; ?>
                                                            value="<?php echo $store['id']; ?>">
                                                            <?php echo $store['store_name']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <span class="sel_arrow">
                                                        <i class="fa fa-angle-down "></i>
                                                    </span>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <button class="btn btn-primary" type="reset">reset</button>
                                                    <input
                                                        name="<?php echo isset($_GET['edit_product']) ? "edit_product_btn" : "add_product_btn"; ?>"
                                                        class="btn btn-danger" type="submit">
                                                </div>
                                            </div>
                                            <!-- <div class="col-md">

                                                <div class="form-group">
                                                    <label for="row" class="col-form-label">Row</label>
                                                    <input
                                                        value="<?php echo isset($_GET['edit_product']) ? $id[0]['row'] : null; ?>"
                                                        class="form-control" name="row" type="number"
                                                        placeholder="Enter Row" id="row">
                                                </div>
                                            </div>
                                            <div class="col-md">

                                                <div class="form-group">
                                                    <label for="col" class="col-form-label">Col</label>
                                                    <input
                                                        value="<?php echo isset($_GET['edit_product']) ? $id[0]['col'] : null; ?>"
                                                        class="form-control" name="col" type="number"
                                                        placeholder="Enter Col" id="col">
                                                </div>

                                            </div>
                                            <div class="col-md">

                                                <div class="form-group">
                                                    <label for="low_stock_limit" class="col-form-label">Low stock
                                                        limit</label>
                                                    <input
                                                        value="<?php echo isset($_GET['edit_product']) ? $id[0]['low_stock_limit'] : null; ?>"
                                                        class="form-control" name="low_stock_limit" type="number"
                                                        placeholder="Enter Low stock limit" id="low_stock_limit">
                                                </div>
                                                <div class="form-group mb-3">
                                                    <button class="btn btn-primary" type="reset">reset</button>
                                                    <input
                                                        name="<?php echo isset($_GET['edit_product']) ? "edit_product_btn" : "add_product_btn"; ?>"
                                                        class="btn btn-danger" type="submit">
                                                </div>

                                            </div> -->
                                        </div>

                                        <div class="row">
                                            <div class="col-md">

                                                <div class="form-group">

                                                    <input value="" class="form-control" name="search_aa" type="text"
                                                        placeholder="Search products..." id="search_aa">
                                                </div>
                                            </div>
                                        </div>
                                        <div id="products_load"></div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>


                </div>

            </div>
            <?php require_once 'assets/includes/footer.php'; ?>

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
    $("#printbtnproduct").on("click", e => {
        location.href = `printreport1.php?s=${searchedValue}&t=product`;
    });
    $('#product-select').on('select2:select', function(target) {
        var data = target.params.data;
        var selectedProductId = data.id;

        $.ajax({
            type: "post",
            url: "selected_product.php",
            data: {
                id: selectedProductId
            },
            success: e => {
                const pd = JSON.parse(e);
                $("#product_details").val(pd[0].product_details);
                $("#purchase_per_unit_price").val(pd[0].purchase_per_unit_price);
                $("#whole_sale_price").val(pd[0].whole_sale_price);
                $("#trade_unit_price").val(pd[0].trade_unit_price);
                $("#quantity_per_box").val(pd[0].quantity_per_box);
                $("#total_quantity").val(pd[0].total_quantity);



            }
        })
    });
    $("#search_aa").on("input", target => {
        $.ajax({
            type: "POST",
            url: "load_all_products.php",
            data: {
                "s": target.target.value
            },
            success: e => {

                $("#products_load").html(e);
            }
        })
    })
    </script>

</body>

</html>