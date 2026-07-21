<?php

$host = "localhost";
$user = "root";
$password = "";
$database = "inventory_management";

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Connection Failed : " . mysqli_connect_error());
}

if(isset($_POST['id']))
{

$id=$_POST['id'];

$customer_id=$_POST['customer_id'];
$product_id=$_POST['product_id'];

$new_quantity=$_POST['quantity'];
$old_quantity=$_POST['old_quantity'];

$selling_price=$_POST['selling_price'];
$total_price=$_POST['total_price'];
$sale_date=$_POST['sale_date'];

/* Get Old Sale */

$old=mysqli_query($conn,"
SELECT *
FROM sales
WHERE id='$id'
");

$oldData=mysqli_fetch_assoc($old);

$old_product=$oldData['product_id'];

/* Restore Old Stock */

mysqli_query($conn,"
UPDATE products
SET quantity=quantity+$old_quantity
WHERE id='$old_product'
");

/* Check Current Stock */

$check=mysqli_query($conn,"
SELECT quantity
FROM products
WHERE id='$product_id'
");

$product=mysqli_fetch_assoc($check);

$currentStock=$product['quantity'];

if($new_quantity>$currentStock)
{

echo "<script>

alert('Insufficient Stock Available!');

window.location='edit_sale.php?id=$id';

</script>";

exit();

}

/* Deduct New Stock */

mysqli_query($conn,"
UPDATE products
SET quantity=quantity-$new_quantity
WHERE id='$product_id'
");

/* Update Sale */

mysqli_query($conn,"
UPDATE sales
SET

customer_id='$customer_id',
product_id='$product_id',
quantity='$new_quantity',
selling_price='$selling_price',
total_price='$total_price',
sale_date='$sale_date'

WHERE id='$id'
");

header("Location:sales.php?updated=1");

exit();

}

mysqli_close($conn);

?>