<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Place Order</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #007BFF;
            color: white;
            text-align: center;
            padding: 10px 0;
        }

        form {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background: white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }

        form input, form select, form button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        form button {
            background-color: #007BFF;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }

        form button:hover {
            background-color: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #007BFF;
            color: white;
        }
    </style>
</head>
<body>
    <header>
        <h1>Place an Order</h1>
    </header>

    <form id="orderForm">
        <select id="productSelect" required>
            <option value="">Select Product</option>
            <!-- Products populated dynamically -->
        </select>
        <input type="number" id="quantity" placeholder="Enter Quantity" min="1" required>
        <button type="submit">Submit Order</button>
    </form>

    <table id="ordersTable">
        <thead>
            <tr>
                <th>Product ID</th>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Total Price</th>
            </tr>
        </thead>
        <tbody>
            <!-- Orders will appear here -->
        </tbody>
    </table>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const productSelect = document.getElementById('productSelect');
            const orderForm = document.getElementById('orderForm');
            const ordersTableBody = document.getElementById('ordersTable').querySelector('tbody');

            // Fetch products
            fetch('scms_api.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ action: 'getProducts' })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    data.products.forEach(product => {
                        const option = document.createElement('option');
                        option.value = product.id;
                        option.textContent = `${product.name} ($${product.price})`;
                        productSelect.appendChild(option);
                    });
                } else {
                    alert('Failed to load products.');
                }
            })
            .catch(err => console.error('Error fetching products:', err));

            // Handle order submission
            orderForm.addEventListener('submit', function (e) {
                e.preventDefault();

                const orderData = {
                    productId: productSelect.value,
                    quantity: document.getElementById('quantity').value
                };

                fetch('scms_api.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        action: 'placeOrder',
                        data: orderData 
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to place order. Check server response.');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.status === 'success') {
                        alert('Order placed successfully!');
                        updateOrdersTable(data.order);
                        orderForm.reset();
                    } else {
                        alert('Error: ' + data.message); 
                    }
                })
                .catch(err => console.error('Error placing order:', err));
            });

            function updateOrdersTable(order) {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${order.productId}</td>
                    <td>${order.productName}</td>
                    <td>${order.quantity}</td>
                    <td>$${order.totalPrice}</td>
                `;
                ordersTableBody.appendChild(row);
            }
        });
    </script>
</body>
</html>
