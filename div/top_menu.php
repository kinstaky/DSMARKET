<?php
	echo "<div id='top_menu', style='width:850px;height:30px;margin:auto'>\n";
		if (isset($_SESSION["usrname"])) {
			echo "<div id='top_left_menu', style='float:left'>\n";
			if ($_SESSION["status"] == 0) {
				#superadmin
				echo "	<a href='../usr/admin_management.php' target='_top' style='margin:10px;text-decoration:none'>". $_SESSION["usrname"] . "</a>\n";
			}
			#customer or admin
			else echo "	<a href='../usr/personal_info.php' target='_top' style='margin:10px;text-decoration:none'>". $_SESSION["usrname"] . "</a>\n";
			echo "	<a href='../usr/sign_out.php' target='_top' style='margin:10px;text-decoration:none'>sign out</a>\n";
			echo "</div>\n";

			#top_right
			echo "<div id='top_right_menu', style='float:right'>\n";
			if (!isset($_SESSION["status"])) {
				echo "	<a href='../usr/sign_in.php' target='_top' style='margin:10px;text-decoration:none'>cart(0)</a>\n";
			}
			#admin
			else if ($_SESSION["status"] < 2) {
				echo "<a href='../goods/buy_management.php' target='_top' style='margin:8px;text-decoration:none'>buy</a>\n";
				echo "<a href='../goods/good_management.php' target='_top' style='margin:8px;text-decoration:none'>goods</a>\n";
				if ($_SESSION["status"] == 0) echo "<a href='../usr/admin_management.php' target='_top' style='margin:8px;text-decoration:none'>admin</a>\n";
				$retval = db_select("name", "customer", "status=1");
				$nrow = $retval->num_rows;
				echo "<a href='../usr/usr_management.php' target='_top' style='margin:8px;text-decoration:none'>users</a>\n";
				echo "<a href='../usr/check_seller.php' target='_top' style='margin:8px;text-decoration:none'>check";
				if ($nrow > 0) echo "($nrow)";
				echo "</a>\n";
			}
			#customer
			else  {
				$usrname = $_SESSION["usrname"];
				$uid = $_SESSION["uid"];
				$retval = db_select("name", "customer", "name='$usrname' && status=2");
				if ($retval->num_rows > 0) echo "<a href='../goods/sell_management.php' target='_top' style='margin:10px;text-decoration:none'>sell()</a>\n";
				$retval = db_select("*", "carts, goods", "carts.uid=$uid AND goods.gid=carts.gid AND goods.status=0");
				$cartn = $retval->num_rows;
				echo "<a href='../goods/cart_management.php' target='_top' style='margin:10px;text-decoration:none'>cart($cartn)</a>\n";
				echo "<a href='../goods/buy_management.php' target='_top' style='margin:10px'>buy</a>\n";
			}
			echo "</div>\n";

			echo "<div id='top_center_menu', style='width:50px;margin:auto'>\n";
			echo "<a href='../index.php' target='_top' style='text-decoration:none'>Home</a>\n";
			echo "</div>\n";
		}
		else {
			echo <<<EOF
				<div id="top_left_menu", style="float:left">
					<a href="../usr/sign_in.php" target="_top" style="margin:10px;text-decoration:none">sign in</a>
					<a href="../usr/sign_up.php" target="_top" style="margin:10px;text-decoration:none">sign up</a>
				</div>
				<div id="top_center_menu", style="width:50px;margin:auto">
					<a href="../index.php" target="_top" style="text-decoration:none">Home</a>
				</div>
			EOF;
		}
	echo "</div>\n";

?>