<?php

$host="localhost";
$user="root";
$password="";
$database="inventory_management";

$conn=mysqli_connect($host,$user,$password,$database);

if(!$conn){
    die(mysqli_connect_error());
}

if(isset($_GET['id']))
{

$id=$_GET['id'];

/* Get Purchase Details */

$purchase=mysqli_query($conn,"
SELECT *
FROM purchases
WHERE id='$id'
");

$data=mysqli_fetch_assoc($purchase);

$product_id=$data['product_id'];
$quantity=$data['quantity'];

/* Reduce Product Quantity */

mysqli_query($conn,"
UPDATE products
SET quantity=quantity-$quantity
WHERE id='$product_id'
");

/* Delete Purchase */

mysqli_query($conn,"
DELETE FROM purchases
WHERE id='$id'
");

header("Location:purchases.php?deleted=1");

exit();

}

mysqli_close($conn);

?>