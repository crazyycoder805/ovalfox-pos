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
        exit;
    }

    $ledger = $pdo->read("ledger", ['id' => $_GET['leid']]);
    $company = $pdo->read("companies_profile", ['id' => $_SESSION['ovalfox_pos_cp_id']])[0];
    $user = $pdo->read("customers", ['id' => $ledger[0]['payment_from']]);
    ?>

    <style>
        * {
            margin: 0;
            padding: 0;
            font-size: 25px !important;
        }

        @media print {
            @page {
                size: 8.5in 11in;
                margin: 2cm;
            }

            #bbtn {
                display: none;
            }
        }

        body {
            font-size: 12px;
        }

        #main {
            padding-left: 3px;
        }

        #company_name,
        #address,
        #whatsapp {
            text-align: center;
        }

        #table-info {
            font-size: 12px;
        }

        #table-data-product {
            border-collapse: collapse;
            width: 100%;
        }

        #footer-outer,
        #sub-total-inner,
        #discount-outer,
        #total-box,
        #rec-box,
        #bala-box,
        #cb-box,#cbb-box {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            border-bottom: 1px solid black;

        }

        #footer-outer {
            margin-top: 5px;
            padding: 5px;
        }

        #terms-cond {
            border: 0;
        }
    </style>
</head>

<body>

    <div class="page">
        <div id="main">
            <div id="main-inner">
                <p id="bbtn"><a href="sales.php">Back</a></p>

                <h1 id="company_name" style="color: royalblue;">
                    <?php echo !empty($company['company_name']) ? htmlspecialchars($company['company_name']) : ""; ?>
                </h1>
                <p id="address">Address: 
                    <?php echo htmlspecialchars($company['address'] ?? '') . ', Email: ' . htmlspecialchars($company['email'] ?? ''); ?>
                </p>
                <p id="whatsapp">WA: 
                    <?php 
                    echo htmlspecialchars($company['phone1'] ?? '') 
                        . (!empty($company['phone2']) ? ' - ' . htmlspecialchars($company['phone2']) : '') 
                        . (!empty($company['phone3']) ? ' - ' . htmlspecialchars($company['phone3']) : '');
                    ?>
                </p>

                <div id="table-info">
                    <div style="border: 2px solid black;"></div>

                    <div id="footer-outer">
                        <p><b>Details:</b> <br>
                            <textarea disabled style="font-size: 8px; color:red; font-weight: bolder;" 
                                      placeholder="Type..." cols="22" rows="3">
                                <?php echo htmlspecialchars($ledger[0]['details'] ?? ''); ?>
                            </textarea>
                        </p>

                        <div id="sub-total">
                            <div id="bala-box">
                                <span><b>Customer:</b></span>
                                <?php echo $user[0]['name']; ?>
                            </div>

                            <div id="sub-total-inner">
                                <span><b>Payment Type:</b></span>
                                <span><?php echo htmlspecialchars($ledger[0]['payment_type']); ?></span>
                            </div>

                            <div id="discount-outer">
                                <span><b>Total Amount:</b></span> Rs
                                <?php echo !empty($ledger[0]['total_amount']) ? $ledger[0]['total_amount'] : 0; ?>
                            </div>

                            <div id="total-box">
                                <span><b>Received Amount:</b></span> Rs
                                <?php echo !empty($ledger[0]['recevied_amount']) ? $ledger[0]['recevied_amount'] : 0; ?>
                            </div>

                            <div id="rec-box">
                                <span><b>Remaining Amount:</b></span> Rs
                                <?php echo !empty($ledger[0]['remaining_amount']) ? $ledger[0]['remaining_amount'] : 0; ?>
                            </div>

                            <div id="cb-box">
                                <span><b>Previous Balance:</b></span> Rs
                                <?php echo !empty($ledger[0]['prev_blnc']) ? $ledger[0]['prev_blnc'] : 0;; ?>
                            </div>
                            <div id="cbb-box">
                                <span><b>Current Balance:</b></span> Rs
                                <?php echo !empty($ledger[0]['blnce']) ? $ledger[0]['blnce'] : 0;; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div style="width: 100%; border-bottom: 1px solid black;"></div>
                <h6 style="text-align: center;">Powered By ovalfox.com || Contact 0334 8647633</h6>
            </div>
        </div>
    </div>

    <button hidden id="downloadBtn">Download as PDF</button>

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/print.js"></script>
    <script>
        const options = {
            filename: 'small_inv.pdf',
            image: { type: 'png', quality: 0.98 },
            html2canvas: { scale: 2 },
            jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
        };

        html2pdf().from(document.body).set(options).save();
    </script>
</body>

</html>
