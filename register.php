<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password for security
    
    // Check if username already exists
    $sql = "SELECT id FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "Username already exists.";
    } else {
        // Insert new user
        $sql = "INSERT INTO users (username, password, balance) VALUES ('$username', '$password', 0.00)";
        
        if ($conn->query($sql) === TRUE) {
            header("Location: login.html?register=success");  // Redirect to login page with success message
            exit;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    $conn->close();
}
?>
