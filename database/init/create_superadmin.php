<?php
	require '/var/www/html/database/connect_db.php';
	echo "connect database success\n";

	$sql =  "CREATE TABLE superadmin(".
			"sid INT NOT NULL AUTO_INCREMENT,".
			"name VARCHAR(100) NOT NULL,".
			"password TEXT NOT NULL,".
			"PRIMARY KEY (sid)".
			") ENGINE=InnoDB DEFAULT CHARSET=utf8;";
	$retval = mysqli_query($conn, $sql);
	if (!$retval) {
		die('Create table fail: ' . mysqli_error($conn));
	}
	echo "Create table success\n";

	$retval = db_insert("superadmin(name, password) ", "('superadmin', MD5('asdqwe'))");
	mysqli_close($conn);
?>