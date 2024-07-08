<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <?php 

require_once 'assets/includes/pdo.php';
session_start();
    if (!isset($_SESSION["ovalfox_pos_username"])) {
        header("location:login.php");
    }

$invoice_number = $_GET['inv'];

$company = [];

if (!isset($invoice_number) || empty($invoice_number)) {
    header('location:index.php');
} else {
    $company = $pdo->read("companies_profile", ['id' => $_SESSION['ovalfox_pos_cp_id']])[0];

}

$sales_1 = $pdo->read('sales_1', ['invoice_number'=>$invoice_number, 'company_profile_id' => $_SESSION['ovalfox_pos_cp_id']]);
$sales_2 = $pdo->read('sales_2', ['invoice_number'=>$invoice_number, 'company_profile_id' => $_SESSION['ovalfox_pos_cp_id']]);
$customers = $pdo->read('customers', ['id' => $sales_2[0]['customer_name'], 'company_profile_id' => $_SESSION['ovalfox_pos_cp_id']]);
$booker = $pdo->read('access', ['id' => $sales_2[0]['booker_name'], 'company_profile_id' => $_SESSION['ovalfox_pos_cp_id']]);

$total_quantity = 0;
$total_price = 0;
$total_quantity = 0;
$total_price = 0;

?>
    <style>
    @media print {
        @page {
            size: 8.5in 11in;
            margin: 2cm
        }


        /* body {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
        }

        table {
            width: 100%;
        } */

        /* td {
            word-wrap: break-word;
            max-width: calc(100% / 9);
        } */

        /* #main {
            padding: 5px;
            height: calc(100% - 20px);
        } */
        /* 
        #main-inner {
            height: 100%;
        } */
        /* 
        #table-info,
        #footer-outer {
            font-size: 10px;
        } */
        /* 
        #table-data-product {
            font-size: 10px;
        } */

        #bbtn {
            display: none;
        }


    }



    #footer-outer {
        margin-top: 5px;
        font-size: 12px;
        padding: 5px;
    }

    #terms-cond {
        font-size: 12px;

    }




    * {
        margin: 0;
        padding: 0;
        font-size: 25px !important;

    }



    #main {
        padding-left: 3px;
        /* margin-top: -0.3px !important; */
    }





    #company_name {
        text-align: center;
    }

    #address {
        text-align: center;
    }

    #whatsapp {
        text-align: center;
    }

    #table-info {
        /* margin-left: 15px;
        margin-right: 18px; */
        font-size: 12px;
    }



    #table-data-product {
        border-collapse: collapse;
        font-size: 12px;
        width: 100%;
        height: 0.01in;
    }

    #table-data-product thead th {
        padding: 3.8px;
    }

    #footer-outer {
        display: flex;
        margin-top: 5px;
        font-size: 12px;
        padding: 5px;
    }

    #terms-cond {
        border: 0px;
    }

    /*
    #sub-total {
    display: block;
    } */

    #sub-total-inner {
        display: flex;
        justify-content: space-between;

    }

    #sub-total-text {
        text-align: left;
        font-size: 12px;
    }

    #sub-total-price {
        font-size: 12px;
    }

    #discount-outer {
        display: flex;
        justify-content: space-between;

        border-bottom: 1px solid black;
    }

    #discount-text-inner {
        text-align: left;
        font-size: 12px;
    }

    #discount-total-price {
        font-size: 12px;
    }

    #total-box {
        display: flex;
        justify-content: space-between;


    }

    #total-text {
        text-align: left;
        font-size: 12px;
    }

    #total-price-total {
        font-size: 12px;
    }

    #rec-box {
        display: flex;
        justify-content: space-between;

        border-bottom: 1px solid black;

    }

    #rec-text {
        text-align: left;
        font-size: 12px;
    }

    #bala-box {
        display: flex;
        justify-content: space-between;

        border-bottom: 1px solid black;
    }

    #bala-text {
        text-align: left;
        font-size: 12px;
    }

    #cb-box {
        display: flex;
        justify-content: space-between;

    }

    #cb-text {
        text-align: left;
        font-size: 12px;
    }
    </style>
</head>


