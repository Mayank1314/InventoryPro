<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../vendor/autoload.php';


function sendOTP($receiverEmail, $otp)
{

    $mail = new PHPMailer(true);

    try {

        // SMTP Configuration
        $mail->isSMTP();

        $mail->Host = "smtp.gmail.com";

        $mail->SMTPAuth = true;


        // YOUR INVENTORYPRO GMAIL
        $mail->Username = "project.workss1314@gmail.com";


        // YOUR NEW GMAIL APP PASSWORD
        $mail->Password = "ceda zqfj yiss rqxp";


        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

        $mail->Port = 587;


        // Sender
        $mail->setFrom(
            "project.workss1314@gmail.com",
            "InventoryPro"
        );


        // User email
        $mail->addAddress($receiverEmail);


        // Email format
        $mail->isHTML(true);


        $mail->Subject = "InventoryPro Password Reset OTP";


        $mail->Body = "

        <div style='font-family:Arial;'>

            <h2>InventoryPro</h2>

            <p>Your password reset OTP is:</p>

            <h1 style='letter-spacing:5px;'>$otp</h1>

            <p>This OTP is valid for 5 minutes.</p>

            <br>

            <p>If you did not request this, ignore this email.</p>

        </div>

        ";


        $mail->send();

        return true;


    } 
    catch(Exception $e)
    {

        return false;

    }

}

?>