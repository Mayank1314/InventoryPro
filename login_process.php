<?php

session_start();

$conn = mysqli_connect("localhost", "root", "", "inventory_management");

if (!$conn) {
    die("Database Connection Failed");
}

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: login.php");
    exit();
}

$username = trim($_POST['username']);
$password = trim($_POST['password']);

$stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE username = ?");
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) == 1) {

    $user = mysqli_fetch_assoc($result);

    if (password_verify($password, $user['password'])) {

        session_regenerate_id(true);

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        if ($user['role'] == "Admin") {

            header("Location: dashboard.php");

        } else {

            header("Location: user_dashboard.php");

        }

        exit();

    }
}

header("Location: login.php?error=invalid");
exit();

?>