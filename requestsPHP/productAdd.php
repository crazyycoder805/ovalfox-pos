<?php
session_start();
require_once '../assets/includes/pdo.php';

// Sanitize and format the input date
$_POST['date'] = str_replace("T", " ", $_POST['date']);

// Convert common numeric variables to their appropriate types
$_POST['invoice_number'] = (int) $_POST['invoice_number'];
$_POST['total_quantity'] = (float) $_POST['total_quantity'];
$_POST['total_amount'] = (float) $_POST['total_amount'];
$_POST['quantity'] = isset($_POST['quantity']) ? (float) $_POST['quantity'] : 0;
$_POST['item_price'] = isset($_POST['item_price']) ? (float) $_POST['item_price'] : 0;
$_POST['discount'] = isset($_POST['discount']) ? (float) $_POST['discount'] : 0;
$_POST['extra_discount'] = isset($_POST['extra_discount']) ? (float) $_POST['extra_discount'] : 0;
$_POST['product_id'] = (int) $_POST['product_id'];
$_POST['taaup'] = isset($_POST['taaup']) ? (float) $_POST['taaup'] : 0;

// Construct the item name based on the type and if it's a free item
$item_name = ($_POST['type'] !== "rf")
    ? ($_POST['isItemFree'] === "true" ? "(Free Item) " . $_POST['item_name'] : $_POST['item_name'])
    : "(Refunded) " . $_POST['item_name'];

// Read sales_1 record
$sales_1 = $pdo->read("sales_1", [
    'invoice_number' => $_POST['invoice_number'],
    'item_code' => $_POST['item_code'],
    'item_name' => $item_name,
    'company_profile_id' => $_SESSION['ovalfox_pos_cp_id']
]);

