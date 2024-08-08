<?php
// Include database connection
include '../db.php';

// Handle the form submission to update the record
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $transaction_date = $_POST['transaction_date'];
    $mf_name = $_POST['mutual_funds_name']; // Assuming this matches the form field name
    $quantity = $_POST['quantity'];
    $nav = $_POST['nav'];
    $stamp_charge = $_POST['stamp_charge'];
    $gross_amount = $_POST['gross_amount'];
    $net_amount = $_POST['net_amount'];
    $dividend = $_POST['dividend'];

    // Prepare and execute update query using prepared statements
    $stmt = $conn->prepare("UPDATE mutual_funds_transactions SET transaction_date = ?, mf_name = ?, quantity = ?, nav = ?, stamp_charge = ?, gross_amount = ?, net_amount = ?, dividend = ? WHERE id = ?");
    $stmt->bind_param("ssdddddii", $transaction_date, $mf_name, $quantity, $nav, $stamp_charge, $gross_amount, $net_amount, $dividend, $id);

    if ($stmt->execute()) {
        // Redirect to mutual funds transactions table page after successful update
        header("Location: ../portfolio/mutual_funds_portfolio.php");
        exit();
    } else {
        echo "Error updating record: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
    exit();
}

// Check if ID is provided via GET method
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare and execute select query using prepared statements
    $stmt = $conn->prepare("SELECT * FROM mutual_funds_transactions WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        // If no record found with the provided ID
        echo "No record found";
        exit();
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    // If ID is not provided via GET method
    echo "Invalid request";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Mutual Funds Transaction - FinTrackPro</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/styles.css">
    <script>
        function confirmUpdate() {
            if (confirm('Are you sure you want to update this record?')) {
                document.getElementById('updateForm').submit();
            }
        }
    </script>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Edit Mutual Funds Transaction</div>
                    <div class="card-body">
                        <form id="updateForm" action="" method="POST">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
                            <div class="form-group">
                                <label for="transactionDate">Transaction Date</label>
                                <input type="date" class="form-control" id="transactionDate" name="transaction_date" value="<?php echo htmlspecialchars($row['transaction_date']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="mutualFundName">Mutual Fund Name</label>
                                <select class="form-control" id="mfName" name="mfName" required>
                                                <option value="">Select a mutual fund</option>
                                                <option value="HDFC Top 100 Fund">HDFC Top 100 Fund</option>
                                                <option value="ICICI Prudential Bluechip Fund">ICICI Prudential Bluechip Fund</option>
                                                <option value="SBI Bluechip Fund">SBI Bluechip Fund</option>
                                                <!-- Add more options as needed -->
                                            </select>
                                <input type="text" class="form-control" id="mutualFundName" name="mutual_funds_name" value="<?php echo htmlspecialchars($row['mf_name']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="quantity">Quantity</label>
                                <input type="number" class="form-control" id="quantity" name="quantity" value="<?php echo htmlspecialchars($row['quantity']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="nav">NAV</label>
                                <input type="number" step="any" class="form-control" id="nav" name="nav" value="<?php echo htmlspecialchars($row['nav']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="stampCharge">Stamp Charge</label>
                                <input type="number" step="any" class="form-control" id="stampCharge" name="stamp_charge" value="<?php echo htmlspecialchars($row['stamp_charge']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="grossAmount">Gross Amount</label>
                                <input type="number" step="any" class="form-control" id="grossAmount" name="gross_amount" value="<?php echo htmlspecialchars($row['gross_amount']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="netAmount">Net Amount</label>
                                <input type="number" step="any" class="form-control" id="netAmount" name="net_amount" value="<?php echo htmlspecialchars($row['net_amount']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="dividend">Dividend</label>
                                <input type="number" step="any" class="form-control" id="dividend" name="dividend" value="<?php echo htmlspecialchars($row['dividend']); ?>" required>
                            </div>
                            <button type="button" onclick="confirmUpdate()" class="btn btn-primary">Update</button>
                            <a href="../portfolio/mutual_funds_portfolio.php" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
