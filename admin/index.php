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
	<title>Dashboard</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
	<style>
		body {
			background-color: #f8f9fa;
		}

		.box {
			border: 1px solid #ddd;
			padding: 15px;
			margin: 15px;
			border-radius: 8px;
			background-color: #fff;
			box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
		}

		.navbar {
			background-color: #fff !important;
			border-bottom: 2px solid #dc3545;
		}

		.nav-link {
			color: #555 !important;
			font-weight: 500;
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

		.container {
			margin-top: 20px;
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
					<li class="nav-item"><a class="nav-link" href="index.php" aria-label="Home">Home</a></li>
					<li class="nav-item"><a class="nav-link" href="user.php" aria-label="User">User</a></li>
					<li class="nav-item"><a class="nav-link" href="category.php" aria-label="Category">Category</a></li>
					<li class="nav-item"><a class="nav-link" href="product.php" aria-label="Product">Product</a></li>
					<li class="nav-item"><a class="nav-link" href="sale.php" aria-label="Sale">Sale</a></li>
				</ul>
				<div class="d-flex">
					<span class="navbar-text me-3">
						Login as: <strong><?php echo htmlspecialchars($_SESSION['USER'] ?? 'Guest'); ?></strong>
					</span>
					<a href="../logout.php" class="btn btn-outline-danger btn-sm">Logout</a>
				</div>
			</div>
		</div>
	</nav>
</header>

<!-- Main Content Section -->
<section class="container mt-4">
<section class="container mt-4">
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="box">
                    <h4>User Management</h4>
                    <p>Manage user accounts and permissions.</p>
                    <a href="user.php" class="btn btn-primary btn-sm">Go to User</a>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="box">
                    <h4>Category Management</h4>
                    <p>Manage product categories and related data.</p>
                    <a href="category.php" class="btn btn-primary btn-sm">Go to Category</a>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="box">
                    <h4>Product Management</h4>
                    <p>Manage product information and inventory.</p>
                    <a href="product.php" class="btn btn-primary btn-sm">Go to Product</a>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="box">
                    <h4>Sales Management</h4>
                    <p>Manage sales orders and reports.</p>
                    <a href="sale.php" class="btn btn-primary btn-sm">Go to Sale</a>
                </div>
            </div>
        </div>
    </section>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
