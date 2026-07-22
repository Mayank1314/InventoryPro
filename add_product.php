<?php

$host = "localhost";
$user = "root";
$password = "";
$database = "inventory_management";

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Connection Failed : " . mysqli_connect_error());
}

$customers = mysqli_query($conn, "
SELECT *
FROM customers
ORDER BY customer_name ASC
");

$products = mysqli_query($conn, "
SELECT *
FROM products
ORDER BY product_name ASC
");

?>
<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Add Sale</title>


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css">


<!-- COMMON ADMIN CSS (Handles sidebar layout) -->
<link rel="stylesheet" href="assets/css/admin.css">


<style>

:root {
    --sidebar-width: 260px;
    --dark-blue: #0a2540;
    --soft-blue: #f0f4f8;
}

body {
    background: var(--soft-blue);
    font-family: 'Segoe UI', sans-serif;
}

/* Main Area Layout */
#main-content {
    margin-left: 260px;
    padding: 30px;
}

.text-blue-dark {
    color: var(--dark-blue);
}

/* Card Styling */
.card {
    border: none;
    border-radius: 12px;
    overflow: hidden;
}

/* Card Header */
.card-header {
    background: #0d6efd !important;
    color: white;
    padding: 16px 20px;
    border: none;
}

/* Form Controls */
.form-control,
.form-select {
    border-radius: 8px;
    padding: 10px 14px;
    border: 1px solid #dee2e6;
}

.form-control:focus,
.form-select:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 .2rem rgba(13, 110, 253, .15);
}

.form-control[readonly] {
    background-color: #f8f9fa;
    opacity: 1;
}

label {
    font-weight: 600;
    color: var(--dark-blue);
    margin-bottom: 6px;
}

/* Buttons */
.btn-primary {
    border-radius: 6px;
    padding: 8px 18px;
    font-weight: 500;
}

.btn-secondary {
    border-radius: 6px;
    padding: 8px 18px;
    font-weight: 500;
}

</style>

</head>


<body>


<?php include("includes/sidebar.php"); ?>


<div id="main-content">

    <!-- PAGE HEADER ROW (Title on Left, Back Button on Right) -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2 class="fw-bold text-blue-dark m-0">
            <i class="bi bi-cart-plus"></i>
            Add Sale
        </h2>

        <a href="sales.php" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i>
            Back
        </a>

    </div>


    <!-- FORM CARD -->
    <div class="card shadow border-0">

        <div class="card-header">
            <h5 class="mb-0 fw-semibold">
                <i class="bi bi-cash-coin me-1"></i>
                Sale Details
            </h5>
        </div>


        <div class="card-body p-4">

            <form action="sale_process.php" method="POST">

                <!-- Customer Selection -->
                <div class="mb-3">
                    <label class="form-label">Customer</label>
                    <select name="customer_id" class="form-select" required>
                        <option value="">-- Select Customer --</option>
                        <?php while($customer = mysqli_fetch_assoc($customers)) { ?>
                            <option value="<?php echo $customer['id']; ?>">
                                <?php echo htmlspecialchars($customer['customer_name']); ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>


                <!-- Product Selection -->
                <div class="mb-3">
                    <label class="form-label">Product</label>
                    <select name="product_id" id="product" class="form-select" required>
                        <option value="">-- Select Product --</option>
                        <?php while($product = mysqli_fetch_assoc($products)) { ?>
                            <option 
                                value="<?php echo $product['id']; ?>"
                                data-price="<?php echo $product['selling_price']; ?>"
                                data-stock="<?php echo $product['quantity']; ?>">
                                <?php echo htmlspecialchars($product['product_name']); ?> (Stock: <?php echo $product['quantity']; ?>)
                            </option>
                        <?php } ?>
                    </select>
                </div>


                <!-- Stock & Price Row -->
                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Available Stock</label>
                        <input
                            type="text"
                            id="stock"
                            class="form-control"
                            readonly>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Selling Price</label>
                        <input
                            type="number"
                            step="0.01"
                            name="selling_price"
                            id="price"
                            class="form-control"
                            readonly>
                    </div>

                </div>


                <!-- Quantity & Total Price Row -->
                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Quantity</label>
                        <input
                            type="number"
                            name="quantity"
                            id="quantity"
                            class="form-control"
                            min="1"
                            placeholder="Enter Quantity"
                            required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Total Price</label>
                        <input
                            type="text"
                            id="total_display"
                            class="form-control"
                            readonly>
                        <input
                            type="hidden"
                            name="total_price"
                            id="total_price">
                    </div>

                </div>


                <!-- Sale Date -->
                <div class="mb-3">
                    <label class="form-label">Sale Date</label>
                    <input
                        type="date"
                        name="sale_date"
                        class="form-control"
                        value="<?php echo date('Y-m-d'); ?>"
                        required>
                </div>


                <!-- Action Buttons -->
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i>
                        Save Sale
                    </button>

                    <a href="sales.php" class="btn btn-secondary ms-2">
                        <i class="bi bi-x-circle me-1"></i>
                        Cancel
                    </a>
                </div>

            </form>

        </div>

    </div>

</div>


<script>
const product = document.getElementById("product");
const price = document.getElementById("price");
const stock = document.getElementById("stock");
const qty = document.getElementById("quantity");
const total = document.getElementById("total_display");
const hidden = document.getElementById("total_price");

function calculateSale() {
    let option = product.options[product.selectedIndex];
    let selling = parseFloat(option.dataset.price) || 0;
    let available = parseInt(option.dataset.stock) || 0;
    let quantity = parseInt(qty.value) || 0;

    price.value = selling.toFixed(2);
    stock.value = available;

    let amount = selling * quantity;
    total.value = amount.toFixed(2);
    hidden.value = amount.toFixed(2);
}

product.addEventListener("change", calculateSale);
qty.addEventListener("keyup", calculateSale);
qty.addEventListener("change", calculateSale);
</script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>

<?php
mysqli_close($conn);
?>