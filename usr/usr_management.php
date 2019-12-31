<!DOCTYPE html>
<?php
	session_start();
	include "../database/connect_db.php";
?>
<html>
<head>
	<meta charset="utf-8">
	<title>user management</title>
	<style> a {text-decoration:none} </style>
	<!-- <author>kinstaky</author> -->
</head>

<body>
<?php include "../div/top_menu.php" ?>
<div id='blank' style='margin:auto;width:800px;height:150px'></div>
<div id="container" style='margin:auto;width:800px'>
<?php
	if (!isset($_SESSION["status"]) || ($_SESSION["status"]!=1 && $_SESSION["status"]!=0)) {
		echo "Error page\n";
		exit;
	}
	echo "<h3> user management </h3><br>\n";
	$retval = db_select2("name, status", "customer ORDER BY name");
	if ($retval->num_rows > 0) {
		while ($row = $retval->fetch_assoc()) {
			echo "<a href='personal_info.php?usrname=".$row["name"]."' target='_top' style='margin:10px;float:left;width:200px;'>".$row["name"]."</a>\n";
			echo "<form action='freeze_usr.php' method = 'POST' style='margin:10px;float:left;width:110px'>\n";
			echo "	<input type='hidden' name='act' value='".$row["name"]."'>\n";
			echo "  <input type='hidden' name='grade' value=0>\n";
			echo "	<input type='submit' value='degrade'";
			if ($row["status"] != 2) echo " disabled";
			echo ">\n";
			echo "</form>\n";
			echo "<form action='freeze_usr.php' method = 'POST' style='margin:10px;float:left;width:100px'>\n";
			echo "	<input type='hidden' name='act' value='".$row["name"]."'>\n";
			echo "  <input type='hidden' name='grade' value=";
			switch ($row["status"]) {
				case -2:
					echo "2";
					break;
				case -1:
					echo "0";
					break;
				case 2:
					echo "-2";
					break;
				default:
					echo "-1";
			}
			echo ">\n";
			echo "	<input type='submit' value='";
			if ($row["status"] < 0) echo "un";
			echo "freeze'>\n";
			echo "</form>\n";
			echo "<form action='delete_usr.php' method = 'POST' style='margin:10px;float:left;width:110px'>\n";
			echo "	<input type='hidden' name='act' value='".$row["name"]."'>\n";
			echo "	<input type='submit' value='delete'>\n";
			echo "</form><br><br><br>\n";
		}
	}
	db_close();
?>
</div>
</body>
</html>