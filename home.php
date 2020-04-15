<html>
<title>Me Tube</title>
<head>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="MeTubeStyle.css" />
	<?php
		ob_start();
		session_start();
		include_once 'connmysql.php';
		connect_db();

		// get all the videos

		$getmedia = "SELECT * FROM VIDEO_LIST LIMIT 20";
		$mediaTable = mysqli_query($mysqli, $getmedia);
		
		while ($row = mysqli_fetch_array($mediaTable)) {

			$data_item['user_id'] = $row['user_id'];
			$data_item['media_type'] = $row['file_type'];
			$data_item['file_name'] = $row['file_name'];

			$data_item['video_url'] = $row['video_url'];
			$data_item['caption'] = $row["caption"];
			$data_item['uploaded_date'] = $row["uploaded_date"];

			$media_details[] = $data_item;

			// storing physical media paths
			if ($data_item['media_type'] == 'video'){
				$media_paths[] = 'uploads/'.$data_item['user_id'].'/'.$data_item['media_type'].'/'.$data_item['file_name'].'#t=0.5';
			}
			else{
				$media_paths[] = 'uploads/'.$data_item['user_id'].'/'.$data_item['media_type'].'/'.$data_item['file_name'];
			}

			
			

	//		echo "video_url: " . $data_item['video_url']. " - user_id: " . $data_item['user_id']. " " . $data_item['caption']. "<br>";
		}
		mysqli_free_result($mediaTable);
//		print($items[0]['video_url']);
//		$arr_v = $items;
//		print_r ($arr_v);
?>

<script>
var myVideo = document.getElementById('videoplay');
myVideo.addEventListener('click', function () {
	alert("Clicked on media file!!!");
}

</script>

</head>
<body>
	<div class="container-fluid" style="margin-top:1%;" >
		<div class="col-sm-2">
			<div style="display: grid;">
				<button type="button" class="btn btn-link">Me Tube</button>
				<button type="button" class="btn btn-link">Home</button>
				<button type="button" class="btn btn-link">Trending</button>
				<button type="button" class="btn btn-link">Subscriptions</button>
				<button type="button" class="btn btn-link">Library</button>
				<button type="button" class="btn btn-link">History</button>

				<?php
					if(isset($_SESSION['username'])){
						echo '<button type="button" name="button" class="btn btn-link" onClick="location.href=\'contactList.php\'">My Contacts</button>';
					}else{
						echo '<button type="button" name="button" class="btn btn-link" onClick="location.href=\'loginPage.php\'">My Contacts</button>';
					}
				?>

				<?php
					if(isset($_SESSION['username'])){
						echo '<button type="button" name="button" class="btn btn-link" onClick="location.href=\'media_upload.php\'">Upload</button>';
					}else{
						echo '<button type="button" name="button" class="btn btn-link" onClick="location.href=\'loginPage.php\'">Upload</button>';
					}
				?>

				<?php
					if(isset($_SESSION['username'])){
						echo '<button type="button" name="button" class="btn btn-link" onClick="location.href=\'myChannel.php\'">My Channel</button>';
					}else{
						echo '<button type="button" name="button" class="btn btn-link" onClick="location.href=\'loginPage.php\'">My Channel</button>';
					}
				?>
				
			</div>
		</div>

	<div class="col-sm-10">
		<div class="row" style="display:flex;">
			<div class="input-group col-sm-8" style="display:flex;">
			  <input style="margin-left:10%;" type="text" class="form-control" placeholder="Search for a video" aria-label="Search" aria-describedby="basic-addon2">
			  <div class="input-group-append">
			    <button class="btn btn-light" id="basic-addon2">Search</span>
			  </div>
			</div>
			<div class="col-sm-4">
				<?php

					if(isset($_SESSION['username'])){
						echo ' firstname : '.$_SESSION['firstname'];
						echo '<button type="button" name="button" class="btn btn-primary" onClick="location.href=\'update_profile.php\'">Profile</button>';
						echo '<button type="button" name="button" class="btn btn-primary" onClick="location.href=\'logout.php\'">Sign Out</button>';
					}else{
						echo '<button style="margin-left:80%" type="button" name="button" class="btn btn-primary" onClick="location.href=\'loginPage.php\'">Sign In</button>';
					}
				?>

			</div>
		</div>

		<div class="row">

		<!-- starting cards -->

			<div class="col-md-3">
				<div class="card">
					<div class="image">
						<video preload="metadata">
							<source src="<?php echo $media_paths[0] ?>" type="video/mp4">
						</video>
					</div>
					<div class="text">
						<p><?php print($media_details[0]['caption']); ?></p>
					</div>
				</div>
			</div>

			<div class="col-md-3">
				<div class="card">
					<div class="image">
						<img src="http://assets.materialup.com/uploads/fc97b003-ba72-4c6e-9dd3-19bf5002c244/preview.jpg" width="100%">
					</div>
					<div class="text">
						<div class="fab"><img style="border-radius:50%; width:45px; height:45px;" src="https://www.itl.cat/pngfile/big/1-14290_minions-mischievous.jpg"></div>
						<h3>HTML Part-II</h3>
						<p>This is a tutorial for HTML beginners. Click for more.</p>
					</div>
				</div>
			</div>

			<div class="col-md-3">
				<div class="card">
					<div class="image">
						<img src="http://assets.materialup.com/uploads/fc97b003-ba72-4c6e-9dd3-19bf5002c244/preview.jpg" width="100%">
					</div>
					<div class="text">
						<div class="fab"><img style="border-radius:50%; width:45px; height:45px;" src="https://www.itl.cat/pngfile/big/1-14290_minions-mischievous.jpg"></div>
						<h3>HTML Part-III</h3>
						<p>This is a tutorial for HTML beginners. Click for more.</p>
					</div>
				</div>
			</div>

			<div class="col-md-3">
				<div class="card">
					<div class="image">
						<img src="http://assets.materialup.com/uploads/fc97b003-ba72-4c6e-9dd3-19bf5002c244/preview.jpg" width="100%">
					</div>
					<div class="text">
						<div class="fab"><img style="border-radius:50%; width:45px; height:45px;" src="https://www.itl.cat/pngfile/big/1-14290_minions-mischievous.jpg"></div>
						<h3>HTML Part-IV</h3>
						<p>This is a tutorial for HTML beginners. Click for more.</p>
					</div>
				</div>
			</div>
	<!-- ending cards-->

	</div>
	</div>
	<br>

	</div>




</body>
</html>
