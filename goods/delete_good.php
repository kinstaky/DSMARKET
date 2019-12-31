<?php
	session_start();
	include "../database/connect_db.php";
	if (!isset($_SERVER["REQUEST_METHOD"]) || $_SERVER["REQUEST_METHOD"]!='POST') {
		echo "not post\n";
		exit;
	}
	$gid = $_POST["gid"];
	$url = $_POST["url"];
	$retval = db_delete("goods", "gid=$gid");
	db_close();
	header("Location:$url");
?>