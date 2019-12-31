<?php
	include "../database/connect_db.php";
	if (!isset($_SERVER["REQUEST_METHOD"]) || $_SERVER["REQUEST_METHOD"]!="POST") {
		echo "Not find post";
		exit;
	}
	$pay = $_POST["pay"];
	if (($len = count($pay)) == 0) header("Location:cart_management.php");
	for ($i = 0; $i < count($pay); ++$i) {
		$cid = $pay[$i];
		$retval = db_select("gid, uid", "carts", "cid=$cid");
		if ($retval->num_rows > 0) {
			$row = $retval->fetch_assoc();
			$uid = $row["uid"];
			$gid = $row["gid"];
			db_insert("buy(uid, gid, time)", "($uid, $gid, NOW())");
		}
	}
	db_close();
	header("Location:buy_management.php");
	exit;
?>