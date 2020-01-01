<?php
	session_start();
	include "../database/connect_db.php";
	if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"]=="POST") {
		$usrname = $_POST["usrname"];
		$birthday="";
		if (!isset($_POST["birthday"]) || empty($_POST["birthday"])) aerror(1);
		else {
			$birthday = $_POST["birthday"];
		}

		$sex = $_POST["sex"] == "MALE" ? 0 : 1;

		if (!isset($_POST["Email"]) || empty($_POST["Email"])) aerror(2);
		else {
			$email = test_input($_POST["Email"]);
			if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$email)) aerror(2);
		}

		if (!isset($_POST["phone"]) || empty($_POST["phone"])) aerror(3);
		else {
			$phone = test_input($_POST["phone"]);
			if (!preg_match("/^1\d{10}$/", $phone)) aerror(3);
		}
		db_update("customer", "birthday='$birthday', sex=$sex, Email='$email', phone='$phone'", "name='$usrname'");
		header("Location:personal_info.php?usrname=".$usrname);
		exit;
	}

	function aerror($val) {
		GLOBAL $usrname;
		$_SESSION["edit_cus_error"] = $val;
		$shtml = "<form id='jumppost' name='jumppost' action='edit_info.php' method='post'>\n";
		$shtml .= "<input type=hidden name='usrname' value='$usrname'>\n";
		$shtml .= "<input type=submit name='jmp' style='display:none'></form>\n";
		$shtml .= "<script> document.forms['jumppost'].submit();</script>";
		echo $shtml;
		exit;
	}

	function test_input($data) {
		$data = trim($data);
	  	$data = stripslashes($data);
	  	$data = htmlspecialchars($data);
	  	return $data;
	}
?>