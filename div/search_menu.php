<?php
	if (isset($_GET["keyword"])) $keyword = $_GET["keyword"];
	else $keyword ="";
	echo <<<EOF
		<div id='blank' style='margin:auto;width:800px;height:50px'> </div>
		<div id='search_part' style='margin:auto;width:800px;height:230px'>
			<div id='logo' style='margin:auto;width:145px;height:145px;float:left;border-width:10px;border-style:solid;border-color:#73AD21';>
				<div style='margin:auto;width:100%;text-align:center;font-size:80px'> DS<br></div>
				<div style='margin:auto;text-align:center;width:100%;font-size:30px'>MARKET<br> </div>
			</div>
			<div id='search_part' style='width:600px;float:right;height:170px'>
			<form id='search' style='width:600px;float:right;height:170px;line-height:150px' action='../index.php' method='GET'>
				<input type='text' name='keyword' style='width:400px' value='$keyword'>
				<input type='submit' value='search' style='font-size:20px'>
			</form><br>
			<a href='../files/show_xml.php?keyword=$keyword' target='_blank' style='position:relative;top:-40px;width:500px;float:left;margin:auto;text-align:center'>Show XML</a>
			</div>
		</div>
	EOF;
?>