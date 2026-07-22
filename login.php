<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>InventoryPro | Login</title>


<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">


<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">


<!-- Google Font -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">


<!-- Custom CSS -->
<link rel="stylesheet" href="assets/css/login.css">


</head>



<body>


<div class="background">

    <div class="circle circle1"></div>
    <div class="circle circle2"></div>

</div>




<div class="container-fluid">


<div class="row vh-100">



<!-- ================= LEFT SIDE ================= -->


<div class="col-lg-6 left-panel">


<div class="content">



<!-- LOGO -->


<div class="logo-box">


<div class="logo-icon">

<img src="assets/images/logo.png" alt="InventoryPro Logo">

</div>



<div>


<h3>
InventoryPro
</h3>


<span>
Inventory & Stock Management
</span>


</div>


</div>





<!-- TITLE -->


<h1>

Inventory & Stock
<br>
Management System

</h1>





<p>

Manage inventory, suppliers, sales, purchases and reports
from one powerful dashboard.

</p>






<!-- FEATURES -->


<div class="features">


<div>

<i class="bi bi-check-circle-fill"></i>

Product Management

</div>



<div>

<i class="bi bi-check-circle-fill"></i>

Stock Tracking

</div>




<div>

<i class="bi bi-check-circle-fill"></i>

Supplier Management

</div>




<div>

<i class="bi bi-check-circle-fill"></i>

Reports & Analytics

</div>



</div>




</div>


</div>









<!-- ================= RIGHT SIDE ================= -->



<div class="col-lg-6 right-panel">



<div class="login-card">
<?php if(isset($_GET['logout'])){ ?>

<div class="alert alert-success alert-dismissible fade show mb-3" role="alert">

    <i class="bi bi-check-circle-fill me-2"></i>

    You have been logged out successfully.

    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>

</div>

<?php } ?>
<?php

if(isset($_GET['registered']))
{

?>

<div class="alert alert-success alert-dismissible fade show mb-3" role="alert">

    <i class="bi bi-check-circle-fill me-2"></i>

    Account created successfully! Please login.

    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>

</div>

<?php

}

?>


<?php

if(isset($_GET['error']))
{

?>

<div class="alert alert-danger alert-dismissible fade show">

<i class="bi bi-exclamation-triangle-fill"></i>

Something went wrong. Please try again.

<button type="button" class="btn-close" data-bs-dismiss="alert"></button>

</div>

<?php

}

?>




<h2>

Welcome Back 👋

</h2>



<p>

Login to continue

</p>







<form action="login_process.php" method="POST">





<!-- Username -->


<div class="mb-3">


<label>

Username

</label>



<div class="input-group">



<span class="input-group-text">

<i class="bi bi-person-fill"></i>

</span>



<input

type="text"

name="username"

class="form-control"

placeholder="Enter Username"

required>


</div>


</div>







<!-- Password -->


<div class="mb-3">


<label>

Password

</label>



<div class="input-group">



<span class="input-group-text">

<i class="bi bi-lock-fill"></i>

</span>





<input

id="password"

name="password"

type="password"

class="form-control"

placeholder="Enter Password"

required>






<span class="input-group-text toggle-password">


<i class="bi bi-eye-fill"></i>


</span>



</div>


</div>







<!-- Remember -->


<div class="d-flex justify-content-between align-items-center mb-4">



<div class="form-check">


<input

class="form-check-input"

type="checkbox"

id="remember">



<label class="form-check-label" for="remember">

Remember Me

</label>


</div>





<a href="#">

Forgot Password?

</a>




</div>







<button class="btn btn-primary w-100">


Login


</button>





</form>










<div class="bottom-links">


<div class="text-center mb-3">

<span class="text-muted">

New to InventoryPro?

</span>


<a href="register.php" class="fw-semibold">

Create an Account

</a>


</div>




<div class="d-flex justify-content-between">


<a href="forgot_username.php">

Forgot Username?

</a>



<a href="index.php">

← Back to Home

</a>


</div>


</div>




</div>




</div>






</div>


</div>






<script src="assets/js/login.js"></script>


</body>


</html>