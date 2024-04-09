<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Orders</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px 15px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            color: #333;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f2f2f2;
        }

        td[colspan="4"] {
            text-align: center;
        }

        .button-container {
            text-align: center;
            margin-top: 20px;
        }

        a.button {
            display: inline-block;
            padding: 10px 20px;
            text-decoration: none;
            background-color: #4CAF50;
            color: #fff;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        a.button:hover {
            background-color: #555;
        }
        </style>
</head>
<body>
    <h2>Order History</h2>
    <table>
        <tr>
            <th>Order ID</th>
            <th>Product Name</th>
            <th>Quantity</th>
            <th>Total Cost</th>
            <!-- Add more columns as needed -->
        </tr>
        <?php
        session_start();

        // Check if user is logged in as customer
        if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
            header("Location: login.php");
            exit();
        }

        // Check if user is customer
        include('db_connection.php');
        $username = $_SESSION['username'];
        $sql = "SELECT role FROM users WHERE username='$username'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        if ($row['role'] != 'customer') {
            echo "Unauthorized access!";
            exit();
        }

        // Retrieve orders for the current customer
        $sql = "SELECT * FROM orders WHERE customer_username='$username'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>".$row["order_id"]."</td>";
                echo "<td>".$row["product_name"]."</td>";
                echo "<td>".$row["quantity"]."</td>"; // Display quantity
                echo "<td>".$row["total_cost"]."</td>"; // Display total cost
                // Add more columns as needed
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No orders found</td></tr>";
        }
        ?>
    </table>
    <div class="button-container">
        <a href="customer_dashboard.php" class="button">Back to Dashboard</a>
    </div>
</body>
</html>
