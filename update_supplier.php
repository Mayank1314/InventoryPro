<?php

$host = "localhost";
$user = "root";
$password = "";
$database = "inventory_management";

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}

if(isset($_POST['id']))
{

    $id = mysqli_real_escape_string($conn,$_POST['id']);
    $supplier_name = mysqli_real_escape_string($conn,$_POST['supplier_name']);
    $contact_person = mysqli_real_escape_string($conn,$_POST['contact_person']);
    $phone = mysqli_real_escape_string($conn,$_POST['phone']);
    $email = mysqli_real_escape_string($conn,$_POST['email']);
    $address = mysqli_real_escape_string($conn,$_POST['address']);

    $sql = "UPDATE suppliers SET

            supplier_name='$supplier_name',
            contact_person='$contact_person',
            phone='$phone',
            email='$email',
            address='$address'

            WHERE id='$id'";

    if(mysqli_query($conn,$sql))
    {
        header("Location: suppliers.php?updated=1");
        exit();
    }
    else
    {
        echo "Error : ".mysqli_error($conn);
    }

}
else
{
    header("Location: suppliers.php");
    exit();
}

mysqli_close($conn);

?>