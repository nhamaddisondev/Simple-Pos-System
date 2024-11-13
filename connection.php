<?php
	$conn = new mysqli('localhost','root','','tgi_db');
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 
	if ($conn->connect_error) {
		error_log("Connection failed: " . $conn->connect_error);
		echo "Error connecting to database.";
		exit();
	}
?>