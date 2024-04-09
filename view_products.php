<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Products</title>
    <style>
        /* Table styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            padding: 10px;
            border: 1px solid #dee2e6;
            text-align: left;
        }

        th {
            background-color: #007bff;
            color: #fff;
        }

        /* Edit and delete link styles */
        .edit-btn, .delete-btn {
            padding: 5px 10px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
        }

        .delete-btn {
            background-color: #dc3545;
            margin-left: 5px;
        }

        .edit-btn:hover, .delete-btn:hover {
            background-color: #218838;
            transition: background-color 0.3s ease;
        }
        .back-btn {
            text-align: center;
            margin-top: 20px;
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

        /* Search bar styles */
        .search-container {
            margin-bottom: 20px;
        }

        .search-container input[type=text] {
            padding: 10px;
            margin-right: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .search-container input[type=submit] {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .search-container input[type=submit]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h2>Products</h2>

    <!-- Search bar -->
    <div class="search-container">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="GET">
            <input type="text" placeholder="Search by ID or Name" name="search">
            <input type="submit" value="Search">
        </form>
    </div>

    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        <?php
        // Retrieve products from the database
        include('db_connection.php');

        // Default SQL query to retrieve all products
        $sql = "SELECT * FROM products";

        // Check if a search query is submitted
        if(isset($_GET['search']) && !empty(trim($_GET['search']))){
            $search = trim($_GET['search']);
            // Modify the SQL query to include search functionality
            $sql = "SELECT * FROM products WHERE id LIKE '%$search%' OR name LIKE '%$search%'";
        }

        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>".$row["id"]."</td>";
                echo "<td>".$row["name"]."</td>";
                echo "<td>".$row["price"]."</td>";
                echo "<td>".$row["quantity"]."</td>";
                echo "<td><a class='edit-btn' href='edit_product.php?id=".$row["id"]."'>Edit</a></td>";
                echo "<td><a class='delete-btn' href='delete_product.php?id=".$row["id"]."' onclick='return confirm(\"Are you sure you want to delete this product?\")'>Delete</a></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No products found</td></tr>";
        }
        ?>
    </table>
    <div class="back-btn">
            <a href="admin_dashboard.php">Back to Dashboard</a>
        </div>
</body>
</html>
