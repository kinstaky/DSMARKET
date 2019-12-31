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
	if ($_SESSION["status"] < 2) {
		echo <<<EOF
			<h3> goods management </h3>
			<br>
		EOF;
		$retval = db_select2("name, gid, status, price", "goods");
		if ($retval->num_rows > 0) {
			echo "<span style='position:absolute;left:0px'>Name</span>\n";
			echo "<span style='position:absolute;left:250px'>Status</span>\n";
			echo "<span style='position:absolute;left:400px'>Price</span>\n";
			echo "<span style='position:absolute;left:550px'>Action</span><br><br>\n";
			while ($row = $retval->fetch_assoc()) {
				$gid = $row["gid"];
				$gname = $row["name"];
				$gprice = $row["price"];
				if ($row["status"] == 1) $gsta = "sold";
				else if ($row["status"] == 0) $gsta = "selling";
				else if ($row["status"] == -1 || $row["status"] == -4 || $row["status"] == -5) $gsta = "frozen";
				else if ($row["status"] == -2) $gsta = "returned";
				else $gsta = "error";

				echo "<a href='good_info.php?gid=$gid' target='_top'>$gname</a>\n";

				echo "<span style='position:absolute;left:250px'>$gsta</span>\n";

				echo "<span style='position:absolute;left:400px;color:#ff0000'>$gprice</span>\n";

				echo "<form action='freeze_good.php' method = 'POST' style='position:relative;top:-25px'>\n";
				echo "	<input type='hidden' name='gid' value='$gid'>\n";
				echo "  <input type='hidden' name='url' value='good_management.php'>\n";
				echo "  <input type='hidden' name='sta' value=";
				if ($row["status"] == -5) echo -1;
				else if ($row["status"] == -4) echo 0;
				else if ($row["status"] == -1) echo -5;
				else if ($row["status"] == 0) echo -4;
				else echo -3;
				echo ">\n";
				echo "	<input type='submit' style='position:relative;left:550px' value='";
				if ($row["status"] ==-5 || $row["status"] == -4) echo "un";
				echo "freeze'";
				if ($row["status"] == -2 || $row["status"] == 1) echo " disabled";
				echo ">\n";
				echo "</form>\n";

				echo "<form action='delete_good.php' method = 'POST' style='position:relative;top:-54px'>\n";
				echo "	<input type='hidden' name='gid' value='".$row["gid"]."'>\n";
				echo "  <input type='hidden' name='url' value='good_management.php'>\n";
				echo "	<input type='submit' style='position:absolute;left:700px' value='delete'";
				if ($row["status"] == 1) echo " disabled";
				echo ">\n";
				echo "</form><br><br>\n";
			}
		}
	}
	else echo "Error page!\n";
	db_close();

?>
</div>
</body>
</html>