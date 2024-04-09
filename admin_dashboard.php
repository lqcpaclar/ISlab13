<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #333;
            text-align: left; /* Align the text to the left */
        }

        ul {
            list-style-type: none;
            padding: 0;
            text-align: left; /* Align the text to the left */
        }

        ul li {
            margin-bottom: 10px;
        }

        ul li a {
            display: block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        ul li a:hover {
            background-color: #0056b3;
        }

        .logout-btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #dc3545;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .logout-btn:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Welcome Admin!</h2>
        <ul>
            <li><a href="add_product.php">Add Product</a></li>
            <li><a href="view_products.php">View Products</a></li>
            <li><a href="view_orders_admin.php">View Orders</a></li>
            <li><a href="login.php" class="logout-btn">Logout</a></li>
        </ul>
    </div>
</body>
</html>
