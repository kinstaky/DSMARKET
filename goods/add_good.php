<?php
	session_start();
	include "../database/connect_db.php";
	if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"]=="POST") {
		if (!isset($_POST["name"]) || empty($_POST["name"])) aerror(1);
		else {
			$name = test_input($_POST["name"]);
			$_SESSION["good_name"] = $name;
		}

		if (!isset($_POST["type"]) || empty($_POST["type"])) aerror(1);
		else {
			$type = test_input($_POST["type"]);
			$_SESSION["good_type"] = $type;
		}

		if (!isset($_POST["price"]) || empty($_POST["price"])) aerror(1);
		else {
			$price = test_input($_POST["price"]);
			if (!preg_match("/^\d+(\.\d{1,2})?$/",$price)) aerror(2);
			else $_SESSION["good_price"] = $price;
		}

		if (!isset($_POST["desc"]) || empty($_POST["desc"])) aerror(1);
		else {
			$desc = test_input($_POST["desc"]);
			$_SESSION["good_desc"] = $desc;
		}
		goerror();
		unset($_SESSION["good_name"]);
		unset($_SESSION["good_type"]);
		unset($_SESSION["good_price"]);
		unset($_SESSION["good_desc"]);
		$uid = $_SESSION["uid"];


		#image info, edit from https://www.runoob.com/php/php-file-upload.html
		$retval = db_select2("max(gid) AS mid", "goods");
		if ($retval->num_rows > 0) {
			$row = $retval->fetch_assoc();
			$mid = (int)($row["mid"])+1;
		}
		// 允许上传的图片后缀
		$allowedExts = array("gif", "jpeg", "jpg", "png");
		$temp = explode(".", $_FILES["file"]["name"]);
		$extension = end($temp);     // 获取文件后缀名
		$fname = $mid.".".$extension;
		if (!(($_FILES["file"]["type"] == "image/gif")
		|| ($_FILES["file"]["type"] == "image/jpeg")
		|| ($_FILES["file"]["type"] == "image/jpg")
		|| ($_FILES["file"]["type"] == "image/pjpeg")
		|| ($_FILES["file"]["type"] == "image/x-png")
		|| ($_FILES["file"]["type"] == "image/png"))
		|| !in_array($extension, $allowedExts)) aerror(4);
		if ($_FILES["file"]["size"] > 204800) aerror(5);// 小于 200 kb

	   	if ($_FILES["file"]["error"] > 0) {
	        echo "错误：: " . $_FILES["file"]["error"] . "<br>";
	        aerror(6);
	    }
	    $addr = "../files/img/".$fname;
	    if (file_exists($addr)) unlink($addr);
        move_uploaded_file($_FILES["file"]["tmp_name"], $addr);

        db_insert("goods(name, type, price, description, status, sid, time, imgsrc)", "('$name', '$type', '$price', '$desc', 0, $uid, NOW(), '$fname')");
		db_close();
		header("Location:sell_management.php");
		exit;
	}

	function aerror($val) {
		if (!isset($_SESSION["add_good_error"])) $_SESSION["add_good_error"] = $val;
	}

	function goerror() {
		if (isset($_SESSION["add_good_error"])) {
			header("Location:new_good.php");
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