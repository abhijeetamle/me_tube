<?php
	session_start();
	include_once 'connmysql.php';
	connect_db();
	$_SESSION['searchText'] = $_POST['search'];
  echo '<script>alert("Done setting session vars");</script>';
?>
