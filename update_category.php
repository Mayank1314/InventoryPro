<?php

$host = "localhost";
$user = "root";
$password = "";
$database = "inventory_management";

$conn = mysqli_connect($host,$user,$password,$database);

if(!$conn){
    die("Connection Failed : ".mysqli_connect_error());
}

$id = $_POST['id'];
$category_name = mysqli_real_escape_string($conn,$_POST['category_name']);
$description = mysqli_real_escape_string($conn,$_POST['description']);

$sql = "UPDATE categories SET
category_name='$category_name',
description='$description'
WHERE id='$id'";

if(mysqli_query($conn,$sql))
{
    header("Location: categories.php?updated=1");
    exit();
}
else
{
    echo "Error : ".mysqli_error($conn);
}

mysqli_close($conn);

?>