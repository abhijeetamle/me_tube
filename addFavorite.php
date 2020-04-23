<?php
	session_start();
	include_once 'connmysql.php';
	connect_db();
	$media_id = $_POST['media_id'];
	$userid = $_SESSION['userid'];
	$removeFromPlaylistSQL = "INSERT INTO FAVORITE_LIST (user_id, video_id) VALUES ('".$media_id."' ,'".$userid."')";
	$res = mysqli_query($mysqli, $removeFromPlaylistSQL);
	var_dump($res);
	if(! $res){
		echo '<script>alert("Sorry, coult not add this video to Favorites. Please try again later.");</script>';
	}
?>
