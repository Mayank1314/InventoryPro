<?php
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Add Supplier</title>

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

<!-- Paste your sidebar here -->

</div>

<div id="main">

<div class="card shadow">

<div class="card-header bg-primary text-white">

<h4>

<i class="bi bi-truck"></i>

Add Supplier

</h4>

</div>

<div class="card-body">

<form action="supplier_process.php" method="POST">

<div class="mb-3">

<label class="form-label">Supplier Name</label>

<input
type="text"
name="supplier_name"
class="form-control"
required>

</div>

<div class="mb-3">

<label class="form-label">Contact Person</label>

<input
type="text"
name="contact_person"
class="form-control">

</div>

<div class="mb-3">

<label class="form-label">Phone Number</label>

<input
type="text"
name="phone"
class="form-control">

</div>

<div class="mb-3">

<label class="form-label">Email Address</label>

<input
type="email"
name="email"
class="form-control">

</div>

<div class="mb-3">

<label class="form-label">Address</label>

<textarea
name="address"
rows="4"
class="form-control"></textarea>

</div>

<button
type="submit"
class="btn btn-primary">

<i class="bi bi-save"></i>

Save Supplier

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