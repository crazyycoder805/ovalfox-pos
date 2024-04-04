<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php 

require_once 'assets/includes/pdo.php';
session_start();

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

$total_quantity = 0;
$total_price = 0;

?>
    <style>
    @media print {
        @page {
            size: Postcard;
        }
    }


    body {
        width: 4.1in;

    }

    #main {}


    #main-inner {
        width: 4.1in;
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
        margin-left: 15px;
        margin-right: 18px;
        font-size: 12px;
    }

    

    #table-data-product {
        border-collapse: collapse;
        font-size: 12px;
        width: 100%;
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
    <div id="main" style="">
        <div id="main-inner" style="">
            <h1 id="company_name" style="">
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
            </p>
            <div id="table-info">
                <div style="border: 1px solid black;">
                <table id="" style="">
                    <thead>

                        <tr>
                            <th style="text-align: start;" id="table-info-first-th-child" style="">
                                <?php echo date("Y-m-d"); ?> <span id="time"></span></th>
                            <th style="text-align: center;">Invoice: <?php echo $invoice_number; ?></th>
                            <th><?php echo $sales_2[0]['status']; ?></th>

                        </tr>
                        <tr>
                            <th style="text-align: start;">Booker : <?php echo $_SESSION['ovalfox_pos_username']; ?>
                            </th>
                            <th style="text-align: center;padding-left: 40px;">Name: <?php echo $customers[0]['name'];?></th>

                        </tr>
                        <tr>
                            <th style="text-align: start;">Add : Gulpur</th>
                            <th style="text-align: start;padding-left: 50px;">Phone: 03411141098</th>

                        </tr>
                    </thead>

                </table>
                <table id="table-data-product" style="" border="1">
                    <thead>
                        <th>SR</th>
                        <th>Qty</th>
                        <th>Description</th>
                        <th>Rate</th>
                        <th>Total</th>
                        <th>Dis</th>
                        <th>%</th>
                        <th>G.Total</th>

                    </thead>
                    <tbody>
                        <?php 
                foreach ($sales_1 as $index => $sale) {
                    $pd = $pdo->read("products", ['item_code' => $sale['item_code']]);
                    $index += 1;
                    $total_quantity += $sale['quantity'];
                    $total_price += $sale['amount'];

                ?>
                        <tr>
                            <td><?php echo $index; ?></td>
                            <td><?php echo $sale['quantity']; ?>
                            </td>
                            <td><?php echo $sale['item_name']; ?>
                            </td>


                            <td>
                                <?php echo $sale['item_price']; ?></td>
                            <td><?php echo $sale['amount']; ?></td>
                            <td><?php echo $sale['discount']; ?></td>
                            <td><?php echo !empty($sale['percentage']) ? $sale['percentage'] : 0; ?></td>
                            <td><?php echo $sale['amount']; ?></td>


                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                </div>
                <div id="footer-outer" style="">
                    <div style="">
                        <h4>Items: <?php echo $total_quantity; ?></h4>


                        <p> <b>Terms and Conditions:</b> <br /> <textarea style="font-size: 12px;" placeholder="Type..."
                                name="" id="terms-cond" cols="22" rows="10"></textarea></p>


                    </div>
                    <div id="sub-total" style="width: 100%;">
                        <div id="sub-total-inner">
                            <span id="sub-total-text" style="">Sub Total</span>
                            <span id="sub-total-price">Rs <?php echo $total_price; ?></span>
                        </div>


                        <div id="discount-outer">
                            <span id="discount-text-inner" style="">Dicount
                            
                                (<?php echo $sales_2[0]['discount'] != 0 && !empty($sales_2[0]['discount']) ? $sales_2[0]['discount'] : 0; ?>%)</span>
                            <span id="discount-total-price" style="">Rs <?php $per = intval(($total_price / 100) * $sales_2[0]['discount'], 2); echo $per; ?></span>
                        </div>
                        <div id="total-box" style="">
                            <span id="total-text" style=""><b>Total</b></span>
                            <b id="total-price-total" style="">Rs
                                <?php echo $per; ?></b>
                        </div>

                        <div id="rec-box" style="">
                            <span id="rec-text" style="">Received</span>

                            <span
                                id="rec-total">Rs<?php echo $sales_2[0]['recevied_amount'] != 0 && !empty($sales_2[0]['recevied_amount']) ? $sales_2[0]['recevied_amount'] : 0; ?></span>
                        </div>

                        <div id="bala-box" style="">
                            <span id="bala-text" style="">Balance</span>
                            Rs <?php echo !empty($customers[0]['balance']) ? $customers[0]['balance'] : 0.00; ?>
                        </div>



                        <div id="cb-box" style=" 
                ">
                            <span id="cb-text" style="">Current Balance</span>
                            Rs
                            <?php echo !empty($customers[0]['balance']) ? $per + $customers[0]['balance'] : $customers[0]['balance']; ?>
                        </div>
                    </div>


                </div>
            </div>



        </div>
    </div>
    <!-- <button id="downloadBtn">Download as PDF</button> -->

    <!-- <script src="assets/js/jquery.min.js"></script> -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script> -->

    <script>
    // Examples
    // document.getElementById('downloadBtn').addEventListener('click', function() {
    //     // Set your page options here
    //     const options = {
    //         filename: 'your_document.pdf', // Name of the PDF file
    //         image: {
    //             type: 'jpeg',
    //             quality: 0.98
    //         }, // Quality and type of images
    //         html2canvas: {
    //             scale: 2
    //         }, // Scale of HTML content
    //         jsPDF: {
    //             unit: 'in',
    //             format: 'letter',
    //             orientation: 'portrait'
    //         } // Page settings
    //     };

    //     // Convert HTML to PDF
    //     html2pdf().from(document.body).set(options).save();
    // });
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
    const time = `${hours}:${minutes}:${seconds} ${period}`;
    document.getElementById("time").textContent = time;
    </script>
</body>

</html>