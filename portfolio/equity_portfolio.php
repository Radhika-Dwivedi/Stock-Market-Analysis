<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "transaction");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to calculate brokerage
function calculateBrokerage($quantity, $rate, $amount) {
    // Your brokerage calculation logic here
    // For example, calculating brokerage as 0.1% of the transaction amount
    $brokerage = $amount * 0.001; // Change this calculation as per your business logic
    return $brokerage;
}

// Update brokerage if current value is 0
$update_query = "UPDATE transactions SET brokerage = ? WHERE id = ?";
$update_stmt = $conn->prepare($update_query);

$select_query = "SELECT * FROM transactions";
$select_stmt = $conn->prepare($select_query);
$select_stmt->execute();
$equity_result = $select_stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Equity Transactions - FinTrackPro</title>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../dist/css/adminlte.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/styles.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Optional JavaScript -->
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- Popper.js, then Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>
    <style>
        /* Icon styles */
        .table .actions a {
            color: #343a40; /* Match navbar color */
            margin-right: 10px; /* Spacing between icons */
        }

        .table .actions a:last-child {
            margin-right: 0; /* Remove right margin for the last icon */
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
                            <a href="index.php" class="nav-link">
                                <i class="nav-icon fas fa-briefcase"></i>
                                <p>Home</p>
                            </a>
                        </li>
                       
                        <li class="nav-item">
                            <a href="Ledger.php" class="nav-link">
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
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Equity Transactions</h1>
                        </div>
                        <div class="col-sm-6 text-right">
                            <a href="../portfolio/portfolio.html" class="btn btn-secondary mt-3">Back</a>
                        </div>
                    </div>
                </div>
            </section>
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box">
                                <div class="box-body">
                                    <div class="table-responsive">
                                        <?php
                                        if ($equity_result->num_rows > 0) {
                                            echo '<table id="equityTable" class="table table-bordered table-striped">';
                                            echo '<thead>';
                                            echo '<tr>';
                                            echo '<th>Transaction Type</th>';
                                            echo '<th>Asset Name</th>';
                                            echo '<th>Transaction Date</th>';
                                            echo '<th>Quantity</th>';
                                            echo '<th>Rate</th>';
                                            echo '<th>Amount</th>';
                                            echo '<th>Dividend</th>';
                                            echo '<th>Brokerage</th>'; // New column for brokerage
                                            echo '<th>Actions</th>'; // New column for actions
                                            echo '</tr>';
                                            echo '</thead>';
                                            echo '<tbody>';
                                            while ($row = $equity_result->fetch_assoc()) {
                                                // Calculate brokerage if current value is 0
                                                if ($row['brokerage'] == 0) {
                                                    $quantity = $row['quantity'];
                                                    $rate = $row['rate'];
                                                    $amount = $row['amount'];
                                                    $brokerage = calculateBrokerage($quantity, $rate, $amount);

                                                    // Update brokerage in database
                                                    $update_stmt->bind_param("di", $brokerage, $row['id']);
                                                    $update_stmt->execute();

                                                    // Update the $row variable for display
                                                    $row['brokerage'] = $brokerage;
                                                }

                                                echo '<tr>';
                                                echo '<td>' . htmlspecialchars($row['transaction_type']) . '</td>';
                                                echo '<td>' . htmlspecialchars($row['asset_name']) . '</td>';
                                                echo '<td>' . htmlspecialchars($row['transaction_date']) . '</td>';
                                                echo '<td>' . htmlspecialchars($row['quantity']) . '</td>';
                                                echo '<td>' . htmlspecialchars($row['rate']) . '</td>';
                                                echo '<td>' . htmlspecialchars($row['amount']) . '</td>';
                                                echo '<td>' . htmlspecialchars($row['dividend']) . '</td>';
                                                echo '<td>' . htmlspecialchars($row['brokerage']) . '</td>'; // Display brokerage
                                                echo '<td class="actions">';
                                                // Edit link with confirmation
                                                echo '<a href="../equity_transaction_form/edit_equity_transaction.php?id=' . $row['id'] . '" class="edit" data-id="' . $row['id'] . '"><i class="fas fa-edit"></i></a>';
                                                // Delete link with confirmation
                                                echo '<a href="../equity_transaction_form/delete_equity_transaction.php?id=' . $row['id'] . '" class="delete" data-id="' . $row['id'] . '"><i class="fas fa-trash"></i></a>';
                                                echo '</td>';
                                                echo '</tr>';
                                            }
                                            echo '</tbody>';
                                            echo '</table>';
                                        } else {
                                            echo '<p>No equity transactions found.</p>';
                                        }
                                        ?>
                                    </div>
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
            <div class="float-right d-none d-sm-inline">
                Anything you want
            </div>
            <strong>&copy; 2024 <a href="#">FinTrackPro</a>.</strong> All rights reserved.
        </footer>
    </div>
    <!-- ./wrapper -->

    <script>
        $(document).ready(function() {
            $('#equityTable').DataTable({
                "responsive": true,
                "autoWidth": false,
                "pageLength": 5 // Show 5 entries by default
            });

            // Delete record confirmation
            $('.delete').click(function(e) {
                e.preventDefault(); // Prevent default link behavior
                var id = $(this).data('id');
                if (confirm('Are you sure you want to delete this record?')) {
                    window.location.href = '../equity_transaction_form/delete_equity_transaction.php?id=' + id;
                }
            });

            // Edit record confirmation (optional)
            $('.edit').click(function(e) {
                e.preventDefault(); // Prevent default link behavior
                var id = $(this).data('id');
                if (confirm('Proceed to edit this record?')) {
                    window.location.href = '../equity_transaction_form/edit_equity_transaction.php?id=' + id;
                }
            });
        });
    </script>
</body>
</html>
