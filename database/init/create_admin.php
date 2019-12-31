<?php
	require '/var/www/html/database/connect_db.php';
	echo "connect database success\n";

	$sql =  "CREATE TABLE admin(".
			"aid INT NOT NULL AUTO_INCREMENT,".
			"name VARCHAR(100) NOT NULL,".
			"password TEXT NOT NULL,".
			"PRIMARY KEY (aid)".
			") ENGINE=InnoDB DEFAULT CHARSET=utf8;";
	$retval = mysqli_query($conn, $sql);
	if (!$retval) {
		die('Create table fail: ' . mysqli_error($conn));
	}
	echo "Create table success\n";
	mysqli_close($conn);
?>