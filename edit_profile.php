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


if(!$conn){
    die("Database Connection Failed");
}



$user_id=$_SESSION['user_id'];



if(isset($_POST['update']))
{

$new_username=mysqli_real_escape_string(
$conn,
$_POST['username']
);


$email=mysqli_real_escape_string(
$conn,
$_POST['email']
);



mysqli_query(
$conn,
"
UPDATE users

SET 
username='$new_username',
email='$email'

WHERE id='$user_id'

"
);



$_SESSION['username']=$new_username;


header("Location: profile.php?updated=1");

exit();

}




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

<html>

<head>


<title>Edit Profile</title>


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">


<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">


<link rel="stylesheet" href="assets/css/admin.css">


</head>


<body>


<?php include("includes/sidebar.php"); ?>



<div id="main-content">



<div class="d-flex justify-content-between align-items-center mb-4">


<h2 class="page-title">

<i class="bi bi-pencil-square"></i>

Edit Profile

</h2>


</div>





<?php if(isset($_GET['updated'])){ ?>


<div class="alert alert-success">

<i class="bi bi-check-circle"></i>

Profile Updated Successfully.

</div>


<?php } ?>






<div class="card shadow-sm border-0 p-4">



<form method="POST">



<div class="mb-3">


<label class="fw-bold">

Username

</label>


<input 
type="text"
name="username"
class="form-control"
value="<?php echo htmlspecialchars($user['username']); ?>"
required>


</div>





<div class="mb-3">


<label class="fw-bold">

Email

</label>


<input 
type="email"
name="email"
class="form-control"
value="<?php echo htmlspecialchars($user['email']); ?>">


</div>






<button 
class="btn btn-primary"
name="update">


<i class="bi bi-save"></i>

Save Changes


</button>



<a href="profile.php"
class="btn btn-secondary">


Cancel


</a>



</form>


</div>



</div>



</body>


</html>