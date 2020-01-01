<?php
	require '../connect_db.php';
	echo "connect database success\n";

	$sql =  "CREATE TABLE goodimage(".
			"iid INT NOT NULL AUTO_INCREMENT,".
			"gid INT NOT NULL,".
			"name TEXT NOT NULL,".
			"PRIMARY KEY (iid),".
			"FOREIGN KEY (gid) REFERENCES goods(gid) ON DELETE CASCADE".
			") ENGINE=InnoDB DEFAULT CHARSET=utf8;";
	$retval = mysqli_query($conn, $sql);
	if (!$retval) {
		die('Create table fail: ' . mysqli_error($conn));
	}
	echo "Create table success\n";
	db_close();
?>
