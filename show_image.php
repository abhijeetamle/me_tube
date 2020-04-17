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
$image_caption = '';

// msg - image_url input

$verifySql = "SELECT * FROM VIDEO_LIST WHERE video_url = '" .$msg."'";
$resultPass = mysqli_query($mysqli, $verifySql);
if (mysqli_num_rows($resultPass) == 1) {

    $row = mysqli_fetch_assoc($resultPass);

    $userid = $userid.$row["user_id"];
    $mediatype = $mediatype.$row["file_type"];
    $filename = $filename.$row["file_name"];
    $image_caption = $image_caption.$row["caption"];
}



$show_image_path = 'uploads/'.$userid.'/'.$mediatype.'/'.$filename;


//$show_image_path = $image_path.$image_filename;

//echo $show_image_path;
?>

<html lang = "en">
  <head>
  <title><?php echo $image_caption?></title>
</head>
<body>

<p>
<img src=<?php echo $show_image_path?> alt=<?php echo $image_caption?> width="900" height="500">  
</image>
</p>
<p1><?php echo $image_caption?></p1>

</body>
</html>
