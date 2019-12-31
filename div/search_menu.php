<?php
	echo <<<EOF
		<div id='blank' style='margin:auto;width:800px;height:50px'> </div>
		<div id='search_part' style='margin:auto;width:800px;height:230px'>
			<div id='logo' style='margin:auto;width:145px;height:145px;float:left;border-width:10px;border-style:solid;border-color:#73AD21';>
				<div style='margin:auto;width:100%;text-align:center;font-size:80px'> DS<br></div>
				<div style='margin:auto;text-align:center;width:100%;font-size:30px'>MARKET<br> </div>
			</div>
			<form id='search' style='width:600px;float:right;height:170px;line-height:150px' action='../index.php' method='GET'>
				<input type='text' name='keyword' style='width:400px;'>
				<input type='submit' value='search' style='font-size:20px'>
			</form>
		</div>
	EOF;
?>