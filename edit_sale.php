<?php

$host = "localhost";
$user = "root";
$password = "";
$database = "inventory_management";

$conn = mysqli_connect($host, $user, $password, $database);

if(!$conn){
    die("Connection Failed : ".mysqli_connect_error());
}

$id = $_GET['id'];

$sql = "
SELECT sales.*,
customers.customer_name,
products.product_name
FROM sales
JOIN customers ON sales.customer_id = customers.id
JOIN products ON sales.product_id = products.id
WHERE sales.id='$id'
";

$result = mysqli_query($conn,$sql);

$row = mysqli_fetch_assoc($result);

$customers = mysqli_query($conn,"
SELECT *
FROM customers
ORDER BY customer_name
");

$products = mysqli_query($conn,"
SELECT *
FROM products
ORDER BY product_name
");

?>
<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<title>Edit Sale</title>

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

.nav-link:hover,
.nav-link.active{
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

<span class="fs-5 fw-bold">

IMS Dashboard

</span>

</a>

<hr>

<ul class="nav nav-pills flex-column">

<li><a href="dashboard.php" class="nav-link"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a></li>

<li><a href="products.php" class="nav-link"><i class="bi bi-box me-2"></i>Product Management</a></li>

<li><a href="categories.php" class="nav-link"><i class="bi bi-tags me-2"></i>Category Management</a></li>

<li><a href="suppliers.php" class="nav-link"><i class="bi bi-truck me-2"></i>Supplier Management</a></li>

<li><a href="customers.php" class="nav-link"><i class="bi bi-people me-2"></i>Customer Management</a></li>

<li><a href="purchases.php" class="nav-link"><i class="bi bi-cart-plus me-2"></i>Purchase Management</a></li>

<li><a href="sales.php" class="nav-link active"><i class="bi bi-cash-coin me-2"></i>Sales Management</a></li>

<li><a href="#" class="nav-link"><i class="bi bi-journal-text me-2"></i>Reports</a></li>

</ul>

<hr>

<div class="dropdown">

<a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">

<i class="bi bi-person-circle fs-5 me-2 text-info"></i>

<strong>Mayank Upadhyay</strong>

</a>

<ul class="dropdown-menu dropdown-menu-dark">

<li>

<a class="dropdown-item" href="login.php">

<i class="bi bi-box-arrow-right me-2"></i>

Logout

</a>

</li>

</ul>

</div>

</div>

<div id="main">

<div class="card shadow">

<div class="card-header bg-warning">

<h4>

<i class="bi bi-pencil-square"></i>

Edit Sale

</h4>

</div>

<div class="card-body">

<form action="update_sale.php" method="POST">

<input type="hidden" name="id" value="<?php echo $row['id']; ?>">

<input type="hidden" name="old_quantity" value="<?php echo $row['quantity']; ?>">
<div class="mb-3">

<label class="form-label">Customer</label>

<select name="customer_id" class="form-select" required>

<?php while($customer=mysqli_fetch_assoc($customers)){ ?>

<option
value="<?php echo $customer['id']; ?>"
<?php if($customer['id']==$row['customer_id']) echo "selected"; ?>>

<?php echo htmlspecialchars($customer['customer_name']); ?>

</option>

<?php } ?>

</select>

</div>

<div class="mb-3">

<label class="form-label">Product</label>

<select name="product_id" id="product" class="form-select" required>

<?php while($product=mysqli_fetch_assoc($products)){ ?>

<option
value="<?php echo $product['id']; ?>"
data-price="<?php echo $product['selling_price']; ?>"
data-stock="<?php echo $product['quantity']; ?>"
<?php if($product['id']==$row['product_id']) echo "selected"; ?>>

<?php echo htmlspecialchars($product['product_name']); ?>

(Stock : <?php echo $product['quantity']; ?>)

</option>

<?php } ?>

</select>

</div>

<div class="row">

<div class="col-md-6 mb-3">

<label class="form-label">

Available Stock

</label>

<input
type="text"
id="stock"
class="form-control"
readonly>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

Selling Price

</label>

<input
type="number"
step="0.01"
name="selling_price"
id="price"
class="form-control"
value="<?php echo $row['selling_price']; ?>"
readonly>

</div>

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
value="<?php echo $row['quantity']; ?>"
required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

Total Price

</label>

<input
type="text"
id="total_display"
class="form-control"
readonly
value="<?php echo number_format($row['total_price'],2); ?>">

<input
type="hidden"
name="total_price"
id="total_price"
value="<?php echo $row['total_price']; ?>">

</div>

</div>

<div class="mb-3">

<label class="form-label">

Sale Date

</label>

<input
type="date"
name="sale_date"
class="form-control"
value="<?php echo $row['sale_date']; ?>"
required>

</div>

<div class="mt-4">

<button type="submit" class="btn btn-warning">

<i class="bi bi-check-circle"></i>

Update Sale

</button>

<a href="sales.php" class="btn btn-secondary">

Cancel

</a>

</div>

</form>

</div>

</div>

</div>

<script>

const product=document.getElementById("product");
const price=document.getElementById("price");
const stock=document.getElementById("stock");
const qty=document.getElementById("quantity");
const total=document.getElementById("total_display");
const hidden=document.getElementById("total_price");

function calculateSale(){

let option=product.options[product.selectedIndex];

let p=parseFloat(option.dataset.price)||0;

let s=parseInt(option.dataset.stock)||0;

let q=parseInt(qty.value)||0;

price.value=p.toFixed(2);

stock.value=s;

let t=p*q;

total.value=t.toFixed(2);

hidden.value=t.toFixed(2);

}

product.addEventListener("change",calculateSale);
qty.addEventListener("keyup",calculateSale);
qty.addEventListener("change",calculateSale);

calculateSale();

</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>

<?php

mysqli_close($conn);

?>