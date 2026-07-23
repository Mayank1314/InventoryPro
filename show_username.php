<?php

if(session_status() == PHP_SESSION_NONE)
{
    session_start();
}


if(!isset($_SESSION['found_username']))
{

    header("Location: login.php");
    exit();

}


$username=$_SESSION['found_username'];

?>


<!DOCTYPE html>

<html lang="en">

<head>


<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">


<title>Username Found | InventoryPro</title>



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



<div class="login-card text-center">





<div class="logo-icon mb-3">


<img 
src="assets/images/logo.png"
alt="InventoryPro Logo"
style="width:70px;">


</div>





<h2 class="mb-2">

Username Found 🎉

</h2>




<p class="text-muted mb-4">

Your InventoryPro username has been recovered

</p>







<div class="alert alert-success">


<i class="bi bi-person-check-fill me-2"></i>


Your Username is:



<h3 class="mt-3 fw-bold">

<?php echo htmlspecialchars($username); ?>

</h3>


</div>








<a href="login.php" class="btn btn-primary w-100 mt-3">


<i class="bi bi-box-arrow-in-right me-2"></i>

Back to Login


</a>






</div>



</div>



</div>



</div>




</body>


</html>