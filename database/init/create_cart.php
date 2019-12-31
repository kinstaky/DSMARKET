<?php
	require '../connect_db.php';
	echo "connect database success\n";

	$sql =  "CREATE TABLE carts(".
			"cid INT NOT NULL AUTO_INCREMENT,".
			"uid INT NOT NULL,".
			"gid INT NOT NULL,".
			"PRIMARY KEY (cid),".
			"FOREIGN KEY (uid) REFERENCES customer(uid) ON DELETE CASCADE,".
			"FOREIGN KEY (gid) REFERENCES goods(gid) ON DELETE CASCADE".
			") ENGINE=InnoDB DEFAULT CHARSET=utf8;";
	$retval = mysqli_query($conn, $sql);
	if (!$retval) {
		die('Create table fail: ' . mysqli_error($conn));
	}
	echo "Create table success\n";
	db_close();
?>
