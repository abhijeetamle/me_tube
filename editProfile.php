<?php
  include_once 'connmysql.php';
  connect_db();
  session_start();
?>

<html lang = "en">
  <head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <title>Register</title>
</head>

<body>
  <?php
      //$fetchProfileSql = "SELECT first_name, last_name FROM USER_ACCOUNT WHERE email_id = '" .$_SESSION['username'] ."'";
      //$profileData = mysqli_query($mysqli, $fetchProfileSql);

      $updateSql = "UPDATE USER_ACCOUNT SET ";
      if(!empty($_POST['firstName'])){
        $updateSql .= " first_name= '" .$_POST['firstName'] ."' " ;
      }
      if(!empty($_POST['lastName'])){
        if(!empty($_POST['firstName'])){
          $updateSql .= ", ";
        }
        $updateSql .= " last_name= '" .$_POST['lastName'] ."' " ;
      }
      $updateSql .= " where email_id = '" .$_SESSION['username'] ."'";

      echo '<script>alert("" + $updateSql)</script>';
      if (isset($_POST['updateButton'])) {
        $updateResult = mysqli_query($mysqli, $updateSql);
          if (mysqli_affected_rows($mysqli) == 1) {
              echo '<script>alert("Profile updated successfully")</script>';
          } else {
              echo '<script>alert("Error occured while updating your profile.")</script>';
          }
      }
   ?>

  <!-- This is update profile container -->
  <div class="container" name="regContainer" id="regContainer" style="width:50%;">
    <form method="post"> <!-- onsubmit="location.href='home.php'; return false;" -->
      <div class="form-group">
        <label for="firstName">First name</label>
        <input type="text" class="form-control" id="firstName" name="firstName">
      </div>

      <div class="form-group">
        <label for="lastName">Last name</label>
        <input type="text" class="form-control" id="lastName" name="lastName">
      </div>
      <!-- add more details -->
      <button type="submit" class="btn btn-primary" name="updateButton">Update</button>
      <button type="button" class="btn btn-primary" name="home" onclick="location.href='home.php';">Home</button>
      <button type="button" class="btn btn-link" href="contactList.php">Contacts</button>
    </form>
  </div>

</body>

</html>
