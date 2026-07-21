<?php

$conn=mysqli_connect("localhost","root","","inventory_management");

$id=$_GET['id'];


$query=mysqli_query($conn,"
SELECT 
sales.id,
sales.quantity,
sales.selling_price,
sales.total_price,
sales.sale_date,

products.product_name,

customers.customer_name

FROM sales

INNER JOIN products
ON sales.product_id = products.id

INNER JOIN customers
ON sales.customer_id = customers.id

WHERE sales.id='$id'
");


$data=mysqli_fetch_assoc($query);

?>


<!DOCTYPE html>
<html>

<head>

<title>Invoice</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>


<body>


<div class="container mt-5">


<div class="card p-4">


<h2 class="text-center">
Inventory Management System
</h2>

<hr>


<h4>Sales Invoice</h4>


<p>
<b>Invoice No:</b>
<?php echo $data['id']; ?>
</p>


<p>
<b>Date:</b>
<?php echo $data['sale_date']; ?>
</p>


<p>
<b>Customer:</b>
<?php echo $data['customer_name']; ?>
</p>



<table class="table table-bordered">


<tr>

<th>Product</th>

<th>Quantity</th>

<th>Price</th>

<th>Total</th>

</tr>


<tr>

<td>
<?php echo $data['product_name']; ?>
</td>


<td>
<?php echo $data['quantity']; ?>
</td>


<td>
₹ <?php echo $data['selling_price']; ?>
</td>


<td>
₹ <?php echo $data['total_price']; ?>
</td>


</tr>


</table>


<h4 class="text-end">

Total Amount:
₹ <?php echo $data['total_price']; ?>

</h4>


<button onclick="window.print()" 
class="btn btn-primary">

Print Invoice

</button>


</div>


</div>


</body>

</html>