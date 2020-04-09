<?php
function connect_db(){
	global $mysqli;
	$servername = "mysql1.cs.clemson.edu";
	$user = 'SYSADM';
	$password = 'passteam@g7';
	$database = 'TEAM_G7_goky';
	$port = 3306;
	$mysqli = new mysqli($servername, $user, $password, $database, $port);

	if ($mysqli->connect_error) {
		die('Connect Error (' . $mysqli->connect_errno . ') '
				. $mysqli->connect_error);
	}
}

function close_db_connection(){
	//echo 'Closing connection';
	$mysqli->close();
}

?>
