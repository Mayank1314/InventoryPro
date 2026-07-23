<?php

$conn = mysqli_connect(
    "localhost",
    "root",
    "",
    "inventory_management"
);

if(!$conn){
    die("Database Connection Failed");
}

/* ---------------- Contact Form ---------------- */

$success = "";

if(isset($_POST['send_message'])){

    $name = mysqli_real_escape_string($conn,$_POST['name']);
    $email = mysqli_real_escape_string($conn,$_POST['email']);
    $subject = mysqli_real_escape_string($conn,$_POST['subject']);
    $message = mysqli_real_escape_string($conn,$_POST['message']);

    $sql = "INSERT INTO contact_messages
    (name,email,subject,message)
    VALUES
    ('$name','$email','$subject','$message')";

    if(mysqli_query($conn,$sql)){
        $success = "Message Sent Successfully!";
    }

}

/* ---------------- Dashboard Data ---------------- */

$product_count = mysqli_fetch_assoc(
mysqli_query($conn,"SELECT COUNT(*) AS total FROM products")
)['total'];

$supplier_count = mysqli_fetch_assoc(
mysqli_query($conn,"SELECT COUNT(*) AS total FROM suppliers")
)['total'];

$sales_today = mysqli_fetch_assoc(
mysqli_query(
$conn,
"SELECT COUNT(*) AS total
FROM sales
WHERE DATE(created_at)=CURDATE()")
)['total'];

$latest_products = mysqli_query($conn,"
SELECT
product_name,
category,
quantity,
unit,
selling_price
FROM products
ORDER BY created_at DESC
LIMIT 6
");

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta
name="viewport"
content="width=device-width, initial-scale=1.0">

<title>InventoryPro</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

<link
rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<link
rel="stylesheet"
href="assets/css/style.css">

</head>

<body>

<!-- NAVBAR -->

<nav class="navbar navbar-expand-lg fixed-top">

<div class="container">

<a class="navbar-brand" href="#">
📦 InventoryPro
</a>

<button
class="navbar-toggler bg-white"
type="button"
data-bs-toggle="collapse"
data-bs-target="#navbarNav">

<span class="navbar-toggler-icon"></span>

</button>

<div class="collapse navbar-collapse" id="navbarNav">

<ul class="navbar-nav ms-auto">

<li class="nav-item">
<a class="nav-link" href="#">Home</a>
</li>

<li class="nav-item">
<a class="nav-link" href="#features">Features</a>
</li>

<li class="nav-item">
<a class="nav-link" href="#about">About</a>
</li>

<li class="nav-item">
<a class="nav-link" href="#contact">Contact</a>
</li>

<li class="nav-item me-3">

<button
id="themeToggle"
class="btn btn-outline-light">

<i class="bi bi-moon-stars-fill"></i>

</button>

</li>

<li class="nav-item ms-3">

<a
href="login.php"
class="btn btn-light login-btn">

Login

</a>

</li>

</ul>

</div>

</div>

</nav>

<!-- HERO -->

<section class="hero">

<div class="container">

<div class="row align-items-center">

<div class="col-lg-6">

<span class="badge bg-warning text-dark mb-3">

Smart Inventory Solution

</span>

<h1>

Inventory & Stock
Management System

</h1>

<p>

Easily manage products,
suppliers, purchases,
sales and stock from one
powerful dashboard.

</p>

<a
href="login.php"
class="btn btn-success btn-lg me-3">

Get Started

</a>

<a
href="#features"
class="btn btn-outline-light btn-lg">

Learn More

</a>

</div>

<div class="col-lg-6 text-center">

<img
src="assets/images/hero.png"
class="img-fluid hero-image">

</div>

<div class="floating-card card1">

<h3
class="counter"
data-target="<?= $product_count ?>">

0

</h3>

<p>Products</p>

</div>

<div class="floating-card card2">

<h3
class="counter"
data-target="<?= $supplier_count ?>">

0

</h3>

<p>Suppliers</p>

</div>

<div class="floating-card card3">

<h3
class="counter"
data-target="<?= $sales_today ?>">

0

</h3>

<p>Sales Today</p>

</div>

</div>

</div>

</section>

<!-- FEATURES -->

<section class="features" id="features">

    <div class="container">

        <h2 class="text-center mb-5">
            System Features
        </h2>

        <div class="row g-4">

            <div class="col-md-3">
                <div class="feature-box">
                    <i class="bi bi-box-seam"></i>
                    <h4>Products</h4>
                    <p>Manage inventory with real-time stock updates.</p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="feature-box">
                    <i class="bi bi-tags"></i>
                    <h4>Categories</h4>
                    <p>Organize products into categories for faster management.</p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="feature-box">
                    <i class="bi bi-truck"></i>
                    <h4>Suppliers</h4>
                    <p>Store supplier details and manage procurement easily.</p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="feature-box">
                    <i class="bi bi-people"></i>
                    <h4>Customers</h4>
                    <p>Maintain customer records and purchase history.</p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="feature-box">
                    <i class="bi bi-cart-plus"></i>
                    <h4>Purchases</h4>
                    <p>Track purchases and automatically update inventory.</p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="feature-box">
                    <i class="bi bi-cash-stack"></i>
                    <h4>Sales</h4>
                    <p>Generate invoices and monitor daily sales instantly.</p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="feature-box">
                    <i class="bi bi-bar-chart-line"></i>
                    <h4>Reports</h4>
                    <p>Analyze purchases, sales and inventory trends.</p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="feature-box">
                    <i class="bi bi-shield-lock"></i>
                    <h4>Secure Login</h4>
                    <p>Protected authentication with role-based access control.</p>
                </div>
            </div>

        </div>

    </div>

</section>

<!-- ABOUT -->

<section id="about" class="py-5">

    <div class="container">

        <div class="row align-items-center">

            <div class="col-lg-6">

                <h2 class="mb-4">
                    About InventoryPro
                </h2>

                <p class="lead">
                    InventoryPro is a modern Inventory & Stock Management System designed to help businesses manage products, suppliers, customers, purchases and sales efficiently.
                </p>

                <p>
                    It provides real-time inventory tracking, secure login, powerful reports and an easy-to-use dashboard.
                </p>

            </div>

            <div class="col-lg-6">

                <div class="row text-center">

                    <div class="col-6 mb-4">
                        <h2><?= $product_count ?></h2>
                        <p>Products</p>
                    </div>

                    <div class="col-6 mb-4">
                        <h2><?= $supplier_count ?></h2>
                        <p>Suppliers</p>
                    </div>

                    <div class="col-6">
                        <h2><?= $sales_today ?></h2>
                        <p>Sales Today</p>
                    </div>

                    <div class="col-6">
                        <h2>24/7</h2>
                        <p>System Ready</p>
                    </div>

                </div>

            </div>

        </div>

    </div>

</section>

<!-- LATEST PRODUCTS -->

<section class="latest-products py-5">

    <div class="container">

        <h2 class="text-center mb-5">
            Latest Products
        </h2>

        <div class="row">

            <?php while($product = mysqli_fetch_assoc($latest_products)){ ?>

                <div class="col-md-4 mb-4">

                    <div class="feature-box h-100">

                        <i class="bi bi-box-seam"></i>

                        <h4>
                            <?= htmlspecialchars($product['product_name']) ?>
                        </h4>

                        <p class="mb-2">
                            <strong>Category:</strong>
                            <?= htmlspecialchars($product['category']) ?>
                        </p>

                        <p class="mb-2">
                            <strong>Stock:</strong>
                            <?= $product['quantity'] ?>
                            <?= htmlspecialchars($product['unit']) ?>
                        </p>

                        <h5 class="text-success">

                            ₹<?= number_format($product['selling_price'],2) ?>

                        </h5>

                    </div>

                </div>

            <?php } ?>

        </div>

    </div>

</section>

<!-- CONTACT -->

<!-- Contact Section -->

<section id="contact" class="py-5">

    <div class="container">

        <div class="text-center mb-5">

            <h2>Contact Us</h2>

            <p class="text-muted">
                Have any questions? We'd love to hear from you.
            </p>

        </div>

        <div class="row">

            <!-- Contact Info -->

            <div class="col-lg-5 mb-4">

                <div class="feature-box h-100">

                    <h4 class="mb-4">Get in Touch</h4>

                    <p>
                        <i class="bi bi-geo-alt-fill text-primary me-2"></i>
                        Indore, Madhya Pradesh, India
                    </p>

                    <p>
                        <i class="bi bi-envelope-fill text-primary me-2"></i>
                        inventorypro@gmail.com
                    </p>

                    <p>
                        <i class="bi bi-telephone-fill text-primary me-2"></i>
                        +91 98765 43210
                    </p>

                    <p>
                        <i class="bi bi-clock-fill text-primary me-2"></i>
                        Monday - Saturday
                        <br>
                        9:00 AM - 6:00 PM
                    </p>

                </div>

            </div>

            <!-- Contact Form -->

            <div class="col-lg-7">

                <div class="feature-box">

                    <?php if(isset($_GET['success'])){ ?>

                        <div class="alert alert-success">

                            Message sent successfully!

                        </div>

                    <?php } ?>

                    <?php if(isset($_GET['error'])){ ?>

                        <div class="alert alert-danger">

                            Failed to send message!

                        </div>

                    <?php } ?>

                    <form action="contact_process.php" method="POST">

                        <div class="mb-3">

                            <input
                                type="text"
                                name="name"
                                class="form-control"
                                placeholder="Your Name"
                                required>

                        </div>

                        <div class="mb-3">

                            <input
                                type="email"
                                name="email"
                                class="form-control"
                                placeholder="Your Email"
                                required>

                        </div>

                        <div class="mb-3">

                            <input
                                type="text"
                                name="subject"
                                class="form-control"
                                placeholder="Subject"
                                required>

                        </div>

                        <div class="mb-3">

                            <textarea
                                name="message"
                                class="form-control"
                                rows="5"
                                placeholder="Write your message..."
                                required></textarea>

                        </div>

                        <button
                            type="submit"
                            class="btn btn-primary w-100">

                            <i class="bi bi-send-fill"></i>
                            Send Message

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</section>

<!-- FOOTER -->

<footer>

    <div class="container">

        <p class="mb-0">

            © 2026 InventoryPro | Inventory & Stock Management System

        </p>

    </div>

</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>

document.addEventListener("DOMContentLoaded", function(){

    /* Counter Animation */

    const counters = document.querySelectorAll(".counter");

    counters.forEach(counter=>{

        const target = parseInt(counter.dataset.target);

        let current = 0;

        const increment = Math.max(1,Math.ceil(target/50));

        function update(){

            current += increment;

            if(current>=target){

                counter.innerText = target;

            }else{

                counter.innerText = current;

                requestAnimationFrame(update);

            }

        }

        update();

    });

    /* Dark Mode */

    const toggle=document.getElementById("themeToggle");

    if(localStorage.getItem("theme")==="dark"){

        document.body.classList.add("dark-mode");

        toggle.innerHTML='<i class="bi bi-sun-fill"></i>';

    }

    toggle.addEventListener("click",function(){

        document.body.classList.toggle("dark-mode");

        if(document.body.classList.contains("dark-mode")){

            localStorage.setItem("theme","dark");

            toggle.innerHTML='<i class="bi bi-sun-fill"></i>';

        }else{

            localStorage.setItem("theme","light");

            toggle.innerHTML='<i class="bi bi-moon-stars-fill"></i>';

        }

    });

});

</script>

</body>

</html>