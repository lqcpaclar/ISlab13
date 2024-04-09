<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <style>
        /* Body styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        /* Header styles */
        h2 {
            color: #343a40;
            text-align: center;
            margin-top: 50px;
        }

        /* Form styles */
        form {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 10px;
            color: #343a40;
        }

        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ced4da;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
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
            background-color: #495057;
        }
    </style>
</head>
<body>
    <h2>Add Product</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="product_name">Product Name:</label>
        <input type="text" id="product_name" name="product_name" required><br><br>

        <label for="product_price">Price:</label>
        <input type="number" id="product_price" name="product_price" step="0.01" min="0" required><br><br>

        <input type="submit" value="Add Product">
    </form>
    <div class="back-btn">
        <a href="admin_dashboard.php">Back to Admin Dashboard</a>
    </div>
    <?php
    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Establish database connection
        include('db_connection.php');

        // Get form data
        $product_name = $_POST['product_name'];
        $product_price = $_POST['product_price'];

        // Prepare and execute SQL query to insert data into the database
        $sql = "INSERT INTO products (name, price) VALUES ('$product_name', '$product_price')";

        if ($conn->query($sql) === TRUE) {
            echo "<p style='text-align:center;'>Product added successfully!</p>";
        } else {
            echo "<p style='text-align:center;'>Error adding product: " . $conn->error . "</p>";
        }

        $conn->close();
    }
    ?>
</body>
</html>