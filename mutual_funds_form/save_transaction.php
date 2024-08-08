<?php
// Database connection parameters
$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'transaction';

// Connect to MySQL database
$conn = new mysqli($hostname, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables to store form data
$transactionDate = $mf_name = $quantity = $nav = $netAmount = $stampCharge = $grossAmount = $dividend = '';

// Check if the form is submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input data
    $transactionDate = mysqli_real_escape_string($conn, $_POST['transactionDate']);
    $mf_name = mysqli_real_escape_string($conn, $_POST['mutual_funds_name']);
    $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);
    $nav = mysqli_real_escape_string($conn, $_POST['nav']);
    $dividend = mysqli_real_escape_string($conn, $_POST['dividend']);

    // Calculate netAmount, stampCharge, and grossAmount
    $netAmount = $quantity * $nav;
    $stampCharge = $netAmount * 0.005; // Assuming 0.5% stamp charge
    $grossAmount = $netAmount + $stampCharge + $dividend;

    // Prepare SQL insert statement using prepared statements
    $stmt = $conn->prepare("INSERT INTO mutual_funds_transactions (transaction_date, mutual_funds_name, quantity, nav, net_amount, stamp_charge, gross_amount, dividend) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiddddd", $transactionDate, $mf_name, $quantity, $nav, $netAmount, $stampCharge, $grossAmount, $dividend);

    if ($stmt->execute()) {
        // Fetch the inserted record for display
        $last_id = $stmt->insert_id;
        $stmt->close();

        // Select the inserted record
        $sql_select = "SELECT * FROM mutual_funds_transactions WHERE id = $last_id";
        $result = $conn->query($sql_select);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            // Display the inserted data
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mutual Funds Transaction Form Submission</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../dist/css/adminlte.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/styles.css">
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
                            <a href="Ledger.php" class="nav-link">
                                <i class="nav-icon fas fa-briefcase"></i>
                                <p>Ledger</p>
                            </a>
                        </li>   
                    <li class="nav-item">
                            <a href="../portfolio.php" class="nav-link">
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
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Mutual Funds Transaction Form Submission</h1>
                        </div>
                    </div>
                </div>
            </section>
            <section class="content">
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-body">
                                    <p>New record created successfully</p>
                                    <p>Transaction ID: <?php echo $row["id"]; ?></p>
                                    <p>Transaction Date: <?php echo $row["transaction_date"]; ?></p>
                                    <p>Mutual Fund Name: <?php echo $row["mutual_funds_name"]; ?></p>
                                    <p>Quantity: <?php echo $row["quantity"]; ?></p>
                                    <p>NAV: <?php echo $row["nav"]; ?></p>
                                    <p>Net Amount: <?php echo $row["net_amount"]; ?></p>
                                    <p>Stamp Charge: <?php echo $row["stamp_charge"]; ?></p>
                                    <p>Gross Amount: <?php echo $row["gross_amount"]; ?></p>
                                    <p>Dividend: <?php echo $row["dividend"]; ?></p>
                                </div>
                                <div class="card-footer">
                                    <a href="../mutual_funds_form/form.php" class="btn btn-secondary">Back to Form</a>
                                    <a href="../portfolio.php" class="btn btn-primary">Portfolio</a>
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
            <strong>Copyright &copy; 2023 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 3.0.5
            </div>
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../dist/js/adminlte.min.js"></script>
    <!-- Custom JS -->
    <script src="js/scripts.js"></script>
</body>
</html>
<?php
        } else {
            echo "Error: Data not found";
        }
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Close database connection
$conn->close();
?>
