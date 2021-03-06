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
    <div class="container" style=" margin-top:1%;" >
      <div class="col-sm-2">
        <div style="display: grid;">
          <!-- no need for anything right now -->
        </div>
      </div>
      <div class="col-sm-9" id="chatWindow">
        <div class="container" style=" border:aliceblue; width:auto;">
          <?php
            include_once 'connmysql.php';
            connect_db();
            global $currChatId;
            global $chatTexts;
            $user1 = $_SESSION['username'];
            $user2 = $_SESSION['user2_email'];
            $selectChatId = 'SELECT CHAT_ID FROM CHAT_SESSION_INFO WHERE (USER1 = "'.$user1.'" && USER2 = "'.$user2.'" ) || (USER1 = "'.$user2.'" && USER2 = "'.$user1.'" )' ;
            $chatId = mysqli_query($mysqli, $selectChatId);
            //var_dump($chatId);
            if($chatId->num_rows == 0){ //if chat id  does  not exist, its a new chat create a chat id
              $currChatId = ''.substr($user1,0, strpos($user1, '@')) .substr($user2,0, strpos($user2, '@'));
              echo '<script>alert("creating new chat ID : "'.$currChatId.');</script>';
              $insertNewChatID = 'INSERT INTO CHAT_SESSION_INFO (USER1, USER2, CHAT_ID) VALUES("'.$user1.'","'.$user2.'","' .$currChatId.'")';
              $res1 = mysqli_query($mysqli, $insertNewChatID);
              //var_dump($res1);
              if(!$res1){
                echo '<script> alert("Not Successful")</script>';
              }
            }else{
              $row1 = mysqli_fetch_array($chatId);
              $currChatId = $row1['CHAT_ID']; //assigning chat id that was fetched from database
              echo '<script>alert("Using existing chat ID -" ' .$currChatId.'" .. ");</script>';
              $selectChatTexts = 'SELECT * FROM CHAT_MESSAGES WHERE CHAT_ID = "' .$currChatId.'" ORDER BY SENT_TS ASC';   //fetch existing texts.
              $chatTexts = mysqli_query($mysqli, $selectChatTexts);
              //var_dump($chatTexts);
            }
            $_SESSION['chat_id'] = $currChatId;
            echo '<h4>User: '.$_SESSION['user2_name'].'</h4> <hr align="left" width="800px">';
            if($chatTexts != null){
              while ($row = mysqli_fetch_array($chatTexts)) {
                if($row['MESSAGE'] != ''){
                  if($row['USERNAME'] == $_SESSION['username']){//Change text card orientation to right aligned
                    echo'<p class="chatRight">'.$row['MESSAGE'].'</p>';
                  }else{//left aligned
                    echo'<p class="chatLeft" >'.$row['MESSAGE'].'</p>';
                  }
                }
              }
            }
          ?>
            <textarea id="inputMsg" rows="5" cols="100" style="margin-left: 20%; margin-top:50%;" name="inputMsg"></textarea>
            <button class="btn btn-primary" id="sendMsgBtn">Send</button>
        </div>
      </div>
    </div>
  </body>
</html>
<!--
    background-color: rgba(255,255,255,.1);
    margin-left: 50%;
    border-color: rgba(255,255,255,.15);
    border-style: groove;
    border-radius: 7px;
 -->
