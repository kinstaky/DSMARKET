<!DOCTYPE html>
<?php
	session_start();
	include "../database/connect_db.php";
?>
<html>
<head>
	<meta charset="utf-8">
	<title>buy management</title>
	<style> a {text-decoration:none} </style>
	<!-- <author>kinstaky</author> -->
</head>

<body>
<?php include "../div/top_menu.php" ?>
<div id='blank' style='margin:auto;width:800px;height:150px'></div>
<div id="container" style='margin:auto;width:800px;position:relative;left:0px'>
<?php
	if ($_SESSION["status"] == 2) {
		echo <<<EOF
			<h3> buy management </h3>
			<br>
		EOF;
		$uid = $_SESSION["uid"];
		$retval = db_select("goods.name AS gname, goods.gid, bid, buy.time, goods.status", "goods, buy", "goods.gid=buy.gid && buy.uid=$uid ORDER BY buy.time DESC");
		if ($retval->num_rows > 0) {
			echo "<span style='position:absolute;left:0px'>Name</span>\n";
			echo "<span style='position:absolute;left:250px'>Time</span>\n";
			echo "<span style='position:absolute;left:450px'>Action</span><br><br>\n";
			while ($row = $retval->fetch_assoc()) {
				$btime = $row["time"];
				$gid = $row["gid"];
				$gsta = $row["status"];
				$bid = $row["bid"];
				echo "<a href='good_info.php?gid=".$row["gid"]."' target='_top' style='position:absolute;left:0px'>".$row["gname"]."</a>\n";
				echo "<span style='position:absolute;left:250px'>$btime</span>\n";
				echo "<form action='new_comment.php' method = 'GET' style='position:relative;top:-3px'>\n";
				echo "	<input type='hidden' name='bid' value='$bid'>\n";
				echo "	<input type='submit' style='position:absolute;left:450px' value='comment'>\n";
				echo "</form><br><br>\n";
				if ($gsta == 1) {
					echo "<form action='return_good.php' method = 'POST' style='position:relative;top:-41px'>\n";
					echo "	<input type='hidden' name='gid' value='$gid'>\n";
					echo "  <input type='hidden' name='status' value='2'>\n";
					echo "  <input type='hidden' name='url' value='buy_management.php'>\n";
					echo "	<input type='submit' style='position:absolute;left:600px' value='return'>\n";
					echo "</form><br><br>\n";
				}
				else if ($gsta == 2 || $gsta == 6) {
					echo "<div style='position:relative;top:-41px'> <span style='position:absolute;left:600px;color:#ff0000'>returning</span></div><br><br>\n";
				}
				else if ($gsta == 8) {
					echo "<div style='position:relative;top:-41px'> <span style='position:absolute;left:600px;color:#ff0000'>returned</span></div><br><br>\n";
				}
				else if ($gsta == 16) {
					echo "<div style='position:relative;top:-41px'> <span style='position:absolute;left:600px;color:#ff0000'>deny returned</span></div><br><br>\n";
				}
				else echo "<div style='position:relative;top:-41px'> <span style='position:absolute;left:600px;color:#ff0000'>Undefined status $gsta</span></div><br><br>\n";
			}
		}
	}
	else {
		echo <<<EOF
			<h3> buy management </h3>
			<br>
		EOF;
		$retval = db_select("goods.name AS gname, goods.gid AS ggid, buy.time, buy.price AS bprice, c1.name AS seller, c2.name AS buyer", "goods, buy, customer AS c1, customer AS c2", "goods.gid=buy.gid AND buy.uid=c2.uid AND goods.sid=c1.uid");
		if ($retval->num_rows > 0) {
			echo "<span style='position:absolute;left:0px'>Name</span>\n";
			echo "<span style='position:absolute;left:250px'>Price</span>\n";
			echo "<span style='position:absolute;left:400px'>Seller</span>\n";
			echo "<span style='position:absolute;left:550px'>Buyer</span>\n";
			echo "<span style='position:absolute;left:700px'>Time</span><br><br>\n";
			while ($row = $retval->fetch_assoc()) {
				$btime = $row["time"];
				$gid = $row["ggid"];
				$gname = $row["gname"];
				$bprice = $row["bprice"];
				$buyer = $row["buyer"];
				$seller = $row["seller"];
				echo "<a href='good_info.php?gid=$gid' target='_top' style='position:absolute;left:0px'>$gname</a>\n";
				echo "<span style='position:absolute;left:250px'>$bprice</span>\n";
				echo "<a href='../usr/personal_info.php?usrname=$seller' target='_top' style='position:absolute;left:400px'>$seller</a>\n";
				echo "<a href='../usr/personal_info.php?usrname=$buyer' target='_top' style='position:absolute;left:550px'>$buyer</a>\n";
				echo "<div style='position:relative;top:-13px'><span style='position:absolute;left:700px'>$btime</span></div><br><br><br>\n";

			}
		}
	}
	db_close();

?>
</div>
</body>
</html>