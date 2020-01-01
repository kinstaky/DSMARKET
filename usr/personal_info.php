<!DOCTYPE html>
<?php
	session_start();
	include "../database/connect_db.php";
?>
<html>
<head>
	<meta charset="utf-8">
	<title>Personal information</title>
	<style> a {text-decoration:none} </style>
	<!-- <author>kinstaky</author> -->
</head>
<body>
<?php
	include "../div/top_menu.php";
	if (isset($_GET["usrname"])) $usrname = $_GET["usrname"];
	else if (isset($_SESSION["usrname"])) $usrname = $_SESSION["usrname"];
	else {
		echo"Error: no usrname\n";
		exit;
	}
	$isadmin = 0;
	GLOBAL $row;
	$retval = db_select("name, birthday, sex, Email, phone", "customer", "name='$usrname'");
	if ($retval->num_rows > 0) {
		$row = $retval->fetch_assoc();
	}
	else if ($_SESSION["status"] == 0 || ($_SESSION["status"] == 1 && $_SESSION["usrname"] == $usrname)) {
		$retval = db_select("name", "admin", "name='$usrname'");
		if ($retval->num_rows > 0) {
			$row = $retval->fetch_assoc();
			$isadmin = 1;
		}
	}
	else echo "username not exists\n";
?>
<div id="blank" style="height:100px">
</div>
<div id='content' style='margin:auto;width:800px;position:relative;left:0px'>
	<h2> personal information </h2>
	<br>
	<span style='margin:10px 65px 10px 0px;'><b>Username</b></span> <?php echo $row["name"]; ?><br><br>
	<?php
		GLOBAL $isadmin;
		if ((!$isadmin && $_SESSION["status"]!=2) || ($_SESSION["status"]==2 && $_SESSION["usrname"]==$row["name"])) {
			echo "<b>Birthday</b><span style='position:absolute;left:160px'>".$row["birthday"]."</span><br><br>\n";
			$sexstring = $row["sex"]? "FEMALE" : "MALE";
			echo "<b>Sex</b><span style='position:absolute;left:160px'>".$sexstring."</span><br><br>\n";
			echo "<b>Email</b><span style='position:absolute;left:160px'>".$row["Email"]."</span><br><br>\n";
			echo "<b>Phone</b><span style='position:absolute;left:160px'>".$row["phone"]."</span><br><br>\n";
		}
		if ($usrname == $_SESSION["usrname"] && $_SESSION["status"] != 0) {
			if ($_SESSION["status"] == 2) {
				echo <<<EOF
					<form method='post' action='edit_info.php'>
						<input type='hidden' name='usrname' value='$usrname'>
						<input type='submit' value='edit'>
					</form>
				EOF;
				$retval = db_select("status", "customer", "name='$usrname'");
				if ($retval->num_rows > 0) {
					$row = $retval->fetch_assoc();
					if ($row["status"] == 0) {
						echo "<br><br>\n";
						echo "<form method='post' action='apply_seller.php'>\n";
						echo "<input type='hidden' name='usrname' value='$usrname'>\n";
						echo "<input type='submit' value='I want to be a seller!' style='font-size:20px'>\n";
						echo "</form>\n";
					}
				}
			}
			echo "<hr>\n";
			echo <<<EOF
				<form method='post' action='change_pwd.php'>
					<input type='hidden' name='usrname' value='$usrname'>
					<b>Old password</b>
					<input type='password' name='opwd' required='required' style='position:absolute;left:210px'><br><br>
					<b>New password</b>
					<input type='password' name='npwd' required='required' style='position:absolute;left:210px'><br><br>
					<b>New password repeat</b>
					<input type='password' name='nrpwd' required='required' style='position:absolute;left:210px'><br><br>
					<input type='submit' value='Change password' style='font-size:20px'>
				</form>
			EOF;
			if (isset($_SESSION["change_pwd_error"])) {
				echo "<span style='color:#ff0000'>\n";
				switch ($_SESSION["change_pwd_error"]) {
					case 1:
						echo "password different\n";
						break;
					case 2:
						echo "old password error\n";
						break;
					case 3:
						echo "fill all\n";
						break;
					default:
						echo "undefine error\n";
				}
				unset($_SESSION["change_pwd_error"]);
			}
		}
		if ($_SESSION["usrname"] != $usrname) {
			$retval = db_select("gid, goods.name AS gname, price, goods.status AS gsta, type", "goods, customer", "sid=uid && customer.name='$usrname'");
			if ($retval->num_rows > 0) {
				echo <<<EOF
					<hr>
					<h3>goods</h3>
					<div style='position:relative;left:0px'>
						<b>name
						<span style='position:absolute;left:200px'>type</span>
						<span style='position:absolute;left:400px'>price</span>
						<span style='position:absolute;left:600px'>status</span><br><br></b>
				EOF;
				while ($grow = $retval->fetch_assoc()) {
					$gid = $grow["gid"];
					$gname = $grow["gname"];
					$gprice = $grow["price"];
					$gtype = $grow["type"];
					$gsta = $grow["gsta"] == 0 ? "selling" : "sold";
					$gsta_color = $grow["gsta"] == 0 ? "#32CD32" : "#808080";
					echo <<<EOF
						<a href="../goods/good_info.php?gid=$gid" style='position:relative;left:0px'>$gname</a>
						<span style='position:absolute;left:200px'>$gtype</span>
						<span style='color:#ff0000;position:absolute;left:400px'>$gprice</span>
						<span style='position:absolute;left:600px;color:$gsta_color'>$gsta</span><br><br>
					EOF;
				}
				echo "</div>\n";
			}
		}
	?>
</div>
</body>
</html>