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

<body>
    <div style="width: 90%;
   margin: 0 auto;
   padding: 20px;
   box-sizing: border-box;">
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
        <h2 style="text-align: center;text-decoration: underline;">Invoice</h2>

        <div style=" display: flex;
        justify-content: space-between;
        ">
            <b>Bill To: <?php echo $customers[0]['name']; ?></b>
            <table style="border-collapse: collapse;">
                <thead>
                    <tr>
                        <th>Invoice No. : <?php echo $sales_2[0]['invoice_number']; ?></th>
                    </tr>
                    <tr>
                        <th>Bill No. : <?php echo $sales_2[0]['bill_number']; ?></th>
                    </tr>
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
        <table style="border-collapse: collapse;">
            <thead style="padding: 10px;background-color: grey !important;color: white;">
                <tr>
                    <th style="padding-right:8px; border-bottom: 1px solid black;">#</th>
                    <th style="padding-right: 8px; border-bottom: 1px solid black;">ItemName</th>
                    <th style="padding-right:8px; border-bottom: 1px solid black;">Qty</th>
                    <th style="padding-right: 8px; border-bottom: 1px solid black;">Price/Unit</th>
                    <th style="border-bottom: 1px solid black;padding-right:8px;">Amount</th>
                    <th style="border-bottom: 1px solid black;padding-right:8px;">Discount</th>
                    <th style="border-bottom: 1px solid black;padding-right:8px;">ExtraDiscount</th>
                    <th style="border-bottom: 1px solid black;padding-right:8px;">%</th>
                    <th style="border-bottom: 1px solid black;padding-right:8px;">G.Total</th>

                    <th style="border-bottom: 1px solid black;">ProductDetails</th>

                </tr>
            </thead>
            <tbody>

                <?php 
            foreach ($sales_1 as $index => $sale) {
                $index += 1;
                $total_quantity += $sale['quantity'];
                $total_price += $sale['amount'];

            ?>
                <tr>
                    <td style="border-bottom: 1px solid black;"><?php echo $index; ?></td>
                    <td style="border-bottom: 1px solid black;"><?php echo $sale['item_name']; ?>
                    </td>
                    <td style="border-bottom: 1px solid black;"><?php echo $sale['quantity']; ?>
                    </td>
                    <td style="border-bottom: 1px solid black;">
                        <?php echo $sale['item_price']; ?></td>
                    <td style="border-bottom: 1px solid black;"><?php echo $sale['amount']; ?></td>
                    <td style="border-bottom: 1px solid black;"><?php echo $sale['discount']; ?></td>
                    <td style="border-bottom: 1px solid black;"><?php echo $sale['extra_discount']; ?></td>
                    <td style="border-bottom: 1px solid black;"><?php echo !empty($sale['percentage']) ? $sale['percentage'] : 0; ?></td>
                    <td style="border-bottom: 1px solid black;"><?php echo !empty($sale['amount']) ? $sale['amount'] : 0; ?></td>

                    <td style="border-bottom: 1px solid black;"><?php echo !empty(trim($sales_2[0]['details'])) ? $sales_2[0]['details'] : "NULL"; ?></td>

                </tr>
                <?php } ?>
                <tr>
                    <th style="border-bottom: 1px solid black;"></th>
                    <th style="text-align: left;border-bottom: 1px solid black;">Total</th>
                    <th style="text-align: left;border-bottom: 1px solid black;"><?php echo $total_quantity; ?></th>
                    <th style="text-align: right;border-bottom: 1px solid black;" colspan="7">Rs
                        <?php echo $total_price; ?></th>
                </tr>
            </tbody>

        </table>
        <br />
        <br />

        <div style=" display: flex;
        justify-content: space-between;
        ">
            <div style="width: 400px;">
                <p> <b>Invoice Amount In Words:</b> <span id="aiw"></span> only</p>

                <p> <b>Terms and Conditions:</b> <br /> <textarea style="border: 0px;" placeholder="Type..." name=""
                        id="" cols="30" rows="10"></textarea></p>


            </div>
            <div style=" display: block;                width: 80%;
            ">
                <div style=" display: flex;
                justify-content: space-between;
                ">
                    <span style="text-align: left;padding-left: 30px;">Sub Total</span>
                    Rs <?php echo $total_price; ?>
                </div>
                <br />

                <div style=" display: flex;
                justify-content: space-between;
                border-bottom: 1px solid black;
                ">
                    <span style="text-align: left;padding-left: 30px;">Dicount
                        (<?php echo $sales_2[0]['discount'] != 0 && !empty($sales_2[0]['discount']) ? $sales_2[0]['discount'] : 0; ?>%)</span>
                    Rs <?php $per = intval(($total_price / 100) * $sales_2[0]['discount'], 2); echo $per; ?>
                </div>
                <div style=" display: flex;
                justify-content: space-between;
               
                ">
                    <span style="text-align: left;padding-left: 30px;"><b>Total</b></span>
                    <b>Rs
                        <?php echo $per; ?></b>
                </div>
                <br />
                <div style=" display: flex;
                justify-content: space-between;
                border-bottom: 1px solid black;
                ">
                    <span style="text-align: left;padding-left: 30px;">Received</span>
                    Rs
                    <?php echo $sales_2[0]['recevied_amount'] != 0 && !empty($sales_2[0]['recevied_amount']) ? $sales_2[0]['recevied_amount'] : 0; ?>
                </div>
                <br />
                <div style=" display: flex;
                justify-content: space-between;
                border-bottom: 1px solid black;
                ">
                    <span style="text-align: left;padding-left: 30px;">Balance</span>
                    Rs <?php echo !empty($customers[0]['balance']) ? $customers[0]['balance'] : 0.00; ?>
                </div>
                <br />


                <div style=" display: flex;
                justify-content: space-between;
                ">
                    <span style="text-align: left;padding-left: 30px;">Current Balance</span>
                    Rs
                    <?php if (!empty($customers[0]['balance'])) {
                        echo $per + $customers[0]['balance'];
                        } else if(!empty($customers[0]['balance'])) {
                            echo $customers[0]['balance'];
                        } else {
                            echo 0;
                        } ?>
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
        document.getElementById("aiw").textContent = convertNumberToWords(+<?php echo $per; ?>);
        // Examples

    });
    </script>
</body>

</html>