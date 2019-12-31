<?php
	session_start();
	include "../database/connect_db.php";
	if (!isset($_SERVER["REQUEST_METHOD"]) || $_SERVER["REQUEST_METHOD"]!="POST") {
		echo "Not find post";
		exit;
	}
	$gid = $_POST["gid"];
	$uid = $_SESSION["uid"];
	db_insert("carts(uid, gid)", "($uid, $gid)");
	db_close();
	header("Location:cart_management.php");
	exit;
?>