<h2>View Reports</h2>

<h3>Products</h3>
<table id="productsReportTable">
    <thead>
        <tr>
            <th>Product ID</th>
            <th>Product Name</th>
            <th>Product Price</th>
            <th>Product Quantity</th>
        </tr>
    </thead>
    <tbody>
        <!-- Product data will be populated here -->
    </tbody>
</table>

<h3>Suppliers</h3>
<table id="suppliersReportTable">
    <thead>
        <tr>
            <th>Supplier ID</th>
            <th>Supplier Name</th>
            <th>Supplier Contact</th>
        </tr>
    </thead>
    <tbody>
        <!-- Supplier data will be populated here -->
    </tbody>
</table>

<h3>Orders</h3>
<table id="ordersReportTable">
    <thead>
        <tr>
            <th>Order ID</th>
            <th>Product Name</th>
            <th>Ordered Quantity</th>
        </tr>
    </thead>
    <tbody>
        <!-- Order data will be populated here -->
    </tbody>
</table>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Fetch all reports
    fetch('scms_api.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ action: 'getReports' })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            // Populate Products Table
            const productTable = document.getElementById('productsReportTable').getElementsByTagName('tbody')[0];
            data.products.forEach(product => {
                const row = productTable.insertRow();
                row.innerHTML = `
                    <td>${product.id}</td>
                    <td>${product.name}</td>
                    <td>${product.price}</td>
                    <td>${product.quantity}</td>
                `;
            });

            // Populate Suppliers Table
            const supplierTable = document.getElementById('suppliersReportTable').getElementsByTagName('tbody')[0];
            data.suppliers.forEach(supplier => {
                const row = supplierTable.insertRow();
                row.innerHTML = `
                    <td>${supplier.id}</td>
                    <td>${supplier.name}</td>
                    <td>${supplier.contact}</td>
                `;
            });

            // Populate Orders Table (Empty for now)
            const orderTable = document.getElementById('ordersReportTable').getElementsByTagName('tbody')[0];
            data.orders.forEach(order => {
                const row = orderTable.insertRow();
                row.innerHTML = `
                    <td>${order.id}</td>
                    <td>${order.productName}</td>
                    <td>${order.quantity}</td>
                `;
            });
        } else {
            alert('Error fetching reports');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error fetching reports');
    });
});
</script>

