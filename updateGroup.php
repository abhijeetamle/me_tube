<?php
  session_start();
  include_once 'connmysql.php';
  connect_db();
  $emailToAdd = $_POST['email'];
  $groupToAdd = $_POST['group'];

  if ($groupToAdd == 'Favorites'){
    $groupToAdd = 'Favorite';
  }
  elseif ($groupToAdd == 'Blocked') {
    $groupToAdd = 'Block';
  }

  $updateGroupSql = "call add_contact('".$_SESSION['username']."','" .$emailToAdd. "', '" .$groupToAdd. "')";
  $result = mysqli_query($mysqli, $updateGroupSql);

  echo '<script>alert("Done updating");</script>';

?>
