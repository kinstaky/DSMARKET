<?php
	session_start();
	include "../database/connect_db.php";
	if (!isset($_SERVER["REQUEST_METHOD"]) || $_SERVER["REQUEST_METHOD"]!='POST') {
		echo "not post\n";
		exit;
	}
	if (isset($_POST["cid"])) {
		$cid = $_POST["cid"];
		$retval = db_delete("carts", "cid=$cid");
		header("Location:cart_management.php");
		exit;
	}
	header("Location:cart_management.php");
?>