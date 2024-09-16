<?php
session_start();
require_once '../assets/includes/pdo.php';
function getCustomerSales($pdo, $invoiceNumber, $companyProfileId) {
    return $pdo->customQuery("SELECT * FROM sales_2 WHERE invoice_number = $invoiceNumber AND company_profile_id = $companyProfileId");
}

// Helper function to fetch customer data
function getCustomerData($pdo, $customerName, $companyProfileId) {
    return $pdo->read("customers", ["id" => $customerName, 'company_profile_id' => $companyProfileId]);
}

// Helper function to fetch ledger data
function getLedgerData($pdo, $invoiceNumber, $companyProfileId) {
    return $pdo->read("ledger", ['invoice_number' => $invoiceNumber, 'company_profile_id' => $companyProfileId]);
}

// Helper function to update or create ledger
function upsertLedger($pdo, $invoiceNumber, $customerId, $data, $customer) {
    $pdo->customQuery("DELETE FROM ledger WHERE details LIKE '%{$_POST['invoice_number']}, e%' AND payment_from = '{$customer[0]['id']}';");
    $pdo->customQuery("DELETE FROM ledger WHERE invoice_number = $invoiceNumber  AND payment_from = '{$customer[0]['id']}';");
    $existingLedger = $pdo->read("ledger", ['invoice_number' => $invoiceNumber]);
    if (empty($existingLedger)) {
        $pdo->create("ledger", array_merge(['invoice_number' => $invoiceNumber, 'payment_from' => $customerId], $data));

    } else {

        $pdo->update("ledger", ['invoice_number' => $invoiceNumber], $data);
    }

    

    // if ($_POST['new_legder_entry'] == "true") {

    //     $pdo->create("ledger", ['invoice_number' => $invoiceNumber, 'payment_from' => $customerId, "payment_type" => $_POST['payment_type'],
    //         "total_amount" => $_POST['total_amount'],
    //         "recevied_amount" => $_POST['recevied_amount'],
    //         "details" => $_POST['details'],
    //         //         //         "remaining_amount" => $_POST['final_amount'],
    //         "status" => $_POST['pending_amount'] != 0 ? "Paid" : "Unpaid"]);

       
    // }
}

// Fetch customer sales
$customerSales = getCustomerSales($pdo, $_POST['invoice_number'], $_SESSION['ovalfox_pos_cp_id']);
$customerSales = $customerSales[0] ?? [];

$customerName = $customerSales['customer_name'] ?? '';



$customer = getCustomerData($pdo, $customerName, $_SESSION['ovalfox_pos_cp_id']);
$ledger = getLedgerData($pdo, $_POST['invoice_number'], $_SESSION['ovalfox_pos_cp_id']);



