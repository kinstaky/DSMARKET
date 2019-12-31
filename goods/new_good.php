<!DOCTYPE html>
<?php
	session_start();
	include "../database/connect_db.php";
?>
<html>
<head>
	<meta charset="utf-8">
	<title>Add goods</title>
	<style> a {text-decoration:none} </style>
	<!-- <author>kinstaky</author> -->
</head>
<body>
<?php include "../div/top_menu.php";?>
<div id="blank" style="height:100px">
</div>
<div id="container" style="width:800px;margin:auto">
	<form action="add_good.php" method="post">
		Name<br/>
		<input type="text" name="name" <?php
											if (isset($_SESSION["good_name"])) {
												$name=$_SESSION["good_name"];
												echo "value='$name'";
												unset($_SESSION["good_name"]);
											}
										?>
										required='required'><br/>
		Type<br>
		<input type="text" name="type" style="margin:2px"  <?php
																if (isset($_SESSION["good_type"])) {
																	$type = $_SESSION["good_type"];
																	echo "value='$type'";
																	unset($_SESSION["good_type"]);
																}
															?> required='required'><br>
		Price<br>
		<input type="text" name="price" style="margin:2px"  <?php
																if (isset($_SESSION["good_price"])) {
																	$price = $_SESSION["good_price"];
																	echo "value='$price'";
																	unset($_SESSION["good_price"]);
																}
															?> required='required'><br>
		Description<br>
		<textarea name="desc" rows=10 cols=50 style='font-size:20px' required='required'><?php
																		if (isset($_SESSION["good_desc"])) {
																			$desc = $_SESSION["good_desc"];
																			echo "value='$desc'";
																			unset($_SESSION["good_desc"]);
																		}?></textarea><br><br>
		<input type="submit" value="Confirm"><br>
	</form><br>
	<?php
		if (isset($_SESSION["add_good_error"])) {
			echo "<div style='color:#ff0000'>";
			switch ($_SESSION["add_good_error"]) {
				case 1:
					echo "fill all";
					break;
				case 2:
					echo "invalid price";
					break;
				default:
					echo "Undefined error";
			}
			echo "</div>";
		}
		unset($_SESSION["add_good_error"]);
	?>
</div>
</body>
</html>