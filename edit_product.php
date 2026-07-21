<?php

$host = "localhost";
$user = "root";
$password = "";
$database = "inventory_management";

$conn = mysqli_connect($host, $user, $password, $database);

if(!$conn){
    die("Connection Failed : " . mysqli_connect_error());
}

if(!isset($_GET['id'])){
    header("Location: products.php");
    exit();
}

$id = $_GET['id'];

$sql = "SELECT * FROM products WHERE id='$id'";
$result = mysqli_query($conn,$sql);

if(mysqli_num_rows($result)==0){
    header("Location: products.php");
    exit();
}

$row = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Edit Product</title>

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
background:var(--dark-blue);
position:fixed;
left:0;
top:0;
padding:20px;
}

#sidebar .nav-link{
color:#d1d5db;
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

<div class="card-header bg-warning text-dark">

<h4>

<i class="bi bi-pencil-square"></i>

Edit Product

</h4>

</div>

<div class="card-body">

<form action="update_product.php" method="POST">

<input type="hidden" name="id" value="<?php echo $row['id']; ?>">

<div class="row">

<div class="col-md-6 mb-3">

<label>Product Name</label>

<input
type="text"
name="product_name"
class="form-control"
value="<?php echo $row['product_name']; ?>"
required>

</div>

<div class="col-md-6 mb-3">

<label>Category</label>

<input
type="text"
name="category"
class="form-control"
value="<?php echo $row['category']; ?>"
required>

</div>

<div class="col-md-6 mb-3">

<label>Supplier</label>

<input
type="text"
name="supplier"
class="form-control"
value="<?php echo $row['supplier']; ?>"
required>

</div>

<div class="col-md-6 mb-3">

<label>SKU</label>

<input
type="text"
name="sku"
class="form-control"
value="<?php echo $row['sku']; ?>">

</div>

<div class="col-md-6 mb-3">

<label>Cost Price</label>

<input
type="number"
step="0.01"
name="cost_price"
class="form-control"
value="<?php echo $row['cost_price']; ?>"
required>

</div>

<div class="col-md-6 mb-3">

<label>Selling Price</label>

<input
type="number"
step="0.01"
name="selling_price"
class="form-control"
value="<?php echo $row['selling_price']; ?>"
required>

</div>

<div class="col-md-6 mb-3">

<label>Quantity</label>

<input
type="number"
name="quantity"
class="form-control"
value="<?php echo $row['quantity']; ?>"
required>

</div>

<div class="col-md-6 mb-3">

<label>Unit</label>

<select
name="unit"
class="form-select">

<option value="Pieces" <?php if($row['unit']=="Pieces") echo "selected"; ?>>Pieces</option>

<option value="Box" <?php if($row['unit']=="Box") echo "selected"; ?>>Box</option>

<option value="Kg" <?php if($row['unit']=="Kg") echo "selected"; ?>>Kg</option>

<option value="Litre" <?php if($row['unit']=="Litre") echo "selected"; ?>>Litre</option>

</select>

</div>

<div class="col-12 mb-3">

<label>Description</label>

<textarea
name="description"
rows="4"
class="form-control"><?php echo $row['description']; ?></textarea>

</div>

<div class="col-12">

<button
type="submit"
class="btn btn-warning">

<i class="bi bi-pencil-square"></i>

Update Product

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