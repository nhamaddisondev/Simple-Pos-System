<?php
session_start();
include("../connection.php");

// Check if user is logged in
if (empty(trim($_SESSION['ID']))) {
    header("location:../login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Management Tools</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <style>
        body {
            background-color: #f0f2f5;
            color: #333;
        }

        .box {
            border: 1px solid #ddd;
            padding: 20px;
            margin: 15px;
            border-radius: 10px;
            background-color: #ffffff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s ease, transform 0.3s ease;
        }

        .box:hover {
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2);
            transform: translateY(-2px);
        }

        .navbar {
            background-color: #ffffff !important;
            border-bottom: 1px solid #e0e0e0;
        }

        .nav-link {
            color: #555 !important;
            font-weight: 500;
            margin-right: 10px;
            transition: color 0.3s ease;
        }

        .nav-link:hover {
            color: #007bff !important;
        }

        .btn-outline-danger {
            color: #dc3545 !important;
            border-color: #dc3545 !important;
            transition: all 0.3s ease;
        }

        .btn-outline-danger:hover {
            background-color: #dc3545 !important;
            color: #fff !important;
        }
    </style>
</head>
<body>
    <!-- Header Section -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container">
                <a class="navbar-brand" href="#" style="font-weight: bold; color: #007bff;">MyApp</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="user.php">User</a></li>
                        <li class="nav-item"><a class="nav-link" href="category.php">Category</a></li>						<li class="nav-item"><a class="nav-link" href="sales.php">Sales</a></li>
						<li class="nav-item"><a class="nav-link" href="Cart.php">Cart</a></li>
                    </ul>
                    <div class="d-flex">
                        <span class="navbar-text me-3">
                            Logged in as: <strong><?php echo htmlspecialchars($_SESSION['USER']); ?></strong>
                        </span>
                        <a href="../logout.php" class="btn btn-outline-danger btn-sm">Logout</a>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>