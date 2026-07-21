<?php
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Add Category</title>

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
background:var(--dark);
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
<a href="categories.php" class="nav-link active">
<i class="bi bi-tags me-2"></i>
Category Management
</a>
</li>

<li>
<a href="products.php" class="nav-link">
<i class="bi bi-box me-2"></i>
Product Management
</a>
</li>

</ul>

</div>

<div id="main">

<div class="card shadow">

<div class="card-header bg-primary text-white">

<h4>
<i class="bi bi-plus-circle"></i>
Add New Category
</h4>

</div>

<div class="card-body">

<form action="category_process.php" method="POST">

<div class="mb-3">

<label class="form-label">
Category Name
</label>

<input
type="text"
name="category_name"
class="form-control"
placeholder="Enter Category Name"
required>

</div>

<div class="mb-3">

<label class="form-label">
Description
</label>

<textarea
name="description"
class="form-control"
rows="5"
placeholder="Enter Category Description"></textarea>

</div>

<button
type="submit"
class="btn btn-primary">

<i class="bi bi-save"></i>

Save Category

</button>

<a
href="categories.php"
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