<!DOCTYPE html>
<?php
	session_start();
	require "../database/connect_db.php";
	if (!isset($_SERVER["REQUEST_METHOD"]) || $_SERVER["REQUEST_METHOD"] != 'GET') {
		echo "Not get\n";
		exit;
	}
	if (!isset($_GET["gid"])) {
		echo "Not set get parameter.\n";
		exit;
	}
	$gid = $_GET["gid"];
	$retval = db_select("name, type, price, description, imgsrc", "goods", "gid=$gid");
	GLOBAL $row;
	if ($retval->num_rows > 0) {
		$row = $retval->fetch_assoc();
	}
	else echo "sql not find gid=$gid";
	$gname = $row["name"];
	$gtype = $row["type"];
	$gprice = $row["price"];
	$gdesc = $row["description"];
	$fname = $row["imgsrc"];
?>
<html>
<head>
	<meta charset="utf-8">
	<title>Edit good information</title>
	<style> a {text-decoration:none} </style>
	<!-- <author>kinstaky</author> -->

	<!-- script below copy from https://blog.csdn.net/jackfrued/article/details/8967667 -->
    <script type="text/javascript">

        function showPreview(source) {
            var file = source.files[0];
            if(window.FileReader) {
                var fr = new FileReader();
                fr.onloadend = function(e) {
                    document.getElementById("portrait").src = e.target.result;
                };
                fr.readAsDataURL(file);
            }
        }
    </script>

</head>
<body>
<?php include "../div/top_menu.php";?>
<div id="blank" style="height:100px">
</div>
<div id="container" style="width:800px;margin:auto">
	<h3> edit good information </h3>
	<br>
	<div id='edit_img' style='width:400px;height:500px;float:left;outline-width:1px'>
		<div id='img' style='margin-bottom:20px;width:400px;height:400px;float:left;outline-width:1px;outline-style:solid;outline-color:#99ff66'>
			<img id="portrait" src=<?php echo "'../files/img/$fname'";?> width='400' height="400" alt='select img'>
		</div>
		<input form='edit_good' type='file' name='file' id='file' onchange="showPreview(this)" accept='image/jpeg, image/gif, image/jpg, image/pjpeg, image/x-png, image/png'>
	</div>
	<div id='edit_text' style='width:400px;position:relative;left:50px;float:left'>
		<form id='edit_good' action="edit_good.php" method="post" enctype="multipart/form-data">
			<input type='hidden' name='gid' required='required' value=<?php echo "'$gid'"; ?>>
			Name<br>
			<input type="text" name="gname" <?php echo "value='$gname'";?> required='required'><br><br>
			Type<br>
			<input type="text" name="gtype" <?php echo "value='$gtype'";?> required='required'><br><br>
			price<br>
			<input type="text" name="gprice" <?php echo "value='$gprice'";?> required='required'><br><br>
			Description<br>
			<textarea name='gdesc' rows=10 cols=50 style='font-size:20px' required='required'><?php echo $gdesc;?> </textarea><br><br>
			<input type="submit" value="confirm">
		</form><br>
		<?php
			if (isset($_SESSION["edit_good_error"])) {
				echo "<div style='color:#ff0000'>";
				switch ($_SESSION["edit_good_error"]) {
					case 1:
						echo "Invalid name";
						break;
					case 2:
						echo "Invalid type";
						break;
					case 3:
						echo "Invalid price";
						break;
					case 4:
						echo "Invalid description";
						break;
					case 6:
						echo "Invalid file type";
						break;
					case 7:
						echo "File too big";
						break;
					case 8:
						echo "Upload file error";
						break;
					default:
						echo "Undefined error";
				}
				echo "</div>";
			}
			unset($_SESSION["edit_good_error"]);
		?>
	</div>
</div>
</body>
</html>