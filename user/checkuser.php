<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'tgi_db');

// Check database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user = $_POST['txtuser'];
$password = $_POST['txtpassword'];

// Use prepared statement to avoid SQL injection
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $user);  // 's' denotes string type
$stmt->execute();
$result = $stmt->get_result();

// Check if user exists
if ($result->num_rows > 0) {
    $row = $result->fetch_object();
    $userid = $row->id;
    $stored_password = $row->password;

    // Verify the password using password_verify()
    if (password_verify($password, $stored_password)) {
        // Create session if password is correct
        $_SESSION['ID'] = $userid;
        $_SESSION['USER'] = $user;
        echo 1;  // Successful login
    } else {
        echo 0;  // Incorrect password
    }
} else {
    echo 0;  // User not found
}

$stmt->close();
$conn->close();
?>
