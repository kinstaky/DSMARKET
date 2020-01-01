<!DOCTYPE html>
<?php
	session_start();
?>
<html>
<head>
	<meta charset="utf-8">
	<title>Sign up</title>
	<style> a {text-decoration:none} </style>
	<!-- <author>kinstaky</author> -->
</head>
<body>
<?php include "../div/top_menu.php";?>
<div id="blank" style="height:100px">
</div>
<div id="container" style="width:800px;margin:auto">
	<form action="add_customer.php" method="post">
		Username<br/>
		<input type="text" name="user" <?php
											if (isset($_SESSION["cus_name"])) {
												$name=$_SESSION["cus_name"];
												echo "value='$name'";
												unset($_SESSION["cus_name"]);
											}
										?>
										required='required'><br/>
		Password<br/>
		<input type="password" name="pwd" required='required'><br/>
		Password Repeat<br/>
		<input type="password" name="rpwd" required='required'><br/>
		Birthday<br>
		<input type="date" name='birthday' required="required" <?php
																	if (isset($_SESSION["cus_birthday"])) {
																		$birthday=$_SESSION["cus_birthday"];
																		echo "value='$birthday'";
																		unset($_SESSION["cus_birthday"]);
																	}
																?>><br>
		Sex<br>
		<input type="radio" name="sex" value="MALE" <?php
														if (isset($_SESSION["cus_sex"]) && $_SESSION["cus_sex"]=="MALE")
															echo "checked='checked'";
															unset($_SESSION["cus_sex"]);
													?> >Male
		<input type="radio" name="sex" value="FEMALE" <?php
														if (isset($_SESSION["cus_sex"]) && $_SESSION["cus_sex"]=="FEMALE")
															echo "checked='checked'";
															unset($_SESSION["cus_sex"]);
													?> >Female<br>
		Email<br>
		<input type="email" name="Email" <?php
											if (isset($_SESSION["cus_email"])) {
												$mail = $_SESSION["cus_email"];
												echo "value='$mail'";
												unset($_SESSION["cus_email"]);
											}
										?> required='required'><br>
		Phone<br>
		<input type="text" name="phone" <?php
											if (isset($_SESSION["cus_phone"])) {
												$pn = $_SESSION["cus_phone"];
												echo "value='$pn'";
												unset($_SESSION["cus_phone"]);
											}
										?> required='required'><br><br>
		<input type="submit" value="Sign up"><br>
	</form><br>
	<?php
		if (isset($_SESSION["sign_up_error"])) {
			echo "<div style='color:#ff0000'>";
			switch ($_SESSION["sign_up_error"]) {
				case 1:
					echo "Fill username";
					break;
				case 2:
					echo "username exsits";
					break;
				case 3:
					echo "Fill password";
					break;
				case 4:
					echo "Fill password repeat";
					break;
				case 5:
					echo "Password different";
					break;
				case 6:
					echo "Fill birthday";
					break;
				case 7:
					echo "Invalid birthday";
					break;
				case 8:
					echo "Select sex";
					break;
				case 9:
					echo "Fill Email";
					break;
				case 10:
					echo "Invalid Email";
					break;
				case 11:
					echo "Fill phone";
					break;
				case 12:
					echo "Invalid phone";
					break;
				default:
					echo "Undefined error";
			}
			echo "</div>";
		}
		unset($_SESSION["sign_up_error"]);
	?>
</div>
</body>
</html>