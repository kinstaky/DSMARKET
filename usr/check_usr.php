<?php
	function test_input($data) {
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}

	$name = $pwd = "";
	if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
		$name = test_input($_POST["user"]);
		$pwd = test_input($_POST["pwd"]);
		include "../database/connect_db.php";
		$retval = db_select('sid, name, password', 'superadmin', "name='$name' and password=MD5('$pwd')");
		if ($retval->num_rows>0) {
			$row = $retval->fetch_assoc();
			session_start();
			$_SESSION["usrname"] = $row["name"];
			$_SESSION["uid"] = $row["sid"];
			$_SESSION["status"] = 0;
			db_close();
			header("Location:../index.php");
			exit;
		}
		$retval = db_select("aid, name, password", "admin", "name='$name' and password=MD5('$pwd')");
		if ($retval->num_rows > 0) {
			$row = $retval->fetch_assoc();
			session_start();
			$_SESSION["usrname"] = $row["name"];
			$_SESSION["uid"] = $row["aid"];
			$_SESSION["status"] = 1;
			db_close();
			header("Location:../index.php");
			exit;
		}
		$retval = db_select("uid, name, password", "customer", "name='$name' and password=MD5('$pwd') and status>-1");
		if ($retval->num_rows > 0) {
			$row = $retval->fetch_assoc();
			session_start();
			$_SESSION["usrname"] = $row["name"];
			$_SESSION["uid"] = $row["uid"];
			$_SESSION["status"] = 2;
			db_close();
			header("Location:../index.php");
			exit;
		}
		echo "ID not exits or password wrong.";
	}
?>