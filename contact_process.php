<?php

$conn = mysqli_connect(
    "localhost",
    "root",
    "",
    "inventory_management"
);

if (!$conn) {
    die("Database Connection Failed");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    $sql = "INSERT INTO contact_messages
            (name, email, subject, message)
            VALUES
            ('$name', '$email', '$subject', '$message')";

    if (mysqli_query($conn, $sql)) {

        header("Location: index.php?success=1");

    } else {

        header("Location: index.php?error=1");

    }

    exit();
}
?>