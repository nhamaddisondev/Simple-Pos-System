<?php
// Include database connection file
include("../connection.php");  // Adjust the path to your actual connection.php location

// Check if 'id' is provided in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Retrieve the image file name before deletion
    $sql = "SELECT picture FROM categorys WHERE catid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $image = $row['picture'];

        // Delete the record from the database
        $delete_sql = "DELETE FROM categorys WHERE catid = ?";
        $delete_stmt = $conn->prepare($delete_sql);
        $delete_stmt->bind_param("i", $id);

        if ($delete_stmt->execute()) {
            // Delete the image file from the server if it exists
            $file_path = "category_image/" . $image;
            if (file_exists($file_path)) {
                unlink($file_path);
            }
            echo "Category deleted successfully.";
        } else {
            echo "Error deleting category: " . $conn->error;
        }
    } else {
        echo "Category not found.";
    }
} else {
    echo "No category ID specified.";
}

$conn->close();
?>
