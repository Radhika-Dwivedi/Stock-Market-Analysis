<?php
session_start();

// Dummy credentials for demonstration
$valid_email = "user@example.com";
$valid_password = "password";

// Assuming form data is being sent via POST
$email = $_POST['email'];
$password = $_POST['password'];

// Check if credentials are valid
if ($email === $valid_email && $password === $valid_password) {
    // Set session variables
    $_SESSION['loggedin'] = true;
    $_SESSION['username'] = 'John Doe'; // Replace with the actual username

    // Redirect to index page or any other page
    header("Location: index.php");
    exit();
} else {
    // Handle invalid credentials
    echo "Invalid credentials";
}
?>
