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
$image_caption = '';
$rating = '';
$views = '';
$image_id = '';

// msg - image_url input

$verifySql = "SELECT * FROM VIDEO_LIST WHERE video_url = '" .$msg."'";
$resultPass = mysqli_query($mysqli, $verifySql);
if (mysqli_num_rows($resultPass) == 1) {

    $row = mysqli_fetch_assoc($resultPass);

    $image_id = $image_id.$row["video_id"];
    $userid = $userid.$row["user_id"];
    $mediatype = $mediatype.$row["file_type"];
    $filename = $filename.$row["file_name"];
    $image_caption = $image_caption.$row["caption"];
    $views = $views.$row["view_count"];
    $rating = $rating.$row["rating"];
}

$views = $views+1;
$add_view_sql = "UPDATE VIDEO_LIST SET view_count = '".$views."' WHERE video_url = '" .$msg."'";
$view_add_sql = mysqli_query($mysqli, $add_view_sql);

$show_image_path = 'uploads/'.$userid.'/'.$mediatype.'/'.$filename;

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

<title><?php echo $image_caption?></title>

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
    if(isset($_SESSION['username'])){    
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
    }
    else{
        echo '<script>alert("Please login to rate a media")</script>';
    }
}

// Comment
if (isset($_POST['comment_btn'])) {
    if(isset($_SESSION['username'])){

        echo '<script>alert("Inside comment_btn php.")</script>';
    }
    else{
        echo '<script>alert("Please login to comment a media file.")</script>';
    }
}


// Add to Playlist
if (isset($_POST['playlist_btn'])) {
    if(isset($_SESSION['username'])){
        $check_playlist_sql = "SELECT EXISTS(SELECT * FROM PLAY_LIST 
            WHERE user_id = '" .$_SESSION['userid']. "' AND video_id = '" .$image_id. "')";
        $check_pl = mysqli_query($mysqli, $check_playlist_sql);
        $check_playlist = $check_pl -> fetch_row();
        $check_playlist = $check_playlist[0];

        if ($check_playlist){
            echo '<script>alert("Media already added to your Playlist")</script>';    
	    }
        else{
            $add_playlist_slq = "insert into PLAY_LIST (user_id, video_id) 
            values('" .$_SESSION['userid']. "','" .$image_id. "')";
            
            if (mysqli_query($mysqli, $add_playlist_slq)){
                echo '<script>alert("Media added to your Playlist")</script>';        
		    }
            else {
                echo '<script>alert("Error occured while adding media to your Playlist. Please try again.")</script>';
            }
	    }
    }
    else{
            echo '<script>alert("Please login to add a media file to playlist")</script>';
        }
}

?>

<div class="w3-container" style="max-width:800px;"> 
<form method="post">


    <p>
        <img style="margin: 0 auto; border: 5px solid #ddd;" src=<?php echo $show_image_path?> alt=<?php echo $image_caption?> width="900" height="500"></img>
    </p>
    <p style="font-size:22px;"><?php echo $image_caption?></p>

    <p>
        <a href=<?php echo $show_image_path ?> download>
        <button class="btnDownload" id="download_btn" name="download_btn"><i class="fa fa-download"></i>Download</button>
        </a>
    <small style="font-size:15px; margin-left: 10px; vertical-align:center;"><?php echo $views?> views</small>
    <button style="float: right; font-size:18px;" class="btn btn-link" name="playlist_btn">Add to Playlist</button>
    </p>

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