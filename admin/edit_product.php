<?php
include("../connection.php");

$id = $_GET['id'];
$sql = "SELECT * FROM products WHERE proid = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_object();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $code = $_POST['code'];
    $proname = $_POST['proname'];
    $price = $_POST['price'];
    // Handle image upload if necessary
    // Update the product in the database
    $updateSql = "UPDATE products SET code = ?, proname = ?, price = ? WHERE proid = ?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("ssdi", $code, $proname, $price, $id);
    $updateStmt->execute();
    header("Location: product_list.php"); // Redirect to product list after update
}

?>

<?php include("header.php"); ?>

<div class="container mt-4">
    <h3>Edit Product</h3>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="code" class="form-label">Product Code</label>
            <input type="text" class="form-control" id="code" name="code" value="<?php echo htmlspecialchars($product->code); ?>" required>
        </div>
        <div class="mb-3">
            <label for="proname" class="form-label">Product Name</label>
            <input type="text" class="form-control" id="proname" name="proname" value="<?php echo htmlspecialchars($product->proname); ?>" required>
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="number" class="form-control" id="price" name="price" value="<?php echo htmlspecialchars($product->price); ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Product</button>
        <a href="product_list.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<?php include("footer.php"); ?>