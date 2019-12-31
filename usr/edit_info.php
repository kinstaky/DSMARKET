<!DOCTYPE html>
<?php
	session_start();
	require "../database/connect_db.php";
	if (!isset($_SERVER["REQUEST_METHOD"]) || $_SERVER["REQUEST_METHOD"] != 'POST') {
		echo "Not post\n";
		exit;
	}
	if (!isset($_POST["usrname"])) {
		echo "Not set post parameter.\n";
		exit;
	}
	$usrname = $_POST["usrname"];
	$retval = db_select("name, birthday, sex, Email, phone", "customer", "name='$usrname'");
	GLOBAL $row;
	if ($retval->num_rows > 0) {
		$row = $retval->fetch_assoc();
	}
	else echo "sql not find $usrname";
	$bir_s = $row["birthday"];
	$pos = strpos($bir_s, '-');
	$year = substr($bir_s, 0, $pos);
	$day = substr($bir_s, $pos+1, strlen($bir_s));
	$pos = strpos($day, '-');
	$month = substr($day, 0, $pos);
	$day = substr($day, $pos+1, strlen($day));
?>
<html>
<head>
	<meta charset="utf-8">
	<title>Edit information</title>
	<style> a {text-decoration:none} </style>
	<!-- <author>kinstaky</author> -->
</head>
<body>
<?php include "../div/top_menu.php";?>
<div id="blank" style="height:100px">
</div>
<div id="container" style="width:800px;margin:auto">
	<h3> edit personal information </h3>
	<br>
	<form action="edit_customer.php" method="post">
		<input type='hidden' name='usrname' required='required' value=<?php echo "'$usrname'";?> >
		Birthday<br>
		<input type="text" name="birthday_y" style="margin:2px" size="5" <?php echo "value='$year'";?> required='required'>
		year
		<input type="text" name="birthday_m" style="margin:2px" size="3" <?php echo "value='$month'";?> required='required'>
		month
		<input type="text" name="birthday_d" style="margin:2px" size="3" <?php echo "value='$day'";?> required='required'>
		day<br>
		Sex<br>
		<input type="radio" name="sex" value="MALE" <?php if (!$row["sex"]) echo "checked='checked'";?> >Male
		<input type="radio" name="sex" value="FEMALE" <?php if ($row["sex"]) echo "checked='checked'";?> >Female<br>
		Email<br>
		<input type="text" name="Email" <?php echo "value='".$row["Email"]."'";?> required='required'><br>
		Phone<br>
		<input type="text" name="phone" <?php echo "value='".$row["phone"]."'";?> required='required'><br><br>
		<input type="submit" value="save"><br>
	</form><br>
	<?php
		if (isset($_SESSION["edit_cus_error"])) {
			echo "<div style='color:#ff0000'>";
			switch ($_SESSION["edit_cus_error"]) {
				case 1:
					echo "Invalid birthday";
					break;
				case 2:
					echo "Invalid Email";
					break;
				case 3:
					echo "Invalid phone";
					break;
				default:
					echo "Undefined error";
			}
			echo "</div>";
		}
		unset($_SESSION["edit_cus_error"]);
	?>
</div>
</body>
</html>