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

	<script>
	function getsum() {
		var sum = 0;
		var items = document.getElementsByName('pay[]');
		var pp = document.getElementsByName('payprice[]');
		for (var i = 0; i < items.length; ++i) {
			if (items[i].checked) {
				sum += Number(pp[i].value);
			}
		}
		document.getElementById('total').innerHTML = sum;
	}
	</script>
</head>

<body>
<?php include "../div/top_menu.php" ?>
<div id='blank' style='margin:auto;width:800px;height:150px'></div>
<div id="container" style='margin:auto;width:800px;position:relative;left:0px'>
<?php
	if ($_SESSION["status"] == 2) {
		echo <<<EOF
			<h3> cart management </h3>
			<br>
		EOF;
		$uid = $_SESSION["uid"];
		$retval = db_select("goods.name AS gname, price, goods.gid, status, cid", "goods, carts", "goods.gid=carts.gid && carts.uid=$uid");
		if ($retval->num_rows > 0) {
			echo "<span style='position:absolute;left:50px'>Name</span>\n";
			echo "<span style='position:absolute;left:250px'>Price</span>\n";
			echo "<span style='position:absolute;left:450px'>Action</span><br><br>\n";
			while ($row = $retval->fetch_assoc()) {
				$gprice = $row["price"];
				$gsta = $row["status"];
				$cid = $row["cid"];
				echo "<input form='gopay' type=checkbox name='pay[]' value='$cid' onclick='getsum()'";
				if ($gsta == 0) echo "checked='checked'>\n";
				else echo "disabled>\n";
				echo "<input form='gopay' type='hidden' name='payprice[]' value='$gprice'>\n";
				echo "<a href='good_info.php?gid=".$row["gid"]."' target='_top' style='position:absolute;left:50px'>".$row["gname"]."</a>\n";
				echo "<span style='position:absolute;left:250px'>$gprice</span>\n";
				echo "<form action='delete_cart.php' method = 'POST' style='position:relative;top:-30px'>\n";
				echo "	<input type='hidden' name='cid' value='$cid'>\n";
				echo "	<input type='submit' style='position:absolute;left:450px' value='delete'>\n";
				echo "</form><br><br>\n";
			}
			echo "<span id='total' style='position:absolute;right:10px;font-size:30px;color:#ff0000;float:right'></span><br><br><br>\n";
			echo "<form id='gopay' method='post' action='pay.php'>\n";
			echo "<input type='submit' style='float:right;font-size:40px;' value='Pay'>\n";
			echo "</form>\n";
			echo "<script>getsum()</script>\n";
		}
	}
	db_close();

?>
</div>
</body>
</html>