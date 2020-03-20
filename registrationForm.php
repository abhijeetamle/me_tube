<?php
  include_once 'connmysql.php';
  connect_db();
?>

<html lang = "en">
  <head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script type="text/javascript">
      function openTab(tabName) {
        var i;
        var x = document.getElementsByClassName("container");
        for (i = 0; i < x.length; i++) {
          x[i].style.display = "none";
        }
        document.getElementById(tabName).style.display = "block";
      };

    </script>
  <title></title>
</head>

<body onload="openTab('regContainer')">
  <?php
      if (isset($_POST['regButton']) && !empty($_POST['email']) && !empty($_POST['pwd'])) {
        $insertSql = "INSERT INTO USER_ACCOUNT (user_id, email_id, password) VALUES ('" .$_POST['email']. "','" .$_POST['email']."','" .$_POST['pwd']. "')";
        if (mysqli_query($mysqli, $insertSql)) {
            echo '<script>alert("New account created successfully")</script>';
        } else {
            //echo "Error: " . $insertSql . "" . mysqli_error($mysqli);
        }
      }

      if (isset($_POST['loginButton']) && !empty($_POST['email1']) && !empty($_POST['pwd1'])) {
        echo $_POST['email1'];
        echo $_POST['pwd1'];
      }
      //close_db_connection();
   ?>
  <ul class="nav justify-content-center" style="display:flex; margin-left: 45%;">
    <li class="nav-item">
      <a class="nav-link active" onclick="openTab('regContainer')">Register</a>
    </li>
    <li class="nav-item">
      <a class="nav-link active" onclick="openTab('loginContainer')">Log in</a>
    </li>
  </ul>
  <!-- This is registration container -->
  <div class="container" name="regContainer" id="regContainer" style="width:50%;">
    <form method="post" > <!-- onsubmit="location.href='home.html'; return false;" -->
      <div class="form-group">
        <label for="exampleInputEmail1">Email address</label>
        <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" required>
        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
      </div>

      <div class="form-group">
        <label for="exampleInputPassword1">Password</label>
        <input type="password" class="form-control" id="pwd" name="pwd" minlength="8" required>
      </div>

      <div class="form-group">
        <label for="exampleInputPassword1">Confirm password</label>
        <input type="password" class="form-control" id="confirm_pwd" name="confirm_pwd" minlength="8" required>
      </div>
      <!-- <div class="form-group form-check">
        <input type="checkbox" class="form-check-input" id="exampleCheck1">
        <label class="form-check-label" for="exampleCheck1">Check me out</label>
      </div> -->
      <button type="submit" class="btn btn-primary" name="regButton">Register</button>
    </form>
  </div>

  <!-- This is log in container -->
  <div class="container" name="loginContainer" id="loginContainer" style="width:50%;">
    <form method="post">
      <div class="form-group">
        <label for="exampleInputEmail1">Email address</label>
        <input type="email" class="form-control" id="email1" name="email1" aria-describedby="emailHelp" required>
        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
      </div>
      <div class="form-group">
        <label for="exampleInputPassword1">Password</label>
        <input type="password" class="form-control" id="pwd1" name="pwd1" required>
      </div>
      <button type="submit" class="btn btn-primary" name="loginButton">Log in</button>
    </form>
  </div>
</body>

</html>
