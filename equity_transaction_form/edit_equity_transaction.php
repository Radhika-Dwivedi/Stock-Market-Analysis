<?php
include '../db.php';

// Handle the form submission to update the record
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $transaction_type = $_POST['transaction_type'];
    $asset_name = $_POST['asset_name'];
    $transaction_date = $_POST['transaction_date'];
    $quantity = $_POST['quantity'];
    $rate = $_POST['rate'];
    $amount = $_POST['amount'];
    $dividend = $_POST['dividend'];
    $brokerage = $_POST['brokerage'];

    // Calculate brokerage if it's zero
    if ($brokerage == 0) {
        $brokerage = calculateBrokerage($asset_name, $transaction_type, $quantity, $rate, $amount);
    }

    // Prepare and execute update query using prepared statements
    $stmt = $conn->prepare("UPDATE transactions SET transaction_type = ?, asset_name = ?, transaction_date = ?, quantity = ?, rate = ?, amount = ?, dividend = ?, brokerage = ? WHERE id = ?");
    $stmt->bind_param("sssidddii", $transaction_type, $asset_name, $transaction_date, $quantity, $rate, $amount, $dividend, $brokerage, $id);

    if ($stmt->execute()) {
        // Redirect to equity transactions table page after successful update
        header("Location: ../portfolio/equity_portfolio.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
    exit();
}

// Function to calculate brokerage based on company name, transaction type, quantity, rate, and amount
function calculateBrokerage($asset_name, $type, $qty, $rate, $amt) {
    // Example logic, adjust as per your business rules
    $brokerage_percentage = 0.01; // Example: 1% brokerage
    $brokerage_fixed = 10; // Example: Fixed brokerage amount
    $brokerage = 0;

    // Calculate brokerage based on company name, type, quantity, rate, amount, etc.
    if ($asset_name == 'AAPL') {
        // Example: Apple Inc. (AAPL) specific brokerage calculation
        if ($type == 'buy') {
            $brokerage = $qty * $rate * $brokerage_percentage;
        } elseif ($type == 'sell') {
            $brokerage = $qty * $rate * $brokerage_percentage;
        }
    } elseif ($asset_name == 'MSFT') {
        // Example: Microsoft Corporation (MSFT) specific brokerage calculation
        if ($type == 'buy') {
            $brokerage = $amt * $brokerage_percentage;
        } elseif ($type == 'sell') {
            $brokerage = $amt * $brokerage_percentage;
        }
    }
    // Add more conditions for other company names as needed

    return $brokerage;
}

// Check if ID is provided via GET method
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare and execute select query using prepared statements
    $stmt = $conn->prepare("SELECT * FROM transactions WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Check if brokerage is zero, calculate and update if needed
        if ($row['brokerage'] == 0) {
            $row['brokerage'] = calculateBrokerage($row['asset_name'], $row['transaction_type'], $row['quantity'], $row['rate'], $row['amount']);
            // Update brokerage in the database for this record
            $update_stmt = $conn->prepare("UPDATE transactions SET brokerage = ? WHERE id = ?");
            $update_stmt->bind_param("di", $row['brokerage'], $id);
            $update_stmt->execute();
        }
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
    <title>Edit Equity Transaction - FinTrackPro</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/styles.css">
    <script>
        // Function to confirm update action
        function confirmUpdate() {
            if (confirm('Are you sure you want to update this record?')) {
                document.getElementById('updateForm').submit();
            }
        }

        // Function to calculate brokerage and update field
        function calculateAndSetBrokerage() {
            var quantity = document.getElementById('quantity').value;
            var rate = document.getElementById('rate').value;
            var amount = document.getElementById('amount').value;
            var assetName = document.getElementById('assetName').value;
            var transactionType = document.getElementById('transactionType').value;
            var brokerage = document.getElementById('brokerage').value;

            // Check if brokerage is zero, calculate and update if needed
            if (brokerage == 0) {
                // Call PHP function to calculate brokerage dynamically
                var calculatedBrokerage = <?php echo calculateBrokerage('asset_name', 'transaction_type', 'quantity', 'rate', 'amount'); ?>;
                
                // Update brokerage field value
                document.getElementById('brokerage').value = calculatedBrokerage;
            }
        }
    </script>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Edit Equity Transaction</div>
                    <div class="card-body">
                        <form id="updateForm" action="" method="POST">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
                            <div class="form-group">
                                <label for="transactionType">Transaction Type</label>
                                <select class="form-control" id="transactionType" name="transaction_type" onchange="calculateAndSetBrokerage()" required>
                                    <option value="buy" <?php if ($row['transaction_type'] == 'buy') echo 'selected'; ?>>Buy</option>
                                    <option value="sell" <?php if ($row['transaction_type'] == 'sell') echo 'selected'; ?>>Sell</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="assetName">Asset Name</label>
                                <select class="form-control" id="assetName" name="asset_name" onchange="calculateAndSetBrokerage()" required>
                                    <option value="AAPL" <?php if ($row['asset_name'] == 'AAPL') echo 'selected'; ?>>Apple Inc. (AAPL)</option>
                                    <option value="MSFT" <?php if ($row['asset_name'] == 'MSFT') echo 'selected'; ?>>Microsoft Corporation (MSFT)</option>
                                    <!-- Add other options as needed -->
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="transactionDate">Transaction Date</label>
                                <input type="date" class="form-control" id="transactionDate" name="transaction_date" value="<?php echo htmlspecialchars($row['transaction_date']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="quantity">Quantity</label>
                                <input type="number" class="form-control" id="quantity" name="quantity" value="<?php echo htmlspecialchars($row['quantity']); ?>" onchange="calculateAndSetBrokerage()" required>
                            </div>
                            <div class="form-group">
                                <label for="rate">Rate</label>
                                <input type="number" class="form-control" id="rate" name="rate" value="<?php echo htmlspecialchars($row['rate']); ?>" onchange="calculateAndSetBrokerage()" required>
                            </div>
                            <div class="form-group">
                                <label for="amount">Amount</label>
                                <input type="number" class="form-control" id="amount" name="amount" value="<?php echo htmlspecialchars($row['amount']); ?>" onchange="calculateAndSetBrokerage()" required>
                            </div>
                            <div class="form-group">
                                <label for="dividend">Dividend</label>
                                <input type="number" class="form-control" id="dividend" name="dividend" value="<?php echo htmlspecialchars($row['dividend']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="brokerage">Brokerage</label>
                                <input type="number" class="form-control" id="brokerage" name="brokerage" value="<?php echo htmlspecialchars($row['brokerage']); ?>" readonly>
                            </div>
                            <button type="button" onclick="confirmUpdate()" class="btn btn-primary">Update</button>
                            <a href="../portfolio/equity_portfolio.php" class="btn btn-secondary">Cancel</a>
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
