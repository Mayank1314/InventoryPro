<?php

session_start();

date_default_timezone_set('Asia/Kolkata');

$conn=mysqli_connect(
    "localhost",
    "root",
    "",
    "inventory_management"
);


if(!$conn){

    die("Database Connection Failed");

}



if(!isset($_SESSION['reset_user']) || !isset($_SESSION['otp_verified'])){

    header("Location: forgot_password.php");
    exit();

}



if(isset($_POST['reset'])){


    $username=$_SESSION['reset_user'];


    $password=$_POST['password'];

    $confirm_password=$_POST['confirm_password'];



    if($password != $confirm_password){


        $error="Passwords do not match";


    }
    else{


        $password=password_hash(
            $password,
            PASSWORD_DEFAULT
        );



        mysqli_query(
            $conn,
            "
            UPDATE users
            SET 
            password='$password',
            otp=NULL,
            otp_expire=NULL
            WHERE username='$username'
            "
        );



        session_destroy();



        header(
            "Location: login.php?reset=success"
        );

        exit();


    }


}

?>


<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">


<title>Reset Password</title>


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">


<link rel="stylesheet" href="assets/css/login.css">


</head>



<body>


<div class="background">

<div class="circle circle1"></div>

<div class="circle circle2"></div>

</div>



<div class="container">


<div class="row vh-100 justify-content-center align-items-center">


<div class="col-md-5">


<div class="login-card">


<h2 class="mb-2">
Reset Password
</h2>


<p class="text-muted mb-4">
Create your new password
</p>

<?php if(isset($error)){ ?>

<div class="alert alert-danger">

<?php echo $error; ?>

</div>

<?php } ?>

<form method="POST">



<div class="mb-3">


<label>
New Password
</label>


<input
type="password"
name="password"
class="form-control"
required>


</div>



<div class="mb-4">


<label>
Confirm Password
</label>


<input
type="password"
name="confirm_password"
class="form-control"
required>


</div>



<button
name="reset"
class="btn btn-primary w-100">

Update Password

</button>



</form>


</div>


</div>


</div>


</div>



</body>

</html>