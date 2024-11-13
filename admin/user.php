<?php
include("header.php");
include("../connection.php"); // Include your database connection file

$message = '';
$user = null;

// Handle Add, Edit, and Delete actions
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = intval($_GET['id']);
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

// Handle adding a new user
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_member'])) {
    $username = trim($_POST['username']);
    $status = trim($_POST['status']);
    $password = trim($_POST['password']); // Get password from form

    if (empty($username) || empty($status) || empty($password)) {
        $message = "All fields are required.";
    } else {
        // Hash the password before storing it
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert new user into the database
        $insert_sql = "INSERT INTO users (username, status, password) VALUES (?, ?, ?)";
        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bind_param("sss", $username, $status, $hashedPassword);

        if ($insert_stmt->execute()) {
            $message = "New user added successfully.";
            header("Location: user.php"); // Redirect back to the user list page
            exit;
        } else {
            $message = "Error adding user: " . $conn->error;
        }
    }
}

// Update user information if form is submitted for editing
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit'])) {
    $id = intval($_POST['id']);
    $username = trim($_POST['username']);
    $status = trim($_POST['status']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($status)) {
        $message = "Username and status are required.";
    } else {
        if (!empty($password)) {
            // Hash new password if provided
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $update_sql = "UPDATE users SET username = ?, status = ?, password = ? WHERE id = ?";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param("sssi", $username, $status, $hashedPassword, $id);
        } else {
            // Update without changing the password
            $update_sql = "UPDATE users SET username = ?, status = ? WHERE id = ?";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param("ssi", $username, $status, $id);
        }

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

    <div class="text-end mb-3">
        <a href="#addMemberModal" data-bs-toggle="modal" class="btn btn-success">Add Member</a>
    </div>

    <table class="table table-bordered mt-4">
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
                        <td>{$row->id}</td>
                        <td>{$row->username}</td>
                        <td>{$row->status}</td>
                        <td>
                            <a href='user.php?action=edit&id={$row->id}' class='btn btn-primary btn-sm'>Edit</a> 
                            <a href='user.php?action=delete&id={$row->id}' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                        </td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No users found.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <?php if ($user): ?>
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
            <div class="mb-3">
                <label for="password" class="form-label">Password (leave blank to keep existing password)</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <button type="submit" name="edit" class="btn btn-primary">Update User</button>
        </form>
    <?php endif; ?>
</div>

<!-- Add Member Modal -->
<div class="modal fade" id="addMemberModal" tabindex="-1" aria-labelledby="addMemberModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addMemberModalLabel">Add New Member</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" action="">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <input type="text" class="form-control" id="status" name="status" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" name="add_member" class="btn btn-success">Add User</button>
        </form>
      </div>
    </div>
  </div>
</div>

<?php include("footer.php"); ?>
