
<?php

session_start();

if(!isset($_SESSION['username'])){
    header("Location: login.php");
    exit();
}

if($_SESSION['role'] != "Admin"){
    header("Location: products.php");
    exit();
}

?>

<?php

$conn=mysqli_connect(
"localhost",
"root",
"",
"inventory_management"
);


if(!$conn){

    die("Database Connection Failed");

}


// DATE FILTER

$from = $_GET['from'] ?? date('Y-m-01');

$to = $_GET['to'] ?? date('Y-m-d');




// SUMMARY


$total_products=mysqli_fetch_assoc(

mysqli_query($conn,"
SELECT COUNT(*) total 
FROM products
")

)['total'];




$current_stock=mysqli_fetch_assoc(

mysqli_query($conn,"
SELECT IFNULL(SUM(quantity),0) total
FROM products
")

)['total'];




// LOW STOCK


$low_stock=mysqli_query($conn,"

SELECT product_name,sku,quantity

FROM products

WHERE quantity <=5

ORDER BY quantity ASC

");




// PURCHASE REPORT


$purchases=mysqli_query($conn,"

SELECT

p.id,
pr.product_name,
s.supplier_name,
p.quantity,
p.total_price,
p.purchase_date


FROM purchases p


JOIN products pr

ON p.product_id=pr.id


JOIN suppliers s

ON p.supplier_id=s.id



WHERE p.purchase_date

BETWEEN '$from' AND '$to'


ORDER BY p.created_at DESC

");





// SALES REPORT


$sales=mysqli_query($conn,"

SELECT

s.id,
pr.product_name,
c.customer_name,
s.quantity,
s.total_price,
s.sale_date


FROM sales s


JOIN products pr

ON s.product_id=pr.id


JOIN customers c

ON s.customer_id=c.id



ORDER BY s.created_at DESC

");




// GRAPH DATA



$graph_sales=mysqli_fetch_assoc(

mysqli_query($conn,"

SELECT IFNULL(SUM(total_price),0) total

FROM sales

WHERE sale_date BETWEEN '$from' AND '$to'

")

)['total'];




$graph_purchase=mysqli_fetch_assoc(

mysqli_query($conn,"

SELECT IFNULL(SUM(total_price),0) total

FROM purchases

WHERE purchase_date BETWEEN '$from' AND '$to'

")

)['total'];




$available_stock=mysqli_fetch_assoc(

mysqli_query($conn,"

SELECT IFNULL(SUM(quantity),0) total

FROM products

")

)['total'];




$low_stock_items=mysqli_fetch_assoc(

mysqli_query($conn,"

SELECT COUNT(*) total

FROM products

WHERE quantity<=5

")

)['total'];



?>

<?php



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


<title>Inventory Reports</title>



<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">



<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">


<link rel="stylesheet" href="assets/css/admin.css">



<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>



</head>



<body>



<?php include("includes/sidebar.php"); ?>




<div id="main-content">





<div class="d-flex justify-content-between align-items-center mb-4">


<h2 class="page-title mb-0">


<i class="bi bi-file-earmark-bar-graph"></i>

Inventory Reports


</h2>



<button class="btn btn-primary" onclick="window.print()">


<i class="bi bi-printer"></i>

Print Report


</button>


</div>






<!-- DATE FILTER -->


<div class="table-container shadow mb-4">


<form method="GET" class="row g-3">



<div class="col-md-4">


<label class="form-label">

From Date

</label>


<input

type="date"

name="from"

class="form-control"

value="<?php echo $from; ?>"

>


</div>




<div class="col-md-4">


<label class="form-label">

To Date

</label>


<input

type="date"

name="to"

class="form-control"

value="<?php echo $to; ?>"

>


</div>




<div class="col-md-2 d-flex align-items-end">


<button class="btn btn-primary w-100">


<i class="bi bi-search"></i>

Generate


</button>


</div>



</form>


</div>








<!-- SUMMARY -->


<div class="row g-4 mb-4">



<div class="col-md-4">


<div class="card-box">


<h6>Total Products</h6>


<h3>

<?php echo $total_products; ?>

</h3>


</div>


</div>




<div class="col-md-4">


<div class="card-box">


<h6>Current Stock</h6>


<h3>

<?php echo $current_stock; ?>

Units

</h3>


</div>


</div>





<div class="col-md-4">


<div class="card-box">


<h6>Report Date</h6>


<h3>

<?php echo date("d M Y"); ?>

</h3>


</div>


</div>



</div>







<!-- GRAPHS -->


<div class="row g-4 mb-4">



<div class="col-md-6">


<div class="card-box">


<h5>

<i class="bi bi-bar-chart"></i>

Sales vs Purchases

</h5>


<canvas id="salesPurchaseChart"></canvas>


</div>


</div>





<div class="col-md-6">


<div class="card-box">


<h5>

<i class="bi bi-pie-chart"></i>

Stock Status

</h5>


<div style="height:300px">

<canvas id="stockChart"></canvas>

</div>


</div>


</div>


</div>







<!-- LOW STOCK -->


<div class="table-container shadow mb-4">


<h5 class="mb-3 text-danger">


<i class="bi bi-exclamation-triangle"></i>

Low Stock Report


</h5>



<table class="table table-bordered">


<tr>

<th>Product</th>

<th>SKU</th>

<th>Quantity</th>

</tr>




<?php


if(mysqli_num_rows($low_stock)>0){


while($row=mysqli_fetch_assoc($low_stock)){


?>


<tr>


<td>

<?php echo $row['product_name']; ?>

</td>


<td>

<?php echo $row['sku']; ?>

</td>


<td>


<span class="badge bg-danger">

<?php echo $row['quantity']; ?>

Left

</span>


</td>


</tr>


<?php

}

}

else{


echo "

<tr>

<td colspan='3' class='text-center'>

No Low Stock Products

</td>

</tr>";

}


?>


</table>


</div>






<!-- PURCHASE TABLE -->


<div class="table-container shadow mb-4">


<h5>

<i class="bi bi-cart-plus"></i>

Purchase Report

</h5>



<table class="table table-hover">


<tr>

<th>ID</th>

<th>Product</th>

<th>Supplier</th>

<th>Quantity</th>

<th>Total</th>

<th>Date</th>

</tr>



<?php while($row=mysqli_fetch_assoc($purchases)){ ?>


<tr>


<td>PUR-<?php echo $row['id']; ?></td>


<td><?php echo $row['product_name']; ?></td>


<td><?php echo $row['supplier_name']; ?></td>


<td><?php echo $row['quantity']; ?></td>


<td>

₹<?php echo number_format($row['total_price'],2); ?>

</td>


<td>

<?php echo date("d-m-Y",strtotime($row['purchase_date'])); ?>

</td>


</tr>


<?php } ?>


</table>


</div>







<!-- SALES TABLE -->


<div class="table-container shadow mb-4">


<h5>

<i class="bi bi-cash-coin"></i>

Sales Report

</h5>



<table class="table table-hover">


<tr>

<th>ID</th>

<th>Product</th>

<th>Customer</th>

<th>Quantity</th>

<th>Total</th>

<th>Date</th>

</tr>




<?php while($row=mysqli_fetch_assoc($sales)){ ?>


<tr>


<td>

SALE-<?php echo $row['id']; ?>

</td>


<td>

<?php echo $row['product_name']; ?>

</td>


<td>

<?php echo $row['customer_name']; ?>

</td>


<td>

<?php echo $row['quantity']; ?>

</td>


<td>

₹<?php echo number_format($row['total_price'],2); ?>

</td>


<td>

<?php echo date("d-m-Y",strtotime($row['sale_date'])); ?>

</td>


</tr>


<?php } ?>


</table>


</div>






</div>





<script>


new Chart(

document.getElementById('salesPurchaseChart'),

{


type:'bar',


data:{


labels:['Sales','Purchases'],


datasets:[{

label:'Amount ₹',

data:[

<?php echo $graph_sales; ?>,

<?php echo $graph_purchase; ?>

]

}]


}


}

);




new Chart(

document.getElementById('stockChart'),

{


type:'pie',


data:{


labels:[

'Available Stock',

'Low Stock'

],


datasets:[{

data:[

<?php echo $available_stock; ?>,

<?php echo $low_stock_items; ?>

]


}]


}



}

);


</script>


<script src="assets/js/darkmode.js"></script>
</body>

</html>