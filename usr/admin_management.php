<!DOCTYPE html>
<?php
	session_start();
	unset($_SESSION["add_error"]);
	include "../database/connect_db.php";
?>
<html>
<head>
	<meta charset="utf-8">
	<title>admin management</title>
	<style> a {text-decoration:none} </style>
	<!-- <author>kinstaky</author> -->
</head>

<body>
<?php include "../div/top_menu.php" ?>
<div id='blank' style='margin:auto;width:800px;height:150px'></div>
<div id="container" style='margin:auto;width:800px;position:relative;left:0px'>
<?php
	if ($_SESSION["status"] == 0) {
		echo <<<EOF
			<h3> admin management </h3>
			<br>
		EOF;
		$retval = db_select2("name", "admin");
		if ($retval->num_rows > 0) {
			while ($row = $retval->fetch_assoc()) {
				echo "<a href='personal_info.php?usrname=".$row["name"]."' target='_top' style='margin:10px;float:left'>".$row["name"]."</a>\n";
				echo "<form action='personal_info.php' method = 'GET' style='margin:10px;position:relative;top:-4px'>\n";
				echo "	<input type='hidden' name='act' value='".$row["name"]."'>\n";
				echo "	<input type='submit' value='alter' style='position:absolute;left:150px'>\n";
				echo "</form>\n";
				echo "<form action='delete_admin.php' method = 'POST' style='margin:10px;float:left;position:relative;top:-14px'>\n";
				echo "	<input type='hidden' name='act' value='".$row["name"]."'>\n";
				echo "	<input type='submit' value='delete'  style='position:absolute;left:170px'>\n";
				echo "</form><br><br><br>\n";
			}
		}
		echo "<form action='new_admin.php' style='float:left'>\n";
		echo "<input type='submit' value='add' style='float:left'>\n";
		echo "</form>\n";
	}
	else {
		echo "Error page!\n";
	}
	db_close();
?>
</div>
</body>
</html>