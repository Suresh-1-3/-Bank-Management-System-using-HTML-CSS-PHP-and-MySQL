<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}

$username = $_SESSION['username']; // Get the username from the session


$user_id = $_SESSION['user_id'];

// Fetch last 10 transactions
$sql = "SELECT type, amount, created_at FROM transactions WHERE user_id = $user_id ORDER BY created_at DESC LIMIT 10";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction History</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
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
            max-width: 600px;
            margin: auto;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            background-color: white;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        button {
            margin-top: 20px;
            padding: 10px 15px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="header">

        <img src="hey.jpg" alt="Logo" /> <!-- Update with your image path -->
        <form method="post" action="logout.php" style="margin: 0;">
            <button type="submit" style="background-color: red; color: white;">Logout</button>
        </form>
    </div>
    <br>
    <br>


    <div class="container">
        
    <div class="username" >Name: <?php echo htmlspecialchars($username); ?></div>
        <h2>Transaction History</h2>
        <table>
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Amount</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['type']); ?></td>
                            <td>₹<?php echo htmlspecialchars($row['amount']); ?></td>
                            <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3">No transactions found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <button onclick="window.location.href='dashboard.php'">Back to Dashboard</button>
    </div>
</body>
</html>