<body>

    <div class="page">
        <!-- style of main: style="margin-top: 0.2in;margin-bottom: 0.2in;" -->

        <div id="main">
            <div id="main-inner" style="">
                <p id="bbtn"><a href="sales.php">Back</a></p>
                <h3 style="text-align: end; font-size: 20px !important;">
                    <?php echo $sales_2[0]['status']; ?>
                </h3>

                <h1 style="font-size: 50px !important;" id="company_name">
                    <?php echo !empty($company['company_name']) ? $company['company_name'] : ""; ?>
                </h1>
                <p id="address" style="font-size: 10px;">Address:
                    <?php echo !empty($company['address']) ? $company['address'] : ""; ?>,
                    Ph. no.: <?php echo !empty($company['phone1']) ? $company['phone1'] : ""; ?>
                    Email:
                    <?php echo !empty($company['email']) ? $company['email'] : ""; ?>
                </p>
                <p id="whatsapp" style="">WA:
                    <?php echo !empty($company['phone1']) ? $company['phone1'] : ""; ?>
                    <?php echo !empty($company['phone2']) ?  '- - '. $company['phone2'] : ""; ?>
                    <?php echo !empty($company['phone3']) ?  '- - '. $company['phone3'] : ""; ?>
                </p>
                <div id="table-info">
                    <div style="border: 2px solid black;">
                        <table id="" style="width: 100%; table-layout: fixed;">
                            <thead>
                                <tr>
                                    <th style="text-align: start; font-size: 20px !important;">
                                        <?php echo str_replace('T', ' ', $sales_2[0]['date']); ?>
                                    </th>
                                    <th style="text-align: start; font-size: 20px !important;">
                                        Inv.: <?php echo $invoice_number; ?>
                                    </th>
                                    <th style="text-align: start; font-size: 20px !important;">
                                        Add.<span style="white-space: nowrap; font-size: 20px !important;">
                                            <?php echo $customers[0]['address']; ?>

                                        </span>
                                    </th>



                                </tr>
                                <tr>
                                    <th style="text-align: start; white-space: nowrap;font-size: 20px !important;">BOK.
                                        <?php echo $booker[0]['username']; ?></th>
                                    <th style="text-align: start; font-size: 20px !important;">
                                        Cash.: <?php echo $_SESSION['ovalfox_pos_username']; ?>
                                    </th>
                                    <th style="text-align: start; font-size: 20px !important;">
                                        Ph.: <?php echo $customers[0]['phone']; ?>
                                    </th>


                                </tr>

                            </thead>
                        </table>
                        <table style="width: 100%; table-layout: fixed;">
                            <thead>
                                <tr>



                                </tr>
                                <tr>
                                    <th style="text-align: start; font-size: 30px !important;width:200px">
                                        CUST.
                                        <?php echo $customers[0]['name']; ?>
                                        </span>

                                    </th>
                                </tr>
                            </thead>
                        </table>

                        <table id="table-data-product" style="width: 100%;" border="2">
                            <thead>
                                <th style="text-align: center;font-size: 20px !important;">SR</th>
                                <th style="text-align: center;font-size: 20px !important;">Description</th>
                                <th style="text-align: center;font-size: 20px !important;">Qty</th>
                                <th style="text-align: center;font-size: 20px !important;">Rate</th>
                                <th style="text-align: center;font-size: 20px !important;">Total</th>
                                <th style="text-align: center;font-size: 20px !important;">Dis</th>
                                <th style="text-align: center;font-size: 20px !important;">%</th>
                                <th style="text-align: center;font-size: 20px !important;">E.D</th>

                                <th style="text-align: center;font-size: 20px !important;">G.Total</th>

                            </thead>
                            <tbody>
                                <?php 
    foreach ($sales_1 as $index => $sale) {
        $index += 1;

        
        $pd = $pdo->read("products", ['item_code' => $sale['item_code']]);
        $total_quantity += $sale['quantity'];
        $total_price += $sale['grand_total'];
    ?>
                                <tr>
                                    <td style="text-align: center;font-size: 23px !important;"><?php echo $index; ?>
                                    </td>

                                    <td style="text-align: center;font-size: 23px !important;">
                                        <?php echo $sale['item_name']; ?>
                                    </td>
                                    <td style="text-align: center;font-size: 23px !important;">
                                        <?php echo $sale['quantity']; ?>
                                    </td>

                                    <td style="text-align: center;font-size: 23px !important;">
                                        <?php echo round($sale['item_price'], 2); ?></td>
                                    <td style="text-align: center;font-size: 23px !important;">
                                        <?php echo round($sale['amount'], 2); ?></td>
                                    <td style="text-align: center;font-size: 23px !important;">
                                        <?php echo round($sale['discount'], 2); ?>
                                    </td>
                                    <td style="text-align: center;font-size: 23px !important;">
                                        <?php echo round(!empty($sale['percentage']) ? $sale['percentage'] : 0); ?></td>
                                    <td style="text-align: center;font-size: 23px !important;">
                                        <?php echo round($sale['extra_discount'], 2); ?>
                                    </td>

                                    <td style="text-align: center;font-size: 23px !important;">
                                        <?php echo round($sale['grand_total'], 2); ?>
                                    </td>
                                    </td>


                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>


                    </div>

                    <div id="footer-outer" style="">
                        <div style="">
                            <h4>Items: <?php echo $total_quantity; ?></h4>
                            <h4>Bill Number: <?php echo $sales_2[0]['bill_number']; ?></h4>


                            <p> <b>Terms and Conditions:</b> <br /> <textarea disabled
                                    style="font-size: 8px;background-color:white;" placeholder="Type..." name=""
                                    id="terms-cond" cols="22" rows="3"><?php echo $sales_2[0]['details']; ?></textarea>
                            </p>


                        </div>
                        <div id="sub-total" style="width: 100%;">
                            <div id="sub-total-inner">
                                <span id="sub-total-text" style="font-weight: bold;">Sub Total</span>
                                <span id="sub-total-price">Rs <?php echo $total_price; ?></span>
                            </div>


                            <div id="discount-outer">
                                <span id="discount-text-inner" style="font-weight: bold;">Dicount
                                    <?php 
function calculate_cut($original_amount, $percentage_cut) {
    return $original_amount * ($percentage_cut / 100);
}
$per = (intval($sales_2[0]['discount']) != 0 ? ($total_price) * (1 - (intval($sales_2[0]['discount']) / 100)) : 0);
$percetage = (double)$sales_2[0]['discount'] != 0 ? round(((double)$sales_2[0]['discount'] / $total_price) * 100, 2) : (double)$sales_2[0]['discount'];
?>
                                    (<?php    
                                    
 echo $_GET['amountIn'] == "amount" ? $percetage : ($sales_2[0]['discount'] != 0 && !empty($sales_2[0]['discount']) ? $sales_2[0]['discount'] : 0); ?>%)</span>
                                <span id="discount-total-price" style="">Rs
                                    <?php $minused = $total_price - $per;echo $_GET['amountIn'] == "amount" ? calculate_cut($total_price, $percetage) : $minused; ?></span>
                            </div>
                            <div id="total-box" style="">
                                <span id="total-text" style=""><b>Total</b></span>
                                <b id="total-price-total" style="">Rs
                                    <?php echo $_GET['amountIn'] == "amount" ? $total_price - (double)$sales_2[0]['discount'] : $per; ?></b>
                            </div>
                            <div id="rec-box" style="">
                                <span id="rec-text" style="font-weight: bold;">Prev.</span>

                                <span id="rec-total">Rs <?php 
                                    
                                    //echo $minused;
                                    $balance = (double)$customers[0]['balance'];
                                    $amountIn = $_GET['amountIn'];
                                    $discount = (double)$sales_2[0]['discount'];
                                    $received_amount = (double)$sales_2[0]['recevied_amount'];
                                    $totalPriceOrPer = $amountIn == "amount" ? (double)$total_price - $discount : (double)$per;
                                    
                                    $new_balance = round($balance - ($totalPriceOrPer - $received_amount), 2);
                                    echo $balance != 0 ? (empty($sales_2[0]['returned_amount']) ? $new_balance : $new_balance - (double)$sales_2[0]['returned_amount']) : 0;                                    //echo ($customers[0]['balance']) - ($minused) >= 0 ? ($customers[0]['balance']) - ($minused) : 0 ;
                                    
                                    ?></span>
                            </div>
                            <div id="bala-box" style="">
                                <span id="bala-text" style="font-weight: bold;">Final Amount</span>
                                Rs
                                <?php echo (($_GET['amountIn'] == "amount" ? $total_price - (double)$sales_2[0]['discount'] : $per) - ($sales_2[0]['recevied_amount'] != 0 && !empty($sales_2[0]['recevied_amount']) ? $sales_2[0]['recevied_amount'] : 0)) >= 0 ? (($_GET['amountIn'] == "amount" ? $total_price - (double)$sales_2[0]['discount'] : $per) - ($sales_2[0]['recevied_amount'] != 0 && !empty($sales_2[0]['recevied_amount']) ? $sales_2[0]['recevied_amount'] : 0)) : 0; ?>
                            </div>

                            <div id="rec-box" style="">
                                <span id="rec-text" style="font-weight: bold;">Received</span>

                                <span id="rec-total">Rs
                                    <?php echo $sales_2[0]['recevied_amount'] != 0 && !empty($sales_2[0]['recevied_amount']) ? $sales_2[0]['recevied_amount'] : 0; ?></span>
                            </div>





                            <div id="cb-box" style=" 
                ">
                                <span id="cb-text" style="font-weight: bold;">Current Balance</span>
                                <b> Rs
                                    <?php echo $customers[0]['balance']; ?></b>
                            </div>
                        </div>


                    </div>
                </div>


                <div style="width: 100%;border-bottom: 1px solid black;"></div>
                <h6 style="text-align: center;">Powerd By ovalfox.com || Contact 0334 8647633</h6>
            </div>

        </div>
    </div>
    <button hidden id="downloadBtn">Download as PDF</button>

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/print.js"></script>

    <script>
    const options = {
        filename: 'small_inv.pdf',
        image: {
            type: 'png',
            quality: 0.98
        },
        html2canvas: {
            scale: 2
        },
        jsPDF: {
            unit: 'in',
            format: 'letter',
            orientation: 'portrait'
        }
    };

    html2pdf().from(document.body).set(options).save();
    </script>
</body>

</html>