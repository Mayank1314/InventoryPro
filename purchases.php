<?php

$host = "localhost";
$user = "root";
$password = "";
$database = "inventory_management";


$conn = mysqli_connect($host,$user,$password,$database);


if(!$conn){
    die("Connection Failed: ".mysqli_connect_error());
}



$search="";


$sql="
SELECT purchases.*,
       suppliers.supplier_name,
       products.product_name

FROM purchases

INNER JOIN suppliers
ON purchases.supplier_id = suppliers.id

INNER JOIN products
ON purchases.product_id = products.id
";



if(isset($_GET['search']) && $_GET['search']!="")
{

    $search=mysqli_real_escape_string($conn,$_GET['search']);


    $sql.="

    WHERE suppliers.supplier_name LIKE '%$search%'

    OR products.product_name LIKE '%$search%'

    ";

}



$sql.=" ORDER BY purchases.id DESC";


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


<title>Purchase Management</title>



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

<i class="bi bi-check-circle"></i>

Purchase Added Successfully


<button class="btn-close" data-bs-dismiss="alert"></button>

</div>


<?php } ?>





<?php if(isset($_GET['updated'])){ ?>


<div class="alert alert-primary alert-dismissible fade show">


<i class="bi bi-pencil"></i>

Purchase Updated Successfully


<button class="btn-close" data-bs-dismiss="alert"></button>


</div>


<?php } ?>





<?php if(isset($_GET['deleted'])){ ?>


<div class="alert alert-danger alert-dismissible fade show">


<i class="bi bi-trash"></i>

Purchase Deleted Successfully


<button class="btn-close" data-bs-dismiss="alert"></button>


</div>


<?php } ?>







<!-- HEADER -->


<div class="d-flex justify-content-between align-items-center mb-4">



<h2 class="page-title mb-0">


<i class="bi bi-cart-plus"></i>

Purchase Management


</h2>


<?php if($_SESSION['role']=="Admin"){ ?>

<a href="add_purchase.php" class="btn btn-primary">


<i class="bi bi-plus-circle"></i>

Add Purchase


</a>


<?php } ?>

</div>






<!-- TABLE -->


<div class="table-container shadow">





<form method="GET">


<div class="input-group mb-4 search-box">



<input

type="text"

name="search"

class="form-control"

placeholder="Search Purchase..."

value="<?php echo htmlspecialchars($search); ?>"



>


<button class="btn btn-primary">


<i class="bi bi-search"></i>

Search


</button>


</div>


</form>







<div class="table-responsive">


<table class="table table-bordered table-hover align-middle">



<thead>


<tr>


<th>ID</th>

<th>Supplier</th>

<th>Product</th>

<th>Quantity</th>

<th>Purchase Price</th>

<th>Total Price</th>

<th>Purchase Date</th>

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
<?php echo htmlspecialchars($row['product_name']); ?>
</td>



<td>
<?php echo $row['quantity']; ?>
</td>



<td>
₹<?php echo number_format($row['purchase_price'],2); ?>
</td>



<td>
₹<?php echo number_format($row['total_price'],2); ?>
</td>



<td>

<?php echo date("d M Y",strtotime($row['purchase_date'])); ?>

</td>




<td>



<a href="edit_purchase.php?id=<?php echo $row['id']; ?>"

class="btn btn-success btn-sm">


<i class="bi bi-pencil-square"></i>

</a>




<a href="delete_purchase.php?id=<?php echo $row['id']; ?>"

class="btn btn-danger btn-sm"

onclick="return confirm('Delete this purchase?');">


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


<td colspan="8" class="text-center py-5">


<i class="bi bi-cart-x display-4"></i>



<h5 class="mt-3">

No Purchase Records Found

</h5>


<p>

Click Add Purchase to create your first purchase.

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