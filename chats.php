<?php
  include_once 'connmysql.php';
  connect_db();
  session_start();
?>

<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="MeTubeStyle.css" />
  </head>
  <body>
    <div class="container-fluid" style="margin-top:1%;" >
      <div class="col-sm-2">
        <div style="display: grid;">
          <button  class="btn btn-info">Contacts</button>
          <?php
            if(isset($_SESSION['username'])){
              $fetchContactsSql = 'SELECT user_id, email_id, first_name, last_name FROM USER_ACCOUNT WHERE user_id <>' . $_SESSION['userid'];
              $contacts = mysqli_query($mysqli, $fetchContactsSql);
              while ($row = mysqli_fetch_array($contacts)){
                echo '<button type="button" class="btn btn-link" onClick="location.href=\'contactList.php\'">'. $row['first_name'] . ' '. $row['last_name'].'</button>';
              }
              //add onclick event
            }
          ?>
        </div>
      </div>

      <div class="col-sm-10">

      </div>
    </div>
  </body>
</html>
