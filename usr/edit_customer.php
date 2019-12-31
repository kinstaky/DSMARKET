<?php
	session_start();
	include "../database/connect_db.php";
	if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"]=="POST") {
		$usrname = $_POST["usrname"];
		$birthday="";
		if (!isset($_POST["birthday_y"]) || empty($_POST["birthday_y"])) aerror(1);
		else {
			$year = test_input($_POST["birthday_y"]);
			if (!isset($_POST["birthday_m"]) || empty($_POST["birthday_m"])) aerror(1);
			else {
				$month = test_input($_POST["birthday_m"]);
				if (!isset($_POST["birthday_d"]) || empty($_POST["birthday_d"])) aerror(1);
				else {
					$day = test_input($_POST["birthday_d"]);

					if ($year < 1950 || $year > 2035) aerror(1);
					else if ($month < 1 || $month > 12) aerror(1);
					else if ($day < 1 || $day > 31) aerror(1);
					else {
						$birthday = $year."-".$month."-".$day;
						$_SESSION["cus_year"] = $year;
						$_SESSION["cus_month"] = $month;
						$_SESSION["cus_day"] = $day;
					}
				}
			}
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