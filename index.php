<?php
session_start();

// Check if the user is logged in
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    $username = 'Guest'; // Default value if no user is logged in
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio - FinTrackPro</title>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/styles.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .main-sidebar {
            background-color: #343a40 !important; /* Custom sidebar color */
        }
        .small-box {
            position: relative;
            display: block;
            box-shadow: 0 1px 1px rgba(0,0,0,0.1);
            border-radius: .25rem;
            color: #fff;
            text-align: center;
            padding: 20px;
        }
        .small-box .inner {
            padding: 10px;
        }
        .small-box h3, .small-box p {
            margin: 0;
        }
        .small-box h3 {
            font-size: 2.2rem;
            font-weight: bold;
        }
        .small-box p {
            font-size: 1.2rem;
        }
        .small-box .icon {
            position: absolute;
            top: -10px;
            right: 10px;
            font-size: 90px;
            transition: all 0.3s linear;
        }
        .small-box:hover .icon {
            font-size: 95px;
        }
        .small-box .small-box-footer {
            position: relative;
            text-align: center;
            padding: 3px 0;
            color: rgba(255,255,255,0.8);
            display: block;
            transition: all 0.3s linear;
        }
        .small-box:hover .small-box-footer {
            color: #fff;
        }
        .content-wrapper {
            margin-top: 20px; /* Add margin between navbar and content */
        }
        .chart-container {
            position: relative;
            height: 400px;
            width: 100%;
        }
        .small-box.bg-warning .inner h3,
.small-box.bg-warning .inner p,
.small-box.bg-warning .small-box-footer {
    color: #fff !important;
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
            <a href="index.php" class="nav-link">Home</a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <?php if ($username !== 'Guest'): ?>
            <li class="nav-item">
                <a class="nav-link">Welcome, <?php echo htmlspecialchars($username); ?></a>
            </li>
            <li class="nav-item">
                <a href="logout.php" class="nav-link">Logout</a>
            </li>
        <?php else: ?>
            <li class="nav-item">
                <a href="login.php" class="nav-link">Login</a>
            </li>
            <li class="nav-item">
                <a href="register.php" class="nav-link">Sign Up</a>
            </li>
        <?php endif; ?>
    </ul>
</nav>

        <!-- /.navbar -->

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
                            <a href="portfolio/portfolio.html" class="nav-link">
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
                            <a href="#" class="nav-link">Forms</a>
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
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Dashboard</h1>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- Small boxes (Stat box) -->
                    <div class="row">
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3>Equity</h3>
                                    <p><a href="equity_transaction_form/form.php" class="text-white" style="text-decoration:none;">Get Started</a></p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <a href="portfolio/equity_portfolio.php" class="small-box-footer">Portfolio <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>Mutual Funds</h3>
                                    <p><a href="mutual_funds_form/form.php" class="text-white" style="text-decoration:none;">Get Started</a></p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                                <a href="portfolio/mutual_funds_portfolio.php" class="small-box-footer">Portfolio <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3>Ledger</h3>
                                    <p>Get Started</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="Ledger.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <h3>Chart</h3>
                                    <p>Get Started</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-pie-graph"></i>
                                </div>
                                <a href="chart/chart.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                    </div>
                    <!-- /.row -->

                    <!-- Chart Section -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Profit and Loss Chart</h3>
                                </div>
                                <div class="card-body">
                                    <div class="chart-container">
                                        <canvas id="profitLossChart"></canvas>
                                    </div>
                                </div>
                            </div>
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
            <strong>&copy; 2023 <a href="#">FinTrackPro</a>.</strong>
            All rights reserved.
        </footer>
        <!-- /.main-footer -->
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->
    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
    <!-- Chart.js -->
    <script>
        $(document).ready(function() {
            $('.small-box').hover(function() {
                $(this).find('.icon').css('font-size', '100px');
            }, function() {
                $(this).find('.icon').css('font-size', '90px');
            });

            // Default Profit and Loss Chart
            var ctx = document.getElementById('profitLossChart').getContext('2d');
            var profitLossChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Today', 'Yesterday', 'This Week', 'This Month', 'This Year'],
                    datasets: [{
                        label: 'Profit & Loss',
                        data: [1200, 1900, 3000, 2500, 3800], // Example data
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>
