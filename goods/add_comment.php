<?php
	include "../database/connect_db.php";
	if (!isset($_SERVER["REQUEST_METHOD"]) || $_SERVER["REQUEST_METHOD"]!="POST") {
		echo "Not find post";
		exit;
	}
	$gid = $_POST["gid"];
	$uid = $_POST["uid"];
	$stars = $_POST["stars"];
	$comment = $_POST["comment"];
	db_insert("comments(gid, uid, stars, comment, time)", "($gid, $uid, $stars, '$comment', NOW())");
	db_close();
	header("Location:buy_management.php");
	exit;
?>