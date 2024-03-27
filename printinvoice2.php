<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
    @media print {}

    @page {
        size: 4.1in
    }

    body {
        width: 4.1in;

    }

    #main {
        margin-left: 180px;
    }


    #main-inner {
        width: 4.1in;
        margin: 9.6px;
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
        border: 1px solid black;
    }

    #table-info-first-th-child {
        text-align: left;
    }

    #table-info-first-th-child thead tr th {
        font-size: 15px;
        padding-right: 14px;
    }

    #table-data-product {
        border-collapse: collapse;
        border-top: 0px;
    }

    #table-data-product thead th {
        padding: 4.3px;
    }

    #footer-outer {
        display: flex;
        justify-content: space-between;
        margin-top: 5px;
    }

    #terms-cond {
        border: 0px;
    }

    #sub-total {
        display: block;
        width: 80%;
    }

    #sub-total-inner {
        display: flex;
        justify-content: space-between;
    }

    #sub-total-text {
        text-align: left;
        font-size: 13px;
    }

    #sub-total-price {
        font-size: 13px;
    }

    #discount-outer {
        display: flex;
        justify-content: space-between;
        border-bottom: 1px solid black;
    }

    #discount-text-inner {
        text-align: left;
        font-size: 13px;
    }

    #discount-total-price {
        font-size: 13px;
    }

    #total-box {
        display: flex;
        justify-content: space-between;

    }

    #total-text {
        text-align: left;
        font-size: 13px;
    }

    #total-price-total {
        font-size: 13px;
    }

    #rec-box {
        display: flex;
        justify-content: space-between;
        border-bottom: 1px solid black;

    }

    #rec-text {
        text-align: left;
        font-size: 13px;
    }

    #bala-box {
        display: flex;
        justify-content: space-between;
        border-bottom: 1px solid black;
    }

    #bala-text {
        text-align: left;
        font-size: 13px;
    }

    #cb-box {
        display: flex;
        justify-content: space-between;
    }

    #cb-text {
        text-align: left;
        font-size: 13px;
    }
    </style>
</head>


<?php 

require_once 'assets/includes/pdo.php';
session_start();

// $invoice_number = $_GET['inv'];

$company = [];


    $company = $pdo->read("companies_profile", ['id' => $_SESSION['ovalfox_pos_cp_id']])[0];



$sales_1 = $pdo->read('sales_1', ['invoice_number'=>1, 'company_profile_id' => $_SESSION['ovalfox_pos_cp_id']]);
$sales_2 = $pdo->read('sales_2', ['invoice_number'=>1, 'company_profile_id' => $_SESSION['ovalfox_pos_cp_id']]);
$customers = $pdo->read('customers', ['id' => $sales_2[0]['customer_name'], 'company_profile_id' => $_SESSION['ovalfox_pos_cp_id']]);

$total_quantity = 0;
$total_price = 0;

?>

