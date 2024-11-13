<?php
include("../connection.php");

if (isset($_POST['productId'])) {
    $productId = $_POST['productId'];
    $sql = "DELETE FROM products WHERE proid = ?";
    
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $productId);
        
        if ($stmt->execute()) {
            echo "success";  // Success response
        } else {
            echo "error";  // Error response
        }
    } else {
        echo "error";  // Error if prepared statement fails
    }
    
    $stmt->close();
    $conn->close();
}
?>
