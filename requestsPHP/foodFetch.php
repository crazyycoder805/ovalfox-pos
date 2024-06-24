<?php
session_start();
require_once '../assets/includes/pdo.php';

$pdo->update("sales_1", ['invoice_number' => $_POST['invoice_number'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']]);

    $sales_1 = $pdo->read("sales_1", ['invoice_number' => $_POST['invoice_number'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']]);
    foreach ($sales_1 as $sale) {
        $pddd = $pdo->read("products", ['item_code'=>$sale['item_code'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']]);
    ?>




<tr id="parentElement">
    <td>
        <div class="img-chair">
            <img src="display_image.php?t=products&i=image&it=image_type&id=<?php echo $pddd[0]['id']; ?>" alt=" " />
        </div>
    </td>
    <td><?php echo $sale['item_name']; ?></td>
    <td id="itemp"><?php echo $sale['item_price']; ?></td>
    <td>
        <div class="int-table-quantity">
            <div class="quantity-wrapper">
                <div class="input-group">
                    <span id="val-plus" class="quantity-minus"> - </span>
                    <input type="number" class="quantity" value="<?php echo $sale['quantity'] ?>">
                    <span id="val-minus" class="quantity-plus"> + </span>
                </div>
            </div>
        </div>
    </td>
    <td><a href="javascript:;"><i class="far fa-times-circle"></i></a></td>
    <td id="itemtotalp"><?php echo $sale['amount']; ?></td>
</tr>




<?php } ?>