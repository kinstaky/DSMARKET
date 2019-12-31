<?php
	# status 0-buyer_only 1-uncheck seller 2-seller -1-frozen_buyer -2-froze_seller
	# sex 0-MALE 1-FEMALE
	require '/var/www/html/database/connect_db.php';
	echo "connect database success\n";

	$sql =  "CREATE TABLE customer(".
			"uid INT NOT NULL AUTO_INCREMENT,".
			"name VARCHAR(100) NOT NULL,".
			"password TEXT NOT NULL,".
			"birthday DATE NOT NULL,".
			"sex TINYINT NOT NULL,".
			"Email VARCHAR(100) NOT NULL,".
			"phone CHAR(16) NOT NULL,".
			"status TINYINT NOT NULL,".
			"PRIMARY KEY (uid)".
			") ENGINE=InnoDB DEFAULT CHARSET=utf8;";
	$retval = mysqli_query($conn, $sql);
	if (!$retval) {
		die('Create table fail: ' . mysqli_error($conn));
	}
	echo "Create table success\n";
	mysqli_close($conn);

?>
