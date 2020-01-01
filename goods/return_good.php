<?php
	include "../database/connect_db.php";
	if (!isset($_SERVER["REQUEST_METHOD"]) || $_SERVER["REQUEST_METHOD"]!="POST") {
		echo "Not find post";
		exit;
	}
	$gid = $_POST["gid"];
	$status = $_POST["status"];
	$url = $_POST["url"];
	db_update("goods", "status=$status", "gid=$gid");
	db_close();
	header("Location:$url");
	exit;
?>