// Check for required POST fields
if (!empty($_POST['invoice_number']) && (!empty($_POST['customer_name']) || !empty($_POST['customer_manual'])) &&
    !empty($_POST['booker_name']) && !empty($_POST['date']) && !empty($_POST['total_quantity']) &&
    (!empty($_POST['item_code_search']) || !empty($_POST['product_id']))) {

    // Set session variable for the booker name
    $_SESSION['booker_select'] = $_POST['booker_name'];

    // Get the next bill number for the customer
    $billNumber = $pdo->customQuery("
        SELECT MAX(CAST(bill_number AS UNSIGNED)) AS billNumber 
        FROM sales_2 
        WHERE customer_name = '{$_POST['customer_name']}' 
        AND company_profile_id = {$_SESSION['ovalfox_pos_cp_id']}
    ")[0]['billNumber'] + 1;

    $customerId = "";
    $customer = "";

    // Handle discounts
    $discount = $_POST['discount'] ?? 0;
    $extra_discount = $_POST['extra_discount'] ?? 0;

    // If a manual customer name is provided, either fetch or create the customer
    if (!empty($_POST['customer_manual'])) {
        if (!$pdo->isDataInserted("customers", [
            'name' => $_POST['customer_manual'],
            'company_profile_id' => $_SESSION['ovalfox_pos_cp_id']
        ])) {
            $returnedId = $pdo->create('customers', [
                'name' => $_POST['customer_manual'],
                'company_profile_id' => $_SESSION['ovalfox_pos_cp_id']
            ]);
            $customerId = $pdo->read('customers', [
                'id' => $returnedId,
                'company_profile_id' => $_SESSION['ovalfox_pos_cp_id']
            ])[0]['id'];
        } else {
            $customerId = $pdo->read('customers', [
                'name' => $_POST['customer_manual'],
                'company_profile_id' => $_SESSION['ovalfox_pos_cp_id']
            ])[0]['id'];
        }
        $customer = $pdo->read("customers", [
            'id' => $customerId,
            'company_profile_id' => $_SESSION['ovalfox_pos_cp_id']
        ]);
    }

    // If the type is a refund
    if ($_POST['type'] === "rf") {
        // Update the product quantity
        $pdo->update("products", [
            'id' => $_POST['product_id'],
            'company_profile_id' => $_SESSION['ovalfox_pos_cp_id']
        ], [
            'total_quantity' => $_POST['total_quantity']
        ]);

        // Check if sales_2 record exists, otherwise create it
        if (empty($pdo->read("sales_2", [
            'invoice_number' => $_POST['invoice_number'],
            'company_profile_id' => $_SESSION['ovalfox_pos_cp_id']
        ]))) {
            $pdo->create("sales_2", [
                'invoice_number' => $_POST['invoice_number'],
                'company_profile_id' => $_SESSION['ovalfox_pos_cp_id'],
                'customer_name' => !empty($_POST['customer_manual']) ? $customerId : $_POST['customer_name'],
                'booker_name' => $_POST['booker_name'],
                'operator_name' => $_POST['booker_name'],
                'date' => $_POST['date'],
                'discount' => 0,
                'bill_number' => $billNumber,
                'total_amount' => $_POST['total_amount'],
                'final_amount' => 0,
                'recevied_amount' => 0,
                'returned_amount' => 0,
                'pending_amount' => 0,
                'status' => "Refund"
            ]);
            echo "Item added.";
        } else {
            $pdo->update("sales_2", [
                'invoice_number' => $_POST['invoice_number'],
                'company_profile_id' => $_SESSION['ovalfox_pos_cp_id']
            ], [
                'total_amount' => $_POST['total_amount']
            ]);
        }

        // If the item is not already in sales_1, create it
        if (empty($sales_1)) {
            processSalesItem($pdo, $item_name, $customerId, $discount, $extra_discount);
        } else {
            updateSalesItem($pdo, $sales_1, $item_name);
        }
    } else {
        // Update product quantity for non-refund
        $pdo->update("products", [
            'id' => $_POST['product_id'],
            'company_profile_id' => $_SESSION['ovalfox_pos_cp_id']
        ], [
            'total_quantity' => $_POST['total_quantity']
        ]);

        // Handle sales_2 record creation or update
        if (empty($pdo->read("sales_2", [
            'invoice_number' => $_POST['invoice_number'],
            'company_profile_id' => $_SESSION['ovalfox_pos_cp_id']
        ]))) {
            $pdo->create("sales_2", [
                'invoice_number' => $_POST['invoice_number'],
                'company_profile_id' => $_SESSION['ovalfox_pos_cp_id'],
                'customer_name' => !empty($_POST['customer_manual']) ? $customerId : $_POST['customer_name'],
                'booker_name' => $_POST['booker_name'],
                'operator_name' => $_POST['booker_name'],
                'date' => $_POST['date'],
                'discount' => 0,
                'bill_number' => $billNumber,
                'total_amount' => $_POST['total_amount'],
                'final_amount' => 0,
                'recevied_amount' => 0,
                'returned_amount' => 0,
                'pending_amount' => 0,
                'status' => "Incomplete"
            ]);
        } else {
            $pdo->update("sales_2", [
                'invoice_number' => $_POST['invoice_number'],
                'company_profile_id' => $_SESSION['ovalfox_pos_cp_id']
            ], [
                'total_amount' => $_POST['total_amount']
            ]);
        }

        // If the item is not already in sales_1, create it
        if (empty($sales_1)) {
            processSalesItem($pdo, $item_name, $customerId, $discount, $extra_discount);
        } else {
            updateSalesItem($pdo, $sales_1, $item_name);
        }
    }
}

// Function to process and create a sales_1 item
function processSalesItem($pdo, $item_name, $customerId, $discount, $extra_discount) {
    $quantity = (double)($_POST['quantity'] ?? 0);
    $item_price = (double)($_POST['item_price'] ?? 0);
    $total_price_before_discounts = $quantity * $item_price;
    $discount_percentage = $total_price_before_discounts > 0 
        ? round(((double)$discount / (double)$total_price_before_discounts) * 100, 2) 
        : 0;

    $pdo->create("sales_1", [
        'invoice_number' => $_POST['invoice_number'],
        'company_profile_id' => $_SESSION['ovalfox_pos_cp_id'],
        'customer_name' => !empty($_POST['customer_manual']) ? $customerId : $_POST['customer_name'],
        'booker_name' => $_POST['booker_name'],
        'operator_name' => $_POST['booker_name'],
        'date' => $_POST['date'],
        'item_code' => $_POST['item_code'],
        'item_name' => $item_name,
        'item_price' => $item_price,
        'quantity' => $quantity,
        'grand_total' => $_POST['isItemFree'] === "true" ? 0 : $total_price_before_discounts - $discount - $extra_discount,
        'percentage' => $discount_percentage,
        'amount' => $_POST['isItemFree'] === "true" ? 0 : ($_POST['taaup'] ?? 0),
        'discount' => round($discount, 2),
        'extra_discount' => round($extra_discount, 2)
    ]);
}

// Function to update a sales_1 item
function updateSalesItem($pdo, $sales_1, $item_name) {
    $quantity = (double)($sales_1[0]['quantity'] + $_POST['quantity']);
    $item_price = (double)($sales_1[0]['item_price']);
    $total_price_before_discounts = $quantity * $item_price;
    $discount_percentage = $total_price_before_discounts > 0 
        ? round($sales_1[0]['discount'] / $total_price_before_discounts * 100, 2) 
        : 0;

    $discountedValue = round($discount_percentage === 0 ? 0 
        : ($total_price_before_discounts * (1 - ($discount_percentage / 100))), 2);

    $pdo->update("sales_1", [
        'invoice_number' => $_POST['invoice_number'],
        'item_code' => $_POST['item_code'],
        'item_name' => $item_name,
        'company_profile_id' => $_SESSION['ovalfox_pos_cp_id']
    ], [
        'quantity' => $quantity,
        'amount' => $_POST['isItemFree'] === "true" ? 0 : $total_price_before_discounts,
        'percentage' => $discount_percentage,
        'discount' => $discountedValue !== 0 ? $total_price_before_discounts - $discountedValue : 0,
        'grand_total' => $_POST['isItemFree'] === "true" ? 0 : $discountedValue - $sales_1[0]['extra_discount']
    ]);
}

// Output the sales_1 records in a table
foreach ($sales_1 as $key => $sale) {
    $key += 1;
    $gt = !empty($sale['grand_total']) ? $sale['grand_total'] : $sale['amount'];
    $isEditable = !preg_match('/\(Refunded\)/', $sale['item_name']) && !preg_match('/\(Free Item\)/', $sale['item_name']) ? "contenteditable='true'" : "";
    ?>
<tr>
    <td style='font-size: 21px !important;font-weight:bolder;'><?php echo $key; ?></td>
    <td style='font-size: 13px !important;font-weight:bolder;' id='item_codeTabledData<?php echo $sale['id'];?>'>
        <?php echo $sale['item_code']; ?>
    </td>
    <td style='width:400px;font-size: 13px !important;font-weight:bolder;'
        id='item_nameTabledData<?php echo $sale['id'];?>'>
        <?php echo $sale['item_name']; ?>
    </td>
    <td style='font-size: 13px !important;font-weight:bolder;' id='quantityTabledData<?php echo $sale['id'];?>'
        <?php echo $isEditable; ?>>
        <?php echo $sale['quantity']; ?>
    </td>
    <td style='font-size: 13px !important;font-weight:bolder;' id='item_priceTabledData<?php echo $sale['id'];?>'
        <?php echo $isEditable; ?>>
        <?php echo $sale['item_price']; ?>
    </td>
    <td style='font-size: 13px !important;font-weight:bolder;' id='amountTabledData<?php echo $sale['id'];?>'>
        <?php echo round($sale['amount']); ?>
    </td>
    <td style='font-size: 13px !important;font-weight:bolder;' id='discountTabledData<?php echo $sale['id'];?>'>
        <?php echo round($sale['discount'], 2); ?>
    </td>
    <td style='font-size: 13px !important;font-weight:bolder;' id='extra_discountTabledData<?php echo $sale['id'];?>'
        <?php echo $isEditable; ?>>
        <?php echo $sale['extra_discount']; ?>
    </td>
    <td style='font-size: 13px !important;font-weight:bolder;' oninput="limitDecimalPlaces(this)"
        id='percentageTabledData<?php echo $sale['id'];?>' <?php echo $isEditable; ?>>
        <?php echo $sale['percentage']; ?>
    </td>
    <td style='font-size: 13px !important;font-weight:bolder;' id='grandTotalTabledData<?php echo $sale['id'];?>'>
        <?php echo $gt; ?>
    </td>
    <td style='font-size: 13px !important;font-weight:bolder;'>
        <div style='position: relative;' class='container-cus'>
            <div style='position: absolute; top: 0; left: 0; width: 100%; height: 100%; color: red; text-align: center; background-color: rgba(0, 0, 0, 1);'
                class='overlay-cus'>
                LOCKED
            </div>
            <div class='content-cus'>
                <button class="btn btn-danger btn-sm sales-btn-remove" value="<?php echo $sale['id']; ?>"
                    id="removeItem">Remove</button>
            </div>
        </div>
    </td>
</tr>
<?php
}
?>