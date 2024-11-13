<?php 
	session_start();
	session_destroy(); // function is used clear all session 
	header("location:login.php");
?>