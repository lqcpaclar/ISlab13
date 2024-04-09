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

// Handle order submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['product_id']) && isset($_POST['quantity'])) {
        $product_id = $_POST['product_id'];
        $quantity = $_POST['quantity'];
        $customer_username = $_SESSION['username'];
        
        // Retrieve product details
        $sql_product = "SELECT name, price FROM products WHERE id='$product_id'";
        $result_product = $conn->query($sql_product);
        if ($result_product->num_rows > 0) {
            $row_product = $result_product->fetch_assoc();
            $product_name = $row_product['name'];
            $product_price = $row_product['price'];

            // Calculate total cost
            $total_cost = $product_price * $quantity;

            // Insert order into database
            $sql_order = "INSERT INTO orders (product_name, quantity, total_cost, customer_username) VALUES ('$product_name', '$quantity', '$total_cost', '$customer_username')";
            if ($conn->query($sql_order) === TRUE) {
                echo "Order placed successfully!";
            } else {
                echo "Error: " . $sql_order . "<br>" . $conn->error;
            }
        } else {
            echo "Product not found!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Place Order</title>
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

        form {
            max-width: 500px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        select, input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"], .btn {
            background-color: #4CAF50;
            color: #fff;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
            text-decoration: none;
            display: inline-block;
            margin-top: 10px;
        }

        input[type="submit"]:hover, .btn:hover {
            background-color: #45a049;
        }

        p {
            text-align: center;
            margin-top: 20px;
        }

        p a, .btn {
            color: #fff;
            text-decoration: none;
            display: inline-block;
        }

        .btn-back {
            background-color: #4CAF50;
        }

        .btn-back:hover {
            background-color: #555;
        }
    </style>
</head>
<body>
    <h2>Place Order</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <!-- Assuming you have a dropdown to select products -->
        <label for="product_id">Select Product:</label>
        <select id="product_id" name="product_id">
            <?php
            // Retrieve products from the database
            $sql_products = "SELECT id, name, price FROM products";
            $result_products = $conn->query($sql_products);
            if ($result_products->num_rows > 0) {
                while($row = $result_products->fetch_assoc()) {
                    echo "<option value='".$row['id']."'>".$row['name']." - $".$row['price']."</option>";
                }
            }
            ?>
        </select>
        
        <label for="quantity">Quantity:</label>
        <input type="number" id="quantity" name="quantity" min="1" value="1" required>

        <input type="submit" value="Order">
    </form>
    <p><a href="customer_dashboard.php" class="btn btn-back">Back to Dashboard</a></p>
</body>
</html>
