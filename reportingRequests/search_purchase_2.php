<?php

session_start();
require_once '../assets/includes/pdo.php';

$purchases_2 = $pdo->customQuery("SELECT * FROM purchases_2 WHERE created_at BETWEEN '{$_POST['start_date']}' AND '{$_POST['end_date']}' AND company_profile_id = {$_SESSION['ovalfox_pos_cp_id']}");
?>


<table id="search_table" class="table table-striped table-bordered dt-responsive">
    <thead>
        <tr>
            <th>#</th>
            <th>Order number</th>
            <th>Bill number</th>

            <th>Date</th>
            <th>Operator</th>
            <th>Company name</th>

            <th>Total amount</th>
            <th>Paid amount</th>
            <th>Remaining amount</th>

            <th>Created at</th>
        </tr>
    </thead>
    <tbody>
        <?php 
foreach ($purchases_2 as $purchase_2) {

?>
        <tr>
            <td>#</td>
            <td><?php echo $purchase_2['order_number']; ?></td>
            <td><?php echo $purchase_2['bill_number']; ?></td>

            <td><?php echo $purchase_2['date']; ?></td>
            <td><?php echo $purchase_2['operator']; ?></td>
            <td><?php echo $purchase_2['company_name']; ?></td>

            <td><?php echo $purchase_2['total_amount']; ?></td>
            <td><?php echo $purchase_2['paid_amount']; ?></td>
            <td><?php echo $purchase_2['remaining_amount']; ?></td>

            <td><?php echo $purchase_2['created_at']; ?></td>
        </tr>
        <?php } ?>

    </tbody>

</table>