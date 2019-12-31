<?php
	session_start();
	if (!isset($_SESSION["status"])) {
		echo "Error page\n";
		exit;
	}
	if (!isset($_SERVER["REQUEST_METHOD"]) || $_SERVER["REQUEST_METHOD"]!='POST') {
		echo "Post error\n";
		exit;
	}
	$gid = $_POST["gid"];
	$sta = $_POST["sta"];
	$url = $_POST["url"];
	require "/var/www/html/database/connect_db.php";
	db_update("goods", "status=$sta", "gid=$gid");
	db_close();
	header("Location:$url");
	exit;
?>