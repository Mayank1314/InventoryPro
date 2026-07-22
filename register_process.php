<?php

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

$email = $_POST['email'];
$username = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$role = $_POST['role'];

$sql = "
INSERT INTO users
(username, email, password, role)

VALUES
(
'$username',
'$email',
'$password',
'$role'
)
";

if(mysqli_query($conn, $sql))
{
    header("Location: login.php?registered=1");
    exit();
}
else
{
    echo "Registration Failed: " . mysqli_error($conn);
}

mysqli_close($conn);

?>