<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report</title>
    <style>
    * {
        padding: 0;
        margin: 0;
    }
    </style>

</head>


<?php 

require_once 'assets/includes/pdo.php';
session_start();

$s = !empty($_GET['s']) ? $_GET['s'] : "" ;
$t = !empty($_GET['t']) ? $_GET['t'] : "";
$rp_name = "";

$data = [];


    $company = $pdo->read("companies_profile", ['id' => $_SESSION['ovalfox_pos_cp_id']]);

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

        } else if ($t == "sales_1") {

            $base64Decoded = base64_decode($_GET['s']);



            $utf8Encoded = mb_convert_encoding($base64Decoded, 'UTF-8', 'UTF-8');

            $jsonDecoded = json_decode($utf8Encoded, true);




            $data = $jsonDecoded;
            $rp_name = "Sales Report";
        } else if ($t == "sales_2") {

            $base64Decoded = base64_decode($_GET['s']);



            $utf8Encoded = mb_convert_encoding($base64Decoded, 'UTF-8', 'UTF-8');

            $jsonDecoded = json_decode($utf8Encoded, true);




            $data = $jsonDecoded;
            $rp_name = "Sales Report";
        }  else if ($t == "purchases_1") {

            $base64Decoded = base64_decode($_GET['s']);



            $utf8Encoded = mb_convert_encoding($base64Decoded, 'UTF-8', 'UTF-8');

            $jsonDecoded = json_decode($utf8Encoded, true);




            $data = $jsonDecoded;
            $rp_name = "Purchase Report";
        }else if (isset($_POST['t']) && $_POST['t'] == "search_daily") {
            $base64EncodedJson = $_POST['s'];
            $base64Decoded = base64_decode($base64EncodedJson);

            $utf8Encoded = mb_convert_encoding($base64Decoded, 'UTF-8', 'UTF-8');
            $jsonDecoded = json_decode($utf8Encoded, true);


            $data = $jsonDecoded;
            $rp_name = "Search Daily Report";
        } else if (isset($_POST['t']) && $_POST['t'] == "search_item_wise") {
            $base64EncodedJson = $_POST['s'];
            $base64Decoded = base64_decode($base64EncodedJson);

            $utf8Encoded = mb_convert_encoding($base64Decoded, 'UTF-8', 'UTF-8');
            $jsonDecoded = json_decode($utf8Encoded, true);


            $data = $jsonDecoded;
            $rp_name = "Search Item Wise Report";

        }
        




?>

