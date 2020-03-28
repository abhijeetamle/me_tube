<?php

session_start();

if (isset($_GET['Message'])) {
    $msg = $_GET['Message'];
    echo "<script>alert('$msg');</script>";
}

$video_path = $_SESSION['video_path'];
$video_filename = $_SESSION['video_filename'];
$video_caption = $_SESSION['caption'];

$play_video_path = $video_path.$video_filename;

//echo $play_video_path;
?>

<html lang = "en">
  <head>
  <title><?php echo $video_filename?></title>
</head>
<body>
<p2><?$php play_video_path?></p2>
<p>
<video width="800px" height="500px" controls>
  <source src=<?php echo $play_video_path?> type="video/mp4">
  <source src=<?php echo $play_video_path?> type="video/ogg">
  Your browser does not support the video tag.
</video>
</p>
<p1><?php echo $video_caption?></p1>
</body>
</html>




