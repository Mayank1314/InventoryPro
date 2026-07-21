<?php

$host = "localhost";
$user = "root";
$password = "";
$database = "inventory_management";

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Connection Failed : " . mysqli_connect_error());
}

if(isset($_POST['customer_id']))
{

    $customer_id   = intval($_POST['customer_id']);
    $product_id    = intval($_POST['product_id']);
    $quantity      = intval($_POST['quantity']);
    $selling_price = floatval($_POST['selling_price']);
    $total_price   = floatval($_POST['total_price']);
    $sale_date     = $_POST['sale_date'];

    /* Check Current Stock */

    $stockQuery = mysqli_query($conn,"
        SELECT quantity
        FROM products
        WHERE id='$product_id'
    ");

    $stockData = mysqli_fetch_assoc($stockQuery);

    $availableStock = $stockData['quantity'];

    /* Stock Validation */

    if($quantity > $availableStock)
    {
        echo "<script>
        alert('Insufficient Stock Available!');
        window.location='add_sale.php';
        </script>";
        exit();
    }

    /* Save Sale */

    $insert = mysqli_query($conn,"
        INSERT INTO sales
        (
            customer_id,
            product_id,
            quantity,
            selling_price,
            total_price,
            sale_date
        )
        VALUES
        (
            '$customer_id',
            '$product_id',
            '$quantity',
            '$selling_price',
            '$total_price',
            '$sale_date'
        )
    ");

    if($insert)
    {

        /* Reduce Product Stock */

        mysqli_query($conn,"
            UPDATE products
            SET quantity = quantity - $quantity
            WHERE id='$product_id'
        ");

        header("Location:sales.php?success=1");
        exit();

    }
    else
    {
        echo mysqli_error($conn);
    }

}

mysqli_close($conn);

?>