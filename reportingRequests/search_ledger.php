<?php

session_start();
require_once '../assets/includes/pdo.php';

$ledgers = "";

if (!empty($_POST["customer_name"]) && !empty($_POST['start_date'])) {
    $ledgers = $pdo->customQuery("SELECT *, SUM(total_amount) AS total_price FROM ledger WHERE Date(date) = '{$_POST['start_date']}' AND customer_name = {$_POST["customer_name"]} AND company_profile_id = {$_SESSION['ovalfox_pos_cp_id']}");
} else if (!empty($_POST["customer_name"]) && !empty($_POST['start_date']) && !empty($_POST['end_date'])) {
    $ledgers = $pdo->customQuery("SELECT *, SUM(total_amount) AS total_price FROM ledger WHERE Date(date) BETWEEN '{$_POST['start_date']}' AND '{$_POST['end_date']}' AND customer_name = {$_POST["customer_name"]} AND company_profile_id = {$_SESSION['ovalfox_pos_cp_id']}");
} else if (!empty($_POST["customer_name"])) {
    $ledgers = $pdo->customQuery("SELECT *, SUM(total_amount) AS total_price FROM ledger WHERE  customer_name = {$_POST["customer_name"]} AND company_profile_id = {$_SESSION['ovalfox_pos_cp_id']}");
}
?>


<table id="search_table" class="table table-striped table-bordered dt-responsive">
<thead>
    <tr>
        <th>#</th>
        <th>Date</th>
        <th>Payment type</th>

        <th>Total amount</th>
        <th>Recevied amount</th>
        <th>Details</th>

        <th>Payment from</th>
        <th>Dr</th>
        <th>Cr</th>
        <th>Remaining amount</th>

        <th>Created at</th>
    </tr>
</thead>
<tbody>
    <?php 
foreach ($ledgers as $ledger) {

?>
    <tr>
        <td>#</td>
        <td><?php echo $ledger['date']; ?></td>
        <td><?php echo $ledger['payment_type']; ?></td>

        <td><?php echo $ledger['total_amount']; ?></td>
        <td><?php echo $ledger['recevied_amount']; ?></td>
        <td><?php echo $ledger['details']; ?></td>

        <td><?php echo $ledger['payment_from']; ?></td>
        <td><?php echo $ledger['dr']; ?></td>
        <td><?php echo $ledger['cr']; ?></td>
        <td><?php echo $ledger['remaining_amount']; ?></td>

        <td><?php echo $ledger['created_at']; ?></td>
    </tr>
    <?php } ?>

</tbody>

</table>

