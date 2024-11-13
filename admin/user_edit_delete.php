<?php
include("header.php");
include("../connection.php"); // Include your database connection file

// Handle Edit and Delete actions
$message = '';
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($_GET['action'] == 'edit') {
        // Fetch user for editing
        $sql = "SELECT * FROM users WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_object();
        } else {
            $message = "User not found.";
        }
    } elseif ($_GET['action'] == 'delete') {
        // Handle deletion
        $delete_sql = "DELETE FROM users WHERE id = ?";
        $delete_stmt = $conn->prepare($delete_sql);
        $delete_stmt->bind_param("i", $id);

        if ($delete_stmt->execute()) {
            $message = "User deleted successfully.";
        } else {
            $message = "Error deleting user: " . $conn->error;
        }
    }
}

// Update user information if form is submitted for editing
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit'])) {
    $username = trim($_POST['username']);
    $status = trim($_POST['status']);
    
    if (empty($username) || empty($status)) {
        $message = "All fields are required.";
    } else {
        $update_sql = "UPDATE users SET username = ?, status = ? WHERE id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("ssi", $username, $status, $_POST['id']);

        if ($update_stmt->execute()) {
            $message = "User updated successfully.";
            header("Location: user.php"); // Redirect to user list page after update
            exit;
        } else {
            $message = "Error updating user: " . $conn->error;
        }
    }
}
?>

<div class="container mt-4">
    <h3>User List</h3>
    
    <?php if ($message): ?>
        <div class="alert alert-info"><?php echo $message; ?></div>
    <?php endif; ?>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Username</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * FROM users";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_object()) {
                    echo "<tr>
                        <td>".$row->id."</td>
                        <td>".$row->username."</td>
                        <td>".$row->status."</td>
                        <td>
                            <a href='user.php?action=edit&id=".$row->id."'>Edit</a> | 
                            <a href='user.php?action=delete&id=".$row->id."' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                        </td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No users found.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <?php if (isset($user)): ?>
        <h3>Edit User</h3>
        <form method="POST" action="">
            <input type="hidden" name="id" value="<?php echo $user->id; ?>">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($user->username); ?>" required>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <input type="text" class="form-control" id="status" name="status" value="<?php echo htmlspecialchars($user->status); ?>" required>
            </div>
            <button type="submit" name="edit" class="btn btn-primary">Update User</button>
        </form>
    <?php endif; ?>
</div>

<?php include("footer.php"); ?>
