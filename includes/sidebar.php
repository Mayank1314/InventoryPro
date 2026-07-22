<?php

if(session_status() == PHP_SESSION_NONE)
{
    session_start();
}

$current_page = basename($_SERVER['PHP_SELF']);

?>

<div id="sidebar">

    <a href="<?php echo ($_SESSION['role']=="Admin") ? 'dashboard.php' : 'products.php'; ?>" class="brand">
        <i class="bi bi-box-seam text-info"></i>
        Inventory System
    </a>

    <ul>

        <!-- ADMIN ONLY -->
        <?php if(isset($_SESSION['role']) && $_SESSION['role']=="Admin"){ ?>

        <li>
            <a href="dashboard.php"
               class="<?= $current_page=='dashboard.php'?'active':'' ?>">
                <i class="bi bi-speedometer2"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <?php } ?>


        <!-- BOTH ADMIN & STAFF -->

        <li>
            <a href="categories.php"
               class="<?= $current_page=='categories.php'?'active':'' ?>">
                <i class="bi bi-grid"></i>
                <span>Categories</span>
            </a>
        </li>

        <li>
            <a href="products.php"
               class="<?= $current_page=='products.php'?'active':'' ?>">
                <i class="bi bi-box"></i>
                <span>Products</span>
            </a>
        </li>

        <li>
            <a href="suppliers.php"
               class="<?= $current_page=='suppliers.php'?'active':'' ?>">
                <i class="bi bi-truck"></i>
                <span>Suppliers</span>
            </a>
        </li>

        <li>
            <a href="customers.php"
               class="<?= $current_page=='customers.php'?'active':'' ?>">
                <i class="bi bi-people"></i>
                <span>Customers</span>
            </a>
        </li>

        <li>
            <a href="purchases.php"
               class="<?= $current_page=='purchases.php'?'active':'' ?>">
                <i class="bi bi-cart-plus"></i>
                <span>Purchases</span>
            </a>
        </li>

        <li>
            <a href="sales.php"
               class="<?= $current_page=='sales.php'?'active':'' ?>">
                <i class="bi bi-cart-check"></i>
                <span>Sales</span>
            </a>
        </li>

        <!-- ADMIN ONLY -->
        <?php if(isset($_SESSION['role']) && $_SESSION['role']=="Admin"){ ?>

        <li>
            <a href="reports.php"
               class="<?= $current_page=='reports.php'?'active':'' ?>">
                <i class="bi bi-bar-chart"></i>
                <span>Reports</span>
            </a>
        </li>

        <?php } ?>


        <li class="mt-4">
            <a href="logout.php">
                <i class="bi bi-box-arrow-right"></i>
                <span>Logout</span>
            </a>
        </li>

    </ul>

</div>