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
</head>

<body>

<form method="post" action="media_upload_process.php" enctype="multipart/form-data" >
 
  <p style="margin-top: 100px; margin-left: 25%; margin-right:25%;">
  <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
   Add a Media: <label style="color:#663399"><em> (Each file limit 10M)</em></label><br/>
   <br>
   <input  name="file" type="file" size="50" />
   <br><br>
   <label for="caption">Video Caption: </label>
   <br><br>
   <input type="text" id="caption" name="caption" required>
   <br><br>
	<input value="Upload" name="submit" type="submit" />
  </p>
 
                
 </form>

</body>
</html>