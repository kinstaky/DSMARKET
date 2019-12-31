<?php
	session_start();
	require "../database/connect_db.php";
	if (!isset($_SERVER["REQUEST_METHOD"]) || $_SERVER["REQUEST_METHOD"] != 'POST') {
		echo "Not post\n";
		exit;
	}
	if (!isset($_POST["usrname"]) || !isset($_POST["opwd"]) || !isset($_POST["npwd"]) || !isset($_POST["nrpwd"])) {
		echo "Not set post parameter.\n";
		exit;
	}
	$usrname = $_POST["usrname"];
	$opwd = MD5($_POST["opwd"]);
	$npwd = MD5($_POST["npwd"]);
	if (empty($_POST["opwd"]) || empty($_POST["npwd"]) || empty($_POST["nrpwd"])) aerror(3);
	if ($npwd != MD5($_POST["nrpwd"])) aerror(1);
	$retval = db_select("password", "customer", "name='$usrname'");
	if ($retval->num_rows > 0) {
		$row = $retval->fetch_assoc();
		if ($opwd != $row["password"]) aerror(2);
	}
	db_update("customer", "password='$npwd'", "name='$usrname'");
	db_close();
		header("Location:personal_info.php?usrname=$usrname");
	header($jurl);


	function aerror($val) {
		GLOBAL $usrname;
		$_SESSION["change_pwd_error"] = $val;
		db_close();
		header("Location:personal_info.php?usrname=$usrname");
		exit;
	}
?>