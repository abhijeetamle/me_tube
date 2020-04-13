<?php
session_start();
include_once 'connmysql.php';
connect_db();

$username=$_SESSION['username'];
$userid=$_SESSION['userid'];

$video_caption = $_POST['caption'];
echo $video_caption;
echo '<br>';

$success_message = '';

// check media type
$filetype = $_FILES["file"]["type"];
$mediatype = '';
if (strpos($filetype, 'image') !== false) {
	$mediatype = $mediatype.'image';
}
elseif (strpos($filetype, 'audio') !== false) {
	$mediatype = $mediatype.'audio';
}
else {
	$mediatype = $mediatype.'video';
}

echo $mediatype;
echo '<br>';

// Directory to upload Media
$dirfile = 'uploads/'.$userid.'/'.$mediatype.'/';

echo $dirfile;
echo '<br>';

//Create Directory if doesn't exist
if(!file_exists($dirfile))
	mkdir($dirfile, 0744, true);


if($_FILES["file"]["error"] > 0 )
{ $result=$_FILES["file"]["error"];
	echo $result;} //error from 1-4
else
{
	$upfile = $dirfile.urlencode($_FILES["file"]["name"]);
//  echo $upfile;
	  
	if(file_exists($upfile))
	{
	  	$result="5"; //The file has been uploaded.
		echo 'File already uploaded on server.';
		$success_message .= 'Error! File already uploaded on server.';
	//	echo "<script>alert('$success_message');</script>";
		echo '<br>';
	}
	else{
		if(is_uploaded_file($_FILES["file"]["tmp_name"]))
		{
			if(!move_uploaded_file($_FILES["file"]["tmp_name"],$upfile))
			{
				$result="6"; //Failed to move file from temporary directory
				echo $result;
			}
			else /*Successfully upload file*/
			{
				$filename = urlencode($_FILES["file"]["name"]);
				echo $filename;
				echo '<br>';
				echo $dirfile;
				echo '<br>';
					
				echo $filetype;
				echo '<br>';
				echo $userid;
				echo '<br>';

							

				//insert into video_list table
			//	$insert = "insert into VIDEO_LIST (file_name, file_path, video_caption, user_id) values('" .$filename. "','" .$dirfile. "','" .$filepath. "','" .$userid. "')";
				$insert = "insert into VIDEO_LIST (file_name, file_type, caption, user_id) values('" .$filename. "', '" .$mediatype. "', '" .$video_caption. "', '" .$userid. "')";
				if (mysqli_query($mysqli, $insert)) {
					$_SESSION['video_path'] = $dirfile;
					$_SESSION['video_filename'] = $filename;
					$_SESSION['caption'] = $video_caption;
					echo '<br>';
			//		echo $_SESSION['play_video_path'];
					echo '<br>';
					$success_message .= "Media file uploaded successfully";
					
					echo '<br>';
					echo $success_message;
				} else {
					$success_message .= "Error! Please try again.";
				//	echo "<script>alert('$success_message');</script>";
					echo '<br>';
					echo $success_message;
					//printf("Connect failed: %s\n", $mysqli->connect_error);
				}
				$result="0";
					
			}
		}
		else  
		{
				$result="7"; //upload file failed
				$success_message .= "Error! Please try again.";
		//		echo "<script>alert('$success_message');</script>";
				echo '<br>';
				echo $success_message;
				echo $result;
		}
	}
}
	

unset($_POST['caption']);

// video uploaded successfully
if (strpos($success_message, 'successfully') !== false) {
	
	header("Location: play_video.php?Message=".urlencode($success_message));
	exit;
}
// Error while uploading
elseif (strpos($success_message, 'Error!') !== false) {
	
	header("Location: media_upload.php?Message=".urlencode($success_message));
	exit;
}
// if any error is not caught by the above conditions, then it will be redirected to home page
else {
	
	header("Location: home.php?Message=".urlencode($success_message));
	exit;
}


?>

