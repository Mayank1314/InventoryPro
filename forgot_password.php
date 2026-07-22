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


// PHPMailer file
include "includes/mail_config.php";



if(isset($_POST['send_otp'])){


$username=mysqli_real_escape_string(
$conn,
$_POST['username']
);


$email=mysqli_real_escape_string(
$conn,
$_POST['email']
);



$result=mysqli_query(
$conn,
"
SELECT *
FROM users
WHERE username='$username'
AND email='$email'
"
);



if(mysqli_num_rows($result)>0){



    $otp = rand(100000,999999);

mysqli_query($conn,"
UPDATE users
SET
    otp='$otp',
    otp_expire = DATE_ADD(NOW(), INTERVAL 10 MINUTE)
WHERE username='$username'
");



    // Send OTP Email
    if(sendOTP($email,$otp)){


        $_SESSION['reset_user']=$username;



        echo "
        <script>

        alert('OTP has been sent to your email');

        window.location='verify_otp.php';

        </script>
        ";



    }
    else{


        $error="Failed to send OTP. Try again.";

    }



}
else{


    $error="Invalid Username or Email";


}


}

?>



<!DOCTYPE html>

<html lang="en">

<head>


<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">


<title>Forgot Password</title>


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">


<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">


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

Forgot Password

</h2>



<p class="text-muted mb-4">

Reset your account password

</p>



<?php if(isset($error)){ ?>


<div class="alert alert-danger">

<?php echo $error; ?>

</div>


<?php } ?>



<form method="POST">



<div class="mb-3">


<label>Username</label>


<input
type="text"
name="username"
class="form-control"
required>


</div>




<div class="mb-3">


<label>Email</label>


<input
type="email"
name="email"
class="form-control"
required>


</div>




<button
type="submit"
name="send_otp"
class="btn btn-primary w-100">


Send OTP


</button>



<div class="text-center mt-3">


<a href="login.php">

Back to Login

</a>


</div>



</form>



</div>


</div>


</div>


</div>



</body>

</html>