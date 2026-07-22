<?php

session_start();

date_default_timezone_set("Asia/Kolkata");

$conn = mysqli_connect(
    "localhost",
    "root",
    "",
    "inventory_management"
);

if(!$conn){
    die("Database Connection Failed");
}

include "includes/mail_config.php";

if(!isset($_SESSION['reset_user'])){

    header("Location: forgot_password.php");
    exit();

}

$username = $_SESSION['reset_user'];

$result = mysqli_query(
    $conn,
    "SELECT email FROM users WHERE username='$username'"
);

if(mysqli_num_rows($result)==1){

    $user = mysqli_fetch_assoc($result);

    $email = $user['email'];

    $otp = rand(100000,999999);

    mysqli_query(
        $conn,
        "
        UPDATE users
        SET
        otp='$otp',
        otp_expire=DATE_ADD(NOW(),INTERVAL 10 MINUTE)
        WHERE username='$username'
        "
    );

    if(sendOTP($email,$otp)){

        $_SESSION['otp_message']="A new OTP has been sent to your email.";

    }else{

        $_SESSION['otp_error']="Failed to send OTP.";

    }

}

header("Location: verify_otp.php");
exit();

?>