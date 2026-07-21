<?php

$conn=mysqli_connect("localhost","root","","inventory_management");

$id=$_GET['id'];


/* Get sale details */
$result=mysqli_query($conn,"
SELECT product_id, quantity 
FROM sales 
WHERE id='$id'
");

$sale=mysqli_fetch_assoc($result);

$product_id=$sale['product_id'];
$quantity=$sale['quantity'];


/* Restore product quantity */
mysqli_query($conn,"
UPDATE products 
SET quantity = quantity + '$quantity'
WHERE id='$product_id'
");


/* Delete sale */
mysqli_query($conn,"
DELETE FROM sales 
WHERE id='$id'
");


header("Location:sales.php?deleted=1");
exit();

?>