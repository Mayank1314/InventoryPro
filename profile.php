<?php

session_start();


if(!isset($_SESSION['username']))
{
    header("Location: login.php");
    exit();
}



$conn=mysqli_connect(
"localhost",
"root",
"",
"inventory_management"
);



if(!$conn)
{
    die("Database Connection Failed");
}




$user_id=$_SESSION['user_id'];



$result=mysqli_query(
$conn,
"
SELECT *
FROM users
WHERE id='$user_id'
"
);



$user=mysqli_fetch_assoc($result);



?>


<!DOCTYPE html>

<html lang="en">

<head>

    
</style>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">


<title>My Profile</title>



<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">



<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">



<link rel="stylesheet" href="assets/css/admin.css">



</head>



<body>



<?php include("includes/sidebar.php"); ?>




<div id="main-content">





<!-- HEADER -->

<div class="d-flex justify-content-between align-items-center mb-4">


<h2 class="page-title">


<i class="bi bi-person-circle"></i>


My Profile


</h2>


</div>







<!-- SUCCESS ALERT -->


<?php if(isset($_GET['updated'])){ ?>


<div class="alert alert-success alert-dismissible fade show">


<i class="bi bi-check-circle-fill"></i>


Profile Updated Successfully.


<button class="btn-close" data-bs-dismiss="alert"></button>


</div>


<?php } ?>









<div class="row">

<div class="col-lg-10 mx-auto">





<div class="card shadow-lg border-0 profile-card">





<!-- PROFILE HEADER -->


<div class="profile-header text-center">



<div class="profile-icon">
    <i class="bi bi-person-circle"></i>
</div>




<h2 class="mt-3">


<?php echo htmlspecialchars($user['username']); ?>


</h2>





<span class="profile-role">

<?php echo htmlspecialchars($user['role']); ?>

</span>



</div>








<!-- PROFILE DETAILS -->


<div class="profile-body">





<div class="profile-item">


<i class="bi bi-person-fill"></i>


<div>


<h6>

Username

</h6>


<p>

<?php echo htmlspecialchars($user['username']); ?>

</p>


</div>


</div>









<div class="profile-item">


<i class="bi bi-envelope-fill"></i>


<div>


<h6>

Email

</h6>


<p>

<?php echo htmlspecialchars($user['email']); ?>

</p>


</div>


</div>









<div class="profile-item">


<i class="bi bi-shield-lock-fill"></i>


<div>


<h6>

Role

</h6>


<p>

<?php echo htmlspecialchars($user['role']); ?>

</p>


</div>


</div>









<div class="profile-item">


<i class="bi bi-calendar-check-fill"></i>


<div>


<h6>

Account Created

</h6>


<p>

<?php echo date("d M Y",strtotime($user['created_at'])); ?>

</p>


</div>


</div>







</div>









<!-- BUTTONS -->


<div class="profile-actions">


<a href="edit_profile.php" 
class="btn btn-primary px-4 me-2">


<i class="bi bi-pencil-square"></i>


Edit Profile


</a>






<a href="change_password.php"
class="btn btn-warning px-4">


<i class="bi bi-key-fill"></i>


Change Password


</a>




</div>







</div>



</div>


</div>







</div>







<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script src="assets/js/darkmode.js"></script>

</body>


</html>



<?php

mysqli_close($conn);

?>