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


// Check user came from forgot password
if(!isset($_SESSION['reset_user'])){

    header("Location: forgot_password.php");
    exit();

}



if(isset($_POST['verify'])){


    $username=$_SESSION['reset_user'];


    $otp=mysqli_real_escape_string(
        $conn,
        $_POST['otp']
    );



    $check=mysqli_query(
        $conn,
        "
        SELECT *
        FROM users
        WHERE username='$username'
        AND otp='$otp'
        AND otp_expire > NOW()
        "
    );



    if(mysqli_num_rows($check)>0){


        // Mark OTP verified

        $_SESSION['otp_verified']=true;


        // Remove OTP after verification

        mysqli_query(
            $conn,
            "
            UPDATE users
            SET otp=NULL,
            otp_expire=NULL
            WHERE username='$username'
            "
        );


        header(
            "Location: reset_password.php"
        );

        exit();



    }
    else{


        $error="Invalid or Expired OTP";


    }


}

?>



<!DOCTYPE html>
<html lang="en">

<head>


<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">


<title>Verify OTP</title>



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

Verify OTP

</h2>




<p class="text-muted mb-4">

Enter the OTP sent to your email

</p>




<?php if(isset($error)){ ?>


<div class="alert alert-danger">

<?php echo $error; ?>

</div>


<?php } ?>

<?php

if(isset($_SESSION['otp_message'])){

?>

<div class="alert alert-success alert-dismissible fade show">

<?php

echo $_SESSION['otp_message'];

unset($_SESSION['otp_message']);

?>

<button
class="btn-close"
data-bs-dismiss="alert">
</button>

</div>

<?php } ?>


<?php

if(isset($_SESSION['otp_error'])){

?>

<div class="alert alert-danger alert-dismissible fade show">

<?php

echo $_SESSION['otp_error'];

unset($_SESSION['otp_error']);

?>

<button
class="btn-close"
data-bs-dismiss="alert">
</button>

</div>

<?php } ?>


<form method="POST">



<div class="mb-4">


<label>
OTP
</label>



<input
type="text"
name="otp"
class="form-control"
placeholder="Enter 6 digit OTP"
maxlength="6"
required>



</div>





<button
name="verify"
class="btn btn-primary w-100">


Verify OTP


</button>





<div class="text-center mt-3">


<a href="resend_otp.php.">

Resend OTP

</a>



</div>



</form>




</div>



</div>



</div>



</div>



</body>

</html>