<!DOCTYPE html>
<?php
	session_start();
	include "../database/connect_db.php";
?>
<html>
<head>
	<meta charset="utf-8">
	<title>good information</title>
	<style> a {text-decoration:none} </style>
	<!-- <author>kinstaky</author> -->
</head>
<body>
<?php
	include "../div/top_menu.php";
	if (isset($_GET["gid"])) $gid = $_GET["gid"];
	else {
		echo"Error: no gid\n";
		exit;
	}
	$uid = $_SESSION["uid"];
	$isowner = 0;
	GLOBAL $row;
	$retval = db_select("sid, name, type, description, price, status", "goods", "gid=$gid");
	if ($retval->num_rows > 0) {
		$row = $retval->fetch_assoc();
		if ($row["sid"] == $_SESSION["uid"]) $isowner = 1;
		$gname = $row["name"];
		$gtype = $row["type"];
		$gdesc = $row["description"];
		$gprice = $row["price"];
		$gsta = $row["status"];
		$sid = $row["sid"];
	}
	$retval = db_select("name", "customer", "uid=$sid");
	if ($retval->num_rows > 0) {
		$row = $retval->fetch_assoc();
		$seller = $row["name"];
	}
	else {
		echo "Error page.";
		exit;
	}
	include "../div/search_menu.php";
	echo <<<EOF
		<div id='content' style='margin:auto;width:800px'>
			<div id='basic_info' style='marign:auto;width:800px;height:400px'>
			<div id='wait_for_update' style="width:400px;height:400px;float:left;outline-width:1px;outline-style:solid;outline-color:#99ff66">wait for update</div>
			<div id='good_info' style='width:400px;height:400px;float:left;position:relative;left:50px'>
				Name
				<span style='position:absolute;left:100px'>$gname</span><br><br>
				Type
				<span style='position:absolute;left:100px'>$gtype</span><br><br>
				Seller
				<a href="../usr/personal_info.php?usrname=$seller" style='position:absolute;left:100px;color:#000000'>$seller</a><br><br>
				<span style='position:relative;top:10px'>Price</span>
				<span style='position:absolute;left:100px;color:#ff0000;font-size:40px'>$gprice</span><br><br><br>
				Detail
				<span style='position:absolute;left:100px'>$gdesc</span><br><br>
	EOF;
	if ($isowner) {
		echo <<<EOF
			<form action='edit_good_info.php' method='get' style='font-size:50px'>
				<input type='hidden' name='gid' value='$gid'>
				<input type='submit' value='edit' style='font-size:40px;border-radius:3px;position:absolute;bottom:10px;right:20px;border-width:0px'>
			</form>
		EOF;
	}
	else {
		echo <<<EOF
			<form action='add_in_cart.php' method='post'>
				<input type='hidden' name='gid' value='$gid'>
		EOF;
		echo "<input type='submit' style='font-size:35px;border-radius:3px;position:absolute;bottom:10px;right:20px;border-width:0px;";
		$retval = db_select("*", "carts", "gid=$gid && uid=$uid");
		if ($gsta != 0) echo "background-color:#808080;color:#ffffff' value='sold out' disabled>\n";
		else if ($retval->num_rows > 0) echo "background-color:#808080;color:#ffffff' value='in cart' disabled>\n";
		else echo "background-color:#ff0000;color:#ffffff' value='add cart'>\n";
		echo "</from>\n";
	}
	echo "</div>\n";
	echo "</div>\n";
	//comments
	$retval = db_select("customer.name AS cname, comments.time, comment, stars", "customer, comments", "customer.uid=comments.uid AND comments.gid=$gid");
	if ($retval->num_rows > 0) {
		while ($row = $retval->fetch_assoc()) {
			$stars = $row["stars"];
			$cname = $row["cname"];
			echo "<div style='width:800px;height:150px;margin:auto'>\n";
			echo "<br><br><hr>\n";
			echo "<div name='usr_info' style='width:100px;float:left'>\n";
			echo "<a href='../usr/personal_info.php?usrname=$cname' style='margin:auto;text-align:center;font-size:25px'>".$row["cname"]."</a><br><br>\n";
			echo "<span style='margin:auto;text-align:center'>".$row["time"]."</span>\n";
			echo "</div>";
			echo "<div name='usr_comment' style='margin-left:20px;width:600px;float:left'>\n";
			echo "stars:".$row["stars"]."/5<br>\n";
			echo $row["comment"];
			echo "\n</div>\n";
			echo "</div>\n";
		}
	}
	echo "</div>\n";
?>

</div>
</body>
</html>