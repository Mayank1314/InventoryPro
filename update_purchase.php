<?php

$host="localhost";
$user="root";
$password="";
$database="inventory_management";

$conn=mysqli_connect($host,$user,$password,$database);

if(!$conn){
    die(mysqli_connect_error());
}

if(isset($_POST['id']))
{

$id=$_POST['id'];
$supplier_id=$_POST['supplier_id'];
$product_id=$_POST['product_id'];
$new_quantity=$_POST['quantity'];
$purchase_price=$_POST['purchase_price'];
$total_price=$_POST['total_price'];
$purchase_date=$_POST['purchase_date'];

/* Get Old Purchase Details */

$old=mysqli_query($conn,"
SELECT *
FROM purchases
WHERE id='$id'
");

$oldData=mysqli_fetch_assoc($old);

$old_product=$oldData['product_id'];
$old_quantity=$oldData['quantity'];

/* Remove Old Stock */

mysqli_query($conn,"
UPDATE products
SET quantity=quantity-$old_quantity
WHERE id='$old_product'
");

/* Add New Stock */

mysqli_query($conn,"
UPDATE products
SET quantity=quantity+$new_quantity
WHERE id='$product_id'
");

/* Update Purchase */

mysqli_query($conn,"
UPDATE purchases
SET

supplier_id='$supplier_id',
product_id='$product_id',
quantity='$new_quantity',
purchase_price='$purchase_price',
total_price='$total_price',
purchase_date='$purchase_date'

WHERE id='$id'
");

header("Location:purchases.php?updated=1");

exit();

}

?>