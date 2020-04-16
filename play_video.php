<html>
  <head>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="MeTubeStyle.css" />
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
$rating = '';
$views = '';
$rated_by = '';

// msg - video_url input

$verifySql = "SELECT * FROM VIDEO_LIST WHERE video_url = '" .$msg."'";
$resultPass = mysqli_query($mysqli, $verifySql);
if (mysqli_num_rows($resultPass) == 1) {

    $row = mysqli_fetch_assoc($resultPass);

    $userid = $userid.$row["user_id"];
    $mediatype = $mediatype.$row["file_type"];
    $filename = $filename.$row["file_name"];
    $video_caption = $video_caption.$row["caption"];
    $views = $views.$row["view_count"];
    $rating = $rating.$row["rating"];
    $rated_by = $rated_by.$row["rated_by"];
    
    
}

$views = $views+1;
$add_view_sql = "UPDATE VIDEO_LIST SET view_count = '".$views."' WHERE video_url = '" .$msg."'";
$view_add_sql = mysqli_query($mysqli, $add_view_sql);



$play_video_path = 'uploads/'.$userid.'/'.$mediatype.'/'.$filename;


//$play_video_path = $video_path.$video_filename;

//echo $play_video_path;


// rounding off the rating value to int 
$rating_int = round($rating);

if ($rating_int == 2){
	$rating_int = 4;
}
else if ($rating_int == 1){
	$rating_int = 5;
}
else if ($rating_int == 4){
	$rating_int = 2;
}
else if ($rating_int == 5){
	$rating_int = 1;
}
else if ($rating_int == 3){
	$rating_int = 3;
}
else {
	$rating_int = 4;
}

?>

<title><?php echo $video_caption?></title>

<style>

.w3-container {
    margin-left  : 120px;
    margin-right : 16px;
    margin-top   : 16px;
    margin-bottom: 16px;
}

hr {
    margin-top: 1%; 
    margin-bottom: 1%;
}

</style>

  </head>
<body>



<?php
// Rating 
if (isset($_POST['rate_btn'])) {

    $selected_rating = $_POST['rating'];
    $rating_int = $selected_rating;

    if ($selected_rating == 2){
        $selected_rating = 4;
    }
    else if ($selected_rating == 1){
        $selected_rating = 5;
    }
    else if ($selected_rating == 4){
        $selected_rating = 2;
    }
    else if ($selected_rating == 5){
        $selected_rating = 1;
    }
    else if ($selected_rating == 3){
        $selected_rating = 3;
    }
    else {
        $selected_rating = 4;
    }


    $updateRating = "call rate_media('".$msg."', '".$selected_rating."')";

    if (mysqli_query($mysqli, $updateRating)) {
    
        echo '<script>alert("Media rated successfully.")</script>';
    } 
    else {
        echo '<script>alert("Error occured while rating media. Please try again.")</script>';
    }


  //  echo '<script>alert("'.$selected_rating.'")</script>';
    
    }

// Comment
if (isset($_POST['comment_btn'])) {

    echo '<script>alert("Inside comment_btn php.")</script>';
    
    }

// Download
if (isset($_POST['download_btn'])) {

    echo '<script>alert("Inside download_btn php.")</script>';
//    echo "<a href=$play_video_path download></a>";
    //echo $play_video_path;
    
    }

?>


<div class="w3-container"> 


<p>
<video width="800px" height="500px" style="margin: 0 auto; border: 5px solid #ddd;" controls>
  <source src=<?php echo $play_video_path?> type="video/mp4">
  <source src=<?php echo $play_video_path?> type="video/ogg">
  <source src=<?php echo $play_video_path?> type="video/webm">
  Your browser does not support the video tag.
</video>
</p>
<p style="font-size:22px;"><?php echo $video_caption?></p>



<p>
<a href=<?php echo $play_video_path ?> download>
<button class="btnDownload" id="download_btn" name="download_btn"><i class="fa fa-download"></i>Download</button>
</a>
<small style="font-size:15px; margin-left: 10px; vertical-align:center;"><?php echo $views?> views</small>

</p>

<form method="post">

<hr align="left" width="800px">

<textarea rows="2" cols="50" name="comment" form="usrform" placeholder="Enter your comment"></textarea>

<span style="margin-left: 25px;" class="starRating">
  <input id="rating1" type="radio" name="rating" value="1"  <?php echo ($rating_int=='1')?'checked':'' ?>>
  <label for="rating1">1</label>
  <input id="rating2" type="radio" name="rating" value="2"  <?php echo ($rating_int=='2')?'checked':'' ?>>
  <label for="rating2">2</label>
  <input id="rating3" type="radio" name="rating" value="3"  <?php echo ($rating_int=='3')?'checked':'' ?>>
  <label for="rating3">3</label>
  <input id="rating4" type="radio" name="rating" value="4"  <?php echo ($rating_int=='4')?'checked':'' ?>>
  <label for="rating4">4</label>
  <input id="rating5" type="radio" name="rating" value="5"  <?php echo ($rating_int=='5')?'checked':'' ?>>
  <label for="rating5">5</label>
</span>
<button type="submit" class="btn btn-link" name="rate_btn">Rate</button>
<br>
<button style="margin-left:15px" type="submit" class="btn btn-link" name="comment_btn">Comment</button>

</form>
</div>

</body>
</html>




