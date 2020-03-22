<?php
session_start();
include_once 'connmysql.php';
connect_db();
//include_once "function.php";

/******************************************************
*
* upload document from user
*
*******************************************************/

$username=$_SESSION['username'];
$userid=$_SESSION['userid'];


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
		echo 'File already uploaded on server, try again after changing the filename.';
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
				$insert = "insert into VIDEO_LIST (file_name, file_type, user_id) values('" .$filename. "', '" .$mediatype. "', '" .$userid. "')";
				if (mysqli_query($mysqli, $insert)) {
					echo '<script>alert("Media file uploaded successfully")</script>';
				} else {
					echo '<script>alert("Error occured while uploading media")</script>';
					//printf("Connect failed: %s\n", $mysqli->connect_error);
				}
				$result="0";
					
			}
		}
		else  
		{
				$result="7"; //upload file failed
				echo $result;
		}
	}
}
	
//You can process the error code of the $result here.

?>

