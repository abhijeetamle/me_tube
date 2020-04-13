<?php
  include_once 'connmysql.php';
  connect_db();
  session_start();
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
  <a style="font-size:28px;" id="friends">Favorites</a>


<?php

$username=$_SESSION['username'];
$userid=$_SESSION['username'];


echo '<br>';
echo '<br>';
echo '<br>';
echo '<br>';
echo '<br>';


// function to get contacts from favorites group
function get_contacts_favorites(){

    global $mysqli, $username;

    $grp_id_sql = "select get_USER_LIST_id('".$username."', 'Favorite')";
    $grp_id = mysqli_query($mysqli, $grp_id_sql);

    $grp_no = '';

    while ( $row = $grp_id->fetch_array(MYSQLI_NUM) ) {
        $grp_no .= $row[0];
    }

    // get all users for favorites group
    $friends_sql = "select title from CONTACT_LIST where parent_id = '".$grp_no."'";
    $friends = mysqli_query($mysqli, $friends_sql);

    if (mysqli_num_rows($friends) > 0){

        while ( $frow = $friends -> fetch_row() ) {

            $friend_sql = "select user_id, first_name, last_name from USER_ACCOUNT where email_id = '".$frow[0]."'";
            $friend = mysqli_query($mysqli, $friend_sql);

            while ( $fr = $friend -> fetch_row() ) {
                echo '<br>';
                printf("Friend: %s  %s\n", $fr[1], $fr[2]);
                echo '<br>';
            }

            $friend -> free_result();
        }
    }
    else {
	    echo "You don't have any contact added in the favorites list.";
    }

    $grp_id -> free_result();
    $friends -> free_result();
}

get_contacts_favorites();

?>

</div>

</body>
</html>
