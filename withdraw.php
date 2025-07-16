<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}


$username = $_SESSION['username']; // Get the username from the session
 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $amount = floatval($_POST['amount']);
    $user_id = $_SESSION['user_id'];

    // Get current balance
    $sql = "SELECT balance FROM users WHERE id = $user_id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $balance = $row['balance'];

    // Validate withdraw amount is a number and less than or equal to 100000
    if ($amount > 0 && $amount <= 100000) {
        // Check if balance is sufficient
        if ($balance >= $amount) {
            // Update balance
            $sql = "UPDATE users SET balance = balance - $amount WHERE id = $user_id";
            $conn->query($sql);

            // Insert transaction record
            $transaction_sql = "INSERT INTO transactions (user_id, type, amount) VALUES ($user_id, 'withdraw', $amount)";
            $conn->query($transaction_sql);

            header("Location: dashboard.php");  // Redirect back to dashboard after withdrawal
            exit;
        } else {
            echo "Insufficient balance.";
        }
    } else {
        echo "Invalid amount. Please enter a value between ₹0 and ₹100,000.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Withdraw</title>
    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: aqua; 
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: #ffffff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .header img {
            height: 80px; /* Adjust height as necessary */
        }

        .container {
            max-width: 400px;
            width: 100%;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            text-align: center;
            margin: auto;
            background-color:white;
        }

        input, button {
            padding: 10px;
            margin: 10px 0;
            width: 100%;
            box-sizing: border-box;
        }

        button {
            cursor: pointer;
        }

        /* Validation error styling */
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="hey.jpg" alt="Logo" /> <!-- Update with your image path -->
        <h2>Withdraw Money</h2>
        <form method="post" action="logout.php" style="margin: 0;">
            <button type="submit" style="background-color: red; color: white;">Logout</button>
        </form>
    </div>
    <br>
    <br>
    
    <div class="container">
    <div class="username">Name:  <?php echo htmlspecialchars($username); ?></div>

        <form method="post" action="" onsubmit="return validateForm()">
            <input type="number" step="0.01" name="amount" id="amount" placeholder="Enter amount to withdraw" min="0" max="100000" required>
            <p class="error" id="error-message" style="display:none;">Amount must be between ₹0 and ₹100,000.</p>
            <button type="submit">Withdraw ₹</button>
        </form>
        <button onclick="window.location.href='dashboard.php'">Back to Dashboard</button>
    </div>

    <script>
        function validateForm() {
            const amount = parseFloat(document.getElementById('amount').value);
            const errorMessage = document.getElementById('error-message');

            if (isNaN(amount) || amount <= 0 || amount > 100000) {
                errorMessage.style.display = 'block';
                return false;
            }
            errorMessage.style.display = 'none';
            return true;
        }
    </script>
</body>
</html>
