<?php
	session_start();
	include "../database/connect_db.php";
	if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"]=="POST") {
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