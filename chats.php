<?php
  include_once 'connmysql.php';
  connect_db();
  session_start();
?>
<html lang="en">
  <head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <!-- <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"> -->
    <script src="https://code.jquery.com/jquery-3.5.0.js" integrity="sha256-r/AaFHrszJtwpe+tHyNi/XCfMxYpbsRg2Uqn0x3s2zc=" crossorigin="anonymous"></script>
  </head>
  <body>
  <script type="text/javascript" language="javascript">
      $(document).ready(function(){
        $('.btn-link').click(function() {
          var emailid = $(this).data('mail');
          var name = $(this).data('name');
          var myData = {"name" : name, "emailid" : emailid};
          var request = $.ajax({ //send request to set things up
            url: "chatsRedirect.php",
            type: "post",
            data: myData
          });
          request.done(function (response, textStatus, jqXHR){
              console.log("Request completed!");
          });
          request.fail(function (jqXHR, textStatus, errorThrown){
              console.error(
                  "Could not complete the request. The following error occured: "+
                  textStatus, errorThrown
              );
          });
          $('#chatWindow').load('chatsScreen.php #chatWindow', function() { //load container with id=chatWindow in place of chatWindow
          });
        });
    });

    $(document).on('click', '#sendMsgBtn', function(){
      var msg1 = $('#inputMsg').val();
      var myData = {"msg" : msg1};
      //alert(msg1);
      var request = $.ajax({
        url: "chatsInsert.php",
        type: "post",
        data: myData
      });
      request.done(function (response, textStatus, jqXHR){
          console.log("Request completed!");
      });
      request.fail(function (jqXHR, textStatus, errorThrown){
          console.error(
              "Could not complete the request. The following error occured: "+
              textStatus, errorThrown
          );
      });
      $('#inputMsg').html("");
    });
  </script>
    <div class="container" style=" margin-top:1%;">
      <div class="col-sm-2" id="contactList">
        <div style="display: grid;">
          <button class="btn btn-info">Contacts</button>
          <?php
            if(isset($_SESSION['username'])){
              $fetchContactsSql = 'SELECT user_id, email_id, first_name, last_name FROM USER_ACCOUNT WHERE user_id <>' . $_SESSION['userid'];
              $contacts = mysqli_query($mysqli, $fetchContactsSql);
              while ($row = mysqli_fetch_array($contacts)){//$user1 is current user and $user2 is clicked user
                $fullName = $row['first_name'].' '.$row['last_name'];
                $emailid = $row['email_id'];
                echo '<button id="chatHeading" type="button" class="btn btn-link" data-mail='.$emailid.
                ' data-name='.$fullName.' >'.$fullName.
                '</button>';
              }
            }
          ?>
        </div>
      </div>
      <div class="col-sm-9">
        <div class="container" id="chatWindow">
        </div>
      </div>
    </div>
  </body>
</html>
