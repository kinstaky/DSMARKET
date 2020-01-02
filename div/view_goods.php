<?php
	if (isset($_GET["keyword"])) {
		$keyword = $_GET["keyword"];
		$retval = db_select("name, price, gid, imgsrc", "goods", "status=0 AND (type LIKE '%$keyword%' OR name LIKE '%$keyword%') AND (TIMESTAMPDIFF(YEAR, goods.time, NOW()) < 5) ORDER BY time DESC");
	}
	else $retval = db_select("name, price, gid, imgsrc", "goods", "status=0 AND (TIMESTAMPDIFF(YEAR, goods.time, NOW()) < 5) ORDER BY time DESC");
	if ($retval->num_rows > 0) {
		$n = 0;
		echo "<div style='width:850px;margin:auto;padding:5px'>\n";
		while ($row = $retval->fetch_assoc()) {
			$gid = $row["gid"];
			$price = $row["price"];
			$goodname = $row["name"];
			$fname = $row["imgsrc"];
			echo "<a id='good_$n' href='../goods/good_info.php?gid=$gid' target='_top' style='height:240px;width:150px;margin:10px;float:left;text-decoration:none;outline-width:1px;outline-style:solid;outline-color:#99ff66;border-width:20px;border-color:#ffffff;border-style:solid'>\n";
			echo "<img src='../files/img/$fname' alt='image not found' width='150' height='150'>\n";
			//echo "<div id='good_".$n."_wait_update' style='height:180px;width:180px;color:#000000'>wait for update</div>\n";
			echo "<div id='good_".$n."_price' style='font-size:30px;color:#ff0000'><b>$price</b></div>\n";
			echo "<div id='good_".$n."_name' style='color:#000000'>$goodname</div>\n";
			echo "</a>\n";
			$n++;
		}
		echo "</div>\n";
	}
?>