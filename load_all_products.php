<?php
require_once 'assets/includes/pdo.php';
session_start();
$products = $pdo->customQuery("SELECT * FROM products WHERE product_name LIKE '%{$_POST['s']}%' AND company_profile_id = '{$_SESSION['ovalfox_pos_cp_id']}'");

?>

<table id="exampleNew" class="table table-striped table-bordered dt-responsive">
    <thead>
        <tr>
            <th>#</th>
            <th>Image</th>
            <th>Item code</th>
            <th>Category</th>
            <th>Sub category</th>
            <th>Product name</th>
            <th>Product details</th>
            <th>Per unit price</th>
            <th>Per box price</th>
            <th>Whole sale price</th>
            <th>Trade unit price</th>
            <th>Trade box price</th>
            <th>Whole sale box price</th>
            <th>Quantity per box price</th>
            <th>Total quantity</th>
            <th>Store</th>
            <th>Row</th>
            <th>Col</th>
            <th>Low stock limit</th>

            <th>Created at</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($products as $product) {

?>

        <tr>
            <td><?php echo $product['id']; ?></td>
            <td><img width="100" height="50" src="assets/ovalfox/products/<?php echo $product['image']; ?>" alt="" />
            </td>
            <td><?php echo $product['item_code']; ?></td>
            <td><?php echo !empty($category2[0]['category']) ? $category2[0]['category'] : 'no_category'; ?>
            </td>
            <td><?php echo !empty($sub_category2[0]['sub_category']) ? $sub_category2[0]['sub_category'] : 'no_sub_category';; ?>
            </td>
            <td><?php echo $product['product_name']; ?></td>
            <td><?php echo $product['product_details']; ?></td>

            <td><?php echo $product['purchase_per_unit_price']; ?></td>
            <td><?php echo $product['purchase_per_box_price']; ?></td>
            <td><?php echo $product['whole_sale_price']; ?></td>
            <td><?php echo $product['trade_unit_price']; ?></td>
            <td><?php echo $product['trade_box_price']; ?></td>
            <td><?php echo $product['whole_sale_box_price']; ?></td>
            <td><?php echo $product['quantity_per_box']; ?>
            </td>
            <td><?php echo $product['total_quantity']; ?></td>
            <td><?php echo !empty($store2[0]['store_name']) ? $store2[0]['store_name'] : 'no_sotre_name';; ?>
            </td>
            <td><?php echo $product['row']; ?></td>
            <td><?php echo $product['col']; ?></td>
            <td><?php echo $product['low_stock_limit']; ?></td>

            <td><?php echo $product['created_at']; ?></td>
            <td>
                <a class="text-success" href="products.php?edit_product=<?php echo $product['id']; ?>">
                    <i class="fa fa-edit"></i>
                </a>
                &nbsp;&nbsp;&nbsp;
                <a class="text-danger" href="products.php?delete_product=<?php echo $product['id']; ?>">
                    <i class="fa fa-trash"></i>
                </a>
            </td>

        </tr>
        <?php } ?>

    </tbody>
</table>



<div class="form-group mb-3">
    <button id="printbtnproduct" class="btn btn-danger" type="button"><i class="fa fa-print"></i> Print</button>

</div>

<script>
$('#exampleNew').DataTable();
</script>