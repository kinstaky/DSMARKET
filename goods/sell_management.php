<!DOCTYPE html>
<?php
	session_start();
	include "../database/connect_db.php";
?>
<html>
<head>
	<meta charset="utf-8">
	<title>goods management</title>
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
			<h3> goods management </h3>
			<br>
		EOF;
		$uid = $_SESSION["uid"];
		$retval = db_select("gid, name, price, status", "goods", "sid=$uid");
		if ($retval->num_rows > 0) {
			while ($row = $retval->fetch_assoc()) {
				$gid = $row["gid"];
				echo "<a href='good_info.php?gid=".$row["gid"]."' target='_top' style='margin:10px;float:left;width:200px'>".$row["name"]."</a>\n";
				if ($row["status"] == 1) {
					$cr = db_select("name, price, time", "customer, buy", "customer.uid=buy.uid AND buy.gid=$gid");
					$crow = $cr->fetch_assoc();
					$uname = $crow["name"];
					$btime = $crow["time"];
					$bprice = $crow["price"];
					echo "<span style='width:120px;float:left;margin:10px'>".$crow["price"]."</span>\n";
					echo "<span style='position:relative;top:10px'>bought by </span>";
					echo "<a href='../usr/personal_info.php?usrname='$uname' style='position:relative;top:10px'>$uname</a>\n";
					echo "<span style='position:relative;top:10px;left:5px'> $btime</span>";
				}
				else {
					echo "<span style='width:120px;float:left;margin:10px'>".$row["price"]."</span>\n";
					echo "<form action='edit_good_info.php' method = 'get' style='margin:10px;float:left;width:90px'>\n";
					echo "	<input type='hidden' name='gid' value='".$row["gid"]."'>\n";
					echo "	<input type='submit' value='edit'";
					if ($row["status"] == 1) echo " disabled";
					echo ">\n";
					echo "</form>\n";
					echo "<form action='freeze_good.php' method = 'POST' style='margin:10px;float:left;width:100px'>\n";
					echo "	<input type='hidden' name='gid' value='".$row["gid"]."'>\n";
					echo "  <input type='hidden' name='url' value='sell_management.php'>\n";
					echo "  <input type='hidden' name='sta' value=";
					if ($row["status"] == -1) echo 0;
					else if ($row["status"] == 0) echo -1;
					echo ">\n";
					echo "	<input type='submit' value='";
					if ($row["status"] == -1) echo "un";
					echo "freeze'";
					if ($row["status"] != 0 && $row["status"] != -1) echo " disabled";
					echo ">\n";
					echo "</form>\n";
					echo "<form action='delete_good.php' method = 'POST' style='margin:10px;float:left;width:110px'>\n";
					echo "	<input type='hidden' name='gid' value='".$row["gid"]."'>\n";
					echo "  <input type='hidden' name='url' value='sell_management.php'>\n";
					echo "	<input type='submit' value='delete'";
					if ($row["status"] == 1) echo " disabled";
					echo ">\n";
					echo "</form>\n";
				}
				echo "<br><br><br>\n";
			}
		}
		echo "<form action='new_good.php' style='float:left'>\n";
		echo "<input type='submit' value='add' style='float:left'>\n";
		echo "</form>\n";
	}
	db_close();

?>
</div>
</body>
</html>