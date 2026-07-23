<?php

error_reporting(E_ALL);
ini_set('display_errors',1);


if(session_status() == PHP_SESSION_NONE)
{
    session_start();
}


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



include "includes/mail_config.php";



if(isset($_POST['send_otp'])){


$email=mysqli_real_escape_string(
$conn,
$_POST['email']
);



$result=mysqli_query(
$conn,
"
SELECT *
FROM users
WHERE email='$email'
"
);



if(mysqli_num_rows($result)>0){



$otp=rand(100000,999999);



mysqli_query($conn,"
UPDATE users
SET
otp='$otp',
otp_expire = DATE_ADD(NOW(), INTERVAL 10 MINUTE)
WHERE email='$email'
");



if(sendOTP($email,$otp)){



$_SESSION['username_email']=$email;



echo "

<script>

alert('OTP has been sent to your email');

window.location='verify_username_otp.php';

</script>

";



}
else{


$error="Failed to send OTP. Try again.";

}



}
else{


$error="Email not registered";


}



}

?>



<!DOCTYPE html>

<html lang="en">

<head>


<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">


<title>Forgot Username | InventoryPro</title>



<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">



<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">



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

Forgot Username

</h2>



<p class="text-muted mb-4">

Recover your InventoryPro username

</p>





<?php if(isset($error)){ ?>


<div class="alert alert-danger alert-dismissible fade show">


<i class="bi bi-exclamation-triangle-fill me-2"></i>


<?php echo $error; ?>


<button class="btn-close" data-bs-dismiss="alert"></button>


</div>



<?php } ?>






<form method="POST">





<div class="mb-3">


<label>

Registered Email

</label>



<div class="input-group">



<span class="input-group-text">

<i class="bi bi-envelope-fill"></i>

</span>




<input

type="email"

name="email"

class="form-control"

placeholder="Enter registered email"

required>



</div>



</div>







<button

type="submit"

name="send_otp"

class="btn btn-primary w-100">


<i class="bi bi-send-fill me-2"></i>

Send OTP


</button>






<div class="text-center mt-3">


<a href="login.php">

← Back to Login

</a>


</div>




</form>



</div>



</div>



</div>



</div>



</body>


</html>