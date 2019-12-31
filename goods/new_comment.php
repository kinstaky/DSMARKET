<!DOCTYPE html>
<?php
	session_start();
	include "../database/connect_db.php";
	if (!isset($_SERVER["REQUEST_METHOD"]) || $_SERVER["REQUEST_METHOD"]!="GET") {
		echo "Not find get";
		exit;
	}
	$bid = $_GET["bid"];
	$retval = db_select("gid, uid", "buy", "bid=$bid");
	if ($retval->num_rows > 0) {
		$row = $retval->fetch_assoc();
		$gid = $row["gid"];
		$uid = $row["uid"];
		if ($uid != $_SESSION["uid"]) {
			echo "Error page";
			exit;
		}
	}
?>
<html>
<head>
	<meta charset="utf-8">
	<title>New comment</title>
	<style> a {text-decoration:none} </style>
	<!-- <author>kinstaky</author> -->
	<script>
		function validstars() {
			var x = document.getElementById("stars").value;
			if (isNaN(x) || x < 1 || x > 5) {
				document.getElementById("submit_error").innerHTML = "stars between 1 and 5";
				return false;
			}
			else {
				document.getElementById("submit_error").innerHTML = "";
			}
		}
	</script>
</head>
<body>
<?php include "../div/top_menu.php";?>
<div id="blank" style="height:100px">
</div>
<div id="container" style="width:800px;margin:auto">
	<form id='add_comment' action="add_comment.php" method="post" onsubmit='return validstars()'>
		<input type='hidden' name='uid' value=<?php echo "'$uid'";?>>
		<input type='hidden' name='gid' value=<?php echo "'$gid'";?>>
		Stars<br>
		<input id="stars" type="text" name="stars" size='1' required='required'>/5<br/>
		Comment<br>
		<textarea form='add_comment' cols='80' rows='20' name='comment' style='font-size:18px' required="required"><?php if (isset($_SESSION["comment"])) echo $_SESSION["comment"];?></textarea><br><br>
		<input type='submit' value='confirm'><br>
	</form><br>
	<p id='submit_error' style='color:#ff0000'></p>
</div>
</body>
</html>