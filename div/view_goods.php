<?php
	if (isset($_GET["keyword"])) {
		$keyword = $_GET["keyword"];
		$retval = db_select("name, price, gid", "goods", "status=0 AND type LIKE '%$keyword%' AND (TIMESTAMPDIFF(YEAR, goods.time, NOW()) < 5)");
	}
	else $retval = db_select("name, price, gid", "goods", "status=0 AND (TIMESTAMPDIFF(YEAR, goods.time, NOW()) < 5)");
	if ($retval->num_rows > 0) {
		$n = 0;
		echo "<div style='width:800px;margin:auto;padding:5px'>\n";
		while ($row = $retval->fetch_assoc()) {
			$gid = $row["gid"];
			$price = $row["price"];
			$goodname = $row["name"];
			//$imgretval = db_select("src", "good_imgs", "gid=$gid");
			echo "<a id='good_$n' href='../goods/good_info.php?gid=$gid' target='_top' style='height:270px;width:180px;margin:10px;float:left;text-decoration:none;outline-width:1px;outline-style:solid;outline-color:#99ff66;border-width:20px;border-color:#ffffff;border-style:solid'>\n";
			// if ($imgretval->num_rows > 0) {
			// 	$imgrow = $imgsrc->fetch_assoc();
			// 	$imgsrc = $imgrow["src"];
			// 	echo "<img src='../img/imgsrc' alt='without image' width='180' height='180'>\n";
			// }
			echo "<div id='good_".$n."_wait_update' style='height:180px;width:180px;color:#000000'>wait for update</div>\n";
			echo "<div id='good_".$n."_price' style='font-size:30px;color:#ff0000'><b>$price</b></div>\n";
			echo "<div id='good_".$n."_name' style='color:#000000'>$goodname</div>\n";
			echo "</a>\n";
			$n++;
		}
		echo "</div>\n";
	}
?>