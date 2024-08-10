<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "transaction");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$mutual_funds_query = "SELECT * FROM mutual_funds_transactions"; // Adjusted table name
$mutual_funds_result = $conn->query($mutual_funds_query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mutual Funds Transactions - FinTrackPro</title>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- AdminLTE Theme style -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/styles.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE Script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/js/adminlte.min.js"></script>
    <style>
        /* Custom styles */
        
        .table .actions a {
            color: #343a40; /* Match navbar color */
            margin-right: 10px; /* Spacing between icons */
        }

        .table .actions a:last-child {
            margin-right: 0; /* Remove right margin for the last icon */
        }

        .table .actions a.edit i {
            color: #343a40; /* Custom color for edit icon */
        }

        .table .actions a.delete i {
            color: #343a40; /* Custom color for delete icon */
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
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Mutual Funds Transactions</h1>
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
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <?php
                                        if ($mutual_funds_result->num_rows > 0) {
                                            echo '<table id="mutualFundsTable" class="table table-bordered table-striped">';
                                            echo '<thead>';
                                            echo '<tr>';
                                            echo '<th>Transaction Date</th>';
                                            echo '<th>Mutual Fund Name</th>';
                                            echo '<th>Quantity</th>';
                                            echo '<th>NAV</th>';
                                            echo '<th>Net Amount</th>';
                                            echo '<th>Stamp Charge</th>';
                                            echo '<th>Gross Amount</th>';
                                            echo '<th>Dividend</th>';
                                            echo '<th>Actions</th>'; // New column for actions
                                            echo '</tr>';
                                            echo '</thead>';
                                            echo '<tbody>';
                                            while ($row = $mutual_funds_result->fetch_assoc()) {
                                                echo '<tr>';
                                                echo '<td>' . htmlspecialchars($row['transaction_date']) . '</td>';
                                                echo '<td>' . htmlspecialchars($row['mf_name']) . '</td>';
                                                echo '<td>' . htmlspecialchars($row['quantity']) . '</td>';
                                                echo '<td>' . htmlspecialchars($row['nav']) . '</td>';
                                                echo '<td>' . htmlspecialchars($row['net_amount']) . '</td>';
                                                echo '<td>' . htmlspecialchars($row['stamp_charge']) . '</td>';
                                                echo '<td>' . htmlspecialchars($row['gross_amount']) . '</td>';
                                                echo '<td>' . htmlspecialchars($row['dividend']) . '</td>';
                                                echo '<td class="actions">';
                                                echo '<a href="../mutual_funds_form/edit_mf_transaction.php?id=' . $row['id'] . '" class="edit" data-id="' . $row['id'] . '"><i class="fas fa-edit"></i></a>';
                                                echo '<a href="../mutual_funds_form/delete_mf_transaction.php?id=' . $row['id'] . '" class="delete" data-id="' . $row['id'] . '"><i class="fas fa-trash"></i></a>';
                                                echo '</td>';
                                                echo '</tr>';
                                            }
                                            echo '</tbody>';
                                            echo '</table>';
                                        } else {
                                            echo '<p>No mutual funds transactions found.</p>';
                                        }

                                        $conn->close();
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
            $('#mutualFundsTable').DataTable({
                "responsive": true,
                "autoWidth": false,
                "pageLength": 5, // Show 5 entries by default
                "lengthMenu": [5, 10, 25, 50, 75, 100], // Custom length menu
                "language": {
                    "lengthMenu": "Show _MENU_ entries",
                    "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                    "search": "Search:",
                    "paginate": {
                        "first": "First",
                        "last": "Last",
                        "next": "Next",
                        "previous": "Previous"
                    }
                }
            });

            // Confirmation dialog for delete action
            $('.delete').on('click', function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                if (confirm('Are you sure you want to delete this transaction?')) {
                    window.location.href = '../mutual_funds_form/delete_mf_transaction.php?id=' + id;
                }
            });

            // Confirmation dialog for edit action (optional)
            $('.edit').on('click', function(e) {
                e.preventDefault();
                if (confirm('Proceed to edit this transaction?')) {
                    window.location.href = $(this).attr('href');
                }
            });
        });
    </script>
</body>
</html>
