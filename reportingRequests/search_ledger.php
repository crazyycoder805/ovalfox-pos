<?php

session_start();
require_once '../assets/includes/pdo.php';

// Build the query
$query = "SELECT *, SUM(total_amount) AS total_price FROM ledger WHERE company_profile_id = {$_SESSION['ovalfox_pos_cp_id']}";

// Add conditions based on POST data
if (!empty($_POST["customer_name"])) {
    $query .= " AND customer_name = {$_POST["customer_name"]}";
}

if (!empty($_POST['start_date'])) {
    $query .= " AND Date(date) = {$_POST['start_date']}";
    

    if (!empty($_POST['end_date'])) {
        $query .= " AND Date(date) BETWEEN {$_POST['start_date']} AND {$_POST['end_date']}";
    }
}

// Execute the query
$ledgers = $pdo->customQuery($query);

?>

<table id="search_table" class="table table-striped table-bordered dt-responsive">
    <thead>
        <tr>
            <th>#</th>
            <th>Date</th>
            <th>Payment Type</th>
            <th>Total Amount</th>
            <th>Received Amount</th>
            <th>Details</th>
            <th>Payment From</th>
            <th>Dr</th>
            <th>Cr</th>
            <th>Remaining Amount</th>
            <th>Created At</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($ledgers as $ledger): ?>
        <tr>
            <td>#</td>
            <td><?php echo htmlspecialchars($ledger['date']); ?></td>
            <td><?php echo htmlspecialchars($ledger['payment_type']); ?></td>
            <td><?php echo htmlspecialchars($ledger['total_amount']); ?></td>
            <td><?php echo htmlspecialchars($ledger['received_amount']); ?></td>
            <td><?php echo htmlspecialchars($ledger['details']); ?></td>
            <td><?php echo htmlspecialchars($ledger['payment_from']); ?></td>
            <td><?php echo htmlspecialchars($ledger['dr']); ?></td>
            <td><?php echo htmlspecialchars($ledger['cr']); ?></td>
            <td><?php echo htmlspecialchars($ledger['remaining_amount']); ?></td>
            <td><?php echo htmlspecialchars($ledger['created_at']); ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
