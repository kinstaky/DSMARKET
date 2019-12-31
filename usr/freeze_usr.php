<?php
	session_start();
	if (!isset($_SESSION["status"]) || ($_SESSION["status"] != 1 &&  $_SESSION["status"] != 0)) {
		echo "Error page\n";
		exit;
	}
	if (!isset($_SERVER["REQUEST_METHOD"]) || $_SERVER["REQUEST_METHOD"]!='POST') {
		echo "Post error\n";
		exit;
	}
	$name = $_POST["act"];
	$grade = $_POST["grade"];
	require "/var/www/html/database/connect_db.php";
	db_update("customer", "status=$grade", "name='$name'");
	db_close();
	header("Location:http://localhost/usr/usr_management.php");
	exit;
?>