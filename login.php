<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Fetch user from the database
    $sql = "SELECT id, password FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // Verify password
        if (password_verify($password, $row['password'])) {
            // Set session variables
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $username; // Store username in session
            header("Location: dashboard.php");  // Redirect to dashboard after successful login
            exit;
        } else {
            header("Location: login.html?error=invalid_password");  // Redirect with error message
            exit;
        }
    } else {
        header("Location: login.html?error=invalid_username");  // Redirect with error message
        exit;
    }

    $conn->close();
}
?>
