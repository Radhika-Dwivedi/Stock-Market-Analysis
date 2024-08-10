<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profit & Loss Chart - FinTrackPro</title>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../dist/css/adminlte.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/styles.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Datepicker CSS & JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <style>
        .main-sidebar {
            background-color: #343a40 !important; /* Custom sidebar color */
        }
        .content-wrapper {
            margin-top: 20px; /* Add margin between navbar and content */
        }
        .chart-container {
            width: 80%;
            margin: 20px auto;
        }
        .date-picker-container {
            margin: 20px auto;
            text-align: center;
        }
        .btn-custom {
            background-color: #343a40; /* Navbar color */
            color: #ffffff;
        }
        .btn-custom:hover {
            background-color: #23272b; /* Darker shade on hover */
            color: #ffffff;
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
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Profit & Loss Chart</h1>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- Date Range Picker -->
                    <div class="date-picker-container">
                        <div class="text-right mb-2">
                            <a href="../index.php" class="btn btn-custom">Back</a>
                        </div>
                        <input type="text" id="dateRange" placeholder="Select date range" class="form-control">
                        <button id="updateChart" class="btn btn-custom mt-2">Update Chart</button>
                    </div>
                    <!-- Chart -->
                    <div class="chart-container">
                        <canvas id="profitLossChart"></canvas>
                    </div>
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <strong>&copy; 2023 <a href="#">FinTrackPro</a>.</strong>
            All rights reserved.
        </footer>
        <!-- /.main-footer -->
    </div>
    <!-- ./wrapper -->
    <!-- REQUIRED SCRIPTS -->
    <!-- jQuery -->
    <script src="../plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../dist/js/adminlte.min.js"></script>
    <!-- Chart Script -->
    <script>
        var ctx = document.getElementById('profitLossChart').getContext('2d');
        var profitLossChart = new Chart(ctx, {
            type: 'line', // or 'bar', 'pie', etc.
            data: {
                labels: ['Today', 'Yesterday', 'This Week', 'This Month', 'This Year'],
                datasets: [{
                    label: 'Profit/Loss',
                    data: [12, 19, 3, 5, 2], // Initial data
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                responsive: true,
                maintainAspectRatio: false,
            }
        });

        // Date Picker Initialization
        flatpickr('#dateRange', {
            mode: 'range',
            dateFormat: 'Y-m-d'
        });

        // Update Chart on Button Click
        document.getElementById('updateChart').addEventListener('click', function() {
            var dateRange = document.getElementById('dateRange').value;
            // Simulate fetching data based on the selected date range
            var newLabels = ['Date 1', 'Date 2', 'Date 3', 'Date 4', 'Date 5'];
            var newData = [Math.random() * 100, Math.random() * 100, Math.random() * 100, Math.random() * 100, Math.random() * 100];
            
            // Update chart data
            profitLossChart.data.labels = newLabels;
            profitLossChart.data.datasets[0].data = newData;
            profitLossChart.update();
        });
    </script>
</body>
</html>
