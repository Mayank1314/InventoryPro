<?php

$host="localhost";
$user="root";
$password="";
$database="inventory_management";

$conn=mysqli_connect($host,$user,$password,$database);

if(!$conn){
    die(mysqli_connect_error());
}

if(!isset($_GET['id'])){
    header("Location:purchases.php");
    exit();
}

$id=$_GET['id'];

$purchase=mysqli_query($conn,"
SELECT *
FROM purchases
WHERE id='$id'
");

$data=mysqli_fetch_assoc($purchase);

$suppliers=mysqli_query($conn,"
SELECT *
FROM suppliers
ORDER BY supplier_name ASC
");

$products=mysqli_query($conn,"
SELECT *
FROM products
ORDER BY product_name ASC
");

?>

<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<title>Edit Purchase</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css">

<style>

body{
background:#f4f7fb;
font-family:Segoe UI;
}

#sidebar{
width:260px;
height:100vh;
background:#0A2540;
position:fixed;
left:0;
top:0;
padding:20px;
overflow-y:auto;
}

#main{
margin-left:260px;
padding:30px;
}

.nav-link{
color:#d1d5db;
margin-bottom:5px;
}

.nav-link.active,
.nav-link:hover{
background:#0d6efd;
color:white;
}

.card{
border:none;
border-radius:15px;
}

</style>

</head>

<body>

<div id="sidebar" class="d-flex flex-column text-white">

<a href="dashboard.php" class="d-flex align-items-center mb-4 text-white text-decoration-none">

<i class="bi bi-box-seam fs-4 me-2 text-info"></i>

<span class="fs-5 fw-bold">IMS Dashboard</span>

</a>

<hr>

<ul class="nav nav-pills flex-column">

<li><a href="dashboard.php" class="nav-link">Dashboard</a></li>

<li><a href="products.php" class="nav-link">Product Management</a></li>

<li><a href="categories.php" class="nav-link">Category Management</a></li>

<li><a href="suppliers.php" class="nav-link">Supplier Management</a></li>

<li><a href="customers.php" class="nav-link">Customer Management</a></li>

<li><a href="purchases.php" class="nav-link active">Purchase Management</a></li>

<li><a href="sales.php" class="nav-link">Sales Management</a></li>

<li><a href="reports.php" class="nav-link">Reports</a></li>

</ul>

</div>

<div id="main">

<div class="card shadow">

<div class="card-header bg-primary text-white">

<h4>Edit Purchase</h4>

</div>

<div class="card-body">

<form action="update_purchase.php" method="POST">

<input type="hidden" name="id" value="<?php echo $data['id']; ?>">
<div class="mb-3">

<label class="form-label">Supplier</label>

<select name="supplier_id" class="form-select" required>

<?php

while($supplier=mysqli_fetch_assoc($suppliers))
{

?>

<option value="<?php echo $supplier['id']; ?>"

<?php
if($supplier['id']==$data['supplier_id'])
echo "selected";
?>

>

<?php echo htmlspecialchars($supplier['supplier_name']); ?>

</option>

<?php

}

?>

</select>

</div>

<div class="mb-3">

<label class="form-label">Product</label>

<select name="product_id" class="form-select" required>

<?php

while($product=mysqli_fetch_assoc($products))
{

?>

<option value="<?php echo $product['id']; ?>"

<?php
if($product['id']==$data['product_id'])
echo "selected";
?>

>

<?php echo htmlspecialchars($product['product_name']); ?>

</option>

<?php

}

?>

</select>

</div>

<div class="row">

<div class="col-md-6 mb-3">

<label class="form-label">

Quantity

</label>

<input
type="number"
name="quantity"
id="quantity"
class="form-control"
value="<?php echo $data['quantity']; ?>"
required
onkeyup="calculateTotal()"
onchange="calculateTotal()">

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

Purchase Price

</label>

<input
type="number"
step="0.01"
name="purchase_price"
id="purchase_price"
class="form-control"
value="<?php echo $data['purchase_price']; ?>"
required
onkeyup="calculateTotal()"
onchange="calculateTotal()">

</div>

</div>

<div class="row">

<div class="col-md-6 mb-3">

<label class="form-label">

Total Price

</label>

<input
type="text"
id="total_display"
class="form-control"
value="<?php echo number_format($data['total_price'],2,'.',''); ?>"
readonly>

<input
type="hidden"
name="total_price"
id="total_price"
value="<?php echo $data['total_price']; ?>">

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

Purchase Date

</label>

<input
type="date"
name="purchase_date"
class="form-control"
value="<?php echo $data['purchase_date']; ?>"
required>

</div>

</div>

<div class="mt-4">

<button class="btn btn-primary">

<i class="bi bi-save"></i>

Update Purchase

</button>

<a href="purchases.php" class="btn btn-secondary">

Cancel

</a>

</div>

</form>

</div>

</div>

</div>

<script>

function calculateTotal(){

let qty=parseFloat(document.getElementById('quantity').value)||0;

let price=parseFloat(document.getElementById('purchase_price').value)||0;

let total=qty*price;

document.getElementById("total_display").value=total.toFixed(2);

document.getElementById("total_price").value=total.toFixed(2);

}

</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>

<?php

mysqli_close($conn);

?>