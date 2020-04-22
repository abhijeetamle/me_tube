<?php
  session_start();
  $_SESSION['user2_email'] = $_POST['emailid'];
  $_SESSION['user2_name'] = $_POST['name'];
  echo '<script>alert("Done setting session vars");</script>';
?>
