<?php
	require "../database/connect_db.php";
	if (!isset($_SERVER["REQUEST_METHOD"]) || $_SERVER["REQUEST_METHOD"] != 'POST') {
		echo "Not post\n";
		exit;
	}
	if (!isset($_POST["usrname"])) {
		echo "Not set post parameter.\n";
		exit;
	}
	$usrname = $_POST["usrname"];
	db_update("customer", "status=1", "name='$usrname'");
	db_close();
	header("Location:personal_info.php?usrname=$usrname");
?>