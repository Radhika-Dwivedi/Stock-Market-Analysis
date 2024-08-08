<?php
include '../db.php';

// Check if ID is provided via GET method
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare and execute delete query using prepared statements
    $stmt = $conn->prepare("DELETE FROM transactions WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Redirect to equity transactions table page after successful deletion
        header("Location: ../portfolio/equity_portfolio.php");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    // If ID is not provided via GET method
    echo "Invalid request";
}
?>
