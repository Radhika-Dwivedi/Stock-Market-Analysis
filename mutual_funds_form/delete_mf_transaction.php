<?php
// Include database connection
include '../db.php';

// Check if ID is provided via GET method
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare and execute delete query using prepared statements
    $stmt = $conn->prepare("DELETE FROM mutual_funds_transactions WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Redirect to mutual funds transactions table page after successful deletion
        header("Location: ../portfolio/mutual_funds_portfolio.php");
        exit();
    } else {
        // If deletion fails, output the error
        echo "Error deleting record: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    // If ID is not provided via GET method
    echo "Invalid request";
}
?>
