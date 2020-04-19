<?php
  session_start();
  include_once 'connmysql.php';
  connect_db();
  $msgToInsert = $_POST['msg'];
  $insertMsgSql = "INSERT INTO CHAT_MESSAGES (USERNAME, MESSAGE, CHAT_ID) VALUES ('".$_SESSION['username']."', '".$msgToInsert."', '".$_SESSION['chat_id']."')";
  $result = mysqli_query($mysqli, $insertMsgSql);
  echo '<script>alert("Done setting session vars");</script>';
?>
