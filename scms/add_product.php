<form id="productForm">
    <input type="text" id="productId" placeholder="Product ID" required>
    <input type="text" id="productName" placeholder="Product Name" required>
    <input type="number" id="productPrice" placeholder="Product Price" required>
    <input type="number" id="productQuantity" placeholder="Product Quantity" required>
    <button type="submit">Add Product</button>
</form>

<table id="productTable">
    <thead>
        <tr>
            <th>Product ID</th>
            <th>Product Name</th>
            <th>Product Price</th>
            <th>Product Quantity</th>
        </tr>
    </thead>
    <tbody>
        <!-- Existing products will be listed here -->
    </tbody>
</table>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Fetch existing products when the page loads
    fetchProducts();

    // Prevent default form submission
    document.getElementById('productForm').addEventListener('submit', function(event) {
        event.preventDefault();  // Stop the form from submitting the traditional way
        addProduct();  // Call the function to add a product
    });

    function fetchProducts() {
        fetch('scms_api.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                action: 'getProducts'  // Action to fetch products
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                data.products.forEach(product => {
                    updateProductTable(product);  // Update the table with existing products
                });
            } else {
                alert('Error fetching products: ' + data.output);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error fetching products');
        });
    }

    function addProduct() {
        // Get form data
        const productData = {
            id: document.getElementById('productId').value,
            name: document.getElementById('productName').value,
            price: document.getElementById('productPrice').value,
            quantity: document.getElementById('productQuantity').value
        };

        fetch('scms_api.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                action: 'addProduct',  // Action to add a product
                data: JSON.stringify(productData)  // Send the product data correctly
            })
        })
        .then(response => response.json())  // Parse the response as JSON
        .then(data => {
            if (data.status === 'success') {
                alert('Product added successfully!');

                // Add the new product to the table
                updateProductTable(data.product);

                // Reset the form fields
                document.getElementById('productId').value = '';
                document.getElementById('productName').value = '';
                document.getElementById('productPrice').value = '';
                document.getElementById('productQuantity').value = '';
            } else {
                alert('Error adding product: ' + data.output);  // Show output from backend error
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error adding product');
        });
    }

    // Function to update the product table dynamically
    function updateProductTable(product) {
        const tableBody = document.getElementById('productTable').getElementsByTagName('tbody')[0];
        
        // Create a new row and add the product data
        const newRow = tableBody.insertRow();
        newRow.innerHTML = `
            <td>${product.id}</td>
            <td>${product.name}</td>
            <td>${product.price}</td>
            <td>${product.quantity}</td>
        `;
    }
});
</script>