<body>
    <div style="width: 100% !important;">
        <div style="display: flex;flex-direction: row;justify-content:space-between">
            <div>
                <h4> <?php echo $rp_name; ?>
                </h4>
                <h1 style="" id="company_name">
                    <?php echo $company[0]['company_name']; ?>
                </h1>
                <p>
                    <?php echo $company[0]['address']; ?>

                </p>
                <h3>Email: <?php echo $company[0]['email']; ?></h3>

            </div>
            <div>
                <h3>Ph1. <?php echo $company[0]['phone1']; ?></h3>
                <h3>Ph2. <?php echo $company[0]['phone2']; ?></h3>
                <h3>Ph3. <?php echo $company[0]['phone3']; ?></h3>

            </div>
        </div>

        <?php 
        if ($t == "category") {
        ?>

        <table style="border-collapse: collapse;width: 100% !important;">
            <thead style="border-left: 1px solid black;background-color: grey !important;color: white;">
                <tr>
                    <th style=" border-bottom: 1px solid black;border-right: 1px solid black;">#</th>
                    <th style=" border-bottom: 1px solid black;border-right: 1px solid black;">Ctg</th>
                    <th style=" border-bottom: 1px solid black;border-right: 1px solid black;">Crd.At</th>

                </tr>
            </thead>
            <tbody>

                <?php 
                foreach ($data as $d) {
                    
                
            ?>
                <tr>
                    <td
                        style=" border-bottom: 1px solid black;border-right: 1px solid black;font-size: 8pt !important;border-left: 1px solid black;">
                        <?php echo $d['id']; ?></td>
                    <td
                        style=" border-bottom: 1px solid black;border-right: 1px solid black;font-size: 8pt !important;">
                        <?php echo $d['category']; ?>
                    </td>
                    <td
                        style=" border-bottom: 1px solid black;border-right: 1px solid black;font-size: 8pt !important;">
                        <?php echo $d['created_at']; ?>
                    </td>

                </tr>
                <?php } ?>

            </tbody>

        </table>
        <?php } else if ($t == "subcategory") {
        ?>
        <table style="border-collapse: collapse;width: 100% !important;">
            <thead style="border-left: 1px solid black;background-color: grey !important;color: white;">
                <tr>
                    <th style=" border-bottom: 1px solid black;border-right: 1px solid black;">#</th>
                    <th style=" border-bottom: 1px solid black;border-right: 1px solid black;">S.Ctg</th>
                    <th style=" border-bottom: 1px solid black;border-right: 1px solid black;">Ctg</th>

                    <th style=" border-bottom: 1px solid black;border-right: 1px solid black;">Crd.At</th>

                </tr>
            </thead>
            <tbody>

                <?php 
                foreach ($data as $d) {
                    
                
            ?>
                <tr>
                    <td
                        style=" border-bottom: 1px solid black;border-right: 1px solid black;font-size: 8pt !important;border-left: 1px solid black;">
                        <?php echo $d['id']; ?></td>
                    <td
                        style=" border-bottom: 1px solid black;border-right: 1px solid black;font-size: 8pt !important;">
                        <?php echo $d['sub_category']; ?>
                    </td>
                    <td
                        style=" border-bottom: 1px solid black;border-right: 1px solid black;font-size: 8pt !important;">
                        <?php echo $d['category']; ?>

                    <td
                        style=" border-bottom: 1px solid black;border-right: 1px solid black;font-size: 8pt !important;">
                        <?php echo $d['created_at']; ?>
                    </td>

                </tr>
                <?php } ?>

            </tbody>

        </table>
        <?php } else if ($t == "product") {
        ?>
        <table style="border-collapse: collapse;width: 100% !important;">
            <thead style="border-left: 1px solid black;background-color: grey !important;color: white;">
                <tr>
                    <th style=" border-bottom: 1px solid black;border-right: 1px solid black;">#</th>
                    <th style=" border-bottom: 1px solid black;border-right: 1px solid black;">it.Cde</th>
                    <th style=" border-bottom: 1px solid black;border-right: 1px solid black;">Ctg</th>
                    <th style=" border-bottom: 1px solid black;border-right: 1px solid black;">S.Ctg</th>
                    <th style=" border-bottom: 1px solid black;border-right: 1px solid black;">P.Nme</th>
                    <th style=" border-bottom: 1px solid black;border-right: 1px solid black;">P.Dtls</th>
                    <th style=" border-bottom: 1px solid black;border-right: 1px solid black;">Pr.Prc</th>
                    <th style=" border-bottom: 1px solid black;border-right: 1px solid black;">Pr.Bx.Prc</th>
                    <th style=" border-bottom: 1px solid black;border-right: 1px solid black;">Whl.Prc</th>
                    <th style=" border-bottom: 1px solid black;border-right: 1px solid black;">Trd.Prc</th>
                    <th style=" border-bottom: 1px solid black;border-right: 1px solid black;">Trd.Bx.Prc</th>
                    <th style=" border-bottom: 1px solid black;border-right: 1px solid black;">Whl.Bx.Prc</th>
                    <th style=" border-bottom: 1px solid black;border-right: 1px solid black;">Qty.Pr.Bx</th>
                    <th style=" border-bottom: 1px solid black;border-right: 1px solid black;">T.Qty</th>
                    <th style=" border-bottom: 1px solid black;border-right: 1px solid black;">Str</th>
                    <th style=" border-bottom: 1px solid black;border-right: 1px solid black;">Rw</th>
                    <th style=" border-bottom: 1px solid black;border-right: 1px solid black;">Cl</th>
                    <th style=" border-bottom: 1px solid black;border-right: 1px solid black;">Dis</th>
                    <th style=" border-bottom: 1px solid black;border-right: 1px solid black;">Lw.St.Lim</th>

                    <th style=" border-bottom: 1px solid black;border-right: 1px solid black;">Crd.At</th>

                </tr>
            </thead>
            <tbody>

                <?php 
                foreach ($data as $d) {
                    
                
            ?>
                <tr>
                    <td
                        style=" border-bottom: 1px solid black;border-right: 1px solid black;font-size: 8pt !important;border-left: 1px solid black;">
                        <?php echo $d['id']; ?></td>
                    <td
                        style=" border-bottom: 1px solid black;border-right: 1px solid black;font-size: 8pt !important;">
                        <?php echo $d['item_code']; ?>
                    </td>
                    <td
                        style=" border-bottom: 1px solid black;border-right: 1px solid black;font-size: 8pt !important;">
                        <?php echo $d['category']; ?>
                    <td
                        style=" border-bottom: 1px solid black;border-right: 1px solid black;font-size: 8pt !important;">
                        <?php echo $d['sub_category']; ?>
                    <td
                        style=" border-bottom: 1px solid black;border-right: 1px solid black;font-size: 8pt !important;">
                        <?php echo $d['product_name']; ?>
                    <td
                        style=" border-bottom: 1px solid black;border-right: 1px solid black;font-size: 8pt !important;">
                        <?php echo $d['product_details']; ?>
                    <td
                        style=" border-bottom: 1px solid black;border-right: 1px solid black;font-size: 8pt !important;">
                        <?php echo $d['purchase_per_unit_price']; ?>
                    <td
                        style=" border-bottom: 1px solid black;border-right: 1px solid black;font-size: 8pt !important;">
                        <?php echo $d['purchase_per_box_price']; ?>
                    <td
                        style=" border-bottom: 1px solid black;border-right: 1px solid black;font-size: 8pt !important;">
                        <?php echo $d['whole_sale_price']; ?>
                    <td
                        style=" border-bottom: 1px solid black;border-right: 1px solid black;font-size: 8pt !important;">
                        <?php echo $d['trade_unit_price']; ?>
                    <td
                        style=" border-bottom: 1px solid black;border-right: 1px solid black;font-size: 8pt !important;">
                        <?php echo $d['trade_box_price']; ?>
                    <td
                        style=" border-bottom: 1px solid black;border-right: 1px solid black;font-size: 8pt !important;">
                        <?php echo $d['whole_sale_box_price']; ?>
                    <td
                        style=" border-bottom: 1px solid black;border-right: 1px solid black;font-size: 8pt !important;">
                        <?php echo $d['quantity_per_box']; ?>
                    <td
                        style=" border-bottom: 1px solid black;border-right: 1px solid black;font-size: 8pt !important;">
                        <?php echo $d['total_quantity']; ?>
                    <td
                        style=" border-bottom: 1px solid black;border-right: 1px solid black;font-size: 8pt !important;">
                        <?php echo $d['store_name']; ?>
                    <td
                        style=" border-bottom: 1px solid black;border-right: 1px solid black;font-size: 8pt !important;">
                        <?php echo $d['row']; ?>
                    <td
                        style=" border-bottom: 1px solid black;border-right: 1px solid black;font-size: 8pt !important;">
                        <?php echo $d['col']; ?>
                    <td
                        style=" border-bottom: 1px solid black;border-right: 1px solid black;font-size: 8pt !important;">
                        <?php echo $d['discount']; ?>
                    <td
                        style=" border-bottom: 1px solid black;border-right: 1px solid black;font-size: 8pt !important;">
                        <?php echo $d['low_stock_limit']; ?>

                    <td
                        style=" border-bottom: 1px solid black;border-right: 1px solid black;font-size: 8pt !important;">
                        <?php echo $d['created_at']; ?>
                    </td>

                </tr>
                <?php } ?>

            </tbody>

        </table>
        <?php } else if ($t == "customer") {
        ?>
        <table style="border-collapse: collapse;width: 100% !important;">
            <thead style="border-left: 1px solid black;background-color: grey !important;color: white;">
                <tr>
                    <th style=" border-bottom: 1px solid black;border-right: 1px solid black;">#</th>
                    <th style=" border-bottom: 1px solid black;border-right: 1px solid black;">Nme</th>
                    <th style=" border-bottom: 1px solid black;border-right: 1px solid black;">CNIC</th>
                    <th style=" border-bottom: 1px solid black;border-right: 1px solid black;">Ph</th>
                    <th style=" border-bottom: 1px solid black;border-right: 1px solid black;">Add</th>
                    <th style=" border-bottom: 1px solid black;border-right: 1px solid black;">Blnc</th>
                    <th style=" border-bottom: 1px solid black;border-right: 1px solid black;">B.hd</th>

                    <th style=" border-bottom: 1px solid black;border-right: 1px solid black;">Crd.At</th>

                </tr>
            </thead>
            <tbody>

                <?php 
                foreach ($data as $d) {
                    
                
            ?>
                <tr>
                    <td
                        style=" border-bottom: 1px solid black;border-right: 1px solid black;font-size: 8pt !important;border-left: 1px solid black;">
                        <?php echo $d['id']; ?></td>
                    <td
                        style=" border-bottom: 1px solid black;border-right: 1px solid black;font-size: 8pt !important;">
                        <?php echo $d['name']; ?>
                    </td>
                    <td
                        style=" border-bottom: 1px solid black;border-right: 1px solid black;font-size: 8pt !important;">
                        <?php echo $d['cnic']; ?>
                    <td
                        style=" border-bottom: 1px solid black;border-right: 1px solid black;font-size: 8pt !important;">
                        <?php echo $d['phone']; ?>
                    <td
                        style=" border-bottom: 1px solid black;border-right: 1px solid black;font-size: 8pt !important;">
                        <?php echo $d['address']; ?>
                    <td
                        style=" border-bottom: 1px solid black;border-right: 1px solid black;font-size: 8pt !important;">
                        <?php echo $d['balance']; ?>
                    <td
                        style=" border-bottom: 1px solid black;border-right: 1px solid black;font-size: 8pt !important;">
                        <?php echo $d['bill_head']; ?>

                    <td
                        style=" border-bottom: 1px solid black;border-right: 1px solid black;font-size: 8pt !important;">
                        <?php echo $d['created_at']; ?>
                    </td>

                </tr>
                <?php } ?>

            </tbody>

        </table>
        <?php } else if ($t == "expensecategory") {
        ?>
        <table style="border-collapse: collapse;width: 100% !important;">
            <thead style="border-left: 1px solid black;background-color: grey !important;color: white;">
                <tr>
                    <th style=" border-bottom: 1px solid black;border-right: 1px solid black;">#</th>
                    <th style=" border-bottom: 1px solid black;border-right: 1px solid black;">Nme</th>


                    <th style=" border-bottom: 1px solid black;border-right: 1px solid black;">Crd.At</th>

                </tr>
            </thead>
            <tbody>

                <?php 
                foreach ($data as $d) {
                    
                
            ?>
                <tr>
                    <td
                        style=" border-bottom: 1px solid black;border-right: 1px solid black;font-size: 8pt !important;border-left: 1px solid black;">
                        <?php echo $d['id']; ?></td>
                    <td
                        style=" border-bottom: 1px solid black;border-right: 1px solid black;font-size: 8pt !important;">
                        <?php echo $d['name']; ?>
                    </td>
                    <td
                        style=" border-bottom: 1px solid black;border-right: 1px solid black;font-size: 8pt !important;">
                        <?php echo $d['created_at']; ?>
                    </td>

                </tr>
                <?php } ?>

            </tbody>

        </table>
        <?php } else if ($t == "supplier") {
        ?>
        <table style="border-collapse: collapse;width: 100% !important;">
            <thead style="border-left: 1px solid black;background-color: grey !important;color: white;">
                <tr>
                    <th style="font-size: 12px; border-bottom: 1px solid black;border-right: 1px solid black;">#</th>
                    <th style="font-size: 12px; border-bottom: 1px solid black;border-right: 1px solid black;">Name</th>
                    <th style="font-size: 12px; border-bottom: 1px solid black;border-right: 1px solid black;">Dst.Nme
                    </th>

                    <th style="font-size: 12px; border-bottom: 1px solid black;border-right: 1px solid black;">CNIC</th>
                    <th style="font-size: 12px; border-bottom: 1px solid black;border-right: 1px solid black;">Mbl</th>
                    <th style="font-size: 12px; border-bottom: 1px solid black;border-right: 1px solid black;">Ofc</th>
                    <th style="font-size: 12px; border-bottom: 1px solid black;border-right: 1px solid black;">Add</th>
                    <th style="font-size: 12px; border-bottom: 1px solid black;border-right: 1px solid black;">D.Add
                    </th>
                    <th style="font-size: 12px; border-bottom: 1px solid black;border-right: 1px solid black;">Blnc</th>
                    <th style="font-size: 12px; border-bottom: 1px solid black;border-right: 1px solid black;">B.hd</th>

                    <th style="font-size: 12px; border-bottom: 1px solid black;border-right: 1px solid black;">Crd.At
                    </th>

                </tr>
            </thead>
            <tbody>

                <?php 
                foreach ($data as $d) {
                    
                
            ?>
                <tr>
                    <td
                        style=" border-bottom: 1px solid black;border-right: 1px solid black;font-size: 8pt !important;border-left: 1px solid black;">
                        <?php echo $d['id']; ?></td>
                    <td
                        style=" border-bottom: 1px solid black;border-right: 1px solid black;font-size: 8pt !important;">
                        <?php echo $d['name']; ?>
                    </td>
                    <td
                        style=" border-bottom: 1px solid black;border-right: 1px solid black;font-size: 8pt !important;">
                        <?php echo $d['dist_name']; ?>
                    </td>
                    <td
                        style=" border-bottom: 1px solid black;border-right: 1px solid black;font-size: 8pt !important;">
                        <?php echo $d['cnic']; ?>
                    </td>
                    <td
                        style=" border-bottom: 1px solid black;border-right: 1px solid black;font-size: 8pt !important;">
                        <?php echo $d['mobile']; ?>
                    </td>
                    <td
                        style=" border-bottom: 1px solid black;border-right: 1px solid black;font-size: 8pt !important;">
                        <?php echo $d['office']; ?>
                    </td>
                    <td
                        style=" border-bottom: 1px solid black;border-right: 1px solid black;font-size: 8pt !important;">
                        <?php echo $d['address']; ?>
                    </td>
                    <td
                        style=" border-bottom: 1px solid black;border-right: 1px solid black;font-size: 8pt !important;">
                        <?php echo $d['dist_address']; ?>
                    </td>
                    <td
                        style=" border-bottom: 1px solid black;border-right: 1px solid black;font-size: 8pt !important;">
                        <?php echo $d['balanace']; ?>
                    </td>
                    <td
                        style=" border-bottom: 1px solid black;border-right: 1px solid black;font-size: 8pt !important;">
                        <?php echo $d['bill_head']; ?>
                    </td>
                    <td
                        style=" border-bottom: 1px solid black;border-right: 1px solid black;font-size: 8pt !important;">
                        <?php echo $d['created_at']; ?>
                    </td>

                </tr>
                <?php } ?>

            </tbody>

        </table>
        <?php } else if ($t == "gernelexpense") {
        ?>
        <table style="border-collapse: collapse;width: 100% !important;">
            <thead style="border-left: 1px solid black;background-color: grey !important;color: white;">
                <tr>
                    <th style="font-size: 12px; border-bottom: 1px solid black;border-right: 1px solid black;">#</th>
                    <th style="font-size: 12px; border-bottom: 1px solid black;border-right: 1px solid black;">Ctgy</th>
                    <th style="font-size: 12px; border-bottom: 1px solid black;border-right: 1px solid black;">Nme</th>
                    <th style="font-size: 12px; border-bottom: 1px solid black;border-right: 1px solid black;">Dte</th>

                    <th style="font-size: 12px; border-bottom: 1px solid black;border-right: 1px solid black;">Pd.By
                    </th>
                    <th style="font-size: 12px; border-bottom: 1px solid black;border-right: 1px solid black;">Pd.To
                    </th>
                    <th style="font-size: 12px; border-bottom: 1px solid black;border-right: 1px solid black;">Amnt</th>


                    <th style="font-size: 12px; border-bottom: 1px solid black;border-right: 1px solid black;">Crd.At
                    </th>

                </tr>
            </thead>
            <tbody>

                <?php 
                foreach ($data as $d) {
                    
                
            ?>
                <tr>
                    <td
                        style=" border-bottom: 1px solid black;border-right: 1px solid black;font-size: 8pt !important;border-left: 1px solid black;">
                        <?php echo $d['id']; ?></td>
                    <td
                        style=" border-bottom: 1px solid black;border-right: 1px solid black;font-size: 8pt !important;">
                        <?php echo $d['name']; ?>
                    </td>
                    <td
                        style=" border-bottom: 1px solid black;border-right: 1px solid black;font-size: 8pt !important;">
                        <?php echo $d['expense_name']; ?>
                    </td>
                    <td
                        style=" border-bottom: 1px solid black;border-right: 1px solid black;font-size: 8pt !important;">
                        <?php echo $d['date']; ?>
                    </td>
                    <td
                        style=" border-bottom: 1px solid black;border-right: 1px solid black;font-size: 8pt !important;">
                        <?php echo $d['paid_by']; ?>
                    </td>
                    <td
                        style=" border-bottom: 1px solid black;border-right: 1px solid black;font-size: 8pt !important;">
                        <?php echo $d['paid_to']; ?>
                    </td>
                    <td
                        style=" border-bottom: 1px solid black;border-right: 1px solid black;font-size: 8pt !important;">
                        <?php echo $d['amount']; ?>
                    </td>

                    <td
                        style=" border-bottom: 1px solid black;border-right: 1px solid black;font-size: 8pt !important;">
                        <?php echo $d['created_at']; ?>
                    </td>

                </tr>
                <?php } ?>

            </tbody>

        </table>
        <?php } else if ($t == "store") {
        ?>
        <table style="border-collapse: collapse;width: 100% !important;">
            <thead style="border-left: 1px solid black;background-color: grey !important;color: white;">
                <tr>
                    <th style="font-size: 12px; border-bottom: 1px solid black;border-right: 1px solid black;">#</th>
                    <th style="font-size: 12px; border-bottom: 1px solid black;border-right: 1px solid black;">Str</th>
                    <th style="font-size: 12px; border-bottom: 1px solid black;border-right: 1px solid black;">Str.Dtls
                    </th>



                    <th style="font-size: 12px; border-bottom: 1px solid black;border-right: 1px solid black;">Crd.At
                    </th>

                </tr>
            </thead>
            <tbody>

                <?php 
                foreach ($data as $d) {
                    
                
            ?>
                <tr>
                    <td
                        style=" border-bottom: 1px solid black;border-right: 1px solid black;font-size: 8pt !important;border-left: 1px solid black;">
                        <?php echo $d['id']; ?></td>
                    <td
                        style=" border-bottom: 1px solid black;border-right: 1px solid black;font-size: 8pt !important;">
                        <?php echo $d['store_name']; ?>
                    </td>
                    <td
                        style=" border-bottom: 1px solid black;border-right: 1px solid black;font-size: 8pt !important;">
                        <?php echo $d['store_details']; ?>
                    </td>

                    <td
                        style=" border-bottom: 1px solid black;border-right: 1px solid black;font-size: 8pt !important;">
                        <?php echo $d['created_at']; ?>
                    </td>

                </tr>
                <?php } ?>

            </tbody>

        </table>



        <?php } else if ($t == "ledger") {
        ?>
        <table style="border-collapse: collapse;width: 100% !important;">
            <thead style="border-left: 1px solid black;background-color: grey !important;color: white;">
                <tr>
                    <th style="font-size: 12px; border-bottom: 1px solid black;border-right: 1px solid black;">#</th>
                    <th style="font-size: 12px; border-bottom: 1px solid black;border-right: 1px solid black;">Date</th>
                    <th style="font-size: 12px; border-bottom: 1px solid black;border-right: 1px solid black;">Pay.Tpe
                    </th>
                    <th style="font-size: 12px; border-bottom: 1px solid black;border-right: 1px solid black;">T.Amnt
                    </th>
                    <th style="font-size: 12px; border-bottom: 1px solid black;border-right: 1px solid black;">Rec.Amnt
                    </th>
                    <th style="font-size: 12px; border-bottom: 1px solid black;border-right: 1px solid black;">Dtls</th>

                    <th style="font-size: 12px; border-bottom: 1px solid black;border-right: 1px solid black;">Pay.Fro
                    </th>
                    <th style="font-size: 12px; border-bottom: 1px solid black;border-right: 1px solid black;">Dr</th>
                    <th style="font-size: 12px; border-bottom: 1px solid black;border-right: 1px solid black;">Cr</th>
                    <th style="font-size: 12px; border-bottom: 1px solid black;border-right: 1px solid black;">Rem.Amnt
                    </th>
                    <th style="font-size: 12px; border-bottom: 1px solid black;border-right: 1px solid black;">Sts</th>


                    <th style="font-size: 12px; border-bottom: 1px solid black;border-right: 1px solid black;">Crd.At
                    </th>

                </tr>
            </thead>
            <tbody>

                <?php 
                foreach ($data as $d) {
                    
                
            ?>
                <tr>
                    <td
                        style=" border-bottom: 1px solid black;border-right: 1px solid black;font-size: 8pt !important;border-left: 1px solid black;">
                        <?php echo $d['id']; ?></td>
                    <td
                        style=" border-bottom: 1px solid black;border-right: 1px solid black;font-size: 8pt !important;">
                        <?php echo $d['date']; ?>
                    </td>
                    <td
                        style=" border-bottom: 1px solid black;border-right: 1px solid black;font-size: 8pt !important;">
                        <?php echo $d['payment_type']; ?>
                    </td>
                    <td
                        style=" border-bottom: 1px solid black;border-right: 1px solid black;font-size: 8pt !important;">
                        <?php echo $d['total_amount']; ?>
                    </td>
                    <td
                        style=" border-bottom: 1px solid black;border-right: 1px solid black;font-size: 8pt !important;">
                        <?php echo $d['recevied_amount']; ?>
                    </td>
                    <td
                        style=" border-bottom: 1px solid black;border-right: 1px solid black;font-size: 8pt !important;">
                        <?php echo $d['details']; ?>
                    </td>
                    <td
                        style=" border-bottom: 1px solid black;border-right: 1px solid black;font-size: 8pt !important;">
                        <?php echo $d['payment_from']; ?>
                    </td>
                    <td
                        style=" border-bottom: 1px solid black;border-right: 1px solid black;font-size: 8pt !important;">
                        <?php echo $d['dr']; ?>
                    </td>
                    <td
                        style=" border-bottom: 1px solid black;border-right: 1px solid black;font-size: 8pt !important;">
                        <?php echo $d['cr']; ?>
                    </td>
                    <td
                        style=" border-bottom: 1px solid black;border-right: 1px solid black;font-size: 8pt !important;">
                        <?php echo $d['remaining_amount'] ; ?>
                    </td>
                    <?php 
                    if ($d['status'] == "Unpaid") {

                    
                    ?>
                    <td
                        style=" border-bottom: 1px solid black;border-right: 1px solid black;text-align: center;font-size: 8pt !important;background-color: #D3D3D3;">
                        <?php echo $d['status']; ?>
                    </td>

                    <?php } else if ($d['status'] == "Incomplete") { ?>
                    <td
                        style=" border-bottom: 1px solid black;border-right: 1px solid black;text-align: center;font-size: 8pt !important;background-color: #A9A9A9;">
                        <?php echo $d['status']; ?>
                    </td>

                    <?php }  else { ?>
                    <td
                        style=" border-bottom: 1px solid black;border-right: 1px solid black;text-align: center;font-size: 8pt !important;">
                        <?php echo $d['status']; ?>
                    </td>

                    <?php } ?>
                    <td
                        style=" border-bottom: 1px solid black;border-right: 1px solid black;font-size: 8pt !important;">
                        <?php echo $d['created_at']; ?>
                    </td>

                </tr>
                <?php } ?>

            </tbody>

        </table>
        <?php } else if ($t == "designation") {
        ?>
        <table style="border-collapse: collapse;width: 100% !important;">
            <thead style="border-left: 1px solid black;background-color: grey !important;color: white;">
                <tr>
                    <th style="font-size: 12px; border-bottom: 1px solid black;border-right: 1px solid black;">#</th>
                    <th style="font-size: 12px; border-bottom: 1px solid black;border-right: 1px solid black;">Name</th>
                    <th style="font-size: 12px; border-bottom: 1px solid black;border-right: 1px solid black;">CreatedAt
                    </th>

                </tr>
            </thead>
            <tbody>

                <?php 
                foreach ($data as $d) {
                    
                
            ?>
                <tr>
                    <td
                        style=" border-bottom: 1px solid black;border-right: 1px solid black;font-size: 8pt !important;border-left: 1px solid black;">
                        <?php echo $d['id']; ?></td>
                    <td
                        style=" border-bottom: 1px solid black;border-right: 1px solid black;font-size: 8pt !important;">
                        <?php echo $d['name']; ?>
                    </td>


                    <td
                        style=" border-bottom: 1px solid black;border-right: 1px solid black;font-size: 8pt !important;">
                        <?php echo $d['created_at']; ?>
                    </td>

                </tr>
                <?php } ?>

            </tbody>

        </table>


        <?php } else if ($t == "sales_1") {
        ?>
        <table style="border-collapse: collapse;width: 100% !important;">
            <thead style="border-left: 1px solid black;background-color: grey !important;color: white;">
                <tr>
                    <th style="font-size: 12px; border-bottom: 1px solid black;border-right: 1px solid black;">#</th>
                    <th style="font-size: 12px; border-bottom: 1px solid black;border-right: 1px solid black;">Inv.</th>

                    <th style="font-size: 12px; border-bottom: 1px solid black;border-right: 1px solid black;">Cust.
                    </th>
                    <th style="font-size: 12px; border-bottom: 1px solid black;border-right: 1px solid black;">Bok.</th>
                    <th style="font-size: 12px; border-bottom: 1px solid black;border-right: 1px solid black;">Date</th>
                    <th style="font-size: 12px; border-bottom: 1px solid black;border-right: 1px solid black;">it.Cde
                    </th>
                    <th style="font-size: 12px; border-bottom: 1px solid black;border-right: 1px solid black;">it.Nme
                    </th>
                    <th style="font-size: 12px; border-bottom: 1px solid black;border-right: 1px solid black;">it.Prc
                    </th>
                    <th style="font-size: 12px; border-bottom: 1px solid black;border-right: 1px solid black;">Qty</th>
                    <th style="font-size: 12px; border-bottom: 1px solid black;border-right: 1px solid black;">Amnt</th>
                    <th style="font-size: 12px; border-bottom: 1px solid black;border-right: 1px solid black;">Dis</th>
                    <th style="font-size: 12px; border-bottom: 1px solid black;border-right: 1px solid black;">Ex.Dis
                    </th>
                    <th style="font-size: 12px; border-bottom: 1px solid black;border-right: 1px solid black;">%</th>
                    <th style="font-size: 12px; border-bottom: 1px solid black;border-right: 1px solid black;">G.Ttl
                    </th>


                </tr>
            </thead>
            <tbody>

                <?php 
                $totalItems = count($data);
                $totalQuantity = [];
                $totalAmnt = [];
                $totalGrand = [];

                foreach ($data as $d) {
                    $customer = $pdo->read("customers", ['id' => $d['customer_name']]);
                    $booker_name = $pdo->read("access", ['id' => $d['booker_name']]);
                    
                    $totalQuantity[] = $d['quantity'];
                    $totalAmnt[] = $d['amount'];
                    $totalGrand[] = $d['grand_total'];
            ?>
                <tr>
                    <td
                        style=" border-bottom: 1px solid black;border-right: 1px solid black;text-align: center;border-left: 1px solid black;">
                        <?php echo $d['id']; ?></td>
                    <td style=" border-bottom: 1px solid black;border-right: 1px solid black;text-align: center;">
                        <?php echo $d['invoice_number']; ?>
                    </td>

                    <td
                        style=" border-bottom: 1px solid black;border-right: 1px solid black;font-size: 8pt !important;">
                        <?php echo $customer[0]['name']; ?>
                    </td>
                    <td
                        style=" border-bottom: 1px solid black;border-right: 1px solid black;font-size: 8pt !important;">
                        <?php echo $booker_name[0]['username']; ?>
                    </td>

                    <td
                        style=" border-bottom: 1px solid black;border-right: 1px solid black;font-size: 8pt !important;">
                        <?php echo $d['date']; ?>
                    </td>
                    <td style=" border-bottom: 1px solid black;border-right: 1px solid black;text-align: center;">
                        <?php echo $d['item_code']; ?>
                    </td>
                    <td
                        style=" border-bottom: 1px solid black;border-right: 1px solid black;font-size: 8pt !important;">
                        <?php echo $d['item_name']; ?>
                    </td>
                    <td style=" border-bottom: 1px solid black;border-right: 1px solid black;text-align: center;">
                        <?php echo $d['item_price']; ?>
                    </td>
                    <td style=" border-bottom: 1px solid black;border-right: 1px solid black;text-align: center;">
                        <?php echo $d['quantity']; ?>
                    </td>
                    <td style=" border-bottom: 1px solid black;border-right: 1px solid black;text-align: center;">
                        <?php echo $d['amount']; ?>
                    </td>
                    <td style=" border-bottom: 1px solid black;border-right: 1px solid black;text-align: center;">
                        <?php echo $d['discount'] == "" ? 0 : $d['discount']; ?>
                    </td>
                    <td style=" border-bottom: 1px solid black;border-right: 1px solid black;text-align: center;">
                        <?php echo $d['extra_discount'] == "" ? 0 : $d['extra_discount']; ?>
                    </td>
                    <td style=" border-bottom: 1px solid black;border-right: 1px solid black;text-align: center;">
                        <?php echo $d['percentage'] == "" ? 0 : $d['percentage']; ?>
                    </td>
                    <td style=" border-bottom: 1px solid black;border-right: 1px solid black;text-align: center;">
                        <?php echo $d['grand_total']; ?>
                    </td>

                </tr>
                <?php } 
                $totalAmnt = array_sum($totalAmnt);
                $totalGrand = array_sum($totalGrand);
                $totalQuantity = array_sum($totalQuantity);
                ?>

            </tbody>



        </table>
        <table>
            <tfoot>
                <tr>
                    <th>
                        Total Items: <?php echo $totalItems; ?>
                    </th>
                    <th style="padding-left: 10px;">
                        Total Quantity: <?php echo $totalQuantity; ?>
                    </th>
                    <th style="padding-left: 10px;">
                        Total Amount: <?php echo $totalAmnt; ?>
                    </th>
                    <th style="padding-left: 10px;">
                        Grand Total: <?php echo $totalGrand; ?>
                    </th>
                </tr>
            </tfoot>
        </table>

        <?php } else if ($t == "sales_2") {
        ?>
        <table style="border-collapse: collapse;width: 100% !important;">
            <thead style="border-left: 1px solid black;background-color: grey !important;color: white;">
                <tr>
                    <th style="font-size: 12px; border-bottom: 1px solid black;border-right: 1px solid black;">#</th>
                    <th style="font-size: 12px; border-bottom: 1px solid black;border-right: 1px solid black;">Inv.</th>
                    <th style="font-size: 12px; border-bottom: 1px solid black;border-right: 1px solid black;">Cust.
                    </th>
                    <th style="font-size: 12px; border-bottom: 1px solid black;border-right: 1px solid black;">Bok.</th>
                    <th style="font-size: 12px; border-bottom: 1px solid black;border-right: 1px solid black;">Date</th>
                    <th style="font-size: 12px; border-bottom: 1px solid black;border-right: 1px solid black;">T.Amnt
                    </th>
                    <th style="font-size: 12px; border-bottom: 1px solid black;border-right: 1px solid black;">Dis</th>
                    <th style="font-size: 12px; border-bottom: 1px solid black;border-right: 1px solid black;">Fin.Amnt
                    </th>
                    <th style="font-size: 12px; border-bottom: 1px solid black;border-right: 1px solid black;">Rec.Amnt
                    </th>
                    <th style="font-size: 12px; border-bottom: 1px solid black;border-right: 1px solid black;">Ret.Amnt
                    </th>
                    <th style="font-size: 12px; border-bottom: 1px solid black;border-right: 1px solid black;">Pend.Amnt
                    </th>
                    <th style="font-size: 12px; border-bottom: 1px solid black;border-right: 1px solid black;">Sts</th>
                    <th style="font-size: 12px; border-bottom: 1px solid black;border-right: 1px solid black;">Detls
                    </th>


                </tr>
            </thead>
            <tbody>

                <?php 
                 $totalItems = count($data);
                 $totalAmnt = [];
                 $totalFinalAmnt = [];
                 $totalReceviedAmnt = [];
                 $totalReturnedAmnt = [];
                 $totalPendingAmnt = [];

                foreach ($data as $d) {
                    $customer = $pdo->read("customers", ['id' => $d['customer_name']]);
                    $booker_name = $pdo->read("access", ['id' => $d['booker_name']]);
                    $totalAmnt[] = $d['total_amount'];
                    $totalFinalAmnt[] = $d['final_amount'];
                    $totalReceviedAmnt[] = $d['recevied_amount'];
                    $totalReturnedAmnt[] = $d['returned_amount'];
                    $totalPendingAmnt[] = $d['pending_amount'];
            ?>
                <tr>
                    <td
                        style=" border-bottom: 1px solid black;border-right: 1px solid black;text-align: center;border-left: 1px solid black;">
                        <?php echo $d['id']; ?></td>
                    <td style=" border-bottom: 1px solid black;border-right: 1px solid black;text-align: center;">
                        <?php echo $d['invoice_number']; ?>
                    </td>


                    <td
                        style=" border-bottom: 1px solid black;border-right: 1px solid black;font-size: 8pt !important;">
                        <?php echo $customer[0]['name']; ?>
                    </td>
                    <td
                        style=" border-bottom: 1px solid black;border-right: 1px solid black;font-size: 8pt !important;">
                        <?php echo $booker_name[0]['username']; ?>
                    </td>

                    <td style=" border-bottom: 1px soled black;font-size: 8pt !important;"><?php echo $d['date']; ?>
                    </td>
                    <td style=" border-bottom: 1px solid black;border-right: 1px solid black;text-align: center;">
                        <?php echo $d['total_amount']; ?>
                    </td>
                    <td
                        style=" border-bottom: 1px solid black;border-right: 1px solid black;font-size: 8pt !important;">
                        <?php echo $d['discount'] == "" ? 0 : $d['discount']; ?>
                    </td>
                    <td style=" border-bottom: 1px solid black;border-right: 1px solid black;text-align: center;">
                        <?php echo $d['final_amount']; ?>
                    </td>
                    <td style=" border-bottom: 1px solid black;border-right: 1px solid black;text-align: center;">
                        <?php echo $d['recevied_amount']  == "" ? 0 : $d['recevied_amount']; ?>
                    </td>
                    <td style=" border-bottom: 1px solid black;border-right: 1px solid black;text-align: center;">
                        <?php echo $d['returned_amount'] == "" ? 0 : $d['returned_amount']; ?>
                    </td>
                    <td style=" border-bottom: 1px solid black;border-right: 1px solid black;text-align: center;">
                        <?php echo $d['pending_amount']  == "" ? 0 : $d['pending_amount']; ?>
                    </td>
                    <?php 
                    if ($d['status'] == "Unpaid") {

                    
                    ?>
                    <td
                        style=" border-bottom: 1px solid black;border-right: 1px solid black;text-align: center;font-size: 8pt !important;background-color: #D3D3D3;">
                        <?php echo $d['status']; ?>
                    </td>

                    <?php } else if ($d['status'] == "Incomplete") { ?>
                    <td
                        style=" border-bottom: 1px solid black;border-right: 1px solid black;text-align: center;font-size: 8pt !important;background-color: #A9A9A9;">
                        <?php echo $d['status']; ?>
                    </td>

                    <?php }  else { ?>
                    <td
                        style=" border-bottom: 1px solid black;border-right: 1px solid black;text-align: center;font-size: 8pt !important;">
                        <?php echo $d['status']; ?>
                    </td>

                    <?php } ?>
                    <td style=" border-bottom: 1px solid black;border-right: 1px solid black;text-align: center;">
                        <?php echo $d['details']; ?>
                    </td>

                </tr>
                <?php } 
                $totalAmnt = array_sum($totalAmnt);
                $totalFinalAmnt = array_sum($totalFinalAmnt);
                $totalReceviedAmnt = array_sum($totalReceviedAmnt);
                $totalReturnedAmnt = array_sum($totalReturnedAmnt);
                $totalPendingAmnt = array_sum($totalPendingAmnt);

                ?>

            </tbody>

        </table>
        <table>
            <tfoot>
                <tr>
                    <th>
                        Total Items: <?php echo $totalItems; ?>
                    </th>

                    <th style="padding-left: 10px;">
                        Total Amount: <?php echo $totalAmnt; ?>
                    </th>
                    <th style="padding-left: 10px;">
                        Total Final Amount: <?php echo $totalFinalAmnt; ?>
                    </th>
                    <th style="padding-left: 10px;">
                        Total Recevied Amount: <?php echo $totalReceviedAmnt; ?>
                    </th>
                    <th style="padding-left: 10px;">
                        Total Returned Amount: <?php echo $totalReturnedAmnt; ?>
                    </th>
                    <th style="padding-left: 10px;">
                        Total Pending Amount: <?php echo $totalPendingAmnt; ?>
                    </th>
                </tr>
            </tfoot>
        </table>

        <?php } else if (isset($_POST['t']) && $_POST['t'] == "search_daily") {
        ?>
        <table style="border-collapse: collapse;width: 100% !important;">
            <thead
                style="border-left: 1px solid black;background-color: grey !important;color: white;border: 1px solid black;">
                <tr>
                    <th style="font-size: 12px; border-bottom: 1px solid black;border-right: 1px solid black;">#</th>
                    <th style="font-size: 12px; border-bottom: 1px solid black;border-right: 1px solid black;">Inv.</th>
                    <th style="font-size: 12px; border-bottom: 1px solid black;border-right: 1px solid black;">Bl.Nmb
                    </th>
                    <th style="font-size: 12px; border-bottom: 1px solid black;border-right: 1px solid black;">Date</th>
                    <th style="font-size: 12px; border-bottom: 1px solid black;border-right: 1px solid black;">Bok.</th>

                    <th style="font-size: 12px; border-bottom: 1px solid black;border-right: 1px solid black;">Cust.
                    </th>
                    <th style="font-size: 12px; border-bottom: 1px solid black;border-right: 1px solid black;">T.Amnt
                    </th>
                    <th style="font-size: 12px; border-bottom: 1px solid black;border-right: 1px solid black;">Dis</th>
                    <th style="font-size: 12px; border-bottom: 1px solid black;border-right: 1px solid black;">Fin.Amnt
                    </th>
                    <th style="font-size: 12px; border-bottom: 1px solid black;border-right: 1px solid black;">Rec.Amnt
                    </th>
                    <th style="font-size: 12px; border-bottom: 1px solid black;border-right: 1px solid black;">Ret.Amnt
                    </th>
                    <th style="font-size: 12px; border-bottom: 1px solid black;border-right: 1px solid black;">Pend.Amnt
                    </th>
                    <th style="font-size: 12px; border-bottom: 1px solid black;border-right: 1px solid black;">Status
                    </th>
                    <th style="font-size: 12px; border-bottom: 1px solid black;border-right: 1px solid black;">Details
                    </th>


                </tr>
            </thead>
            <tbody>

                <?php 
                 $totalItems = count($data);
                 $totalAmnt = [];
                 $totalFinalAmnt = [];
                 $totalReceviedAmnt = [];
                 $totalReturnedAmnt = [];
                 $totalPendingAmnt = [];

                foreach ($data as $idx => $d) {
                    $idx += 1;
                    $customer = $pdo->read("customers", ['id' => $d['customer_name']]);
                    $booker_name = $pdo->read("access", ['id' => $d['booker_name']]);
                    $totalAmnt[] = $d['total_amount'];
                    $totalFinalAmnt[] = $d['final_amount'];
                    $totalReceviedAmnt[] = $d['recevied_amount'];
                    $totalReturnedAmnt[] = $d['returned_amount'];
                    $totalPendingAmnt[] = $d['pending_amount'];
            ?>
                <tr>
                    <td
                        style="font-weight: bolder;<?php echo $d['status'] == "Paid" ? "background-color: #A9A9A9;color:white;" : "" ?>border-bottom: 1px solid black;border-right: 1px solid black;text-align: center;font-size: 10pt !important;border-left: 1px solid black;">
                        <?php echo $idx; ?></td>
                    <td
                        style="font-weight: bolder;<?php echo $d['status'] == "Paid" ? "background-color: #A9A9A9;color:white;" : "" ?>border-bottom: 1px solid black;border-right: 1px solid black;text-align: center;font-size: 10pt !important;">
                        <?php echo $d['invoice_number']; ?>
                    </td>

                    <td
                        style="font-weight: bolder;<?php echo $d['status'] == "Paid" ? "background-color: #A9A9A9;color:white;" : "" ?>border-bottom: 1px solid black;border-right: 1px solid black;text-align: center;font-size: 10pt !important;">
                        <?php echo $d['bill_number']; ?>
                    </td>
                    <td
                        style="font-weight: bolder;<?php echo $d['status'] == "Paid" ? "background-color: #A9A9A9;color:white;" : "" ?>border-bottom: 1px solid black;border-right: 1px solid black;font-size: 10pt !important;text-align: center;">
                        <?php echo $d['date']; ?>
                    </td>
                    <td
                        style="font-weight: bolder;<?php echo $d['status'] == "Paid" ? "background-color: #A9A9A9;color:white;" : "" ?>border-bottom: 1px solid black;border-right: 1px solid black;font-size: 10pt !important;text-align: center;">
                        <?php echo $booker_name[0]['username']; ?>
                    </td>
                    <td
                        style="font-weight: bolder;<?php echo $d['status'] == "Paid" ? "background-color: #A9A9A9;color:white;" : "" ?>border-bottom: 1px solid black;border-right: 1px solid black;font-size: 10pt !important;text-align: center;">
                        <?php echo $customer[0]['name']; ?>
                    </td>



                    <td
                        style="font-weight: bolder;<?php echo $d['status'] == "Paid" ? "background-color: #A9A9A9;color:white;" : "" ?>border-bottom: 1px solid black;border-right: 1px solid black;text-align: center;font-size: 10pt !important;text-align: center;">
                        <?php echo $d['total_amount']; ?>
                    </td>
                    <td
                        style="font-weight: bolder;<?php echo $d['status'] == "Paid" ? "background-color: #A9A9A9;color:white;" : "" ?>border-bottom: 1px solid black;border-right: 1px solid black;font-size: 10pt !important;text-align: center;">
                        <?php echo $d['discount'] == "" ? 0 : $d['discount']; ?>
                    </td>
                    <td
                        style="font-weight: bolder;<?php echo $d['status'] == "Paid" ? "background-color: #A9A9A9;color:white;" : "" ?>border-bottom: 1px solid black;border-right: 1px solid black;text-align: center;font-size: 10pt !important;">
                        <?php echo $d['final_amount']; ?>
                    </td>
                    <td
                        style="font-weight: bolder;<?php echo $d['status'] == "Paid" ? "background-color: #A9A9A9;color:white;" : "" ?>border-bottom: 1px solid black;border-right: 1px solid black;text-align: center;font-size: 10pt !important;">
                        <?php echo $d['recevied_amount'] == "" ? 0 : $d['recevied_amount']; ?>
                    </td>
                    <td
                        style="font-weight: bolder;<?php echo $d['status'] == "Paid" ? "background-color: #A9A9A9;color:white;" : "" ?>border-bottom: 1px solid black;border-right: 1px solid black;text-align: center;font-size: 10pt !important;">
                        <?php echo $d['returned_amount']== "" ? 0 : $d['returned_amount']; ?>
                    </td>
                    <td
                        style="font-weight: bolder;<?php echo $d['status'] == "Paid" ? "background-color: #A9A9A9;color:white;" : "" ?>border-bottom: 1px solid black;border-right: 1px solid black;text-align: center;font-size: 10pt !important;">
                        <?php echo $d['pending_amount']; ?>
                    </td>
                
                    <td
                        style="font-weight: bolder;<?php echo $d['status'] == "Paid" ? "background-color: #A9A9A9;color:white;" : "" ?>border-bottom: 1px solid black;border-right: 1px solid black;text-align: center;font-size: 10pt !important;">
                        <?php echo $d['status']; ?>
                    </td>
                    <td
                        style="font-weight: bolder;<?php echo $d['status'] == "Paid" ? "background-color: #A9A9A9;color:white;" : "" ?>border-bottom: 1px solid black;border-right: 1px solid black;text-align: center;font-size: 10pt !important;">
                        <?php echo $d['details']; ?>
                    </td>
                </tr>
                <?php } 
                $totalAmnt = array_sum($totalAmnt);
                $totalFinalAmnt = array_sum($totalFinalAmnt);
                $totalReceviedAmnt = array_sum($totalReceviedAmnt);
                $totalReturnedAmnt = array_sum($totalReturnedAmnt);
                $totalPendingAmnt = array_sum($totalPendingAmnt);

                ?>

            </tbody>

        </table>
        <table>
            <tfoot>
                <tr>
                    <th>
                        Total Items: <?php echo $totalItems; ?>
                    </th>

                    <th style="padding-left: 10px;">
                        Total Amount: <?php echo $totalAmnt; ?>
                    </th>
                    <th style="padding-left: 10px;">
                        Total Final Amount: <?php echo $totalFinalAmnt; ?>
                    </th>
                    <th style="padding-left: 10px;">
                        Total Recevied Amount: <?php echo $totalReceviedAmnt; ?>
                    </th>
                    <th style="padding-left: 10px;">
                        Total Returned Amount: <?php echo $totalReturnedAmnt; ?>
                    </th>
                    <th style="padding-left: 10px;">
                        Total Pending Amount: <?php echo $totalPendingAmnt; ?>
                    </th>
                </tr>
            </tfoot>
        </table>

        <?php } else if (isset($_POST['t']) && $_POST['t'] == "search_item_wise") {
        ?>
        <table style="border-collapse: collapse;width: 100% !important;">
            <thead style="border-left: 1px solid black;background-color: grey !important;color: white;">
                <tr>
                    <th style="font-size: 12px; border-bottom: 1px solid black;border-right: 1px solid black;">#</th>
                    <th style="font-size: 12px; border-bottom: 1px solid black;border-right: 1px solid black;">Inv.</th>

                    <th style="font-size: 12px; border-bottom: 1px solid black;border-right: 1px solid black;">Cust.
                    </th>
                    <th style="font-size: 12px; border-bottom: 1px solid black;border-right: 1px solid black;">Bok.</th>
                    <th style="font-size: 12px; border-bottom: 1px solid black;border-right: 1px solid black;">Date</th>
                    <th style="font-size: 12px; border-bottom: 1px solid black;border-right: 1px solid black;">it.Cde
                    </th>
                    <th style="font-size: 12px; border-bottom: 1px solid black;border-right: 1px solid black;">it.Nme
                    </th>
                    <th style="font-size: 12px; border-bottom: 1px solid black;border-right: 1px solid black;">it.Prc
                    </th>
                    <th style="font-size: 12px; border-bottom: 1px solid black;border-right: 1px solid black;">Qty</th>
                    <th style="font-size: 12px; border-bottom: 1px solid black;border-right: 1px solid black;">Amnt</th>
                    <th style="font-size: 12px; border-bottom: 1px solid black;border-right: 1px solid black;">Dis</th>
                    <th style="font-size: 12px; border-bottom: 1px solid black;border-right: 1px solid black;">Ex.Dis
                    </th>
                    <th style="font-size: 12px; border-bottom: 1px solid black;border-right: 1px solid black;">%</th>
                    <th style="font-size: 12px; border-bottom: 1px solid black;border-right: 1px solid black;">G.Total
                    </th>


                </tr>
            </thead>
            <tbody>

                <?php 
                $totalItems = count($data);
                $totalQuantity = [];
                $totalAmnt = [];
                $totalGrand = [];

                foreach ($data as $d) {
                    $customer = $pdo->read("customers", ['id' => $d['customer_name']]);
                    $booker_name = $pdo->read("access", ['id' => $d['booker_name']]);
                    
                    $totalQuantity[] = $d['quantity'];
                    $totalAmnt[] = $d['amount'];
                    $totalGrand[] = $d['grand_total'];
            ?>
                <tr>
                    <td
                        style="font-weight: bolder;border-bottom: 1px solid black;border-right: 1px solid black;text-align: center;border-left: 1px solid black;font-size: 10pt !important;">
                        <?php echo $d['id']; ?></td>
                    <td
                        style="font-weight: bolder;border-bottom: 1px solid black;border-right: 1px solid black;text-align: center;font-size: 10pt !important;">
                        <?php echo $d['invoice_number']; ?>
                    </td>

                    <td
                        style="font-weight: bolder;border-bottom: 1px solid black;border-right: 1px solid black;font-size: 10pt !important;text-align: center;">
                        <?php echo $customer[0]['name']; ?>
                    </td>
                    <td
                        style="font-weight: bolder;border-bottom: 1px solid black;border-right: 1px solid black;font-size: 10pt !important;text-align: center;">
                        <?php echo $booker_name[0]['username']; ?>
                    </td>

                    <td
                        style="font-weight: bolder;border-bottom: 1px solid black;border-right: 1px solid black;font-size: 10pt !important;text-align: center;">
                        <?php echo $d['date']; ?>
                    </td>
                    <td
                        style="font-weight: bolder;border-bottom: 1px solid black;border-right: 1px solid black;text-align: center;font-size: 10pt !important;">
                        <?php echo $d['item_code']; ?>
                    </td>
                    <td
                        style="font-weight: bolder;border-bottom: 1px solid black;border-right: 1px solid black;font-size: 10pt !important;font-size: 10pt !important;text-align: center;">
                        <?php echo $d['item_name']; ?>
                    </td>
                    <td
                        style="font-weight: bolder;border-bottom: 1px solid black;border-right: 1px solid black;text-align: center;font-size: 10pt !important;">
                        <?php echo $d['item_price']; ?>
                    </td>
                    <td
                        style="font-weight: bolder;border-bottom: 1px solid black;border-right: 1px solid black;text-align: center;font-size: 10pt !important;">
                        <?php echo $d['quantity']; ?>
                    </td>
                    <td
                        style="font-weight: bolder;border-bottom: 1px solid black;border-right: 1px solid black;text-align: center;font-size: 10pt !important;">
                        <?php echo $d['amount']; ?>
                    </td>
                    <td
                        style="font-weight: bolder;border-bottom: 1px solid black;border-right: 1px solid black;text-align: center;font-size: 10pt !important;">
                        <?php echo $d['discount'] == "" ? 0 : $d['discount']; ?>
                    </td>
                    <td
                        style="font-weight: bolder;border-bottom: 1px solid black;border-right: 1px solid black;text-align: center;font-size: 10pt !important;">
                        <?php echo $d['extra_discount'] == "" ? 0 : $d['extra_discount']; ?>
                    </td>
                    <td
                        style="font-weight: bolder;border-bottom: 1px solid black;border-right: 1px solid black;text-align: center;font-size: 10pt !important;">
                        <?php echo $d['percentage']  == "" ? 0 : $d['percentage']; ?>
                    </td>
                    <td
                        style="font-weight: bolder;border-bottom: 1px solid black;border-right: 1px solid black;text-align: center;font-size: 10pt !important;">
                        <?php echo $d['grand_total']; ?>
                    </td>

                </tr>
                <?php } 
                $totalAmnt = array_sum($totalAmnt);
                $totalGrand = array_sum($totalGrand);
                $totalQuantity = array_sum($totalQuantity);
                ?>

            </tbody>



        </table>
        <table>
            <tfoot>
                <tr>
                    <th>
                        Total Items: <?php echo $totalItems; ?>
                    </th>
                    <th style="padding-left: 10px;">
                        Total Quantity: <?php echo $totalQuantity; ?>
                    </th>
                    <th style="padding-left: 10px;">
                        Total Amount: <?php echo $totalAmnt; ?>
                    </th>
                    <th style="padding-left: 10px;">
                        Grand Total: <?php echo $totalGrand; ?>
                    </th>
                </tr>
            </tfoot>
        </table>

        <?php } ?>
        <div style="width: 100%;border-bottom: 1px solid black;"></div>
        <h6 style="text-align: center;">Powerd By ovalfox.com || Contact 0334 8647633</h6>


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