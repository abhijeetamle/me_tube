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
$audio_caption = '';

// msg - audio_url input

$verifySql = "SELECT * FROM VIDEO_LIST WHERE video_url = '" .$msg."'";
$resultPass = mysqli_query($mysqli, $verifySql);
if (mysqli_num_rows($resultPass) == 1) {

    $row = mysqli_fetch_assoc($resultPass);

    $userid = $userid.$row["user_id"];
    $mediatype = $mediatype.$row["file_type"];
    $filename = $filename.$row["file_name"];
    $audio_caption = $audio_caption.$row["caption"];
}



$play_audio_path = 'uploads/'.$userid.'/'.$mediatype.'/'.$filename;


//$play_audio_path = $audio_path.$audio_filename;

//echo $play_audio_path;
?>

<html lang = "en">
  <head>
  <title><?php echo $audio_caption?></title>
</head>
<body>

<p>
<audio width="800px" height="500px" controls>
  <source src=<?php echo $play_audio_path?> type="audio/ogg">
  <source src=<?php echo $play_audio_path?> type="audio/mpeg">
  <source src=<?php echo $play_audio_path?> type="audio/wav">
  Your browser does not support the audio tag.
</audio>
</p>
<p1><?php echo $audio_caption?></p1>

</body>
</html>




