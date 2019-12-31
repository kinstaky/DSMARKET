<!DOCTYPE html>
<?php
	session_start();
	$_SESSION["usrname"];
	$_SESSION["status"];
	$_SESSION["uid"];
	include "database/connect_db.php";
?>
<html>
<head>
	<meta charset="utf-8">
	<title>Second hand market</title>
	<style> a {text-decoration:none} </style>
	<!-- <author>kinstaky</author> -->
</head>

<body>
<div id="container">
	<?php include "div/top_menu.php";?>
	<?php include "div/search_menu.php";?>
	<?php include "div/view_goods.php";?>
</div>
</body>
</html>