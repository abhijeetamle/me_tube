<?php
  session_start();
  include_once 'connmysql.php';
  connect_db();
  $emailToAdd = $_POST['email'];
  $groupToAdd = $_POST['group'];

  //write your code here

  //  $updateGroupSql = "";
  //  $result = mysqli_query($mysqli, $insertMsgSql);


  echo '<script>alert("Done updating");</script>';

?>
