<!DOCTYPE html>
<?php
	session_start();
	include "../database/connect_db.php";
?>
<html>
<head>
	<meta charset="utf-8">
	<title>check seller</title>
	<style> a {text-decoration:none} </style>
	<!-- <author>kinstaky</author> -->
</head>

<body>
<?php include "../div/top_menu.php"; ?>
<div id='blank' style='margin:auto;width:800px;height:150px'></div>
<div id='container' style='margin:auto;width:800px'>
<?php
	if (isset($_SESSION["status"]) && $_SESSION["status"] < 2) {
		$ret_val = db_select("name", "customer", "status=1");
		while ($row = $retval->fetch_assoc()) {
			echo "<a href='personal_info.php?usrname='".$row["name"]."' target='_top' style='margin:10px;float:left'>".$row["name"]."</a>\n";
			echo "<form action='update_seller.php' method = 'POST' style='margin:10px;float:left'>\n";
			echo "	<input type='hidden' name='act' value='".$row["name"]."'>\n";
			echo "	<input type='submit' value='approve'>\n";
			echo "</form><br><br><br>\n";
		}
	}
?>
</div>
</body>
</html>
