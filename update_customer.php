<?php

$conn=mysqli_connect("localhost","root","","inventory_management");

$id=$_POST['id'];
$name=mysqli_real_escape_string($conn,$_POST['customer_name']);
$phone=mysqli_real_escape_string($conn,$_POST['phone']);
$email=mysqli_real_escape_string($conn,$_POST['email']);
$address=mysqli_real_escape_string($conn,$_POST['address']);

$sql="UPDATE customers SET

customer_name='$name',
phone='$phone',
email='$email',
address='$address'

WHERE id='$id'";

if(mysqli_query($conn,$sql))
{
header("Location: customers.php?updated=1");
exit();
}
else
{
echo mysqli_error($conn);
}

?>