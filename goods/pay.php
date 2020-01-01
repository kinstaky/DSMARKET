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
		$retval = db_select("goods.gid, uid, price", "carts, goods", "cid=$cid AND goods.gid=carts.gid");
		if ($retval->num_rows > 0) {
			$row = $retval->fetch_assoc();
			$uid = $row["uid"];
			$gid = $row["gid"];
			$price = $row["price"];
			db_insert("buy(uid, gid, time, price)", "($uid, $gid, NOW(), $price)");
		}
	}
	db_close();
	header("Location:buy_management.php");
	exit;
?>