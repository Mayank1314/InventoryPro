<?php

$conn=mysqli_connect("localhost","root","","inventory_management");

$id=$_GET['id'];

$sql="DELETE FROM customers WHERE id='$id'";

if(mysqli_query($conn,$sql))
{
header("Location: customers.php?deleted=1");
exit();
}
else
{
echo mysqli_error($conn);
}

?>