<body>
    <div id="main" style="">
        <div id="main-inner" style="">
            <h1 id="company_name" style="">
                <?php echo !empty($company['company_name']) ? $company['company_name'] : ""; ?>
            </h1>
            <p id="address" style="">Address:
                <?php echo !empty($company['address']) ? $company['address'] : ""; ?>,
                Ph. no.: <?php echo !empty($company['phone1']) ? $company['phone1'] : ""; ?>
                Email:
                <br />
                <?php echo !empty($company['email']) ? $company['email'] : ""; ?>
            </p>
            <p id="whatsapp" style="">WA:
                <?php echo !empty($company['phone1']) ? $company['phone1'] : ""; ?>
                <?php echo !empty($company['phone2']) ?  '- - '. $company['phone2'] : ""; ?>
            </p>
            <table id="table-info" style="">
                <thead>
                    <tr>
                        <th id="table-info-first-th-child" style="">24-Mar-04
                            10:11:19 AM</th>
                        <th>Invoice: 3085</th>
                        <th>Unpaid</th>

                    </tr>
                    <tr>
                        <th>Cashier : asad</th>
                        <th>Name: Nisma G.S</th>

                    </tr>
                    <tr>
                        <th>Add : Gulpur</th>
                        <th>Phone: 03411141098</th>

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
            </table>
            <div id="footer-outer" style="">
                <div>
                    <h4>Items: 31</h4>


                    <p> <b>Terms and Conditions:</b> <br /> <textarea style="" placeholder="Type..." name=""
                            id="terms-cond" cols="30" rows="10"></textarea></p>


                </div>
                <div id="sub-total" style="">
                    <div id="sub-total-inner">
                        <span id="sub-total-text" style="">Sub Total</span>
                        <span id="sub-total-price">Rs <?php echo $total_price; ?></span>
                    </div>


                    <div id="discount-outer">
                        <span id="discount-text-inner" style="">Dicount
                            (<?php echo $sales_2[0]['discount'] != 0 && !empty($sales_2[0]['discount']) ? $sales_2[0]['discount'] : 0; ?>%)</span>
                        <span id="discount-total-price" style="">Rs <?php echo $total_price; ?></span>
                    </div>
                    <div id="total-box" style="">
                        <span id="total-text" style=""><b>Total</b></span>
                        <b id="total-price-total" style="">Rs
                            <?php echo $sales_2[0]['final_amount'] != 0 && !empty($sales_2[0]['final_amount']) ? $sales_2[0]['final_amount'] : 0; ?></b>
                    </div>

                    <div id="rec-box" style="">
                        <span id="rec-text" style="">Received</span>

                        <span
                            id="rec-total">Rs<?php echo $sales_2[0]['recevied_amount'] != 0 && !empty($sales_2[0]['recevied_amount']) ? $sales_2[0]['recevied_amount'] : 0; ?></span>
                    </div>

                    <div id="bala-box" style=" 
                ">
                        <span id="bala-text" style="">Balance</span>
                        Rs <?php echo !empty($customers[0]['balance']) ? $sales_2[0]['final_amount'] : 0.00; ?>
                    </div>



                    <div id="cb-box" style=" 
                ">
                        <span id="cb-text" style="">Current Balance</span>
                        Rs
                        <?php echo !empty($customers[0]['balance']) ? $total_price + $customers[0]['balance'] : $customers[0]['balance']; ?>
                    </div>
                </div>


            </div>

        </div>
    </div>
    <button id="downloadBtn">Download as PDF</button>

    <!-- <script src="assets/js/jquery.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>

    <script>
    // Examples
    document.getElementById('downloadBtn').addEventListener('click', function() {
        // Set your page options here
        const options = {
            filename: 'your_document.pdf', // Name of the PDF file
            image: {
                type: 'jpeg',
                quality: 0.98
            }, // Quality and type of images
            html2canvas: {
                scale: 2
            }, // Scale of HTML content
            jsPDF: {
                unit: 'in',
                format: 'letter',
                orientation: 'portrait'
            } // Page settings
        };

        // Convert HTML to PDF
        html2pdf().from(document.body).set(options).save();
    });
    // $(document).ready(e => {
    //     var currentTime = new Date();

    //     // Get the current hour, minute, and second
    //     var hours = currentTime.getHours();
    //     var minutes = currentTime.getMinutes();
    //     var seconds = currentTime.getSeconds();
    //     // Determine if it's AM or PM
    //     var period = hours < 12 ? "AM" : "PM";

    //     // Adjust hours for AM/PM format
    //     hours = hours % 12;
    //     hours = hours ? hours : 12; // Handle midnight (0 hours)
    //     const time = `Time : ${hours}:${minutes}:${seconds} ${period}`;
    //     document.getElementById("time").textContent = time;



    //     function convertNumberToWords(number) {
    //         // Handle invalid input (negative numbers or decimals)
    //         if (number < 0 || !Number.isInteger(number)) {
    //             return 'Invalid input: Please enter a non-negative integer.';
    //         }

    //         // Handle numbers exceeding the range supported by the function
    //         if (number >= 1000000000000) { // Limit to 12 digits
    //             return 'Number too large: The function currently supports up to 12-digit integers.';
    //         }

    //         // Define an array of words for single digits
    //         var ones = [
    //             '', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine'
    //         ];

    //         // Define an array of words for teens (10-19)
    //         var teens = [
    //             'ten', 'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen',
    //             'eighteen', 'nineteen'
    //         ];

    //         // Define an array of words for multiples of ten (20-90)
    //         var tens = [
    //             '', '', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety'
    //         ];

    //         // Define an array of words for larger denominations (thousands, millions, billions)
    //         var denominations = ['', 'thousand', 'million', 'billion'];

    //         // Initialize variables to store the result string and the remaining number
    //         let result = '';
    //         let remaining = number;

    //         // Iterate through denominations in descending order (billions to ones)
    //         for (let i = denominations.length - 1; i >= 0; i--) {
    //             var denomination = denominations[i];

    //             // Extract the relevant part of the number for this denomination
    //             var part = Math.floor(remaining / Math.pow(1000, i));
    //             remaining %= Math.pow(1000, i);

    //             // Handle numbers larger than 999 for each denomination
    //             if (part > 999) {
    //                 // Convert hundreds place
    //                 var hundreds = convertNumberToWords(part).trim();
    //                 if (hundreds) {
    //                     result += `${hundreds} hundred ${denomination} `;
    //                 }
    //             } else {
    //                 // Convert hundreds, tens, and ones places
    //                 if (part > 0) {
    //                     let convertedPart = '';

    //                     // Handle hundreds place
    //                     if (part >= 100) {
    //                         convertedPart += `${ones[Math.floor(part / 100)]} hundred `;
    //                         part %= 100;
    //                     }

    //                     // Handle tens and ones places
    //                     if (part >= 20) {
    //                         convertedPart += `${tens[Math.floor(part / 10)]} `;
    //                         part %= 10;
    //                     } else if (part >= 10) {
    //                         convertedPart += `${teens[part - 10]} `;
    //                         part = 0;
    //                     }

    //                     if (part > 0) {
    //                         convertedPart += `${ones[part]} `;
    //                     }

    //                     // Add converted part with denomination (except for zero)
    //                     if (convertedPart.trim()) {
    //                         result += `${convertedPart.trim()} ${denomination} `;
    //                     }
    //                 }
    //             }
    //         }

    //         // Remove trailing spaces
    //         return result.trim();
    //     }
    //     document.getElementById("aiw").textContent = convertNumberToWords(+<?php echo $total_price; ?>);

    // });
    </script>
</body>

</html>