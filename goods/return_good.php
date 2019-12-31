<?php
	include "../database/connect_db.php";
	if (!isset($_SERVER["REQUEST_METHOD"]) || $_SERVER["REQUEST_METHOD"]!="POST") {
		echo "Not find post";
		exit;
	}
	$gid = $_POST["gid"];
	db_update("goods", "status=-2", "gid=$gid");
	db_close();
	header("Location:buy_management.php");
	exit;
?>