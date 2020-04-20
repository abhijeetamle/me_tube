<!DOCTYPE html>
<html>
<head>
<title>Contacts</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="MeTubeStyle.css" />
<meta name="viewport" content="width=device-width, initial-scale=1">

<?php
  include_once 'connmysql.php';
  connect_db();
  session_start();

$fetchContactsSql = 'SELECT first_name, last_name, email_id from USER_ACCOUNT WHERE user_id <>'. $_SESSION['userid']; 
$all_contacts_sql = mysqli_query($mysqli, $fetchContactsSql);
while ($row = mysqli_fetch_array($all_contacts_sql)){

    $contact['first_name'] = $row["first_name"];
	$contact['last_name'] = $row["last_name"];
    $contact['email_id'] = $row["email_id"];

    $get_grp_sql = "select get_group_name('".$_SESSION['username']."', '".$row['email_id']."')";
    $get_group_name = mysqli_query($mysqli, $get_grp_sql);

    $group_name = $get_group_name -> fetch_row();
    $contact['group'] = $group_name[0];

    $all_contacts[] = $contact;

    $get_group_name -> free_result();

}

?>

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
  <a style="font-size:28px;" id="all_contacts">All</a>

  <?php

$username=$_SESSION['username'];
$userid=$_SESSION['userid'];

echo '<br>';
echo '<br>';
echo "<table>".
        "<tr>".
            "<th>First name</th>".
            "<th>Last name</th>".
            "<th>Current group</th>".
            "<th colspan='2'>Add to group</th>".
        "</tr>";

for ($x = 0; $x < count($all_contacts); $x++) {

    $c_fn = $all_contacts[$x]['first_name'];
    $c_ln = $all_contacts[$x]['last_name'];
    $c_grp = $all_contacts[$x]['group'];

    echo "<tr>".
                "<td>$c_fn</td>".
                "<td>$c_ln</td>".
                "<td>$c_grp</td>".
                "<td><select id='group'>".
                        "<option value='None'".(($c_grp=='None')?"selected='selected'":'').">None</option>".
                        "<option value='Friends'".(($c_grp=='Friends')?"selected='selected'":'').">Friends</option>".
                        "<option value='Family'".(($c_grp=='Family')?"selected='selected'":'').">Family</option>".
                        "<option value='Favorites'".(($c_grp=='Favorite')?"selected='selected'":'').">Favorites</option>".
                        "<option value='Blocked'".(($c_grp=='Block')?"selected='selected'":'').">Blocked</option>".
                    "</select>".
                "</td>".
                "<td><button type='button' id='update_grp' class='btn btn-link' name='group'>Update Group</button>".
                "</td>".
         "</tr>";
}

echo "</table>";


echo '<br>';


?>

</div>
   
</body>
</html> 
