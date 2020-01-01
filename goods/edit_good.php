<?php
	session_start();
	include "../database/connect_db.php";

	if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"]=="POST") {
		#basic info
		$gid = $_POST["gid"];
		$gname = test_input($_POST["gname"]);
		if (empty($gname)) aerror(1);
		$gtype = test_input($_POST["gtype"]);
		if (empty($gtype)) aerror(2);
		$gprice = test_input($_POST["gprice"]);
		if (empty($gprice)) aerror(3);
		if (!preg_match("/^\d+(\.\d{1,2})?$/",$gprice)) aerror(3);
		$gdesc = test_input($_POST["gdesc"]);
		if (empty($gdesc)) aerror(4);

		db_update("goods", "name='$gname', type='$gtype', price='$gprice', description='$gdesc'", "gid=$gid");

		#image info, edit from https://www.runoob.com/php/php-file-upload.html
		if (!empty($_FILES["file"]["name"])) {
			// 允许上传的图片后缀
			$allowedExts = array("gif", "jpeg", "jpg", "png");
			$temp = explode(".", $_FILES["file"]["name"]);
			$extension = end($temp);     // 获取文件后缀名
			if (!(($_FILES["file"]["type"] == "image/gif")
			|| ($_FILES["file"]["type"] == "image/jpeg")
			|| ($_FILES["file"]["type"] == "image/jpg")
			|| ($_FILES["file"]["type"] == "image/pjpeg")
			|| ($_FILES["file"]["type"] == "image/x-png")
			|| ($_FILES["file"]["type"] == "image/png"))
			|| !in_array($extension, $allowedExts)) aerror(6);
			if ($_FILES["file"]["size"] > 204800) aerror(7);// 小于 200 kb

		   	if ($_FILES["file"]["error"] > 0) {
		        echo "错误：: " . $_FILES["file"]["error"] . "<br>";
		        aerror(8);
		    }
		    $fname = $gid.".".$extension;
		    $addr = "../files/img/".$fname;
		    if (file_exists($addr)) unlink($addr);
	        move_uploaded_file($_FILES["file"]["tmp_name"], $addr);
	        db_update("goodimage", "name='$fname'", "gid='$gid'");
	    }

		header("Location:good_info.php?gid=$gid");
		exit;
	}

	function aerror($val) {
		GLOBAL $gid;
		$_SESSION["edit_good_error"] = $val;
		header("Location:edit_good_info.php?gid=$gid");
		exit;
	}

	function test_input($data) {
		$data = trim($data);
	  	$data = stripslashes($data);
	  	$data = htmlspecialchars($data);
	  	return $data;
	}
?>