<?php

session_start();
include_once 'connmysql.php';
connect_db();

if (isset($_GET['url'])) {
    $msg = $_GET['url'];
//    echo "<script>alert('$msg');</script>";
}


$userid = '';
$mediatype = '';
$filename = '';
$video_caption = '';

// msg - video_url input

$verifySql = "SELECT * FROM VIDEO_LIST WHERE video_url = '" .$msg."'";
$resultPass = mysqli_query($mysqli, $verifySql);
if (mysqli_num_rows($resultPass) == 1) {

    $row = mysqli_fetch_assoc($resultPass);

    $userid = $userid.$row["user_id"];
    $mediatype = $mediatype.$row["file_type"];
    $filename = $filename.$row["file_name"];
    $video_caption = $video_caption.$row["caption"];
}



$play_video_path = 'uploads/'.$userid.'/'.$mediatype.'/'.$filename;


//$play_video_path = $video_path.$video_filename;

//echo $play_video_path;
?>

<html lang = "en">
  <head>
  <title><?php echo $video_caption?></title>
</head>
<body>

<p>
<video width="800px" height="500px" controls>
  <source src=<?php echo $play_video_path?> type="video/mp4">
  <source src=<?php echo $play_video_path?> type="video/ogg">
  <source src=<?php echo $play_video_path?> type="video/webm">
  Your browser does not support the video tag.
</video>
</p>
<p1><?php echo $video_caption?></p1>

</body>
</html>




