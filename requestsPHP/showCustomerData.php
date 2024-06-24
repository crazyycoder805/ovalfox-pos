<?php 
session_start();
require_once '../assets/includes/pdo.php';

    $customerSales2 = $pdo->read("sales_2", ['customer_name' => $_POST['cusId'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']]);
    foreach ($customerSales2 as $index => $cs) {
        $index += 1;
        $customer = $pdo->read("customers" , ['id' => $cs['customer_name'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']]);
        $sl1 = $pdo->read("sales_1", ['invoice_number' => !empty($cs['invoice_number']) ? $cs['invoice_number'] : -1]);
        $booker = $pdo->read("access" , ['id' => $cs['booker_name'], 'company_profile_id'=>$_SESSION['ovalfox_pos_cp_id']]);

    ?>
<tr>
    <td><?php echo $index; ?></td>
    <td><?php echo $cs['bill_number']; ?></td>
    <td><?php echo preg_match('/\(Refunded\)/', (!empty($sl1[0]['item_name']) ? $sl1[0]['item_name'] : "")) ? '(Refunded) ' . $cs['invoice_number'] : $cs['invoice_number']; ?>
    </td>

    <td><?php echo $customer[0]['name']; ?></td>
    <td><?php echo $booker[0]['username']; ?></td>

    <td><?php echo $cs['final_amount']; ?></td>
    <td><?php echo $cs['date']; ?></td>

    <td>
        <a href="#" id="printCustomer" data-cus="<?php echo $cs['invoice_number'] ?>" name="printCustomer">PRINT</a> || <a
            href="sales.php?inv_num=<?php echo $cs['invoice_number'] ?>" id="editCustomer"
            data-cus="<?php echo $cs['invoice_number'] ?>" name="printCustomer">EDIT</a>
    </td>

</tr>
<?php } ?>