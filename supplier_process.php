<?php

$host = "localhost";
$user = "root";
$password = "";
$database = "inventory_management";

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}

if (isset($_POST['supplier_name'])) {

    $supplier_name = mysqli_real_escape_string($conn, $_POST['supplier_name']);
    $contact_person = mysqli_real_escape_string($conn, $_POST['contact_person']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);

    // Check if supplier already exists
    $check = "SELECT * FROM suppliers WHERE supplier_name='$supplier_name'";
    $result = mysqli_query($conn, $check);

    if (mysqli_num_rows($result) > 0) {
        header("Location: add_supplier.php?exists=1");
        exit();
    }

    $sql = "INSERT INTO suppliers
            (supplier_name, contact_person, phone, email, address)
            VALUES
            ('$supplier_name', '$contact_person', '$phone', '$email', '$address')";

    if (mysqli_query($conn, $sql)) {
        header("Location: suppliers.php?success=1");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }

} else {

    header("Location: add_supplier.php");
    exit();

}

mysqli_close($conn);

?>