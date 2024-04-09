<?php
session_start();

// Check if user is logged in as admin
if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Check if user is admin
include('db_connection.php');
$username = $_SESSION['username'];
$sql = "SELECT role FROM users WHERE username='$username'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
if ($row['role'] != 'admin') {
    echo "Unauthorized access!";
    exit();
}

// Retrieve orders with customer usernames and total cost
$sql_orders = "SELECT orders.*, users.username AS customer_username, orders.total_cost AS total_cost FROM orders INNER JOIN users ON orders.customer_username = users.username";
$result_orders = $conn->query($sql_orders);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - View Orders</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            margin-top: 30px;
            margin-bottom: 20px;
            color: #333;
        }

        table {
            width: 80%;
            margin: 0 auto;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #007bff;
            color: #fff;
            font-weight: bold;
            text-transform: uppercase;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        a {
            text-decoration: none;
            color: #007bff;
        }

        a:hover {
            text-decoration: underline;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Back button styles */
        .back-btn {
            margin-top: 20px;
            text-align: center;
        }

        .back-btn a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .back-btn a:hover {
            background-color: #555;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Orders</h2>
        <table>
            <tr>
                <th>Order ID</th>
                <th>Product Name</th>
                <th>Customer Username</th>
                <th>Total Cost</th>
            </tr>
            <?php
            if ($result_orders && $result_orders->num_rows > 0) {
                while($row = $result_orders->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>".$row["order_id"]."</td>";
                    echo "<td>".$row["product_name"]."</td>";
                    echo "<td>".$row["customer_username"]."</td>";
                    echo "<td>".$row["total_cost"]."</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No orders found</td></tr>";
            }
            ?>
        </table>
        <div class="back-btn">
            <a href="admin_dashboard.php">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>
