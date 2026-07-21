<?php

$host = "localhost";
$user = "root";
$password = "";
$database = "inventory_management";

$conn = mysqli_connect($host,$user,$password,$database);

if(!$conn){
    die("Connection Failed : ".mysqli_connect_error());
}

$search="";

if(isset($_GET['search']))
{
    $search=mysqli_real_escape_string($conn,$_GET['search']);

    $sql="SELECT * FROM categories
          WHERE category_name LIKE '%$search%'
          OR description LIKE '%$search%'
          ORDER BY id DESC";
}
else
{
    $sql="SELECT * FROM categories ORDER BY id DESC";
}

$result=mysqli_query($conn,$sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Category Management</title>

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
color:#fff;
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

.table th{
background:#0A2540;
color:#fff;
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

<div class="d-flex justify-content-between align-items-center mb-4">
<?php if(isset($_GET['success'])){ ?>

<div class="alert alert-success alert-dismissible fade show">

<i class="bi bi-check-circle-fill"></i>

Category Added Successfully.

<button class="btn-close" data-bs-dismiss="alert"></button>

</div>

<?php } ?>

<?php if(isset($_GET['updated'])){ ?>

<div class="alert alert-primary alert-dismissible fade show">

<i class="bi bi-pencil-square"></i>

Category Updated Successfully.

<button class="btn-close" data-bs-dismiss="alert"></button>

</div>

<?php } ?>

<?php if(isset($_GET['deleted'])){ ?>

<div class="alert alert-danger alert-dismissible fade show">

<i class="bi bi-trash-fill"></i>

Category Deleted Successfully.

<button class="btn-close" data-bs-dismiss="alert"></button>

</div>

<?php } ?>

<?php if(isset($_GET['exists'])){ ?>

<div class="alert alert-warning alert-dismissible fade show">

<i class="bi bi-exclamation-triangle-fill"></i>

Category already exists.

<button class="btn-close" data-bs-dismiss="alert"></button>

</div>

<?php } ?>

<h2>

<i class="bi bi-tags"></i>

Category Management

</h2>

<a href="add_category.php" class="btn btn-primary">

<i class="bi bi-plus-circle"></i>

Add Category

</a>

</div>

<div class="card shadow">

<div class="card-body">

<form method="GET">

<div class="input-group mb-4" style="max-width:350px;">

<input
type="text"
name="search"
class="form-control"
placeholder="Search Category..."
value="<?php echo $search; ?>">

<button class="btn btn-primary">

<i class="bi bi-search"></i>

</button>

</div>

</form>

<div class="table-responsive">

<table class="table table-bordered table-hover">

<thead>

<tr>

<th>ID</th>

<th>Category Name</th>

<th>Description</th>

<th>Created</th>

<th width="170">

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

<td><?php echo htmlspecialchars($row['category_name']); ?></td>

<td><?php echo htmlspecialchars($row['description']); ?></td>

<td><?php echo date("d M Y", strtotime($row['created_at'])); ?></td>

<td>

<a href="edit_category.php?id=<?php echo $row['id']; ?>"
class="btn btn-success btn-sm">

<i class="bi bi-pencil-square"></i>

Edit

</a>

<a href="delete_category.php?id=<?php echo $row['id']; ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Are you sure you want to delete this category?');">

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

<td colspan="5" class="text-center py-5 text-muted">

<i class="bi bi-tags display-4 d-block mb-3"></i>

<h5>No Categories Found</h5>

<p>Click <strong>Add Category</strong> to create your first category.</p>

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