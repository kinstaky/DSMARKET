<!DOCTYPE html>
<?php
	session_start();
	include "../database/connect_db.php";
?>
<html>
<head>
	<meta charset="utf-8">
	<title>return management</title>
	<style> a {text-decoration:none} </style>
	<!-- <author>kinstaky</author> -->
</head>

<body>
<?php include "../div/top_menu.php" ?>
<div id='blank' style='margin:auto;width:800px;height:150px'></div>
<div id="container" style='margin:auto;width:800px;position:relative;left:0px'>
<?php
	if ($_SESSION["status"] < 2) {
		echo <<<EOF
			<h3> return management </h3>
			<br>
		EOF;
		$retval = db_select("goods.name AS gname, goods.gid AS ggid, c1.name AS seller, c2.name AS buyer, goods.status AS gstatus", "goods, buy, customer AS c1, customer AS c2", "goods.status > 1 AND goods.gid=buy.gid AND buy.uid=c2.uid AND goods.sid=c1.uid");
		if ($retval->num_rows > 0) {
			echo "<span style='position:absolute;left:0px'>Name</span>\n";
			echo "<span style='position:absolute;left:250px'>Status</span>\n";
			echo "<span style='position:absolute;left:400px'>Seller</span>\n";
			echo "<span style='position:absolute;left:550px'>Buyer</span>\n";
			echo "<span style='position:absolute;left:700px'>Action</span><br><br>\n";
			while ($row = $retval->fetch_assoc()) {
				$gid = $row["ggid"];
				$gname = $row["gname"];
				$buyer = $row["buyer"];
				$seller = $row["seller"];
				echo "<a href='good_info.php?gid=$gid' target='_top' style='position:absolute;left:0px'>$gname</a>\n";
				echo "<span style='position:absolute;left:250px'>";
				switch ($row["gstatus"]) {
					case 2:
						echo "wait seller";
						break;
					case 6:
						echo "seller denyed";
						break;
					case 8:
						echo "returned";
						break;
					case 16:
						echo "deny return";
						break;
					default:
						echo "undefined";
						break;
				}
				echo "</span>\n";
				echo "<a href='../usr/personal_info.php?usrname=$seller' target='_top' style='position:absolute;left:400px'>$seller</a>\n";
				echo "<a href='../usr/personal_info.php?usrname=$buyer' target='_top' style='position:absolute;left:550px'>$buyer</a>\n";
				echo "<form action='return_good.php' method='post' style='position:relative;top:0px'>\n";
				echo "<input type='hidden' name='gid' value='$gid'>\n";
				echo "<input type='hidden' name='status' value='8'>\n";
				echo "<input type='hidden' name='url' value='return_management.php'>\n";
				echo "<input type='submit' value='return' style='position:absolute;left:700px'";
				if ($row["gstatus"] != 6) echo "disabled";
				echo ">\n";
				echo "</form>\n";
				echo "<form action='return_good.php' method='post' style='position:relative;top:0px'>\n";
				echo "<input type='hidden' name='gid' value='$gid'>\n";
				echo "<input type='hidden' name='status' value='16'>\n";
				echo "<input type='hidden' name='url' value='return_management.php'>\n";
				echo "<input type='submit' value='deny' style='position:absolute;left:800px'";
				if ($row["gstatus"] != 6) echo "disabled";
				echo ">\n";
				echo "</form><br><br>\n";
			}
		}
	}
	db_close();

?>
</div>
</body>
</html>