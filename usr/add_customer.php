<?php
	session_start();
	include "../database/connect_db.php";
	if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"]=="POST") {
		if (!isset($_POST["user"]) || empty($_POST["user"])) aerror(1);
		else {
			$name = test_input($_POST["user"]);
			$retval = db_select("name", "customer", "name='$name'");
			$_SESSION["cus_name"] = $name;
			if ($retval->num_rows > 0) aerror(2);
		}

		if (!isset($_POST["pwd"]) || empty($_POST["pwd"])) aerror(3);
		else {
			$pwd = MD5(test_input($_POST["pwd"]));
			if (!isset($_POST["rpwd"]) || empty($_POST["rpwd"])) aerror(4);
			else if ($pwd != MD5(test_input($_POST["rpwd"]))) aerror(5);
		}

		$birthday="";
		if (!isset($_POST["birthday"]) || empty($_POST["birthday"])) aerror(6);
		else {
			$birthday = $_POST["birthday"];
			$_SESSION["cus_birthday"] = $birthday;
		}

		if (!isset($_POST["sex"])) aerror(8);
		else {
			$_SESSION["cus_sex"] = $_POST["sex"];
			$sex = $_POST["sex"] == "MALE" ? 0 : 1;
		}

		if (!isset($_POST["Email"]) || empty($_POST["Email"])) aerror(9);
		else {
			$email = test_input($_POST["Email"]);
			if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$email)) aerror(10);
			else $_SESSION["cus_email"] = $_POST["Email"];
		}

		if (!isset($_POST["phone"]) || empty($_POST["phone"])) aerror(11);
		else {
			$phone = test_input($_POST["phone"]);
			if (!preg_match("/^1\d{10}$/", $phone)) aerror(12);
			else $_SESSION["cus_phone"] = $_POST["phone"];
		}
		goerror();
		unset($_SESSION["cus_name"]);
		unset($_SESSION["cus_sex"]);
		unset($_SESSION["cus_birthday"]);
		unset($_SESSION["cus_email"]);
		unset($_SESSION["cus_phone"]);
		db_insert("customer(name, password, birthday, sex, Email, phone, status)", "('$name', '$pwd', '$birthday', $sex, '$email', '$phone', 0)");
		mysqli_close($conn);
		header("Location:../index.php");
		exit;
	}

	function aerror($val) {
		if (!isset($_SESSION["sign_up_error"])) $_SESSION["sign_up_error"] = $val;
	}

	function goerror() {
		if (isset($_SESSION["sign_up_error"])) {
			header("Location:sign_up.php");
			exit;
		}
	}

	function test_input($data) {
		$data = trim($data);
	  	$data = stripslashes($data);
	  	$data = htmlspecialchars($data);
	  	return $data;
	}
?>