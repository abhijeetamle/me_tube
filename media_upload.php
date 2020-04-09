<?php
session_start();

if (isset($_GET['Message'])) {
    $msg = $_GET['Message'];
    echo "<script>alert('$msg');</script>";
}

?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Media Upload</title>

<style>
.dropbtn {
  background-color: #4CAF50;
  color: white;
  padding: 12px;
  font-size: 14px;
  border: none;
}

.dropdown {
  position: relative;
  display: inline-block;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f1f1f1;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

.dropdown-content a:hover {background-color: #ddd;}

.dropdown:hover .dropdown-content {display: block;}

.dropdown:hover .dropbtn {background-color: #3e8e41;}
</style>

</head>

<body>

<form method="post" action="media_upload_process.php" enctype="multipart/form-data" >
 
  <p style="margin-top: 100px; margin-left: 25%; margin-right:25%;">
  <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
   Upload a Media file: <label style="color:#663399"><em> (Each file limit 10M)</em></label><br/>
   <br>
   <input  name="file" type="file" size="50" />
   <br><br>
   <label for="caption">Media Caption: </label>
   <br><br>
   <input type="text" id="caption" name="caption" required>
   <br>
   </p>
   <div class="dropdown" style="margin-left: 25%; margin-right:25%;">
    <button class="dropbtn">Select Category</button>
    <div class="dropdown-content">
        <input type="radio" id="Education" name="category" value="Education" required>
        <label for="Education">Education</label><br>
        <input type="radio" id="Animation" name="category" value="Animation">
        <label for="Animation">Animation</label><br>
        <input type="radio" id="Nature" name="category" value="Nature">
        <label for="Nature">Nature</label><br>
        <input type="radio" id="Music" name="category" value="Music">
        <label for="Music">Music</label><br>
     </div>
    </div>
   <br><br>
	<input style="margin-left: 25%; margin-right:25%;" value="Upload" name="submit" type="submit" />
  
 </form>
</body>
</html>