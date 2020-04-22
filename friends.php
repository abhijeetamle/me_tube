<!DOCTYPE html>
<html>
<head>

<?php
  include_once 'connmysql.php';
  connect_db();
  session_start();
?>

<title>Contacts-Friends</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="MeTubeStyle.css" />
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

table {
  border-collapse: separate;
  border-spacing: 28px 15px;
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
  <a style="font-size:28px;" id="friends">Friends</a>

<?php

$username=$_SESSION['username'];
$userid=$_SESSION['userid'];

// function to get contacts from friends group

function get_contacts_friends(){
    global $mysqli, $username;
    $grp_id_sql = "select get_USER_LIST_id('".$username."', 'Friends')";
    $grp_id = mysqli_query($mysqli, $grp_id_sql);
    $grp_no = '';

    echo '<br>';
    echo '<br>';
    echo "<table>".
        "<tr>".
            "<th>First name</th>".
            "<th>Last name</th>".
            "<th colspan='2'>Update group</th>".
        "</tr>";

    while ( $row = $grp_id->fetch_array(MYSQLI_NUM) ) {
        $grp_no .= $row[0];
    }
    // get all users for friends group
    $friends_sql = "select title from CONTACT_LIST where parent_id = '".$grp_no."'";
    $friends = mysqli_query($mysqli, $friends_sql);
    if (mysqli_num_rows($friends) > 0){
        while ( $frow = $friends -> fetch_row() ) {
            $friend_sql = "select user_id, first_name, last_name from USER_ACCOUNT where email_id = '".$frow[0]."'";
            $friend = mysqli_query($mysqli, $friend_sql);

            while ( $fr = $friend -> fetch_row() ) {
                
                echo "<tr>".
                        "<td>$fr[1]</td>".
                        "<td>$fr[2]</td>".
                        "<td><select id='group'>".
                                "<option value='None'>None</option>".
                                "<option value='Friends' selected>Friends</option>".
                                "<option value='Family'>Family</option>".
                                "<option value='Favorites'>Favorites</option>".
                                "<option value='Blocked'>Blocked</option>".
                            "</select>".
                        "</td>".
                        "<td><button type='button' id='update_grp' class='btn btn-link' name='group'>Update Group</button>".
                        "</td>".
                     "</tr>";
            }
            $friend -> free_result();
        }
    }
    else {
	    echo "You don't have any contact added in the friend list.";
    }

    $grp_id -> free_result();
    $friends -> free_result();
}

get_contacts_friends();

?>

</div>
   
</body>
</html> 

</body>
</html>
