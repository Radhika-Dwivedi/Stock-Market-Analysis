<?php
// Include database connection
include '../db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize form data
    $transactionType = htmlspecialchars($_POST['transactionType']);
    $assetName = htmlspecialchars($_POST['assetName']);
    $transactionDate = htmlspecialchars($_POST['transactionDate']);
    $quantity = htmlspecialchars($_POST['quantity']);
    $rate = htmlspecialchars($_POST['rate']);
    $dividend = isset($_POST['dividend']) ? htmlspecialchars($_POST['dividend']) : (($quantity * $rate) * 0.02); // Default to calculated dividend (example: 2% of (quantity * rate))
    $amount = isset($_POST['amount']) ? htmlspecialchars($_POST['amount']) : (($quantity * $rate) + $dividend); // Default to calculated amount
    $brokerage = isset($_POST['brokerage']) ? htmlspecialchars($_POST['brokerage']) : (($quantity * $rate) * 0.005); // Default to calculated brokerage (example: 0.5% of (quantity * rate))

    // Calculate STT, GST, Stamp Charge, Other Charges, Transaction Charges, and Total Charges
    $stt = ($transactionType === 'sell') ? ($quantity * $rate) * 0.001 : 0; // 0.1% of (quantity * rate) on sell transactions
    $gst = ($brokerage) * 0.18; // 18% GST on brokerage
    $stampCharge = $rate * 0.003; // Example: Stamp charge as 0.3% of rate
    $otherCharges = 100; // Example: Fixed other charges
    $transactionCharges = $stt + $gst + $stampCharge + $otherCharges; // Sum of all charges
    $totalCharges = $amount + $transactionCharges; // Total amount including charges

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO transactions (transaction_type, asset_name, transaction_date, quantity, rate, dividend, amount, brokerage, stt, gst, stamp_charge, other_charges, transaction_charges, total_charges) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssiddiddddddd", $transactionType, $assetName, $transactionDate, $quantity, $rate, $dividend, $amount, $brokerage, $stt, $gst, $stampCharge, $otherCharges, $transactionCharges, $totalCharges);

    // Execute the statement
    if ($stmt->execute()) {
        // Redirect to show transaction details after saving
        header("Location: save_transaction.php?type=equity&transactionType=$transactionType&assetName=$assetName&transactionDate=$transactionDate&quantity=$quantity&rate=$rate&dividend=$dividend&amount=$amount&brokerage=$brokerage&stt=$stt&gst=$gst&stampCharge=$stampCharge&otherCharges=$otherCharges&transactionCharges=$transactionCharges&totalCharges=$totalCharges");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Equity Transaction Form</title>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../dist/css/adminlte.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/styles.css">
    <!-- Bootstrap 4 -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item">
                    <a href="../index.php" class="nav-link">Home</a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a href="../login.php" class="nav-link">Login</a>
                </li>
                <li class="nav-item">
                    <a href="../register.php" class="nav-link">Sign Up</a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="../index.php" class="brand-link">
                <span class="brand-text font-weight-light">FinTrackPro</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item">
                            <a href="../portfolio/portfolio.html" class="nav-link">
                                <i class="nav-icon fas fa-briefcase"></i>
                                <p>Portfolio</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../index.php" class="nav-link">
                                <i class="nav-icon fas fa-sign-out-alt"></i>
                                <p>Logout</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">Form</a>
                            <ul class="nav">
                                <li class="nav-item">
                                    <a href="../equity_transaction_form/form.php" class="nav-link">Equity Transaction Form</a>
                                </li>
                                <li class="nav-item">
                                    <a href="../mutual_funds_form/form.php" class="nav-link">Mutual Funds Transaction Form</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Equity Transaction Form</h1>
                        </div>
                    </div>
                </div>
            </section>
            <section class="content">
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col-md-10">
                            <div class="card">
                                <div class="card-body">
                                    <form id="equityForm" role="form" action="form.php" method="POST" onsubmit="return confirm('Are you sure you want to submit this form?');">
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <td>Transaction Type</td>
                                                    <td>
                                                        <select class="form-control" id="transactionType" name="transactionType" required>
                                                            <option value="buy">Buy</option>
                                                            <option value="sell">Sell</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Asset Name</td>
                                                    <td>
                                                        <select class="form-control" id="assetName" name="assetName" required>
                                                            <option value="">Select an asset</option>
                                                            <option value="AAPL">Apple Inc. (AAPL)</option>
                                                            <option value="MSFT">Microsoft Corporation (MSFT)</option>
                                                            <option value="GOOGL">Alphabet Inc. (GOOGL)</option>
                                                            <option value="AMZN">Amazon.com, Inc. (AMZN)</option>
                                                            <option value="TSLA">Tesla, Inc. (TSLA)</option>
                                                            <option value="BRK.A">Berkshire Hathaway Inc. (BRK.A)</option>
                                                            <option value="JNJ">Johnson & Johnson (JNJ)</option>
                                                            <option value="V">Visa Inc. (V)</option>
                                                            <option value="PG">Procter & Gamble Co. (PG)</option>
                                                            <option value="JPM">JPMorgan Chase & Co. (JPM)</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Transaction Date</td>
                                                    <td><input type="date" class="form-control" id="transactionDate" name="transactionDate" required></td>
                                                </tr>
                                                <tr>
                                                    <td>Quantity</td>
                                                    <td><input type="number" step="any" class="form-control" id="quantity" name="quantity" required></td>
                                                </tr>
                                                <tr>
                                                    <td>Rate</td>
                                                    <td><input type="number" step="any" class="form-control" id="rate" name="rate" required></td>
                                                </tr>
                                                <tr>
                                                    <td>Dividend</td>
                                                    <td><input type="number" step="any" class="form-control" id="dividend" name="dividend"></td>
                                                </tr>
                                                <tr>
                                                    <td>Amount</td>
                                                    <td><input type="number" step="any" class="form-control" id="amount" name="amount" readonly></td>
                                                </tr>
                                                <tr>
                                                    <td>Brokerage</td>
                                                    <td><input type="number" step="any" class="form-control" id="brokerage" name="brokerage" readonly></td>
                                                </tr>
                                                <tr>
                                                    <td>STT</td>
                                                    <td><input type="number" step="any" class="form-control" id="stt" name="stt" readonly></td>
                                                </tr>
                                                <tr>
                                                    <td>GST</td>
                                                    <td><input type="number" step="any" class="form-control" id="gst" name="gst" readonly></td>
                                                </tr>
                                                <tr>
                                                    <td>Stamp Charge</td>
                                                    <td><input type="number" step="any" class="form-control" id="stampCharge" name="stampCharge" readonly></td>
                                                </tr>
                                                <tr>
                                                    <td>Other Charges</td>
                                                    <td><input type="number" step="any" class="form-control" id="otherCharges" name="otherCharges" readonly></td>
                                                </tr>
                                                <tr>
                                                    <td>Transaction Charges</td>
                                                    <td><input type="number" step="any" class="form-control" id="transactionCharges" name="transactionCharges" readonly></td>
                                                </tr>
                                                <tr>
                                                    <td>Total Charges</td>
                                                    <td><input type="number" step="any" class="form-control" id="totalCharges" name="totalCharges" readonly></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div class="row">
                                            <div class="col-md-12 text-right">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                                <a href="../index.php" class="btn btn-default">Back</a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <!-- To the right -->
            <div class="float-right d-none d-sm-inline">
                Financial records keepers.
            </div>
            <!-- Default to the left -->
            <strong>We are always on the right track</strong>.
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="../plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../dist/js/adminlte.min.js"></script>
    <!-- Custom Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const quantityInput = document.getElementById('quantity');
            const rateInput = document.getElementById('rate');
            const dividendInput = document.getElementById('dividend');
            const amountInput = document.getElementById('amount');
            const brokerageInput = document.getElementById('brokerage');
            const sttInput = document.getElementById('stt');
            const gstInput = document.getElementById('gst');
            const stampChargeInput = document.getElementById('stampCharge');
            const otherChargesInput = document.getElementById('otherCharges');
            const transactionChargesInput = document.getElementById('transactionCharges');
            const totalChargesInput = document.getElementById('totalCharges');

            function updateAmount() {
                const quantity = parseFloat(quantityInput.value) || 0;
                const rate = parseFloat(rateInput.value) || 0;
                const dividend = parseFloat(dividendInput.value) || ((quantity * rate) * 0.02); // Default to calculated dividend (example: 2% of (quantity * rate))
                const amount = (quantity * rate) + dividend;
                amountInput.value = amount.toFixed(2);

                // Update brokerage value here based on your brokerage calculation logic
                const brokerage = (quantity * rate) * 0.005; // Example: 0.5% brokerage fee
                brokerageInput.value = brokerage.toFixed(2);

                // Update STT, GST, and Stamp Charge
                const stt = (transactionType.value === 'sell') ? (quantity * rate) * 0.001 : 0; // 0.1% of (quantity * rate) on sell transactions
                sttInput.value = stt.toFixed(2);

                const gst = (brokerage) * 0.18; // 18% GST on brokerage
                gstInput.value = gst.toFixed(2);

                const stampCharge = rate * 0.003; // Example: Stamp charge as 0.3% of rate
                stampChargeInput.value = stampCharge.toFixed(2);

                const otherCharges = 100; // Example: Fixed other charges
                otherChargesInput.value = otherCharges.toFixed(2);

                const transactionCharges = parseFloat(sttInput.value) + parseFloat(gstInput.value) + parseFloat(stampChargeInput.value) + parseFloat(otherChargesInput.value);
                transactionChargesInput.value = transactionCharges.toFixed(2);

                const totalCharges = parseFloat(amountInput.value) + parseFloat(transactionChargesInput.value);
                totalChargesInput.value = totalCharges.toFixed(2);
            }

            quantityInput.addEventListener('input', updateAmount);
            rateInput.addEventListener('input', updateAmount);
            dividendInput.addEventListener('input', updateAmount);
        });
    </script>
</body>
</html>
