<?php
	session_start();
	unset($_SESSION["usrname"]);
	unset($_SESSION["uid"]);
	unset($_SESSION["status"]);
	header("Location:http://localhost");
	exit;
?>