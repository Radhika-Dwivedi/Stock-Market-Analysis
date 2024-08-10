<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mutual Funds Transaction Form</title>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="../dist/css/adminlte.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/styles.css">
    <style>
        .form-table {
            display: grid;
            gap: 20px;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        }

        .form-group {
            margin-bottom: 0; /* Remove default margin to reduce spacing */
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
    </style>
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
                                <i class="nav-icon fas fa-briefcase"></i>
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
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Mutual Funds Transaction Form</h1>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <!-- General form elements -->
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Enter Transaction Details</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form role="form" id="mutualFundsForm" action="save_transaction.php" method="post">
                                    <div class="card-body form-table">
                                        <div class="form-group">
                                            <label for="mfName">Mutual Fund Name</label>
                                            <select class="form-control" id="mfName" name="mfName" required>
                                                <option value="">Select a mutual fund</option>
                                                <option value="HDFC Top 100 Fund">HDFC Top 100 Fund</option>
                                                <option value="ICICI Prudential Bluechip Fund">ICICI Prudential Bluechip Fund</option>
                                                <option value="SBI Bluechip Fund">SBI Bluechip Fund</option>
                                                <!-- Add more options as needed -->
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="transactionDate">Transaction Date</label>
                                            <input type="date" class="form-control" id="transactionDate" name="transactionDate" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="quantity">Quantity</label>
                                            <input type="number" class="form-control" id="quantity" name="quantity" placeholder="Enter quantity" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="nav">Net Asset Value (NAV)</label>
                                            <input type="number" step="any" class="form-control" id="nav" name="nav" placeholder="Enter NAV" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="netAmount">Net Amount</label>
                                            <input type="number" step="any" class="form-control" id="netAmount" name="netAmount" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="stampCharge">Stamp Charge</label>
                                            <input type="number" step="any" class="form-control" id="stampCharge" name="stampCharge" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="grossAmount">Gross Amount</label>
                                            <input type="number" step="any" class="form-control" id="grossAmount" name="grossAmount" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="dividend">Dividend</label>
                                            <input type="number" step="any" class="form-control" id="dividend" name="dividend" readonly>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->

                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                        <a href="../index.php" class="btn btn-secondary">Back</a>
                                    </div>
                                </form>
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                    <!-- /.row -->
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <!-- To the right -->
            <div class="float-right d-none d-sm-inline">
                Version 1.0
            </div>
            <!-- Default to the left -->
            <strong>Footer Section &copy; 2023 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
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
        $(document).ready(function() {
            // Calculate Net Amount, Stamp Charge, Gross Amount, and Dividend
            $('#quantity, #nav').on('input', function() {
                var quantity = parseFloat($('#quantity').val()) || 0;
                var nav = parseFloat($('#nav').val()) || 0;
                var netAmount = quantity * nav;
                var stampCharge = netAmount * 0.005; // Example: 0.5% stamp charge
                var grossAmount = netAmount + stampCharge;
                // Calculate dividend based on a formula (e.g., 2% of net amount)
                var dividend = netAmount * 0.02; // Example: 2% dividend

                $('#netAmount').val(netAmount.toFixed(2));
                $('#stampCharge').val(stampCharge.toFixed(2));
                $('#grossAmount').val(grossAmount.toFixed(2));
                $('#dividend').val(dividend.toFixed(2));
            });
        });
    </script>
</body>
</html>
