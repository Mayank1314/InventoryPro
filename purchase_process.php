<?php

$host = "localhost";
$user = "root";
$password = "";
$database = "inventory_management";

$conn = mysqli_connect($host,$user,$password,$database);

if(!$conn){
    die(mysqli_connect_error());
}

if(isset($_POST['supplier_id'])){

$supplier_id=$_POST['supplier_id'];
$product_id=$_POST['product_id'];
$quantity=$_POST['quantity'];
$purchase_price=$_POST['purchase_price'];
$total_price=$_POST['total_price'];
$purchase_date=$_POST['purchase_date'];

$insert="INSERT INTO purchases
(supplier_id,product_id,quantity,purchase_price,total_price,purchase_date)
VALUES
('$supplier_id','$product_id','$quantity','$purchase_price','$total_price','$purchase_date')";

if(mysqli_query($conn,$insert)){

mysqli_query($conn,"
UPDATE products
SET quantity=quantity+$quantity
WHERE id='$product_id'
");

header("Location:purchases.php?success=1");
exit();

}else{

echo mysqli_error($conn);

}

}

?>