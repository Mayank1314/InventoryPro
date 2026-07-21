<?php

$host = "localhost";
$user = "root";
$password = "";
$database = "inventory_management";

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Connection Failed : " . mysqli_connect_error());
}

$id = $_POST['id'];
$product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
$category = mysqli_real_escape_string($conn, $_POST['category']);
$supplier = mysqli_real_escape_string($conn, $_POST['supplier']);
$sku = mysqli_real_escape_string($conn, $_POST['sku']);
$cost_price = mysqli_real_escape_string($conn, $_POST['cost_price']);
$selling_price = mysqli_real_escape_string($conn, $_POST['selling_price']);
$quantity = mysqli_real_escape_string($conn, $_POST['quantity']);
$unit = mysqli_real_escape_string($conn, $_POST['unit']);
$description = mysqli_real_escape_string($conn, $_POST['description']);

$sql = "UPDATE products SET
product_name='$product_name',
category='$category',
supplier='$supplier',
sku='$sku',
cost_price='$cost_price',
selling_price='$selling_price',
quantity='$quantity',
unit='$unit',
description='$description'
WHERE id='$id'";

if(mysqli_query($conn,$sql))
{
    header("Location: products.php?updated=1");
    exit();
}
else
{
    echo "Error : ".mysqli_error($conn);
}

mysqli_close($conn);

?>