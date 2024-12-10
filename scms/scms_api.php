<?php
include('db_connect.php');

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set the content type to JSON for all responses
header('Content-Type: application/json');

// Get the raw POST data
$input = file_get_contents('php://input');
$data = json_decode($input, true);

// Check if the data is decoded correctly
if ($data === null) {
    echo json_encode(['status' => 'failure', 'output' => 'Invalid JSON format received']);
    exit;
}

// Check for 'action' in the received data
$action = $data['action'] ?? null; // Use null if 'action' is not set

if (!$action) {
    echo json_encode(['status' => 'failure', 'output' => 'Missing action parameter']);
    exit;
}

// Add Supplier Functionality
if ($action === 'addSupplier') {
    $supplierData = json_decode($data['data'], true);
    if (!$supplierData || empty($supplierData['id']) || empty($supplierData['name']) || empty($supplierData['contact'])) {
        echo json_encode(['status' => 'failure', 'output' => 'Missing supplier data']);
        exit;
    }

    $id = $supplierData['id'];
    $name = $supplierData['name'];
    $contact = $supplierData['contact'];

    $stmt = $conn->prepare("INSERT INTO suppliers (id, name, contact) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $id, $name, $contact);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'supplier' => $supplierData]);
    } else {
        echo json_encode(['status' => 'failure', 'output' => 'Error executing query: ' . $conn->error]);
    }

    $stmt->close();
}

// Get Suppliers
if ($action === 'getSuppliers') {
    $sql = "SELECT * FROM suppliers";
    $result = $conn->query($sql);
    $suppliers = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $suppliers[] = $row;
        }
        echo json_encode(['status' => 'success', 'suppliers' => $suppliers]);
    } else {
        echo json_encode(['status' => 'failure', 'output' => 'No suppliers found']);
    }
}

// Add Product Functionality
if ($action === 'addProduct') {
    $productData = json_decode($data['data'], true);
    if (!$productData || empty($productData['id']) || empty($productData['name']) || empty($productData['price']) || empty($productData['quantity'])) {
        echo json_encode(['status' => 'failure', 'output' => 'Missing product data']);
        exit;
    }

    $id = $productData['id'];
    $name = $productData['name'];
    $price = $productData['price'];
    $quantity = $productData['quantity'];

    $stmt = $conn->prepare("INSERT INTO products (id, name, price, quantity) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssii", $id, $name, $price, $quantity);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'product' => $productData]);
    } else {
        echo json_encode(['status' => 'failure', 'output' => 'Error executing query: ' . $conn->error]);
    }

    $stmt->close();
}

// Get Products
if ($action === 'getProducts') {
    $sql = "SELECT * FROM products";
    $result = $conn->query($sql);
    $products = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
        echo json_encode(['status' => 'success', 'products' => $products]);
    } else {
        echo json_encode(['status' => 'failure', 'output' => 'No products found']);
    }
}

// Place Order Functionality
if ($action === 'placeOrder') {
    $orderData = json_decode($data['data'], true);
    if (!$orderData || empty($orderData['productId']) || empty($orderData['quantity']) || !is_numeric($orderData['quantity'])) {
        echo json_encode(['status' => 'failure', 'output' => 'Invalid product ID or quantity']);
        exit;
    }

    $productId = $orderData['productId'];
    $quantity = $orderData['quantity'];

    // Fetch product details from the database
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("s", $productId);
    $stmt->execute();
    $productResult = $stmt->get_result();
    $product = $productResult->fetch_assoc();

    if ($product) {
        $productName = $product['name'];
        $productPrice = $product['price'];

        // Insert the order into the orders table
        $orderStmt = $conn->prepare("INSERT INTO orders (product_id, product_name, quantity, total_price) VALUES (?, ?, ?, ?)");
        $totalPrice = $productPrice * $quantity;
        $orderStmt->bind_param("ssii", $productId, $productName, $quantity, $totalPrice);

        if ($orderStmt->execute()) {
            // Return the order details as JSON
            $order = [
                'productId' => $productId,
                'productName' => $productName,
                'quantity' => $quantity,
                'totalPrice' => $totalPrice
            ];
            echo json_encode(['status' => 'success', 'order' => $order]);
        } else {
            echo json_encode(['status' => 'failure', 'output' => 'Error executing order query: ' . $conn->error]);
        }

        $orderStmt->close();
    } else {
        echo json_encode(['status' => 'failure', 'output' => 'Product not found']);
    }

    $stmt->close();
}

// Get Reports (New Action)
if ($action === 'getReports') {
    // Fetch Products
    $products = [];
    $productSql = "SELECT * FROM products";
    $productResult = $conn->query($productSql);
    if ($productResult->num_rows > 0) {
        while ($row = $productResult->fetch_assoc()) {
            $products[] = $row;
        }
    }

    // Fetch Suppliers
    $suppliers = [];
    $supplierSql = "SELECT * FROM suppliers";
    $supplierResult = $conn->query($supplierSql);
    if ($supplierResult->num_rows > 0) {
        while ($row = $supplierResult->fetch_assoc()) {
            $suppliers[] = $row;
        }
    }

    // Return response with products and suppliers data
    echo json_encode([
        'status' => 'success',
        'products' => $products,
        'suppliers' => $suppliers,
        'orders' => [] // Placeholder for future orders data
    ]);
}

$conn->close();
?>






