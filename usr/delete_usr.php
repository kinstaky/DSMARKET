<?php
	session_start();
	include "../database/connect_db.php";
	if (!isset($_SESSION["status"]) || ($_SESSION["status"] != 1 &&  $_SESSION["status"] != 0)) {
		echo "Error page\n";
		exit;
	}
	if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"]=='POST') {
		if (isset($_POST["act"])) {
			$name = $_POST["act"];
			$retval = db_delete("customer", "name = '$name'");
			header("Location:usr_management.php");
			exit;
		}
	}
	header("Location:usr_management.php");
?>