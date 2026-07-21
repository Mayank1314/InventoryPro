    <?php

    $host = "localhost";
    $user = "root";
    $password = "";
    $database = "inventory_management";

    $conn = mysqli_connect($host, $user, $password, $database);

    if (!$conn) {
        die("Connection Failed: " . mysqli_connect_error());
    }

    $search = "";

    if (isset($_GET['search'])) {

        $search = mysqli_real_escape_string($conn, $_GET['search']);

        $sql = "SELECT * FROM customers
                WHERE customer_name LIKE '%$search%'
                OR phone LIKE '%$search%'
                OR email LIKE '%$search%'
                ORDER BY id DESC";
    }
    else
    {
        $sql = "SELECT * FROM customers ORDER BY id DESC";
    }

    $result = mysqli_query($conn, $sql);

    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Customer Management</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css">

    <style>

    :root{
    --dark:#0A2540;
    --light:#f4f7fb;
    }

    body{
    background:var(--light);
    font-family:'Segoe UI',sans-serif;
    }

    #sidebar{
    width:260px;
    height:100vh;
    background:#0A2540;
    position:fixed;
    left:0;
    top:0;
    padding:20px;
    }

    #main{
    margin-left:260px;
    padding:30px;
    }

    .card{
    border:none;
    border-radius:15px;
    }

    .table th{
    background:#0A2540;
    color:white;
    }

    </style>

    </head>

    <body>

    <div id="sidebar" class="d-flex flex-column p-3 text-white">
        <a href="dashboard.php" class="d-flex align-items-center mb-4 me-md-auto text-white text-decoration-none">
            <i class="bi bi-box-seam fs-4 me-2 text-info"></i>
            <span class="fs-5 fw-bold">IMS Dashboard</span>
        </a>

        <hr style="background-color:#38bdf8; opacity:.3;">

        <ul class="nav nav-pills flex-column mb-auto">

            <li class="nav-item">
                <a href="dashboard.php" class="nav-link">
                    <i class="bi bi-speedometer2 me-2"></i>
                    Dashboard
                </a>
            </li>

            <li>
                <a href="products.php" class="nav-link">
                    <i class="bi bi-box me-2"></i>
                    Product Management
                </a>
            </li>

            <li>
                <a href="categories.php" class="nav-link">
                    <i class="bi bi-tags me-2"></i>
                    Category Management
                </a>
            </li>

            <li>
                <a href="suppliers.php" class="nav-link">
                    <i class="bi bi-truck me-2"></i>
                    Supplier Management
                </a>
            </li>

            <li>
                <a href="customers.php" class="nav-link active">
                    <i class="bi bi-people me-2"></i>
                    Customer Management
                </a>
            </li>

            <li>
                <a href="#" class="nav-link">
                    <i class="bi bi-cart-plus me-2"></i>
                    Purchase Management
                </a>
            </li>

            <li>
                <a href="#" class="nav-link">
                    <i class="bi bi-cash-coin me-2"></i>
                    Sales Management
                </a>
            </li>

            <li>
                <a href="#" class="nav-link">
                    <i class="bi bi-journal-text me-2"></i>
                    Reports
                </a>
            </li>

        </ul>

        <hr style="background-color:#38bdf8; opacity:.3;">

        <div class="dropdown">

            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">

                <i class="bi bi-person-circle fs-5 me-2 text-info"></i>

                <strong>Mayank Upadhyay</strong>

            </a>

            <ul class="dropdown-menu dropdown-menu-dark shadow">

                <li>
                    <a class="dropdown-item" href="login.php">
                        <i class="bi bi-box-arrow-right me-2"></i>
                        Logout
                    </a>
                </li>

            </ul>

        </div>

    </div>


    <div id="main">

    <?php if(isset($_GET['success'])){ ?>

    <div class="alert alert-success alert-dismissible fade show">
    Customer Added Successfully.
    <button class="btn-close" data-bs-dismiss="alert"></button>
    </div>

    <?php } ?>

    <?php if(isset($_GET['updated'])){ ?>

    <div class="alert alert-primary alert-dismissible fade show">
    Customer Updated Successfully.
    <button class="btn-close" data-bs-dismiss="alert"></button>
    </div>

    <?php } ?>

    <?php if(isset($_GET['deleted'])){ ?>

    <div class="alert alert-danger alert-dismissible fade show">
    Customer Deleted Successfully.
    <button class="btn-close" data-bs-dismiss="alert"></button>
    </div>

    <?php } ?>

    <div class="d-flex justify-content-between align-items-center mb-4">

    <h2>

    <i class="bi bi-people"></i>

    Customer Management

    </h2>

    <a href="add_customer.php" class="btn btn-primary">

    <i class="bi bi-plus-circle"></i>

    Add Customer

    </a>

    </div>

    <div class="card shadow">

    <div class="card-body">

    <form method="GET">

    <div class="input-group mb-4" style="max-width:350px;">

    <input
    type="text"
    name="search"
    class="form-control"
    placeholder="Search Customer..."
    value="<?php echo $search; ?>">

    <button class="btn btn-primary">

    <i class="bi bi-search"></i>

    </button>

    </div>

    </form>

    <div class="table-responsive">

    <table class="table table-bordered table-hover">

    <thead>

    <tr>

    <th>ID</th>

    <th>Customer Name</th>

    <th>Phone</th>

    <th>Email</th>

    <th>Created</th>

    <th width="180">Action</th>

    </tr>

    </thead>

    <tbody>

    <?php

    if(mysqli_num_rows($result) > 0)
    {
        while($row = mysqli_fetch_assoc($result))
        {
    ?>

    <tr>

    <td><?php echo $row['id']; ?></td>

    <td><?php echo htmlspecialchars($row['customer_name']); ?></td>

    <td><?php echo htmlspecialchars($row['phone']); ?></td>

    <td><?php echo htmlspecialchars($row['email']); ?></td>

    <td><?php echo date("d M Y", strtotime($row['created_at'])); ?></td>

    <td>

    <a href="edit_customer.php?id=<?php echo $row['id']; ?>"
    class="btn btn-success btn-sm">

    <i class="bi bi-pencil-square"></i>

    Edit

    </a>

    <a href="delete_customer.php?id=<?php echo $row['id']; ?>"
    class="btn btn-danger btn-sm"
    onclick="return confirm('Are you sure you want to delete this customer?');">

    <i class="bi bi-trash"></i>

    Delete

    </a>

    </td>

    </tr>

    <?php
        }
    }
    else
    {
    ?>

    <tr>

    <td colspan="6" class="text-center py-5">

    <i class="bi bi-people display-4 text-secondary"></i>

    <h5 class="mt-3">No Customers Found</h5>

    <p class="text-muted">
    Click <strong>Add Customer</strong> to create your first customer.
    </p>

    </td>

    </tr>

    <?php
    }
    ?>

    </tbody>

    </table>

    </div>

    </div>

    </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    </body>

    </html>

