<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
    @media print {
        @page {
            size: Folio;
            /* Set page size to A6 */
            margin: 0px;
            /* Remove default margin */
        }

        /* Additional print styles can go here */
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
    <div style="width: 360px;
   margin: 9.6px;">
        <h1 style="text-align: center;"><?php echo !empty($company['company_name']) ? $company['company_name'] : ""; ?>
        </h1>
        <p style="text-align: center;">Address: <?php echo !empty($company['address']) ? $company['address'] : ""; ?>,
            Ph. no.: <?php echo !empty($company['phone1']) ? $company['phone1'] : ""; ?>
            Email:
            <br />
            <?php echo !empty($company['email']) ? $company['email'] : ""; ?>
        </p>
        <p style="text-align: center;">WA: <?php echo !empty($company['phone1']) ? $company['phone1'] : ""; ?>
            <?php echo !empty($company['phone2']) ?  '- - '. $company['phone2'] : ""; ?>
        </p>
        <table style="border: 1px solid black;">
            <thead>
                <tr>
                    <th style="text-align:left;font-size: 15px;padding-right: 14px;">24-Mar-04 10:11:19 AM</th>
                    <th style="text-align:left;font-size: 15px;">Invoice: 3085</th>
                    <th style="text-align:left;font-size: 15px;">Unpaid</th>

                </tr>
                <tr>
                    <th style="text-align:left;font-size: 15px;">Cashier : asad</th>
                    <th style="text-align:left;font-size: 15px;">Name: Nisma G.S</th>

                </tr>
                <tr>
                    <th style="text-align:left;font-size: 15px;">Add : Gulpur</th>
                    <th style="text-align:left;font-size: 15px;">Phone: 03411141098</th>

                </tr>
            </thead>

        </table>
        <table style="border-collapse: collapse;border-top: 0px;" border="1">
            <thead>
                <th style="padding: 4.3px;">SR</th>
                <th style="padding: 4.3px;">Qty</th>
                <th style="padding: 4.3px;">Description</th>
                <th style="padding: 4.3px;">Rate</th>
                <th style="padding: 4.3px;">Total</th>
                <th style="padding: 4.3px;">Dis</th>
                <th style="padding: 4.3px;">%</th>
                <th style="padding: 4.3px;">G.Total</th>

            </thead>
        </table>
        <div style=" display: flex;
        justify-content: space-between;
        margin-top: 5px;">
            <div>
                <h4>Items: 31</h4>


                <p> <b>Terms and Conditions:</b> <br /> <textarea style="border: 0px;" placeholder="Type..." name=""
                        id="" cols="30" rows="10"></textarea></p>


            </div>
            <div style=" display: block;                width: 80%;
            ">
                <div style=" display: flex;
                justify-content: space-between;
                ">
                    <span style="text-align: left;font-size: 13px;">Sub Total</span>
                    <span style="font-size: 13px;">Rs <?php echo $total_price; ?></span>
                </div>


                <div style=" display: flex;
                justify-content: space-between;
                border-bottom: 1px solid black;
                ">
                    <span style="text-align: left;font-size: 13px;">Dicount
                        (<?php echo $sales_2[0]['discount'] != 0 && !empty($sales_2[0]['discount']) ? $sales_2[0]['discount'] : 0; ?>%)</span>
                    <span style="font-size: 13px;">Rs <?php echo $total_price; ?></span>
                </div>
                <div style=" display: flex;
                justify-content: space-between;
               
                ">
                    <span style="text-align: left;font-size: 13px;"><b>Total</b></span>
                    <b style="font-size: 13px;">Rs
                        <?php echo $sales_2[0]['final_amount'] != 0 && !empty($sales_2[0]['final_amount']) ? $sales_2[0]['final_amount'] : 0; ?></b>
                </div>

                <div style=" display: flex;
                justify-content: space-between;
                border-bottom: 1px solid black;
                ">
                    <span style="text-align: left;font-size: 13px;">Received</span>
                    Rs
                    <?php echo $sales_2[0]['recevied_amount'] != 0 && !empty($sales_2[0]['recevied_amount']) ? $sales_2[0]['recevied_amount'] : 0; ?>
                </div>

                <div style=" display: flex;
                justify-content: space-between;
                border-bottom: 1px solid black;
                ">
                    <span style="text-align: left;font-size: 13px;">Balance</span>
                    Rs <?php echo !empty($customers[0]['balance']) ? $sales_2[0]['final_amount'] : 0.00; ?>
                </div>



                <div style=" display: flex;
                justify-content: space-between;
                ">
                    <span style="text-align: left;font-size: 13px;">Current Balance</span>
                    Rs
                    <?php echo !empty($customers[0]['balance']) ? $total_price + $customers[0]['balance'] : $customers[0]['balance']; ?>
                </div>
            </div>


        </div>

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



        function convertNumberToWords(number) {
            // Handle invalid input (negative numbers or decimals)
            if (number < 0 || !Number.isInteger(number)) {
                return 'Invalid input: Please enter a non-negative integer.';
            }

            // Handle numbers exceeding the range supported by the function
            if (number >= 1000000000000) { // Limit to 12 digits
                return 'Number too large: The function currently supports up to 12-digit integers.';
            }

            // Define an array of words for single digits
            var ones = [
                '', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine'
            ];

            // Define an array of words for teens (10-19)
            var teens = [
                'ten', 'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen',
                'eighteen', 'nineteen'
            ];

            // Define an array of words for multiples of ten (20-90)
            var tens = [
                '', '', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety'
            ];

            // Define an array of words for larger denominations (thousands, millions, billions)
            var denominations = ['', 'thousand', 'million', 'billion'];

            // Initialize variables to store the result string and the remaining number
            let result = '';
            let remaining = number;

            // Iterate through denominations in descending order (billions to ones)
            for (let i = denominations.length - 1; i >= 0; i--) {
                var denomination = denominations[i];

                // Extract the relevant part of the number for this denomination
                var part = Math.floor(remaining / Math.pow(1000, i));
                remaining %= Math.pow(1000, i);

                // Handle numbers larger than 999 for each denomination
                if (part > 999) {
                    // Convert hundreds place
                    var hundreds = convertNumberToWords(part).trim();
                    if (hundreds) {
                        result += `${hundreds} hundred ${denomination} `;
                    }
                } else {
                    // Convert hundreds, tens, and ones places
                    if (part > 0) {
                        let convertedPart = '';

                        // Handle hundreds place
                        if (part >= 100) {
                            convertedPart += `${ones[Math.floor(part / 100)]} hundred `;
                            part %= 100;
                        }

                        // Handle tens and ones places
                        if (part >= 20) {
                            convertedPart += `${tens[Math.floor(part / 10)]} `;
                            part %= 10;
                        } else if (part >= 10) {
                            convertedPart += `${teens[part - 10]} `;
                            part = 0;
                        }

                        if (part > 0) {
                            convertedPart += `${ones[part]} `;
                        }

                        // Add converted part with denomination (except for zero)
                        if (convertedPart.trim()) {
                            result += `${convertedPart.trim()} ${denomination} `;
                        }
                    }
                }
            }

            // Remove trailing spaces
            return result.trim();
        }
        document.getElementById("aiw").textContent = convertNumberToWords(+<?php echo $total_price; ?>);
        // Examples

    });
    </script>
</body>

</html>