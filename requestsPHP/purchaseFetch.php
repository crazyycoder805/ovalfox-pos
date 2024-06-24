
<?php
session_start();
require_once '../assets/includes/pdo.php';

    $purchases_2 = $pdo->read("purchases_1", ['order_number'=>$_POST['order_no'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']]);

    foreach ($purchases_2 as $pur) {
        $pdouct = $pdo->read("products", ['product_name'=> $pur['item_name'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']]);
    ?>


<tr>
    <td><?php echo $pur['id']; ?></td>

    <td><?php echo $pur['order_number']; ?></td>
    <td><?php echo $pur['bill_number']; ?></td>
    <td><?php echo $pdouct[0]['product_name']; ?></td>

    <td><?php echo $pur['quantity']; ?></td>
    <td><?php echo $pur['product_expiry']; ?></td>
    <td><?php echo $pdouct[0]['trade_unit_price']; ?></td>
    <td><?php echo $pur['total_amount']; ?></td>
    <td><?php echo $pdouct[0]['whole_sale_price']; ?></td>

    <td><button class="btn btn-danger btn-sm" value="<?php echo $pur['id']; ?>" id="removeItem">Remove</button></td>

</tr>
<?php } ?>
