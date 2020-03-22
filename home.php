<html>
<title>Me Tube</title>
<head>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="MeTubeStyle.css" />
	<?php
		ob_start();
		session_start();
	 ?>
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
						echo '<button type="button" name="button" class="btn btn-primary" onClick="location.href=\'media_upload.php\'">Upload</button>';
					}else{
						echo '<button type="button" name="button" class="btn btn-primary" onClick="location.href=\'loginPage.php\'">Upload</button>';
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
						echo ' user : '.$_SESSION['username'];
						echo ' userid : '.$_SESSION['userid'];
						echo '<button style="margin-left:80%" type="button" name="button" class="btn btn-primary" onClick="location.href=\'logout.php\'">Sign Out</button>';
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
						<img src="http://assets.materialup.com/uploads/fc97b003-ba72-4c6e-9dd3-19bf5002c244/preview.jpg" width="100%">
					</div>
					<div class="text">
						<div class="fab"><img style="border-radius:50%; width:45px; height:45px;" src="https://www.itl.cat/pngfile/big/1-14290_minions-mischievous.jpg"></div>
						<h3>HTML Part-I</h3>
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
