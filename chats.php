<?php
  include_once 'connmysql.php';
  connect_db();
  session_start();
?>
<html lang="en">
  <head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="MeTubeStyle.css" />
    <script src="https://code.jquery.com/jquery-3.5.0.js" integrity="sha256-r/AaFHrszJtwpe+tHyNi/XCfMxYpbsRg2Uqn0x3s2zc=" crossorigin="anonymous"></script>
  </head>
  <body>
  <script type="text/javascript" language="javascript">
      $(document).ready(function(){
        var emailid = '';
        var name = '';
        $('.btn-link').click(function() {
          emailid = $(this).data('mail');
          name = $(this).data('name');
          var myData = {"name" : name, "emailid" : emailid};
          var request = $.ajax({ //call settimeout here
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
        // if(emailid && name){
        //   setInterval(getChats, 1000, emailid, name); //calling to refreshchats
        // }
    });

    $(document).on('click', '#sendMsgBtn', function(){
      var msg1 = $('#inputMsg').val();
      var myData = {"msg" : msg1};
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
      <!-- Contact list start -->
      <!-- test side bar -->
      <div class="col-sm-2" id="contactList">
        <div class="vertical-nav bg-white" id="sidebar" style="text-align: center;">
          <div class="py-4 px-3 mb-4 bg-light">
            <div class="media d-flex align-items-center">
              <div class="media-body">
                <h4 class="m-0">Metube chats</h4>
              </div>
            </div>
          </div>

          <p class="text-gray font-weight-bold text-uppercase px-3 small pb-4 mb-0">Personal</p>

          <ul class="nav flex-column bg-white mb-0">
            <?php
              if(isset($_SESSION['username'])){
                $fetchContactsSql = 'SELECT user_id, email_id, first_name, last_name FROM USER_ACCOUNT WHERE user_id <>' . $_SESSION['userid'];
                $contacts = mysqli_query($mysqli, $fetchContactsSql);
                while ($row = mysqli_fetch_array($contacts)){//$user1 is current user and $user2 is clicked user
                  $fullName = $row['first_name'].' '.$row['last_name'];
                  $emailid = $row['email_id'];
                  echo '<li class="nav-item"><button id="chatHeading" type="button" class="btn btn-link" data-mail='.$emailid.
                  ' data-name='.$fullName.' >'.$fullName.
                  '</button></li>';
                }
              }
            ?>
          </ul>

          <p class="text-gray font-weight-bold text-uppercase px-3 small py-4 mb-0">Group</p>

          <ul class="nav flex-column bg-white mb-0">
            <li class="nav-item">
              <a href="#" class="nav-link text-dark font-italic">
                        <i class="fa fa-area-chart mr-3 text-primary fa-fw"></i>
                        Placeholder
                    </a>
            </li>
          </ul>
        </div>
      </div>
      <!-- test sidebar ends -->
      <div class="col-sm-9">
        <div class="container" id="chatWindow">
        </div>
      </div>
    </div>
  </body>
</html>

<!--
$(function() {
  // Sidebar toggle behavior
  $('#sidebarCollapse').on('click', function() {
    $('#sidebar, #content').toggleClass('active');
  });
});
 -->
