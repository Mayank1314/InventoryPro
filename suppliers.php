<?php

$host="localhost";
$user="root";
$password="";
$database="inventory_management";


$conn=mysqli_connect($host,$user,$password,$database);


if(!$conn){

    die("Connection Failed: ".mysqli_connect_error());

}



$search="";


if(isset($_GET['search']) && $_GET['search']!="")
{

    $search=mysqli_real_escape_string($conn,$_GET['search']);


    $sql="

    SELECT * FROM suppliers

    WHERE supplier_name LIKE '%$search%'

    OR contact_person LIKE '%$search%'

    OR phone LIKE '%$search%'

    ORDER BY id DESC

    ";

}
else
{

    $sql="SELECT * FROM suppliers ORDER BY id DESC";

}



$result=mysqli_query($conn,$sql);


?>

<?php

session_start();


if(!isset($_SESSION['username']))
{
    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>

<html lang="en">

<head>


<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">


<title>Supplier Management</title>



<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">



<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">



<link rel="stylesheet" href="assets/css/admin.css">



</head>


<body>



<?php include("includes/sidebar.php"); ?>




<div id="main-content">





<!-- ALERTS -->


<?php if(isset($_GET['success'])){ ?>


<div class="alert alert-success alert-dismissible fade show">

<i class="bi bi-check-circle-fill"></i>

Supplier Added Successfully.

<button class="btn-close" data-bs-dismiss="alert"></button>

</div>


<?php } ?>





<?php if(isset($_GET['updated'])){ ?>


<div class="alert alert-primary alert-dismissible fade show">

<i class="bi bi-pencil-square"></i>

Supplier Updated Successfully.

<button class="btn-close" data-bs-dismiss="alert"></button>

</div>


<?php } ?>





<?php if(isset($_GET['deleted'])){ ?>


<div class="alert alert-danger alert-dismissible fade show">

<i class="bi bi-trash-fill"></i>

Supplier Deleted Successfully.

<button class="btn-close" data-bs-dismiss="alert"></button>

</div>


<?php } ?>





<?php if(isset($_GET['exists'])){ ?>


<div class="alert alert-warning alert-dismissible fade show">

<i class="bi bi-exclamation-triangle-fill"></i>

Supplier already exists.

<button class="btn-close" data-bs-dismiss="alert"></button>

</div>


<?php } ?>







<!-- HEADER -->


<div class="d-flex justify-content-between align-items-center mb-4">



<h2 class="page-title mb-0">


<i class="bi bi-truck"></i>


Supplier Management


</h2>





<a href="add_supplier.php" class="btn btn-primary">


<i class="bi bi-plus-circle"></i>


Add Supplier


</a>



</div>







<!-- TABLE -->


<div class="table-container shadow">





<form method="GET">


<div class="input-group mb-4 search-box">



<input

type="text"

name="search"

class="form-control"

placeholder="Search Supplier..."

value="<?php echo htmlspecialchars($search); ?>"



>


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

<th>Supplier Name</th>

<th>Contact Person</th>

<th>Phone</th>

<th>Email</th>

<th>Created</th>

<th width="180">Action</th>


</tr>


</thead>





<tbody>




<?php


if(mysqli_num_rows($result)>0)

{


while($row=mysqli_fetch_assoc($result))

{


?>


<tr>



<td>

<?php echo $row['id']; ?>

</td>



<td>

<?php echo htmlspecialchars($row['supplier_name']); ?>

</td>



<td>

<?php echo htmlspecialchars($row['contact_person']); ?>

</td>



<td>

<?php echo htmlspecialchars($row['phone']); ?>

</td>



<td>

<?php echo htmlspecialchars($row['email']); ?>

</td>



<td>

<?php echo date("d M Y",strtotime($row['created_at'])); ?>

</td>




<td>



<a href="edit_supplier.php?id=<?php echo $row['id']; ?>"

class="btn btn-success btn-sm">


<i class="bi bi-pencil-square"></i>

</a>




<a href="delete_supplier.php?id=<?php echo $row['id']; ?>"

class="btn btn-danger btn-sm"

onclick="return confirm('Delete this supplier?');">


<i class="bi bi-trash"></i>

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


<td colspan="7" class="text-center py-5">


<i class="bi bi-truck display-4"></i>



<h5 class="mt-3">

No Suppliers Found

</h5>



<p>

Click Add Supplier to create your first supplier.

</p>



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






<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>



</body>


</html>


<?php

mysqli_close($conn);

?>