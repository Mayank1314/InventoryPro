<?php
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Add Product</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css">

<style>

:root{
--sidebar-width:260px;
--dark-blue:#0a2540;
--soft-blue:#f0f4f8;
}

body{
background:var(--soft-blue);
font-family:'Segoe UI',sans-serif;
}

#sidebar{
width:260px;
height:100vh;
position:fixed;
top:0;
left:0;
background:var(--dark-blue);
padding:20px;
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
padding:30px;
}

.card{
border:none;
border-radius:15px;
}

</style>

</head>

<body>

<div id="sidebar">

<h3 class="text-white mb-4">
<i class="bi bi-box-seam"></i>
IMS Dashboard
</h3>

<ul class="nav flex-column">

<li>
<a href="dashboard.php" class="nav-link">
<i class="bi bi-speedometer2 me-2"></i>
Dashboard
</a>
</li>

<li>
<a href="products.php" class="nav-link active">
<i class="bi bi-box me-2"></i>
Product Management
</a>
</li>

</ul>

</div>

<div id="main-content">

<div class="card shadow">

<div class="card-header bg-primary text-white">

<h4>

<i class="bi bi-plus-circle"></i>

Add New Product

</h4>

</div>

<div class="card-body">

<form action="product_process.php" method="POST">

<div class="row">

<div class="col-md-6 mb-3">

<label class="form-label">Product Name</label>

<input
type="text"
name="product_name"
class="form-control"
required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">Category</label>

<input
type="text"
name="category"
class="form-control"
required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">Supplier</label>

<input
type="text"
name="supplier"
class="form-control"
required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">SKU</label>

<input
type="text"
name="sku"
class="form-control">

</div>

<div class="col-md-6 mb-3">

<label class="form-label">Cost Price</label>

<input
type="number"
step="0.01"
name="cost_price"
class="form-control"
required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">Selling Price</label>

<input
type="number"
step="0.01"
name="selling_price"
class="form-control"
required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">Quantity</label>

<input
type="number"
name="quantity"
class="form-control"
required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">Unit</label>

<select
name="unit"
class="form-select">

<option value="Pieces">Pieces</option>
<option value="Box">Box</option>
<option value="Kg">Kg</option>
<option value="Litre">Litre</option>

</select>

</div>

<div class="col-12 mb-3">

<label class="form-label">Description</label>

<textarea
name="description"
rows="4"
class="form-control"></textarea>

</div>

<div class="col-12">

<button
type="submit"
class="btn btn-primary">

<i class="bi bi-save"></i>

Save Product

</button>

<a
href="products.php"
class="btn btn-secondary">

Cancel

</a>

</div>

</div>

</form>

</div>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>