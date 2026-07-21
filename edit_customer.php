<?php

$host = "localhost";
$user = "root";
$password = "";
$database = "inventory_management";

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}

if (!isset($_GET['id'])) {
    header("Location: customers.php");
    exit();
}

$id = intval($_GET['id']);

$sql = "SELECT * FROM customers WHERE id = $id";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 0) {
    header("Location: customers.php");
    exit();
}

$row = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Edit Customer</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css">

<style>

:root{
--dark:#0A2540;
--light:#f4f7fb;
}

body{
background:var(--light);
font-family:'Segoe UI',sans-serif;
}

#sidebar{
width:260px;
height:100vh;
background:#0A2540;
position:fixed;
left:0;
top:0;
padding:20px;
}

#main{
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

<div id="sidebar" class="d-flex flex-column p-3 text-white">

    <a href="dashboard.php" class="d-flex align-items-center mb-4 me-md-auto text-white text-decoration-none">
        <i class="bi bi-box-seam fs-4 me-2 text-info"></i>
        <span class="fs-5 fw-bold">IMS Dashboard</span>
    </a>

    <hr style="background-color:#38bdf8; opacity:.3;">

    <ul class="nav nav-pills flex-column mb-auto">

        <li class="nav-item">
            <a href="dashboard.php" class="nav-link">
                <i class="bi bi-speedometer2 me-2"></i>
                Dashboard
            </a>
        </li>

        <li>
            <a href="products.php" class="nav-link">
                <i class="bi bi-box me-2"></i>
                Product Management
            </a>
        </li>

        <li>
            <a href="categories.php" class="nav-link">
                <i class="bi bi-tags me-2"></i>
                Category Management
            </a>
        </li>

        <li>
            <a href="suppliers.php" class="nav-link active">
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
                <i class="bi bi-journal-text me-2"></i>
                Reports
            </a>
        </li>

    </ul>

    <hr style="background-color:#38bdf8; opacity:.3;">

    <div class="dropdown">

        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">

            <i class="bi bi-person-circle fs-5 me-2 text-info"></i>

            <strong>Mayank Upadhyay</strong>

        </a>

        <ul class="dropdown-menu dropdown-menu-dark shadow">

            <li>
                <a class="dropdown-item" href="login.php">
                    <i class="bi bi-box-arrow-right me-2"></i>
                    Logout
                </a>
            </li>

        </ul>

    </div>

</div>

</div>

<div id="main">

<div class="card shadow">

<div class="card-header bg-success text-white">

<h4>

<i class="bi bi-pencil-square"></i>

Edit Customer

</h4>

</div>

<div class="card-body">

<form action="update_customer.php" method="POST">

<input
type="hidden"
name="id"
value="<?php echo $row['id']; ?>">

<div class="mb-3">

<label class="form-label">Customer Name</label>

<input
type="text"
name="customer_name"
class="form-control"
value="<?php echo htmlspecialchars($row['customer_name']); ?>"
required>

</div>

<div class="mb-3">

<label class="form-label">Phone Number</label>

<input
type="text"
name="phone"
class="form-control"
value="<?php echo htmlspecialchars($row['phone']); ?>">

</div>

<div class="mb-3">

<label class="form-label">Email Address</label>

<input
type="email"
name="email"
class="form-control"
value="<?php echo htmlspecialchars($row['email']); ?>">

</div>

<div class="mb-3">

<label class="form-label">Address</label>

<textarea
name="address"
rows="4"
class="form-control"><?php echo htmlspecialchars($row['address']); ?></textarea>

</div>

<button
type="submit"
class="btn btn-success">

<i class="bi bi-check-circle"></i>

Update Customer

</button>

<a
href="customers.php"
class="btn btn-secondary">

Cancel

</a>

</form>

</div>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>