<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username']; // Get the username from the session


// Get user balance
$sql = "SELECT balance FROM users WHERE id = $user_id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$balance = $row['balance'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: aqua; 
        }
         
        .container {
            max-width: 600px;
            width: 100%;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            text-align: center;
            margin: auto;
            background-color:white;
            
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .header img {
            height: 80px; /* Adjust height as necessary */
        }

        .header h2 {
            margin: 0;
            flex: 1;
            text-align: center;
        }

        button {
            padding: 10px;
            margin: 10px;
            width: 100%;
            cursor: pointer;
            font-size: 16px;
        }

        .balance-info {
            font-size: 24px;
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="hey.jpg" alt="Logo" /> <!-- Update with your image path -->
        <h2>Welcome to your Bank Dashboard</h2>
        <form method="post" action="logout.php" style="margin: 0;">
            <button type="submit" style="background-color: red; color: white;">Logout</button>
        </form>
    </div>

    <div class="container">
        <p class="balance-info">Your current balance: ₹<?php echo $balance; ?></p>

        <!-- Withdraw and Deposit Buttons -->
        <button onclick="window.location.href='deposit.php'">Deposit</button>
        <button onclick="window.location.href='withdraw.php'">Withdraw</button>
        <button onclick="window.location.href='transaction_history.php'">Mini Statement</button>

    </div>
</body>
</html>
