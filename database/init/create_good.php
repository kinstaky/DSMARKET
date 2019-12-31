<?php
	# status -5-freeze-by-admin-and-seller -4-freeze-by-admin-only -2-return -1-freeze-by-seller-only 0-normal 1-sold
	require '../connect_db.php';
	echo "connect database success\n";

	$sql =  "CREATE TABLE goods(".
			"gid INT NOT NULL AUTO_INCREMENT,".
			"name VARCHAR(128) NOT NULL,".
			"type VARCHAR(32) NOT NULL,".
			"description TEXT NOT NULL,".
			"price VARCHAR(12) NOT NULL,".
			"status TINYINT NOT NULL,".
			"sid INT NOT NULL,".
			"PRIMARY KEY (gid),".
			"FOREIGN KEY (sid) REFERENCES customer(uid) ON DELETE CASCADE".
			") ENGINE=InnoDB DEFAULT CHARSET=utf8;";
	$retval = mysqli_query($conn, $sql);
	if (!$retval) {
		die('Create table fail: ' . mysqli_error($conn));
	}
	echo "Create table success\n";
	db_close();
?>
