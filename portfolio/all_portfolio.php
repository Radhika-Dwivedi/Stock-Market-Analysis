<?php
$conn = new mysqli("localhost", "root", "", "transaction");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch Equity Transactions
$equity_query = "SELECT * FROM transactions";
$equity_result = $conn->query($equity_query);

// Fetch Mutual Funds Transactions
$mutual_funds_query = "SELECT * FROM mutual_funds_transactions";
$mutual_funds_result = $conn->query($mutual_funds_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Equity and Mutual Funds Transactions - FinTrackPro</title>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="../dist/css/adminlte.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/styles.css">
    <style>
        body {
            height: auto;
            overflow-x: hidden;
        }
        .wrapper {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .content-wrapper {
            flex: 1;
            overflow-y: auto;
        }
        .box {
            background: #f0f0f0;
            border-radius: 5px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .box-header {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .box-body {
            padding-top: 10px;
        }
        .main-footer {
            margin-top: auto;
            background: #f8f9fa;
            padding: 10px 0;
            text-align: center;
        }
        .actions a {
            margin-right: 0px;
        }
    </style>
</head>
<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light sticky-top">
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
                            <a href="../index.php" class="nav-link">
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
                            <a href="#" class="nav-link">Forms</a>
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
                            <h1>Equity and Mutual Funds Transactions</h1>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- Equity Transactions -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Equity Transactions</h3>
                                    <div class="float-right">
                                        <a href="../portfolio/portfolio.html" class="btn btn-secondary">Back</a>
                                    </div>
                                </div>
                                <div class="box-body">
                                    <?php if ($equity_result->num_rows > 0): ?>
                                        <table id="equityTable" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Asset Name</th>
                                                    <th>Transaction Date</th>
                                                    <th>Quantity</th>
                                                    <th>Rate</th>
                                                    <th>Amount</th>
                                                    <th>Dividend</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php while ($row = $equity_result->fetch_assoc()): ?>
                                                    <tr>
                                                        <td><?= htmlspecialchars($row['asset_name']) ?></td>
                                                        <td><?= htmlspecialchars($row['transaction_date']) ?></td>
                                                        <td><?= htmlspecialchars($row['quantity']) ?></td>
                                                        <td><?= htmlspecialchars($row['rate']) ?></td>
                                                        <td><?= htmlspecialchars($row['amount']) ?></td>
                                                        <td><?= htmlspecialchars($row['dividend']) ?></td>
                                                        <td class="actions">
                                                            <a href="../equity_transaction_form/edit_equity_transaction.php?id=<?= $row['id'] ?>" class="btn btn-sm "><i class="fas fa-edit"></i></a>
                                                            <a href="../equity_transaction_form/delete_equity_transaction.php?id=<?= $row['id'] ?>" class="btn btn-sm "><i class="fas fa-trash"></i></a>
                                                        </td>
                                                    </tr>
                                                <?php endwhile; ?>
                                            </tbody>
                                        </table>
                                    <?php else: ?>
                                        <p>No equity transactions found.</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Mutual Funds Transactions -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Mutual Funds Transactions</h3>
                                </div>
                                <div class="box-body">
                                    <?php if ($mutual_funds_result->num_rows > 0): ?>
                                        <table id="mutualFundsTable" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Transaction Date</th>
                                                    <th>Mutual Fund Name</th>
                                                    <th>Quantity</th>
                                                    <th>NAV</th>
                                                    <th>Net Amount</th>
                                                    <th>Stamp Charge</th>
                                                    <th>Gross Amount</th>
                                                    <th>Dividend</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php while ($row = $mutual_funds_result->fetch_assoc()): ?>
                                                    <tr>
                                                        <td><?= htmlspecialchars($row['transaction_date']) ?></td>
                                                        <td><?= htmlspecialchars($row['mf_name']) ?></td>
                                                        <td><?= htmlspecialchars($row['quantity']) ?></td>
                                                        <td><?= htmlspecialchars($row['nav']) ?></td>
                                                        <td><?= htmlspecialchars($row['net_amount']) ?></td>
                                                        <td><?= htmlspecialchars($row['stamp_charge']) ?></td>
                                                        <td><?= htmlspecialchars($row['gross_amount']) ?></td>
                                                        <td><?= htmlspecialchars($row['dividend']) ?></td>
                                                        <td class="actions">
                                                            <a href="../mutual_funds_form/edit_mf_transaction.php?id=<?= $row['id'] ?>" class="btn btn-sm "><i class="fas fa-edit"></i></a>
                                                            <a href="../mutual_funds_form/delete_mf_transaction.php?id=<?= $row['id'] ?>" class="btn btn-sm "><i class="fas fa-trash"></i></a>
                                                        </td>
                                                    </tr>
                                                <?php endwhile; ?>
                                            </tbody>
                                        </table>
                                    <?php else: ?>
                                        <p>No mutual funds transactions found.</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <!-- To the right -->
            <div class="float-right d-none d-sm-inline">
                FinTrackPro
            </div>
            <!-- Default to the left -->
            <strong>© 2024 <a href="#">FinTrackPro</a>.</strong> All rights reserved.
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
    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>
    <!-- Page Script -->
    <script>
        $(document).ready(function() {
            $('#equityTable').DataTable({
                "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
                "pageLength": 5,
                "pagingType": "full_numbers",
                "scrollX": true,
                "scrollY": "auto",
                "scrollCollapse": true,
                "autoWidth": false,
                "responsive": true
            });

            $('#mutualFundsTable').DataTable({
                "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
                "pageLength": 5,
                "pagingType": "full_numbers",
                "scrollX": true,
                "scrollY": "auto",
                "scrollCollapse": true,
                "autoWidth": false,
                "responsive": true
            });
        });
    </script>
</body>
</html>

<?php
$conn->close();
?>
