<!DOCTYPE html>
<?php
	session_start();
	include "../database/connect_db.php";
	if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"]=='POST') {
		if (!isset($_POST["user"]) || !isset($_POST["pwd"]) || !isset($_POST["rpwd"])) {
			aerror(3);
		}
		$name = $_POST["user"];
		$pwd = test_input($_POST["pwd"]);
		if (test_input($_POST["rpwd"]) != $pwd) aerror(2);
		$retval = db_select("name", "superadmin", "name='$name'");
		if ($retval->num_rows > 0) aerror(1);
		$retval = db_select("name", "admin", "name='$name'");
		if ($retval->num_rows > 0) aerror(1);
		$retval = db_insert("admin(name, password)", "('$name', MD5('$pwd'))");
		unset($_SESSION["add_error"]);
		unset($_SERVER["REQUEST_METHOD"]);
		header("Location:admin_management.php");
		exit;
	}

	function aerror($error_n) {
		$_SESSION["add_error"] = $error_n;
		unset($_SERVER["REQUEST_METHOD"]);
		header("Location:new_admin.php");
		exit;
	}

	function test_input($data) {
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}
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
	<div id="top_menu", style="width:800px;height:30px;margin:auto">
		<?php
			if (isset($_SESSION["usrname"]) && $_SESSION["status"] == 0) {
				echo "<div id='top_left_menu', style='float:left'>\n";
				echo "	<a href='admin_management.php' target='_top' style='margin:10px'> ". $_SESSION["usrname"] . " </a>\n";
				echo "	<a href='usr/sign_out.php' target='_top' style='margin:10px'> sign out </a>\n";
				echo "</div>\n";
				echo "<div id='top_right_menu', style='float:right'>\n";
				echo "	<a href='admin_management.php' target='_top' style='margin:10px'> admin </a>\n";
				echo "	<a href='usr_management.php' target='_top' style='margin:10px'> users </a>\n";
				echo "</div>\n";
				echo "</div>\n";

				echo "<div id='content', style='margin:auto;width:800px'>\n";
				echo "<form action='new_admin.php' method='post'>\n";
				echo "	Username<br/>\n";
				echo "	<input type='text' name='user' required='required'><br/>\n";
				echo "	Password<br/>\n";
				echo "	<input type='password' name='pwd' required='required'><br/>\n";
				echo "	Password Repeat<br/>\n";
				echo "	<input type='password' name='rpwd' required='required'><br/><br/>\n";
				echo "	<input type='submit' value='Add admin'>\n";
				echo "</form>\n";

				if (isset($_SESSION["add_error"])) {
					if ($_SESSION["add_error"] == 1) {
						echo "<div style='color:#ff0000'>ID exits</div>\n";
					}
					else if ($_SESSION["add_error"] == 2) {
						echo "<div style='color:#ff0000'>password different</div>\n";
					}
					else if ($_SESSION["add_error"] == 3) {
						echo "<div style='color:#ff0000'>fill all</div>\n";
					}
				}
				echo "</div>";
			}
			else {
				echo "Error page!\n";
			}

		?>
</div>
</body>
</html>