<form id="supplierForm">
    <input type="text" id="supplierId" placeholder="Supplier ID" required>
    <input type="text" id="supplierName" placeholder="Supplier Name" required>
    <input type="text" id="supplierContact" placeholder="Supplier Contact" required>
    <button type="submit">Add Supplier</button>
</form>

<table id="supplierTable">
    <thead>
        <tr>
            <th>Supplier ID</th>
            <th>Supplier Name</th>
            <th>Supplier Contact</th>
        </tr>
    </thead>
    <tbody>
        <!-- Existing suppliers will be listed here -->
    </tbody>
</table>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Fetch existing suppliers when the page loads
    fetchSuppliers();

    // Prevent default form submission
    document.getElementById('supplierForm').addEventListener('submit', function(event) {
        event.preventDefault();  // Stop the form from submitting the traditional way
        addSupplier();  // Call the function to add a supplier
    });

    function fetchSuppliers() {
        fetch('scms_api.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                action: 'getSuppliers'  // Action to fetch suppliers
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                data.suppliers.forEach(supplier => {
                    updateSupplierTable(supplier);  // Update the table with existing suppliers
                });
            } else {
                alert('Error fetching suppliers: ' + data.output);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error fetching suppliers');
        });
    }

    function addSupplier() {
        // Get form data
        const supplierData = {
            id: document.getElementById('supplierId').value,
            name: document.getElementById('supplierName').value,
            contact: document.getElementById('supplierContact').value
        };

        fetch('scms_api.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                action: 'addSupplier',
                data: JSON.stringify(supplierData)  // Send the supplier data correctly
            })
        })
        .then(response => response.json())  // Parse the response as JSON
        .then(data => {
            if (data.status === 'success') {
                alert('Supplier added successfully!');
                
                // Add the new supplier to the table
                updateSupplierTable(data.supplier);

                // Reset the form fields
                document.getElementById('supplierId').value = '';
                document.getElementById('supplierName').value = '';
                document.getElementById('supplierContact').value = '';
            } else {
                alert('Error adding supplier: ' + data.output);  // Show output from backend error
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error adding supplier');
        });
    }

    // Function to update the supplier table dynamically
    function updateSupplierTable(supplier) {
        const tableBody = document.getElementById('supplierTable').getElementsByTagName('tbody')[0];
        
        // Create a new row and add the supplier data
        const newRow = tableBody.insertRow();
        newRow.innerHTML = `
            <td>${supplier.id}</td>
            <td>${supplier.name}</td>
            <td>${supplier.contact}</td>
        `;
    }
});
</script>







