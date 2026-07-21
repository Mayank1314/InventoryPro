<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "inventory_management";

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}

$search = "";

if (isset($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);

    $sql = "SELECT * FROM products
            WHERE product_name LIKE '%$search%'
            OR category LIKE '%$search%'
            OR supplier LIKE '%$search%'
            ORDER BY id DESC";
} else {
    $sql = "SELECT * FROM products ORDER BY id DESC";
}

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Product Management</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css">

<style>

:root{
--sidebar-width:260px;
--primary-blue:#0d6efd;
--dark-blue:#0a2540;
--soft-blue:#f0f4f8;
--accent-blue:#e1f5fe;
}

body{
background:var(--soft-blue);
font-family:'Segoe UI',sans-serif;
}

#sidebar{
width:260px;
height:100vh;
position:fixed;
left:0;
top:0;
background:#0a2540;
}

#sidebar .nav-link{
color:#cfd8dc;
}

#sidebar .nav-link:hover,
#sidebar .nav-link.active{
background:rgba(255,255,255,.1);
color:white;
border-left:4px solid #38bdf8;
}

#main-content{
margin-left:260px;
padding:25px;
}

.card{
border:none;
border-radius:15px;
}

.table th{
background:#0a2540;
color:white;
}

.btn-primary{
background:#0d6efd;
}

.search-box{
max-width:350px;
}

</style>

</head>

<body>

<div id="sidebar" class="d-flex flex-column p-3 text-white">

<a href="dashboard.php" class="d-flex align-items-center mb-4 me-md-auto text-white text-decoration-none">
<i class="bi bi-box-seam fs-4 me-2 text-info"></i>
IMS Dashboard
</a>

<hr>

<ul class="nav nav-pills flex-column">

<li>
<a href="dashboard.php" class="nav-link">
<i class="bi bi-speedometer2 me-2"></i>
Dashboard
</a>
</li>

<li>
<a href="#" class="nav-link">
<i class="bi bi-tags me-2"></i>
Category Management
</a>
</li>

<li>
<a href="products.php" class="nav-link active">
<i class="bi bi-box me-2"></i>
Product Management
</a>
</li>

<li>
<a href="#" class="nav-link">
<i class="bi bi-truck me-2"></i>
Supplier Management
</a>
</li>

<li>
<a href="#" class="nav-link">
<i class="bi bi-people me-2"></i>
Customer Management
</a>
</li>

<li>
<a href="#" class="nav-link">
<i class="bi bi-cart-plus me-2"></i>
Purchase Management
</a>
</li>

<li>
<a href="#" class="nav-link">
<i class="bi bi-cash-coin me-2"></i>
Sales Management
</a>
</li>

<li>
<a href="#" class="nav-link">
<i class="bi bi-file-earmark-text me-2"></i>
Reports
</a>
</li>

</ul>

</div>

<div id="main-content">

<div class="d-flex justify-content-between align-items-center mb-4">

<?php if(isset($_GET['success'])){ ?>

<div class="alert alert-success alert-dismissible fade show">

<i class="bi bi-check-circle-fill"></i>

Product Added Successfully.

<button class="btn-close" data-bs-dismiss="alert"></button>

</div>

<?php } ?>

<?php if(isset($_GET['updated'])){ ?>

<div class="alert alert-primary alert-dismissible fade show">

<i class="bi bi-pencil-square"></i>

Product Updated Successfully.

<button class="btn-close" data-bs-dismiss="alert"></button>

</div>

<?php } ?>

<?php if(isset($_GET['deleted'])){ ?>

<div class="alert alert-danger alert-dismissible fade show">

<i class="bi bi-trash-fill"></i>

Product Deleted Successfully.

<button class="btn-close" data-bs-dismiss="alert"></button>

</div>

<?php } ?>

<h2 class="fw-bold">
<i class="bi bi-box"></i>
Product Management
</h2>

<a href="add_product.php" class="btn btn-primary">
<i class="bi bi-plus-circle"></i>
Add Product
</a>

</div>

<div class="card shadow">

<div class="card-body">

<form method="GET">

<div class="input-group search-box mb-4">

<input
type="text"
class="form-control"
placeholder="Search Products..."
name="search"
value="<?php echo $search; ?>">

<button class="btn btn-primary">
<i class="bi bi-search"></i>
</button>

</div>

</form>

<div class="table-responsive">

<table class="table table-bordered table-hover align-middle">

<thead>

<tr>

<th>ID</th>

<th>Product Name</th>

<th>Category</th>

<th>Supplier</th>

<th>SKU</th>

<th>Cost</th>

<th>Selling</th>

<th>Qty</th>

<th>Unit</th>

<th width="150">
Action
</th>

</tr>

</thead>

<tbody>

<!-- PART 2 STARTS HERE -->

<?php

if(mysqli_num_rows($result) > 0)
{
    while($row = mysqli_fetch_assoc($result))
    {
?>

<tr>

<td><?php echo $row['id']; ?></td>

<td><?php echo htmlspecialchars($row['product_name']); ?></td>

<td><?php echo htmlspecialchars($row['category']); ?></td>

<td><?php echo htmlspecialchars($row['supplier']); ?></td>

<td><?php echo htmlspecialchars($row['sku']); ?></td>

<td>₹<?php echo number_format($row['cost_price'],2); ?></td>

<td>₹<?php echo number_format($row['selling_price'],2); ?></td>

<td><?php echo $row['quantity']; ?></td>

<td><?php echo htmlspecialchars($row['unit']); ?></td>

<td>

<a href="edit_product.php?id=<?php echo $row['id']; ?>"
class="btn btn-success btn-sm">

<i class="bi bi-pencil-square"></i>

Edit

</a>

<a href="delete_product.php?id=<?php echo $row['id']; ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Are you sure you want to delete this product?');">

<i class="bi bi-trash"></i>

Delete

</a>

</td>

</tr>

<?php
    }
}
else
{
?>

<tr>

<td colspan="10" class="text-center text-muted py-5">

<i class="bi bi-box display-4 d-block mb-3"></i>

<h5>No Products Found</h5>

<p>Add your first product by clicking the <strong>Add Product</strong> button.</p>

</td>

</tr>

<?php
}
?>

</tbody>

</table>

</div>

</div>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>