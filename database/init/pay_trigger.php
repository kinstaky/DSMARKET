<?php
	require '../connect_db.php';
	echo "connect database success\n";

	$sql =  "CREATE TRIGGER pay_trigger BEFORE INSERT ON buy FOR EACH ROW ".
			"BEGIN ".
			"UPDATE goods SET status=1 WHERE new.gid=goods.gid;".
			"DELETE FROM carts WHERE new.gid=carts.gid AND new.uid=carts.uid;".
			"END";
	$retval = mysqli_query($conn, $sql);
	if (!$retval) {
		die('Create trigger fail: ' . mysqli_error($conn));
	}
	echo "Create trigger success\n";
	db_close();
?>
