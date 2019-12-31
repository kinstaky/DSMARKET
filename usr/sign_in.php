<!DOCTYPE html>
<?php
	session_start();
?>
<html>
<head>
	<meta charset="utf-8">
	<title>Sign in page</title>
	<style> a {text-decoration:none} </style>
	<!-- <author>kinstaky</author> -->
</head>

<body>
<?php include "../div/top_menu.php";?>
<div id="blank" style="width:800px;height:100px;margin:auto">
</div>
<div id="container" style="width:800px;margin:auto">
	<form action="check_usr.php" method="post">
		Username<br/>
		<input type="text" name="user"><br/>
		Password<br/>
		<input type="password" name="pwd"><br/>
		<br/>
		<input type="submit" value="Sign in">
	</form>
</div>
</body>
</html>