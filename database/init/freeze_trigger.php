<?php
	require '../connect_db.php';
	echo "connect database success\n";

	$sql =  "CREATE TRIGGER freeze_trigger AFTER UPDATE ON customer FOR EACH ROW ".
			"BEGIN ".
			"UPDATE goods SET status=-4 WHERE new.uid=goods.sid AND goods.status=0 AND new.status<2 AND old.status=2; ".
			"UPDATE goods SET status=-5 WHERE new.uid=goods.sid AND goods.status=-1 AND new.status<2 AND old.status=2; ".
			"UPDATE goods SET status=-1 WHERE new.uid=goods.sid AND goods.status=-4 AND new.status=2 AND old.status<2; ".
			"UPDATE goods SET status=-1 WHERE new.uid=goods.sid AND goods.status=-5 AND new.status=2 AND old.status<2; ".
			"END";
	$retval = mysqli_query($conn, $sql);
	if (!$retval) {
		die('Create trigger fail: ' . mysqli_error($conn));
	}
	echo "Create trigger success\n";
	db_close();
?>
