<?php

$host="localhost";
$user="root";
$password="";
$database="inventory_management";

$conn=mysqli_connect($host,$user,$password,$database);

if(!$conn){
die("Connection Failed : ".mysqli_connect_error());
}

$customer_name=mysqli_real_escape_string($conn,$_POST['customer_name']);
$phone=mysqli_real_escape_string($conn,$_POST['phone']);
$email=mysqli_real_escape_string($conn,$_POST['email']);
$address=mysqli_real_escape_string($conn,$_POST['address']);

$sql="INSERT INTO customers
(customer_name,phone,email,address)
VALUES
('$customer_name','$phone','$email','$address')";

if(mysqli_query($conn,$sql))
{
header("Location: customers.php?success=1");
exit();
}
else
{
echo mysqli_error($conn);
}

mysqli_close($conn);

?>