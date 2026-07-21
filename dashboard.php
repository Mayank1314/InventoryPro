<?php

$conn=mysqli_connect("localhost","root","","inventory_management");

if(!$conn){
    die("Database Connection Failed");
}


// Total Products
$product_count=mysqli_fetch_assoc(
mysqli_query($conn,"SELECT COUNT(*) AS total FROM products")
)['total'];


// Total Categories
$category_count=mysqli_fetch_assoc(
mysqli_query($conn,"SELECT COUNT(*) AS total FROM categories")
)['total'];


// Total Suppliers
$supplier_count=mysqli_fetch_assoc(
mysqli_query($conn,"SELECT COUNT(*) AS total FROM suppliers")
)['total'];


// Total Customers
$customer_count=mysqli_fetch_assoc(
mysqli_query($conn,"SELECT COUNT(*) AS total FROM customers")
)['total'];

// Total Purchase Amount
$purchase_total=mysqli_fetch_assoc(
mysqli_query($conn,"
SELECT SUM(total_price) AS total 
FROM purchases
")
)['total'];


// Total Sales Amount
$sales_total=mysqli_fetch_assoc(
mysqli_query($conn,"
SELECT SUM(total_price) AS total 
FROM sales
")
)['total'];


if($purchase_total==NULL){
    $purchase_total=0;
}

if($sales_total==NULL){
    $sales_total=0;
}

// Current Stock
$current_stock=mysqli_fetch_assoc(
    mysqli_query($conn,"
    SELECT SUM(quantity) AS total 
    FROM products
    ")
)['total'];

if($current_stock == NULL){
    $current_stock = 0;
}


// Low Stock Products
$low_stock_count=mysqli_fetch_assoc(
    mysqli_query($conn,"
    SELECT COUNT(*) AS total 
    FROM products
    WHERE quantity <= 5
    ")
)['total'];

if($low_stock_count == NULL){
    $low_stock_count = 0;
}

// Critical Stock Shortages List
$low_stock_products = mysqli_query($conn,"
    SELECT product_name, sku, quantity
    FROM products
    WHERE quantity <= 5
    ORDER BY quantity ASC
    LIMIT 5
");

// Recent Operations
$recent_operations = mysqli_query($conn,"
(
    SELECT
        id,
        'Sale' AS type,
        total_price,
        created_at
    FROM sales
)
UNION ALL
(
    SELECT
        id,
        'Purchase' AS type,
        total_price,
        created_at
    FROM purchases
)
ORDER BY created_at DESC
LIMIT 10
");
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Inventory & Stock Management System</title>
    <!-- Bootstrap 5 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css">
    <style>
        :root { 
            --sidebar-width: 260px; 
            --primary-blue: #0d6efd;
            --dark-blue: #0a2540;
            --soft-blue: #f0f4f8;
            --accent-blue: #e1f5fe;
        }
        body { 
            background-color: var(--soft-blue); 
            font-family: 'Segoe UI', system-ui, sans-serif; 
        }
        #sidebar { 
            width: var(--sidebar-width); 
            height: 100vh; 
            position: fixed; 
            top: 0; 
            left: 0; 
            z-index: 100; 
            background-color: var(--dark-blue); 
        }
        #sidebar .nav-link {
            color: #b8cad6;
            transition: all 0.2s;
        }
        #sidebar .nav-link:hover, #sidebar .nav-link.active {
            color: #ffffff;
            background-color: rgba(255, 255, 255, 0.1) !important;
        }
        #sidebar .nav-link.active {
            border-left: 4px solid #38bdf8;
        }
        #main-content { 
            margin-left: var(--sidebar-width); 
            padding: 24px; 
        }
        .card-counter { 
            border: none; 
            border-radius: 12px; 
            transition: transform 0.2s, box-shadow 0.2s; 
            background: #ffffff;
        }
        .card-counter:hover { 
            transform: translateY(-3px); 
            box-shadow: 0 10px 20px rgba(10, 37, 64, 0.05) !important;
        }
        .text-blue-dark { color: var(--dark-blue); }
        .bg-blue-light { background-color: var(--accent-blue); color: var(--primary-blue); }
        
        /* Modern Blue Urgent-Alert Gradient */
        .low-stock-alert-card {
            background: linear-gradient(135deg, #1e40af, #3b82f6) !important;
            color: #ffffff !important;
        }
        .low-stock-pulse { 
            animation: pulse-blue 2s infinite; 
        }
        @keyframes pulse-blue {
            0% { box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.5); }
            70% { box-shadow: 0 0 0 10px rgba(59, 130, 246, 0); }
            100% { box-shadow: 0 0 0 0 rgba(59, 130, 246, 0); }
        }
    </style>
</head>
<body>

    <!-- Sidebar Navigation Shell -->
    <div id="sidebar" class="d-flex flex-column p-3 text-white">
        <a href="#" class="d-flex align-items-center mb-4 me-md-auto text-white text-decoration-none">
            <i class="bi bi-box-seam fs-4 me-2 text-info"></i>
            <span class="fs-5 fw-bold">IMS Dashboard</span>
        </a>
        <hr style="background-color: #38bdf8; opacity: 0.3;">
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                <a href="#" class="nav-link active"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a>
            </li>
            <li><a href="categories.php" class="nav-link"><i class="bi bi-tags me-2"></i> Category Management</a></li>
            <li><a href="products.php" class="nav-link"><i class="bi bi-box me-2"></i> Product Management</a></li>
            <li><a href="suppliers.php" class="nav-link"><i class="bi bi-truck me-2"></i> Supplier Management</a></li>
            <li><a href="customers.php" class="nav-link"><i class="bi bi-people me-2"></i> Customer Management</a></li>
            <li><a href="purchases.php" class="nav-link"><i class="bi bi-cart-plus me-2"></i> Purchase Management</a></li>
            <li><a href="sales.php" class="nav-link"><i class="bi bi-cash-coin me-2"></i> Sales Management</a></li>
            <li><a href="#" class="nav-link"><i class="bi bi-journal-text me-2"></i> Reports</a></li>
        </ul>
        <hr style="background-color: #38bdf8; opacity: 0.3;">
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-person-circle fs-5 me-2 text-info"></i>
                <strong>Mayank Upadhyay</strong>
            </a>
            <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser">
                <li><a class="dropdown-item" href="#" onclick="handleLogout()"><i class="bi bi-box-arrow-right me-2"></i> Sign out</a></li>
            </ul>
        </div>
    </div>

    <!-- Main Dashboard Body Content -->
    <div id="main-content">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
            <h1 class="h2 text-blue-dark fw-bold">Inventory Overview</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
                <button type="button" class="btn btn-sm btn-outline-primary" onclick="window.print()"><i class="bi bi-printer me-1"></i> Print Summary</button>
            </div>
        </div>

        <!-- Metric Counter Grid System (Section 2.2 Requirements) -->
        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 g-4 mb-4">
            
            <!-- Total Products Metric Card -->
            <div class="col">
                <div class="card card-counter shadow-sm p-3 border-start border-primary border-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="text-muted text-uppercase small mb-1">Total Products</h6>
                            <h3 class="fw-bold mb-0 text-blue-dark">
<?php echo $product_count; ?>
</h3>
                        </div>
                        <div class="bg-blue-light p-3 rounded fs-3"><i class="bi bi-box"></i></div>
                    </div>
                </div>
            </div>

            <!-- Total Categories Card -->
            <div class="col">
                <div class="card card-counter shadow-sm p-3 border-start border-primary border-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="text-muted text-uppercase small mb-1">Total Categories</h6>
                            <h3 class="fw-bold mb-0 text-blue-dark" id="total-categories"><?php echo $category_count; ?></h3>
                        </div>
                        <div class="bg-blue-light p-3 rounded fs-3"><i class="bi bi-tags"></i></div>
                    </div>
                </div>
            </div>

            <!-- Total Suppliers Card -->
            <div class="col">
                <div class="card card-counter shadow-sm p-3 border-start border-primary border-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="text-muted text-uppercase small mb-1">Total Suppliers</h6>
                            <h3 class="fw-bold mb-0 text-blue-dark" id="total-suppliers"><?php echo $supplier_count; ?></h3>
                        </div>
                        <div class="bg-blue-light p-3 rounded fs-3"><i class="bi bi-truck"></i></div>
                    </div>
                </div>
            </div>

            <!-- Total Customers Card -->
            <div class="col">
                <div class="card card-counter shadow-sm p-3 border-start border-primary border-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="text-muted text-uppercase small mb-1">Total Customers</h6>
                            <h3 class="fw-bold mb-0 text-blue-dark" id="total-customers"><?php echo $customer_count; ?></h3>
                        </div>
                        <div class="bg-blue-light p-3 rounded fs-3"><i class="bi bi-people"></i></div>
                    </div>
                </div>
            </div>

            <!-- Financial Accumulations: Total Purchases -->
            <div class="col">
                <div class="card card-counter shadow-sm p-3 border-start border-info border-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="text-muted text-uppercase small mb-1">Total Purchases</h6>
                            <h3 class="fw-bold mb-0 text-blue-dark">
₹ <?php echo number_format($purchase_total,2); ?>
</h3>
                        </div>
                        <div class="bg-light p-3 rounded text-info fs-3"><i class="bi bi-cart-plus"></i></div>
                    </div>
                </div>
            </div>

            <!-- Financial Accumulations: Total Sales -->
            <div class="col">
                <div class="card card-counter shadow-sm p-3 border-start border-info border-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="text-muted text-uppercase small mb-1">Total Sales</h6>
                            <h3 class="fw-bold mb-0 text-blue-dark">
₹ <?php echo number_format($sales_total,2); ?>
</h3>
                        </div>
                        <div class="bg-light p-3 rounded text-info fs-3"><i class="bi bi-cash-coin"></i></div>
                    </div>
                </div>
            </div>

            <!-- Quantized Current Stock Level -->
<div class="col">
    <div class="card card-counter shadow-sm p-3 border-start border-info border-4">
        <div class="d-flex align-items-center justify-content-between">

            <div>
                <h6 class="text-muted text-uppercase small mb-1">Current Stock</h6>
                <h3 class="fw-bold mb-0 text-blue-dark">
                    <?php echo $current_stock; ?> Units
                </h3>
            </div>

            <div class="bg-light p-3 rounded text-info fs-3">
                <i class="bi bi-boxes"></i>
            </div>

        </div>
    </div>
</div>
            <!-- Low Stock Alerts Card -->
            <div class="col">
                <div class="card card-counter low-stock-alert-card low-stock-pulse shadow-sm p-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="text-white-50 text-uppercase small mb-1">Low Stock Products</h6>
                            <h3 class="fw-bold mb-0 text-white">
    <?php echo $low_stock_count; ?> Items
</h3>
                        </div>
                        <div class="bg-white bg-opacity-20 p-3 rounded text-white fs-3"><i class="bi bi-exclamation-triangle"></i></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Operations & Critical Stock -->
<div class="row mt-4">

    <!-- Recent Operations -->
    <div class="col-lg-8 mb-4">
        <div class="card shadow-sm border-0 h-100">

            <div class="card-header bg-white py-3 border-0">
                <h5 class="mb-0 fw-bold text-blue-dark">
                    <i class="bi bi-clock-history me-2 text-primary"></i>
                    Recent Operations History
                </h5>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-light">
                            <tr>
                                <th>Ref Invoice/ID</th>
                                <th>Type</th>
                                <th>Date</th>
                                <th>Total Amount</th>
                            </tr>
                        </thead>

                        <tbody>

<?php
if(mysqli_num_rows($recent_operations) > 0){

    while($row = mysqli_fetch_assoc($recent_operations)){

        if($row['type'] == "Sale"){
            $badge = "primary";
            $prefix = "INV";
        }else{
            $badge = "info";
            $prefix = "PUR";
        }
?>

<tr>

    <td>
        <strong>
            #<?php echo $prefix . "-" . str_pad($row['id'],5,"0",STR_PAD_LEFT); ?>
        </strong>
    </td>

    <td>
        <span class="badge bg-<?php echo $badge; ?>">
            <?php echo $row['type']; ?>
        </span>
    </td>

    <td>
        <?php echo date("d M, Y", strtotime($row['created_at'])); ?>
    </td>

    <td>
        <strong>₹ <?php echo number_format($row['total_price'],2); ?></strong>
    </td>

</tr>

<?php
    }

}else{
?>

<tr>
    <td colspan="4" class="text-center">
        No Recent Operations Found
    </td>
</tr>

<?php } ?>

</tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <!-- Critical Stock -->
    <div class="col-lg-4 mb-4">

        <div class="card shadow-sm border-0 h-100">

            <div class="card-header bg-white py-3 border-0">
                <h5 class="mb-0 fw-bold text-primary">
                    <i class="bi bi-bell me-2"></i>
                    Critical Stock Shortages
                </h5>
            </div>

           <div class="card-body">

    <div class="list-group list-group-flush">

        <?php
        if(mysqli_num_rows($low_stock_products) > 0){

            while($row = mysqli_fetch_assoc($low_stock_products)){
        ?>

        <div class="list-group-item d-flex justify-content-between align-items-start px-0 py-3">

            <div class="ms-2 me-auto">
                <div class="fw-bold text-blue-dark">
                    <?php echo $row['product_name']; ?>
                </div>

                <small class="text-muted">
                    SKU: <?php echo $row['sku']; ?>
                </small>
            </div>

            <span class="badge bg-danger rounded-pill">
                <?php echo $row['quantity']; ?> left
            </span>

        </div>

        <?php
            }
        } else {
        ?>

        <div class="text-center text-muted py-4">
            No low stock products found.
        </div>

        <?php } ?>

    </div>

</div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function handleLogout() {
            alert("Sign-out workflow clicked. Session destroyed simulation completed.");
        }
    </script>
</body>
</html>