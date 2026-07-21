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
    header("Location: suppliers.php");
    exit();
}

$id = intval($_GET['id']);

$sql = "SELECT * FROM suppliers WHERE id=$id";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 0) {
    header("Location: suppliers.php");
    exit();
}

$row = mysqli_fetch_assoc($result);

?>
<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Edit Supplier</title>

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

<div id="main">

<div class="card shadow">

<div class="card-header bg-success text-white">

<h4>

<i class="bi bi-pencil-square"></i>

Edit Supplier

</h4>

</div>

<div class="card-body">

<form action="update_supplier.php" method="POST">

<input type="hidden" name="id" value="<?php echo $row['id']; ?>">

<div class="mb-3">

<label class="form-label">Supplier Name</label>

<input
type="text"
name="supplier_name"
class="form-control"
value="<?php echo $row['supplier_name']; ?>"
required>

</div>

<div class="mb-3">

<label class="form-label">Contact Person</label>

<input
type="text"
name="contact_person"
class="form-control"
value="<?php echo $row['contact_person']; ?>">

</div>

<div class="mb-3">

<label class="form-label">Phone</label>

<input
type="text"
name="phone"
class="form-control"
value="<?php echo $row['phone']; ?>">

</div>

<div class="mb-3">

<label class="form-label">Email</label>

<input
type="email"
name="email"
class="form-control"
value="<?php echo $row['email']; ?>">

</div>

<div class="mb-3">

<label class="form-label">Address</label>

<textarea
name="address"
rows="4"
class="form-control"><?php echo $row['address']; ?></textarea>

</div>

<button class="btn btn-success">

<i class="bi bi-check-circle"></i>

Update Supplier

</button>

<a href="suppliers.php" class="btn btn-secondary">

Cancel

</a>

</form>

</div>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>