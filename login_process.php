<?php

session_start();

$conn = mysqli_connect(
    "localhost",
    "root",
    "",
    "inventory_management"
);

if(!$conn)
{
    die("Database Connection Failed");
}

$username = $_POST['username'];
$password = $_POST['password'];

$query = mysqli_query($conn,"
SELECT *
FROM users
WHERE username='$username'
");

$user = mysqli_fetch_assoc($query);

if($user && password_verify($password, $user['password']))
{
    $_SESSION['username'] = $user['username'];
    $_SESSION['role'] = $user['role'];

    if($user['role'] == "Admin")
    {
        header("Location: dashboard.php");
    }
    else
    {
        header("Location: products.php");
    }

    exit();
}

header("Location: login.php?error=invalid");
exit();

?>