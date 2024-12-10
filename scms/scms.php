<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supply Chain Management Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
        }

        header {
            background-color: #0078d7;
            color: white;
            padding: 15px;
            text-align: center;
        }

        nav {
            display: flex;
            justify-content: space-around;
            background-color: #005fa3;
            padding: 10px 0;
        }

        nav a {
            color: white;
            text-decoration: none;
            font-weight: bold;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        nav a:hover {
            background-color: #0078d7;
        }

        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            margin-top: 0;
            color: #005fa3;
        }

        form input, form button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        form button {
            background-color: #0078d7;
            color: white;
            border: none;
            cursor: pointer;
            font-weight: bold;
        }

        form button:hover {
            background-color: #005fa3;
        }

        .table-container {
            overflow-x: auto;
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #0078d7;
            color: white;
        }
    </style>
</head>
<body>
    <header>
        <h1>Supply Chain Management Dashboard</h1>
    </header>

    <nav>
        <a href="?page=add-supplier">Add Supplier</a>
        <a href="?page=add-product">Add Product</a>
        <a href="?page=place-order">Place Order</a>
        <a href="?page=reports">View Reports</a>
    </nav>

    <div class="container">
        <?php
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
            if ($page === 'add-supplier') {
                include 'add_supplier.php';
            } elseif ($page === 'add-product') {
                include 'add_product.php';
            } elseif ($page === 'place-order') {
                include 'place_order.php';
            } elseif ($page === 'reports') {
                include 'reports.php';
            } else {
                echo "<h2>Welcome to the Supply Chain Management Dashboard!</h2>";
            }
        } else {
            echo "<h2>Welcome to the Supply Chain Management Dashboard!</h2>";
        }
        ?>
    </div>
</body>
</html>

