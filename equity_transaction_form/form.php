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
    $dividend = htmlspecialchars($_POST['dividend']);
    $amount = isset($_POST['amount']) ? htmlspecialchars($_POST['amount']) : (($quantity * $rate) + $dividend); // Default to calculated amount
    $brokerage = htmlspecialchars($_POST['brokerage']);

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO transactions (transaction_type, asset_name, transaction_date, quantity, rate, dividend, amount, brokerage) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssiddid", $transactionType, $assetName, $transactionDate, $quantity, $rate, $dividend, $amount, $brokerage);

    // Execute the statement
    if ($stmt->execute()) {
        // Redirect to show transaction details after saving
        header("Location: save_transaction.php?type=equity&transactionType=$transactionType&assetName=$assetName&transactionDate=$transactionDate&quantity=$quantity&rate=$rate&dividend=$dividend&amount=$amount&brokerage=$brokerage");
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
        <!-- Navbar -->

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
                            <a href="index.php" class="nav-link">
                                <i class="nav-icon fas fa-briefcase"></i>
                                <p>Home</p>
                            </a>
                        </li>
                       
                        <li class="nav-item">
                            <a href="../Ledger.php" class="nav-link">
                                <i class="nav-icon fas fa-briefcase"></i>
                                <p>Ledger</p>
                            </a>
                        </li>   
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
                                    <form id="equityForm" role="form" action="form.php" method="POST">
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
                                                    <td><input type="number" class="form-control" id="quantity" name="quantity" required></td>
                                                </tr>
                                                <tr>
                                                    <td>Rate</td>
                                                    <td><input type="number" class="form-control" id="rate" name="rate" required></td>
                                                </tr>
                                                <tr>
                                                    <td>Dividend</td>
                                                    <td><input type="number" class="form-control" id="dividend" name="dividend" required></td>
                                                </tr>
                                                <tr>
                                                    <td>Amount</td>
                                                    <td><input type="number" class="form-control" id="amount" name="amount" readonly></td>
                                                </tr>
                                                <tr>
                                                    <td>Brokerage</td>
                                                    <td><input type="number" class="form-control" id="brokerage" name="brokerage" readonly></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div class="row">
                                            <div class="col-md-12 text-right">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                                <a href="../index.php" class="btn btn-secondary">Back</a>
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

        <!-- Main Footer -->
        <footer class="main-footer">
            <strong>&copy; 2023 <a href="#">FinTrackPro</a>.</strong>
            All rights reserved.
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="../plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../dist/js/adminlte.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const quantityInput = document.getElementById('quantity');
            const rateInput = document.getElementById('rate');
            const dividendInput = document.getElementById('dividend');
            const amountInput = document.getElementById('amount');
            const brokerageInput = document.getElementById('brokerage');

            function updateAmount() {
                const quantity = parseFloat(quantityInput.value) || 0;
                const rate = parseFloat(rateInput.value) || 0;
                const dividend = parseFloat(dividendInput.value) || 0;
                const amount = (quantity * rate) + dividend;
                amountInput.value = amount.toFixed(2);

                // Update brokerage value here based on your brokerage calculation logic
                const brokerage = 0.005 * amount; // Example: 0.5% brokerage fee
                brokerageInput.value = brokerage.toFixed(2);
            }

            quantityInput.addEventListener('input', updateAmount);
            rateInput.addEventListener('input', updateAmount);
            dividendInput.addEventListener('input', updateAmount);
        });
    </script>
</body>
</html>