$customerInvMinusAll = empty($pdo->customQuery("SELECT * 
FROM sales_2 
WHERE invoice_number < {$_POST['invoice_number']}
AND customer_name = {$customerSales['customer_name']}
")) ? [] : $pdo->customQuery("SELECT * 
FROM sales_2 
WHERE invoice_number < {$_POST['invoice_number']}
AND customer_name = {$customerSales['customer_name']}

");

$customerInvPlusAll = empty($pdo->customQuery("SELECT * 
FROM sales_2 
WHERE invoice_number > {$_POST['invoice_number']}
AND customer_name = {$customerSales['customer_name']}

")) ? [] : $pdo->customQuery("SELECT * 
FROM sales_2 
WHERE invoice_number > {$_POST['invoice_number']}
AND customer_name = {$customerSales['customer_name']}

");

$customerInvoices = array_merge($customerInvMinusAll, $customerInvPlusAll);


$gT = 0;
$rT = 0;
$prev = 0;
$previosLedger = $pdo->customQuery("SELECT * FROM ledger WHERE invoice_number < {$_POST['invoice_number']} AND company_profile_id = {$_SESSION['ovalfox_pos_cp_id']} AND payment_from = {$customer[0]['id']}");


if (!empty($customerInvMinusAll)) {
    foreach ($customerInvMinusAll as $record) {
        $gT += (double)$record['final_amount'];
        $rT += (double)$record['recevied_amount'];

    }
}
if (!empty($customerInvMinusAll)) {
    foreach ($customerInvMinusAll as $record) {
        $prev += (double)$record['final_amount'];

    }
}
if (!empty($customerInvPlusAll)) {
    foreach ($customerInvPlusAll as $record) {
        $gT += (double)$record['final_amount'];
        $rT += (double)$record['recevied_amount'];

    }
}

// Normalize date format
$_POST['date'] = str_replace("T", " ", $_POST['date']);

// Helper function to fetch customer sales


$date = !empty($_POST['date']) ? $_POST['date'] : $customerSales['date'];
$booker = !empty($_POST['booker_name']) ? $_POST['booker_name'] : $customerSales['booker_name'];
$_SESSION['booker_select'] = $booker;

// Fetch previous and next invoices
$previousInvoice = $pdo->customQuery("SELECT * FROM sales_2 WHERE customer_name = $customerName AND invoice_number < {$_POST['invoice_number']} ORDER BY invoice_number DESC LIMIT 1")[0] ?? [];

// $customerInvMinusAll = $pdo->customQuery("SELECT * FROM sales_2 WHERE customer_name = $customerName AND invoice_number < {$_POST['invoice_number']}");

$nextInvoice = $pdo->customQuery("SELECT * FROM sales_2 WHERE customer_name = $customerName AND invoice_number > {$_POST['invoice_number']} ORDER BY invoice_number ASC LIMIT 1")[0] ?? [];

// Fetch customer and ledger data

$currentBalance = (double)($customer[0]['balance']);
$previousPendingAmount = (double)($customerSales['pending_amount']);
$newPendingAmount = (double)($_POST['pending_amount']);
$receivedAmount = (double)($_POST['recevied_amount']);

$ledgerData = [
    "payment_type" => $_POST['payment_type'],
    "total_amount" => $_POST['total_amount'],
    "recevied_amount" => $_POST['recevied_amount'],
    "prev_blnc" => $currentBalance,
    "remaining_amount" => (((double)$_POST['total_amount'] - (double)$_POST['recevied_amount']) <= 0 ? 0 : (double)$_POST['total_amount'] - (double)$_POST['recevied_amount']),
    "blnce" => (double)$_POST['pending_amount'] + (double)$gT,
    'company_profile_id' => $_SESSION['ovalfox_pos_cp_id'],
    "details" => $_POST['details'],
    'date' => $_POST['date'],
    "status" => $_POST['pending_amount'] != 0 ? "Paid" : "Unpaid"
];
upsertLedger($pdo, $_POST['invoice_number'], $customer[0]['id'], $ledgerData, $customer);
$pdo->update("customers", ["id" => $customerName, 'company_profile_id' => $_SESSION['ovalfox_pos_cp_id']], ["balance" => (double)$_POST['pending_amount'] != 0 ? (double)$_POST['pending_amount'] + (double)$gT : 
(double)$gT - (double)$_POST['returned_amount']]);

if (!empty($_POST['returned_amount'])) {
    
    if (empty($pdo->customQuery("SELECT * FROM ledger WHERE details LIKE '%{$_POST['invoice_number']}, e%';"))) {
        $ledgerData2 = [
            "payment_type" => $_POST['payment_type'],
            "total_amount" => 0,
            "recevied_amount" => $_POST['returned_amount'],
            "prev_blnc" => $prev,
            "remaining_amount" => 0,
            "blnce" => (double)$prev - (double)$_POST['returned_amount'],
            'company_profile_id' => $_SESSION['ovalfox_pos_cp_id'],
            "details" => "{$_POST['invoice_number']}, e",
                    'date' => $_POST['date'],
            "status" => $_POST['pending_amount'] != 0 ? "Paid" : "Unpaid",
        ];
        $pdo->create("ledger", array_merge(['invoice_number' => $_POST['invoice_number'], 'payment_from' =>  $customer[0]['id']], $ledgerData2));
    }
}


// if (!empty($_POST['returned_amount'])) {
//     $remainingAmount = $_POST['returned_amount'];
//     foreach ($customerInvoices as $invoice) {
//         $pendingAmount = $invoice['pending_amount'];

//         // Apply the remaining amount to the current invoice's pending amount
//         if ($remainingAmount >= $pendingAmount) {
//             // If the remaining amount covers the full pending amount, pay off the invoice
//             $remainingAmount -= $pendingAmount;
//             $newPendingAmount = 0;
//             $status = 'Paid';
//             $amountApplied = $pendingAmount; // Full amount is applied
//         } else {
//             // If the remaining amount doesn't cover the full pending amount, partially pay it
//             $newPendingAmount = $pendingAmount - $remainingAmount;
//             $amountApplied = $remainingAmount;
//             $remainingAmount = 0;
//             $status = $newPendingAmount <= 0 ? 'Paid' : $invoice['status'];
//         }

//         // Update the invoice in the database
//         $pdo->customQuery("
//             UPDATE sales_2 
//             SET pending_amount = $newPendingAmount,
//                 recevied_amount = recevied_amount + $amountApplied,
//                 status =  '$status'
//             WHERE invoice_number = {$invoice['invoice_number']}
//         ");

//         // If no more remaining amount to apply, break the loop
//         if ($remainingAmount <= 0) {
//             break;
//         }
//     }
// }



// if (!empty($_POST['returned_amount'])) {
//     $returendAmount = $_POST['returned_amount'];
//     foreach ($customerInvoices as $invoice) {
//         $pendingAmount = $invoice['pending_amount'];

//         if ($returendAmount <= 0) {
//             break; // Exit if there's no more amount to distribute
//         }

//         if ($pendingAmount <= $returendAmount) {
//             // If the pending amount is less than or equal to the returend amount, set pending to zero
//             $returendAmount -= $pendingAmount;
//             $updatedPendingAmount = 0;
//         } else {
//             // Otherwise, subtract the returend amount from the pending amount
//             $updatedPendingAmount = $pendingAmount - $returendAmount;
//             $returendAmount = 0;
//         }

//         // Update the invoice in thed atabase
//         $pdo->customQuery("
//             UPDATE sales_2 
//             SET pending_amount = {$updatedPendingAmount},
//             recevied_amount = {$_POST['returned_amount']},
//             status = 'Paid'
//             WHERE invoice_number = {$invoice['invoice_number']}
//         ");
//     }
// }

// $pdo->update("customers", ["id" => $customerName, 'company_profile_id' => $_SESSION['ovalfox_pos_cp_id']], ["balance" => ]);




// if ($newPendingAmount !== $previousPendingAmount) {
//     $balanceAdjustment = $newPendingAmount - $previousPendingAmount;
//     $currentBalance += $balanceAdjustment;
//     $pdo->update("customers", ["id" => $customerName, 'company_profile_id' => $_SESSION['ovalfox_pos_cp_id']], ["balance" => $currentBalance]);
// }

// if ($receivedAmount > $newPendingAmount) {
//     $balanceAdjustment = $newPendingAmount - $previousPendingAmount;
//     $newBalance = $currentBalance + $balanceAdjustment - (double)$_POST['returned_amount'];
//     $pdo->update("customers", ["id" => $customerName, 'company_profile_id' => $_SESSION['ovalfox_pos_cp_id']], ["balance" => $newBalance]);
// }
// Prepare data for ledger upsert

// Update sales
$salesData = [
    'discount' => $_POST['discount_in_amount'],
    'date' => $date,
    "booker_name" => $booker,
    'previous_blnce' => !empty($previousInvoice) ? $previousInvoice['pending_amount'] : 0,
    'total_amount' => $_POST['total_amount'],

    'final_amount' => $_POST['final_amount'],
    'details' => $_POST['details'],
    'recevied_amount' => $_POST['recevied_amount'],
    'returned_amount' => $_POST['returned_amount'],
    'pending_amount' => $_POST['pending_amount'],
    "status" => $_POST['isIncmp'] != "true" ? ($_POST['pending_amount'] == 0 ? "Paid" : "Unpaid") : "Incomplete"
];

if ($_POST['isEdit'] ?? 'true' === "false") {
    $pdo->update("sales_2", ['invoice_number' => $_POST['invoice_number'], 'company_profile_id' => $_SESSION['ovalfox_pos_cp_id']], $salesData);
} else {
    $updatedRow = $pdo->update("sales_2", ['invoice_number' => $_POST['invoice_number'], 'company_profile_id' => $_SESSION['ovalfox_pos_cp_id']], $salesData);
    
    // Update the next invoice
    $nextInvoiceData = [
        'previous_blnce' => $pdo->read("sales_2", ['id' => $updatedRow])[0]['pending_amount'],
        "booker_name" => $booker
    ];
    $pdo->update("sales_2", ['invoice_number' => $nextInvoice['invoice_number'], 'company_profile_id' => $_SESSION['ovalfox_pos_cp_id']], $nextInvoiceData);
}

