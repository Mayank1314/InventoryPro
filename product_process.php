<?php

// Database Connection
$host = "localhost";
$user = "root";
$password = "";
$database = "inventory_management";

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}

// Check Form Submission
if (isset($_POST['product_name'])) {

    $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $supplier = mysqli_real_escape_string($conn, $_POST['supplier']);
    $sku = mysqli_real_escape_string($conn, $_POST['sku']);
    $cost_price = mysqli_real_escape_string($conn, $_POST['cost_price']);
    $selling_price = mysqli_real_escape_string($conn, $_POST['selling_price']);
    $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);
    $unit = mysqli_real_escape_string($conn, $_POST['unit']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    $sql = "INSERT INTO products
    (
        product_name,
        category,
        supplier,
        sku,
        cost_price,
        selling_price,
        quantity,
        unit,
        description
    )
    VALUES
    (
        '$product_name',
        '$category',
        '$supplier',
        '$sku',
        '$cost_price',
        '$selling_price',
        '$quantity',
        '$unit',
        '$description'
    )";

    if (mysqli_query($conn, $sql)) {

        header("Location: products.php?success=1");
        exit();

    } else {

        echo "Error : " . mysqli_error($conn);

    }

} else {

    header("Location: add_product.php");

}

mysqli_close($conn);

?>