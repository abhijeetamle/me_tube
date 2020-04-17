<?php
  include_once 'connmysql.php';
  connect_db();
  session_start();
?>

<html lang = "en">
  <head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <title>Log in</title>
</head>

<body>
  <?php
      if (isset($_POST['changeButton']) && !empty($_POST['pwdold']) && !empty($_POST['pwd1']) && !empty($_POST['pwd2']) && !empty($_POST['email1'])) {
        if($_POST['pwd2'] == $_POST['pwd1']){
          $fetchPassSql = "SELECT password FROM USER_ACCOUNT WHERE email_id = '" .$_POST['email1'] ."'";
          //verify old password if correct, match pwd1 and pwd2
          $oldPassResult = mysqli_query($mysqli, $fetchPassSql);
          if (mysqli_num_rows($oldPassResult) == 1) {
              $row = mysqli_fetch_assoc($oldPassResult);
              if($row["password"] == $_POST['pwdold']){
                //Old password is correct, updating new password
                $changePwdSql = "UPDATE USER_ACCOUNT SET password='" .$_POST['pwd1'] ."' WHERE email_id = '" .$_POST['email1'] ."'";
                $changePwdResult = mysqli_query($mysqli, $changePwdSql);
                if(mysqli_affected_rows($mysqli) == 1){
                  echo '<script>alert("Password changed successfully.")</script>';
                }else{
                  echo '<script>alert("Could not change password.")</script>';
                }
                echo '<script>location.href="home.php"</script>';
              }else{
                echo '<script>alert("Old password is incorrect.")</script>';
              }
          } else {
              echo '<script>alert("Email entered is incorrect.")</script>';
          }
        }
        else{
          echo '<script>alert("New passwords should match.")</script>';
        }

      }
    //  close_db_connection();
   ?>
  <!-- This is change password container -->
  <div class="container" name="loginContainer" id="loginContainer" style="width:50%;">
    <form method="post">
      <div class="form-group">
        <label for="exampleInputEmail1">Email address</label>
        <input type="email" class="form-control" id="email1" name="email1" aria-describedby="emailHelp" required>
        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
      </div>
      <div class="form-group">
        <label for="exampleInputPassword1">Password</label>
        <input type="password" class="form-control" id="pwdold" name="pwdold" required>
      </div>
      <div class="form-group">
        <label for="exampleInputPassword1">Password</label>
        <input type="password" class="form-control" id="pwd1" name="pwd1" required>
      </div>
      <div class="form-group">
        <label for="exampleInputPassword1">Password</label>
        <input type="password" class="form-control" id="pwd2" name="pwd2" required>
      </div>
      <button type="submit" class="btn btn-primary" name="changeButton">Change Password</button>
      <button type="button" class="btn btn-primary" name="home" onclick="location.href='home.php';">Home</button>
    </form>
  </div>
</body>

</html>
