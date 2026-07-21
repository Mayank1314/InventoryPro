<?php

$host = "localhost";
$user = "root";
$password = "";
$database = "inventory_management";

$conn = mysqli_connect($host,$user,$password,$database);

if(!$conn){
    die("Connection Failed : ".mysqli_connect_error());
}

if(isset($_GET['id']))
{
    $id = $_GET['id'];

    $sql = "DELETE FROM categories WHERE id='$id'";

    if(mysqli_query($conn,$sql))
    {
        header("Location: categories.php?deleted=1");
        exit();
    }
    else
    {
        echo "Error : ".mysqli_error($conn);
    }
}
else
{
    header("Location: categories.php");
}

mysqli_close($conn);

?>