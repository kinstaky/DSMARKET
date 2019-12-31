<?php
	$dbhost = 'localhost';
	$dbuser = 'market';
	$dbpwd = 'dinosaurmarket';
	$conn = mysqli_connect($dbhost, $dbuser, $dbpwd);
	if (!$conn) {
		die('Connect mysql fail: '. mysqli_error());
	}
	mysqli_select_db($conn, 'DSMARKET');

	function db_close() {
		GLOBAL $conn;
		mysqli_close($conn);
	}

	function db_select2($rows, $table) {
		$sql_rq = 'SELECT '.$rows.' FROM '.$table.';';
		return db_query($sql_rq);
	}

	function db_select($rows, $table, $cond) {
		$sql_rq = 'SELECT '.$rows.' FROM '.$table.' WHERE '.$cond.';';
		return db_query($sql_rq);
	}

	function db_insert($table, $values) {
		$sql_rq = 'INSERT INTO '.$table.' VALUES '.$values.';';
		return db_query($sql_rq);
	}

	function db_delete($table, $cond) {
		$sql_rq = 'DELETE FROM '.$table.' WHERE '.$cond.';';
		return db_query($sql_rq);
	}

	function db_query($sql_rq) {
		GLOBAL $conn;
		$retval = mysqli_query($conn, $sql_rq);
		if (!$retval) {
			die ("query fail: ".mysqli_error($conn));
		}
		return $retval;
	}

	function db_update($table, $values, $cond) {
		$sql_rq = 'UPDATE '.$table.' SET '.$values.' WHERE '.$cond.';';
		return db_query($sql_rq);
	}

	function db_update2($table, $values) {
		$sql_rq = 'UPDATE '.$table.' SET '.$values.';';
		return db_query($sql_rq);
	}

?>
