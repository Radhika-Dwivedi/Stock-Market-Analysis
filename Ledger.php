<?php
// Include the database connection file
include 'db.php';

// Check if the connection is established
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch the transactions from the database
$sql = "SELECT id, transaction_date, transaction_type, asset_name, amount, brokerage FROM transactions";
$result = $conn->query($sql);
$transactions = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $transactions[] = $row;
    }
}

// Initialize variables for profit, loss, and column-wise sums
$profit = 0;
$loss = 0;
$total_balance = 0;
$credit_total = 0;
$debit_total = 0;
$brokerage_total = 0;

foreach ($transactions as $transaction) {
    $amount = $transaction['amount'];
    $brokerage = $transaction['brokerage'];

    $brokerage_total += $brokerage;

    if ($transaction['transaction_type'] == 'buy') {
        $loss += $amount + $brokerage;
        $total_balance -= $amount + $brokerage;
        $debit_total += $amount + $brokerage;
    } else {
        $profit += $amount - $brokerage;
        $total_balance += $amount - $brokerage;
        $credit_total += $amount - $brokerage;
    }

    // Update brokerage in the database (optional, for logging purposes)
    // $update_query = "UPDATE transactions SET brokerage = ? WHERE id = ?";
    // $update_stmt = $conn->prepare($update_query);
    // $update_stmt->bind_param("di", $brokerage, $transaction['id']);
    // $update_stmt->execute();
}

// Close the prepared statement (if used for update)
// $update_stmt->close();

// Close the database connection
$conn->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Equity Transactions Ledger</title>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/styles.css">
    <!-- Bootstrap 4 -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .info-box {
            display: flex;
            align-items: center;
            padding: 10px;
            background-color: #f1f1f1;
            border-radius: 8px;
            margin-bottom: 10px;
        }
        .info-box-icon {
            background-color: #4CAF50;
            padding: 10px;
            border-radius: 50%;
            color: white;
            margin-right: 10px;
        }
        .info-box-content {
            display: flex;
            flex-direction: column;
        }
        .info-box-content h5 {
            margin: 0;
        }
        .summary-box {
            padding: 20px;
            border-radius: 8px;
            background-color: #f9f9f9;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .summary-box .summary-header {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .summary-box .summary-value {
            font-size: 24px;
            margin-bottom: 5px;
        }
        .summary-box .summary-label {
            font-size: 14px;
            color: #777;
        }
        .profit-loss-box {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            border-radius: 8px;
            background-color: #e9f7ef;
            margin-bottom: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .profit-loss-box .icon {
            font-size: 36px;
            margin-right: 20px;
        }
        .profit-loss-box .profit {
            color: #28a745;
        }
        .profit-loss-box .loss {
            color: #dc3545;
        }
    </style>
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
                    <a href="index.php" class="nav-link">Home</a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a href="login.php" class="nav-link">Login</a>
                </li>
                <li class="nav-item">
                    <a href="register.php" class="nav-link">Sign Up</a>
                </li>
            </ul>
        </nav>
        <!-- Navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="index.php" class="brand-link">
                <span class="brand-text font-weight-light">FinTrackPro</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item">
                            <a href="portfolio.php" class="nav-link">
                                <i class="nav-icon fas fa-briefcase"></i>
                                <p>Portfolio</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="index.php" class="nav-link">
                                <i class="nav-icon fas fa-sign-out-alt"></i>
                                <p>Logout</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">Form</a>
                            <ul class="nav">
                                <li class="nav-item">
                                    <a href="equity_transaction_form/form.php" class="nav-link">Equity Transaction Form</a>
                                </li>
                                <li class="nav-item">
                                    <a href="mutual_funds_form/form.php" class="nav-link">Mutual Funds Transaction Form</a>
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
                            <h1>Equity Transactions Ledger</h1>
                        </div>
                        <div class="col-md-12 text-right">
                            <a href="index.php" class="btn btn-secondary">Back</a>
                        </div>
                    </div>
                </div>
            </section>
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <!-- Summary Boxes -->
                        <div class="col-md-3">
                            <div class="summary-box">
                                <div class="summary-header">Total Credit</div>
                                <div class="summary-value"><?php echo $credit_total; ?></div>
                                <div class="summary-label">Amount</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="summary-box">
                                <div class="summary-header">Total Debit</div>
                                <div class="summary-value"><?php echo $debit_total; ?></div>
                                <div class="summary-label">Amount</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="summary-box">
                                <div class="summary-header">Total Brokerage</div>
                                <div class="summary-value"><?php echo $brokerage_total; ?></div>
                                <div class="summary-label">Amount</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="summary-box">
                                <div class="summary-header">Total Balance</div>
                                <div class="summary-value"><?php echo $total_balance; ?></div>
                                <div class="summary-label">Amount</div>
                            </div>
                        </div>
                    </div>
                    <!-- Profit/Loss Scenario Box -->
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <div class="profit-loss-box">
                                <div class="info-box-icon">
                                    <i class="fas fa-chart-line icon"></i>
                                </div>
                                <div class="info-box-content">
                                    <h5>Profit</h5>
                                    <div class="summary-value profit"><?php echo $profit; ?></div>
                                    <p class="summary-label">Amount</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="profit-loss-box">
                                <div class="info-box-icon">
                                    <i class="fas fa-chart-line icon"></i>
                                </div>
                                <div class="info-box-content">
                                    <h5>Loss</h5>
                                    <div class="summary-value loss"><?php echo $loss; ?></div>
                                    <p class="summary-label">Amount</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Transactions Table -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Asset Name</th>
                                                <th>Credit</th>
                                                <th>Debit</th>
                                                <th>Brokerage</th>
                                                <th>Total Balance</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($transactions as $transaction): ?>
                                                <?php
                                                $amount = $transaction['amount'];
                                                $brokerage = $transaction['brokerage'];
                                                $credit = ($transaction['transaction_type'] == 'sell') ? $amount - $brokerage : 0;
                                                $debit = ($transaction['transaction_type'] == 'buy') ? $amount + $brokerage : 0;
                                                $total_balance += ($transaction['transaction_type'] == 'buy') ? -$amount - $brokerage : $amount - $brokerage;
                                                ?>
                                                <tr>
                                                    <td><?php echo $transaction['transaction_date']; ?></td>
                                                    <td><?php echo $transaction['asset_name']; ?></td>
                                                    <td><?php echo $credit; ?></td>
                                                    <td><?php echo $debit; ?></td>
                                                    <td><?php echo $brokerage; ?></td>
                                                    <td><?php echo $total_balance; ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
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
            <strong>&copy; 2023 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 3.2.0
            </div>
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->
    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.js"></script>
</body>
</html>
