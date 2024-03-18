<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>


</head>


<?php 

require_once 'assets/includes/pdo.php';
session_start();

$s = $_GET['s'];
$t = $_GET['t'];

$data = [];

if (!isset($s) || !isset($t)) {
    header('location:index.php');
} else {
    

    if ($t == "category") {
        $data = $pdo->customQuery("SELECT * FROM categories WHERE category LIKE '%$s%' OR created_at LIKE '%$s%' AND company_profile_id = {$_SESSION['ovalfox_pos_cp_id']};");
    } else if ($t == "subcategory") {
     
        $data = $pdo->customQuery("SELECT *
        FROM sub_categories
        INNER JOIN categories ON sub_categories.category_id = categories.id
        WHERE sub_category LIKE '%$s%' OR sub_categories.created_at LIKE '%$s%' AND sub_categories.company_profile_id = {$_SESSION['ovalfox_pos_cp_id']};");

    } else if ($t == "product") {
     
        $data = $pdo->customQuery("SELECT *
        FROM products
        INNER JOIN categories ON products.category_id = categories.id
        INNER JOIN sub_categories ON products.sub_category_id = sub_categories.id
        INNER JOIN stores ON products.store_id = stores.id
        WHERE item_code LIKE '%$s%' OR
              products.created_at LIKE '%$s%' OR
              stores.store_name LIKE '%$s%' OR
              sub_categories.sub_category LIKE '%$s%' OR
              categories.category LIKE '%$s%' OR
              product_name LIKE '%$s%' OR
              product_details LIKE '%$s%' OR
              purchase_per_unit_price LIKE '%$s%' OR
              purchase_per_box_price LIKE '%$s%' OR
              whole_sale_price LIKE '%$s%' OR
              trade_unit_price LIKE '%$s%' OR
              trade_box_price LIKE '%$s%' OR
              whole_sale_box_price LIKE '%$s%' OR
              quantity_per_box LIKE '%$s%' OR
              total_quantity LIKE '%$s%' OR
              row LIKE '%$s%' OR
              col LIKE '%$s%' OR
              discount LIKE '%$s%' OR
              low_stock_limit LIKE '%$s%'
              AND products.company_profile_id = {$_SESSION['ovalfox_pos_cp_id']};");

        } else if ($t == "customer") {
            
            $data = $pdo->customQuery("SELECT *
            FROM customers
            
            WHERE name LIKE '%$s%' OR
               
                cnic LIKE '%$s%' OR
                phone LIKE '%$s%' OR
                address LIKE '%$s%' OR
                balance LIKE '%$s%' OR
                bill_head LIKE '%$s%' OR
                created_at LIKE '%$s%'
                AND customers.company_profile_id = {$_SESSION['ovalfox_pos_cp_id']};");

        } else if ($t == "expensecategory") {
            
            $data = $pdo->customQuery("SELECT *
            FROM expense_categories
            
            WHERE name LIKE '%$s%' OR
               
                created_at LIKE '%$s%'
                AND expense_categories.company_profile_id = {$_SESSION['ovalfox_pos_cp_id']};");

        } else if ($t == "supplier") {
            
            $data = $pdo->customQuery("SELECT *
            FROM suppliers
            
            WHERE name LIKE '%$s%' OR
            dist_name LIKE '%$s%' OR
            cnic LIKE '%$s%' OR
            mobile LIKE '%$s%' OR
            office LIKE '%$s%' OR
            address LIKE '%$s%' OR
            dist_address LIKE '%$s%' OR
            balanace LIKE '%$s%' OR
            bill_head LIKE '%$s%' OR
               
                created_at LIKE '%$s%'
                AND suppliers.company_profile_id = {$_SESSION['ovalfox_pos_cp_id']};");

        } else if ($t == "gernelexpense") {
            
            $data = $pdo->customQuery("SELECT * FROM gernel_expenses
            INNER JOIN expense_categories ON gernel_expenses.expense_category_id = expense_categories.id

            WHERE expense_name LIKE '%$s%' OR
            expense_categories.name = '%$s%' OR
            date LIKE '%$s%' OR
            paid_by LIKE '%$s%' OR
            paid_to LIKE '%$s%' OR
            amount LIKE '%$s%' OR
            gernel_expenses.created_at LIKE '%$s%'
                AND gernel_expenses.company_profile_id = {$_SESSION['ovalfox_pos_cp_id']};");

        } else if ($t == "store") {
            
            $data = $pdo->customQuery("SELECT * FROM stores
           
            WHERE store_name LIKE '%$s%' OR
            store_details LIKE '%$s%' OR
            created_at LIKE '%$s%'
                AND company_profile_id = {$_SESSION['ovalfox_pos_cp_id']};");

        } else if ($t == "ledger") {
            
            $data = $pdo->customQuery("SELECT * FROM ledger
           
            WHERE date LIKE '%$s%' OR
            payment_type LIKE '%$s%' OR
            total_amount LIKE '%$s%' OR
            recevied_amount LIKE '%$s%' OR
            details LIKE '%$s%' OR
            payment_from LIKE '%$s%' OR
            dr LIKE '%$s%' OR
            cr LIKE '%$s%' OR
            remaining_amount LIKE '%$s%' OR
            status LIKE '%$s%' OR
            created_at LIKE '%$s%'
                AND company_profile_id = {$_SESSION['ovalfox_pos_cp_id']};");

        } else if ($t == "designation") {
            
            $data = $pdo->customQuery("SELECT * FROM designations
           
            WHERE name LIKE '%$s%' OR
            
            created_at LIKE '%$s%'
                AND company_profile_id = {$_SESSION['ovalfox_pos_cp_id']};");

        }
        
}



?>

<body>
    <div style="width: 90%;
   margin: 0 auto;
   padding: 20px;
   box-sizing: border-box;">

        <h2 style="text-align: center;text-decoration: underline;">Report</h2>

        <div style=" display: flex;
        justify-content: space-between;
        ">
            <table style="border-collapse: collapse;">
                <thead>

                    <tr>
                        <th>Date : <?php echo date("Y-m-d"); ?></th>
                    </tr>
                    <tr>
                        <th id="time"></th>
                    </tr>
                </thead>
            </table>
        </div>
        <br />

        <?php 
        if ($t == "category") {
        ?>

        <table style="border-collapse: collapse;">
            <thead style="padding: 10px;background-color: grey !important;color: white;">
                <tr>
                    <th style="padding-right: 20px; border-bottom: 1px solid black;">#</th>
                    <th style="padding-right: 100px; border-bottom: 1px solid black;">Category</th>
                    <th style="padding-right: 50px; border-bottom: 1px solid black;">CreatedAt</th>

                </tr>
            </thead>
            <tbody>

                <?php 
                foreach ($data as $d) {
                    
                
            ?>
                <tr>
                    <td style="padding-right: 20px; border-bottom: 1px solid black;"><?php echo $d['id']; ?></td>
                    <td style="padding-right: 100px; border-bottom: 1px solid black;"><?php echo $d['category']; ?>
                    </td>
                    <td style="padding-right: 50px; border-bottom: 1px solid black;"><?php echo $d['created_at']; ?>
                    </td>

                </tr>
                <?php } ?>

            </tbody>

        </table>
        <?php } else if ($t == "subcategory") {
        ?>
        <table style="border-collapse: collapse;">
            <thead style="padding: 10px;background-color: grey !important;color: white;">
                <tr>
                    <th style="padding-right: 20px; border-bottom: 1px solid black;">#</th>
                    <th style="padding-right: 100px; border-bottom: 1px solid black;">SubCategory</th>
                    <th style="padding-right: 100px; border-bottom: 1px solid black;">Category</th>

                    <th style="padding-right: 50px; border-bottom: 1px solid black;">CreatedAt</th>

                </tr>
            </thead>
            <tbody>

                <?php 
                foreach ($data as $d) {
                    
                
            ?>
                <tr>
                    <td style="padding-right: 20px; border-bottom: 1px solid black;"><?php echo $d['id']; ?></td>
                    <td style="padding-right: 100px; border-bottom: 1px solid black;"><?php echo $d['sub_category']; ?>
                    </td>
                    <td style="padding-right: 100px; border-bottom: 1px solid black;"><?php echo $d['category']; ?>

                    <td style="padding-right: 50px; border-bottom: 1px solid black;"><?php echo $d['created_at']; ?>
                    </td>

                </tr>
                <?php } ?>

            </tbody>

        </table>
        <?php } else if ($t == "product") {
        ?>
        <table style="border-collapse: collapse;">
            <thead style="padding: 10px;background-color: grey !important;color: white;">
                <tr>
                    <th style="padding-right: 20px; border-bottom: 1px solid black;">#</th>
                    <th style="padding-right: 100px; border-bottom: 1px solid black;">ItemCode</th>
                    <th style="padding-right: 100px; border-bottom: 1px solid black;">Category</th>
                    <th style="padding-right: 100px; border-bottom: 1px solid black;">SubCategory</th>
                    <th style="padding-right: 100px; border-bottom: 1px solid black;">ProductName</th>
                    <th style="padding-right: 100px; border-bottom: 1px solid black;">ProductDetails</th>
                    <th style="padding-right: 100px; border-bottom: 1px solid black;">PurchasePerUnitPrice</th>
                    <th style="padding-right: 100px; border-bottom: 1px solid black;">PurchasePerBoxPrice</th>
                    <th style="padding-right: 100px; border-bottom: 1px solid black;">WholesalePrice</th>
                    <th style="padding-right: 100px; border-bottom: 1px solid black;">TradeUnitPrice</th>
                    <th style="padding-right: 100px; border-bottom: 1px solid black;">TradeBoxPrice</th>
                    <th style="padding-right: 100px; border-bottom: 1px solid black;">WholesaleBoxPrice</th>
                    <th style="padding-right: 100px; border-bottom: 1px solid black;">QuantityPerBox</th>
                    <th style="padding-right: 100px; border-bottom: 1px solid black;">TotalQuantity</th>
                    <th style="padding-right: 100px; border-bottom: 1px solid black;">Store</th>
                    <th style="padding-right: 100px; border-bottom: 1px solid black;">Row</th>
                    <th style="padding-right: 100px; border-bottom: 1px solid black;">Col</th>
                    <th style="padding-right: 100px; border-bottom: 1px solid black;">Discount</th>
                    <th style="padding-right: 100px; border-bottom: 1px solid black;">LowStockLimit</th>

                    <th style="padding-right: 50px; border-bottom: 1px solid black;">CreatedAt</th>

                </tr>
            </thead>
            <tbody>

                <?php 
                foreach ($data as $d) {
                    
                
            ?>
                <tr>
                    <td style="padding-right: 20px; border-bottom: 1px solid black;"><?php echo $d['id']; ?></td>
                    <td style="padding-right: 100px; border-bottom: 1px solid black;"><?php echo $d['item_code']; ?>
                    </td>
                    <td style="padding-right: 100px; border-bottom: 1px solid black;"><?php echo $d['category']; ?>
                    <td style="padding-right: 100px; border-bottom: 1px solid black;"><?php echo $d['sub_category']; ?>
                    <td style="padding-right: 100px; border-bottom: 1px solid black;"><?php echo $d['product_name']; ?>
                    <td style="padding-right: 100px; border-bottom: 1px solid black;">
                        <?php echo $d['product_details']; ?>
                    <td style="padding-right: 100px; border-bottom: 1px solid black;">
                        <?php echo $d['purchase_per_unit_price']; ?>
                    <td style="padding-right: 100px; border-bottom: 1px solid black;">
                        <?php echo $d['purchase_per_box_price']; ?>
                    <td style="padding-right: 100px; border-bottom: 1px solid black;">
                        <?php echo $d['whole_sale_price']; ?>
                    <td style="padding-right: 100px; border-bottom: 1px solid black;">
                        <?php echo $d['trade_unit_price']; ?>
                    <td style="padding-right: 100px; border-bottom: 1px solid black;">
                        <?php echo $d['trade_box_price']; ?>
                    <td style="padding-right: 100px; border-bottom: 1px solid black;">
                        <?php echo $d['whole_sale_box_price']; ?>
                    <td style="padding-right: 100px; border-bottom: 1px solid black;">
                        <?php echo $d['quantity_per_box']; ?>
                    <td style="padding-right: 100px; border-bottom: 1px solid black;">
                        <?php echo $d['total_quantity']; ?>
                    <td style="padding-right: 100px; border-bottom: 1px solid black;"><?php echo $d['store_name']; ?>
                    <td style="padding-right: 100px; border-bottom: 1px solid black;"><?php echo $d['row']; ?>
                    <td style="padding-right: 100px; border-bottom: 1px solid black;"><?php echo $d['col']; ?>
                    <td style="padding-right: 100px; border-bottom: 1px solid black;"><?php echo $d['discount']; ?>
                    <td style="padding-right: 100px; border-bottom: 1px solid black;">
                        <?php echo $d['low_stock_limit']; ?>

                    <td style="padding-right: 50px; border-bottom: 1px solid black;"><?php echo $d['created_at']; ?>
                    </td>

                </tr>
                <?php } ?>

            </tbody>

        </table>
        <?php } else if ($t == "customer") {
        ?>
        <table style="border-collapse: collapse;">
            <thead style="padding: 10px;background-color: grey !important;color: white;">
                <tr>
                    <th style="padding-right: 20px; border-bottom: 1px solid black;">#</th>
                    <th style="padding-right: 100px; border-bottom: 1px solid black;">Name</th>
                    <th style="padding-right: 100px; border-bottom: 1px solid black;">CNIC</th>
                    <th style="padding-right: 100px; border-bottom: 1px solid black;">Phone</th>
                    <th style="padding-right: 100px; border-bottom: 1px solid black;">Address</th>
                    <th style="padding-right: 100px; border-bottom: 1px solid black;">Balance</th>
                    <th style="padding-right: 100px; border-bottom: 1px solid black;">BillHead</th>

                    <th style="padding-right: 50px; border-bottom: 1px solid black;">CreatedAt</th>

                </tr>
            </thead>
            <tbody>

                <?php 
                foreach ($data as $d) {
                    
                
            ?>
                <tr>
                    <td style="padding-right: 20px; border-bottom: 1px solid black;"><?php echo $d['id']; ?></td>
                    <td style="padding-right: 100px; border-bottom: 1px solid black;"><?php echo $d['name']; ?>
                    </td>
                    <td style="padding-right: 100px; border-bottom: 1px solid black;"><?php echo $d['cnic']; ?>
                    <td style="padding-right: 100px; border-bottom: 1px solid black;"><?php echo $d['phone']; ?>
                    <td style="padding-right: 100px; border-bottom: 1px solid black;"><?php echo $d['address']; ?>
                    <td style="padding-right: 100px; border-bottom: 1px solid black;"><?php echo $d['balance']; ?>
                    <td style="padding-right: 100px; border-bottom: 1px solid black;"><?php echo $d['bill_head']; ?>

                    <td style="padding-right: 50px; border-bottom: 1px solid black;"><?php echo $d['created_at']; ?>
                    </td>

                </tr>
                <?php } ?>

            </tbody>

        </table>
        <?php } else if ($t == "expensecategory") {
        ?>
        <table style="border-collapse: collapse;">
            <thead style="padding: 10px;background-color: grey !important;color: white;">
                <tr>
                    <th style="padding-right: 20px; border-bottom: 1px solid black;">#</th>
                    <th style="padding-right: 100px; border-bottom: 1px solid black;">Name</th>


                    <th style="padding-right: 50px; border-bottom: 1px solid black;">CreatedAt</th>

                </tr>
            </thead>
            <tbody>

                <?php 
                foreach ($data as $d) {
                    
                
            ?>
                <tr>
                    <td style="padding-right: 20px; border-bottom: 1px solid black;"><?php echo $d['id']; ?></td>
                    <td style="padding-right: 100px; border-bottom: 1px solid black;"><?php echo $d['name']; ?>
                    </td>
                    <td style="padding-right: 50px; border-bottom: 1px solid black;"><?php echo $d['created_at']; ?>
                    </td>

                </tr>
                <?php } ?>

            </tbody>

        </table>
        <?php } else if ($t == "supplier") {
        ?>
        <table style="border-collapse: collapse;">
            <thead style="padding: 10px;background-color: grey !important;color: white;">
                <tr>
                    <th style="padding-right: 10px;font-size: 15px; border-bottom: 1px solid black;">#</th>
                    <th style="padding-right: 10px;font-size: 15px; border-bottom: 1px solid black;">Name</th>
                    <th style="padding-right: 10px;font-size: 15px; border-bottom: 1px solid black;">DistName</th>

                    <th style="padding-right: 10px;font-size: 15px; border-bottom: 1px solid black;">CNIC</th>
                    <th style="padding-right: 10px;font-size: 15px; border-bottom: 1px solid black;">Mobile</th>
                    <th style="padding-right: 10px;font-size: 15px; border-bottom: 1px solid black;">Office</th>
                    <th style="padding-right: 10px;font-size: 15px; border-bottom: 1px solid black;">Address</th>
                    <th style="padding-right: 10px;font-size: 15px; border-bottom: 1px solid black;">DistAddress</th>
                    <th style="padding-right: 10px;font-size: 15px; border-bottom: 1px solid black;">Balance</th>
                    <th style="padding-right: 10px;font-size: 15px; border-bottom: 1px solid black;">BillHead</th>

                    <th style="padding-right: 50px;font-size: 15px; border-bottom: 1px solid black;">CreatedAt</th>

                </tr>
            </thead>
            <tbody>

                <?php 
                foreach ($data as $d) {
                    
                
            ?>
                <tr>
                    <td style="padding-right: 10px; border-bottom: 1px solid black;"><?php echo $d['id']; ?></td>
                    <td style="padding-right: 10px; border-bottom: 1px solid black;"><?php echo $d['name']; ?>
                    </td>
                    <td style="padding-right: 10px; border-bottom: 1px solid black;"><?php echo $d['dist_name']; ?>
                    </td>
                    <td style="padding-right: 10px; border-bottom: 1px solid black;"><?php echo $d['cnic']; ?>
                    </td>
                    <td style="padding-right: 10px; border-bottom: 1px solid black;"><?php echo $d['mobile']; ?>
                    </td>
                    <td style="padding-right: 10px; border-bottom: 1px solid black;"><?php echo $d['office']; ?>
                    </td>
                    <td style="padding-right: 10px; border-bottom: 1px solid black;"><?php echo $d['address']; ?>
                    </td>
                    <td style="padding-right: 10px; border-bottom: 1px solid black;"><?php echo $d['dist_address']; ?>
                    </td>
                    <td style="padding-right: 10px; border-bottom: 1px solid black;"><?php echo $d['balanace']; ?>
                    </td>
                    <td style="padding-right: 10px; border-bottom: 1px solid black;"><?php echo $d['bill_head']; ?>
                    </td>
                    <td style="padding-right: 50px; border-bottom: 1px solid black;"><?php echo $d['created_at']; ?>
                    </td>

                </tr>
                <?php } ?>

            </tbody>

        </table>
        <?php } else if ($t == "gernelexpense") {
        ?>
        <table style="border-collapse: collapse;">
            <thead style="padding: 10px;background-color: grey !important;color: white;">
                <tr>
                    <th style="padding-right: 10px;font-size: 15px; border-bottom: 1px solid black;">#</th>
                    <th style="padding-right: 10px;font-size: 15px; border-bottom: 1px solid black;">Category</th>
                    <th style="padding-right: 10px;font-size: 15px; border-bottom: 1px solid black;">Name</th>
                    <th style="padding-right: 10px;font-size: 15px; border-bottom: 1px solid black;">Date</th>

                    <th style="padding-right: 10px;font-size: 15px; border-bottom: 1px solid black;">PaidBy</th>
                    <th style="padding-right: 10px;font-size: 15px; border-bottom: 1px solid black;">PaidTo</th>
                    <th style="padding-right: 10px;font-size: 15px; border-bottom: 1px solid black;">Amount</th>


                    <th style="padding-right: 50px;font-size: 15px; border-bottom: 1px solid black;">CreatedAt</th>

                </tr>
            </thead>
            <tbody>

                <?php 
                foreach ($data as $d) {
                    
                
            ?>
                <tr>
                    <td style="padding-right: 10px; border-bottom: 1px solid black;"><?php echo $d['id']; ?></td>
                    <td style="padding-right: 10px; border-bottom: 1px solid black;"><?php echo $d['name']; ?>
                    </td>
                    <td style="padding-right: 10px; border-bottom: 1px solid black;"><?php echo $d['expense_name']; ?>
                    </td>
                    <td style="padding-right: 10px; border-bottom: 1px solid black;"><?php echo $d['date']; ?>
                    </td>
                    <td style="padding-right: 10px; border-bottom: 1px solid black;"><?php echo $d['paid_by']; ?>
                    </td>
                    <td style="padding-right: 10px; border-bottom: 1px solid black;"><?php echo $d['paid_to']; ?>
                    </td>
                    <td style="padding-right: 10px; border-bottom: 1px solid black;"><?php echo $d['amount']; ?>
                    </td>

                    <td style="padding-right: 50px; border-bottom: 1px solid black;"><?php echo $d['created_at']; ?>
                    </td>

                </tr>
                <?php } ?>

            </tbody>

        </table>
        <?php } else if ($t == "store") {
        ?>
        <table style="border-collapse: collapse;">
            <thead style="padding: 10px;background-color: grey !important;color: white;">
                <tr>
                    <th style="padding-right: 10px;font-size: 15px; border-bottom: 1px solid black;">#</th>
                    <th style="padding-right: 10px;font-size: 15px; border-bottom: 1px solid black;">Store</th>
                    <th style="padding-right: 10px;font-size: 15px; border-bottom: 1px solid black;">StoreDetails</th>



                    <th style="padding-right: 50px;font-size: 15px; border-bottom: 1px solid black;">CreatedAt</th>

                </tr>
            </thead>
            <tbody>

                <?php 
                foreach ($data as $d) {
                    
                
            ?>
                <tr>
                    <td style="padding-right: 10px; border-bottom: 1px solid black;"><?php echo $d['id']; ?></td>
                    <td style="padding-right: 10px; border-bottom: 1px solid black;"><?php echo $d['store_name']; ?>
                    </td>
                    <td style="padding-right: 10px; border-bottom: 1px solid black;"><?php echo $d['store_details']; ?>
                    </td>

                    <td style="padding-right: 50px; border-bottom: 1px solid black;"><?php echo $d['created_at']; ?>
                    </td>

                </tr>
                <?php } ?>

            </tbody>

        </table>



        <?php } else if ($t == "ledger") {
        ?>
        <table style="border-collapse: collapse;">
            <thead style="padding: 10px;background-color: grey !important;color: white;">
                <tr>
                    <th style="padding-right: 10px;font-size: 15px; border-bottom: 1px solid black;">#</th>
                    <th style="padding-right: 10px;font-size: 15px; border-bottom: 1px solid black;">Date</th>
                    <th style="padding-right: 10px;font-size: 15px; border-bottom: 1px solid black;">PaymentType</th>
                    <th style="padding-right: 10px;font-size: 15px; border-bottom: 1px solid black;">TotalAmount</th>
                    <th style="padding-right: 10px;font-size: 15px; border-bottom: 1px solid black;">ReceviedAmount</th>
                    <th style="padding-right: 10px;font-size: 15px; border-bottom: 1px solid black;">Details</th>

                    <th style="padding-right: 10px;font-size: 15px; border-bottom: 1px solid black;">PaymentFrom</th>
                    <th style="padding-right: 10px;font-size: 15px; border-bottom: 1px solid black;">Dr</th>
                    <th style="padding-right: 10px;font-size: 15px; border-bottom: 1px solid black;">Cr</th>
                    <th style="padding-right: 10px;font-size: 15px; border-bottom: 1px solid black;">RemainingAmount
                    </th>
                    <th style="padding-right: 10px;font-size: 15px; border-bottom: 1px solid black;">Status</th>


                    <th style="padding-right: 50px;font-size: 15px; border-bottom: 1px solid black;">Created at</th>

                </tr>
            </thead>
            <tbody>

                <?php 
                foreach ($data as $d) {
                    
                
            ?>
                <tr>
                    <td style="padding-right: 10px; border-bottom: 1px solid black;"><?php echo $d['id']; ?></td>
                    <td style="padding-right: 10px; border-bottom: 1px solid black;"><?php echo $d['date']; ?>
                    </td>
                    <td style="padding-right: 10px; border-bottom: 1px solid black;"><?php echo $d['payment_type']; ?>
                    </td>
                    <td style="padding-right: 10px; border-bottom: 1px solid black;"><?php echo $d['total_amount']; ?>
                    </td>
                    <td style="padding-right: 10px; border-bottom: 1px solid black;">
                        <?php echo $d['recevied_amount']; ?>
                    </td>
                    <td style="padding-right: 10px; border-bottom: 1px solid black;"><?php echo $d['details']; ?>
                    </td>
                    <td style="padding-right: 10px; border-bottom: 1px solid black;"><?php echo $d['payment_from']; ?>
                    </td>
                    <td style="padding-right: 10px; border-bottom: 1px solid black;"><?php echo $d['dr']; ?>
                    </td>
                    <td style="padding-right: 10px; border-bottom: 1px solid black;"><?php echo $d['cr']; ?>
                    </td>
                    <td style="padding-right: 10px; border-bottom: 1px solid black;">
                        <?php echo $d['remaining_amount']; ?>
                    </td>
                    <td style="padding-right: 10px; border-bottom: 1px solid black;"><?php echo $d['status']; ?>
                    </td>
                    <td style="padding-right: 50px; border-bottom: 1px solid black;"><?php echo $d['created_at']; ?>
                    </td>

                </tr>
                <?php } ?>

            </tbody>

        </table>
        <?php } else if ($t == "designation") {
        ?>
        <table style="border-collapse: collapse;">
            <thead style="padding: 10px;background-color: grey !important;color: white;">
                <tr>
                    <th style="padding-right: 10px;font-size: 15px; border-bottom: 1px solid black;">#</th>
                    <th style="padding-right: 10px;font-size: 15px; border-bottom: 1px solid black;">Name</th>
                    <th style="padding-right: 50px;font-size: 15px; border-bottom: 1px solid black;">CreatedAt</th>

                </tr>
            </thead>
            <tbody>

                <?php 
                foreach ($data as $d) {
                    
                
            ?>
                <tr>
                    <td style="padding-right: 10px; border-bottom: 1px solid black;"><?php echo $d['id']; ?></td>
                    <td style="padding-right: 10px; border-bottom: 1px solid black;"><?php echo $d['name']; ?>
                    </td>


                    <td style="padding-right: 50px; border-bottom: 1px solid black;"><?php echo $d['created_at']; ?>
                    </td>

                </tr>
                <?php } ?>

            </tbody>

        </table>


        <?php } ?>
        <br />
        <br />


    </div>

    <script src="assets/js/jquery.min.js"></script>
    <script>
    $(document).ready(e => {
        var currentTime = new Date();

        // Get the current hour, minute, and second
        var hours = currentTime.getHours();
        var minutes = currentTime.getMinutes();
        var seconds = currentTime.getSeconds();
        // Determine if it's AM or PM
        var period = hours < 12 ? "AM" : "PM";

        // Adjust hours for AM/PM format
        hours = hours % 12;
        hours = hours ? hours : 12; // Handle midnight (0 hours)
        const time = `Time : ${hours}:${minutes}:${seconds} ${period}`;
        document.getElementById("time").textContent = time;





    });
    </script>
</body>

</html>