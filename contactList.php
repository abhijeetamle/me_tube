<?php
//  include_once 'connmysql.php';
//  connect_db();
  session_start();
//  include_once 'friends.php';
//  include_once 'family.php';
//  include_once 'favorites.php';
//  include_once 'blocked.php';
?>


<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {
  font-family: "Lato", sans-serif;
}

.sidenav {
  height: 100%;
  width: 160px;
  position: fixed;
  z-index: 1;
  top: 0;
  left: 0;
  background-color: #111;
  overflow-x: hidden;
  padding-top: 20px;
}

.sidenav a {
  padding: 6px 8px 6px 16px;
  text-decoration: none;
  font-size: 25px;
  color: #818181;
  display: block;
}

.sidenav a:hover {
  color: #f1f1f1;
}

.main {
  margin-left: 160px; /* Same as the width of the sidenav */
/*  font-size: 28px; /* Increased text to enable scrolling */
  padding: 0px 10px;
  padding-top: 20px;
}

@media screen and (max-height: 450px) {
  .sidenav {padding-top: 15px;}
  .sidenav a {font-size: 18px;}
}
</style>
</head>
<body>

<div class="sidenav">
  <a id="all" style="font-size:30px;" onclick="location.href='contactList.php';">All</a>
  <br>
  <a id="friends" onclick="location.href='friends.php';">Friends</a>
  <a id="family" onclick="location.href='family.php';">Family</a>
  <a id="favorites" onclick="location.href='favorites.php';">Favorites</a>
  <a id="blocked" onclick="location.href='blocked.php';">Blocked</a>
</div>



<div class="main">
  <a style="font-size:33px;"><b>My Contacts &nbsp;&nbsp;</b></a>
  <a style="font-size:28px;" id="all_contacts">All</a>

  <?php

$username=$_SESSION['username'];
$userid=$_SESSION['userid'];

//get_contacts_friends();
//get_contacts_family();
//get_contacts_favorites();
//get_contacts_blocked();

?>

</div>
   
</body>
</html> 
