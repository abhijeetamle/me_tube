<?php
  include_once 'connmysql.php';
  connect_db();
  session_start();

  $userSql = "SELECT first_name, last_name, gender, dob FROM USER_ACCOUNT WHERE email_id = '" .$_SESSION['username']."'";
  $userResult = mysqli_query($mysqli, $userSql);
  $row = mysqli_fetch_assoc($userResult);

  $email = $_SESSION['username'];
  $firstname = $row["first_name"];
  $lastname = $row["last_name"];
  $gender = $row["gender"];
  $dob = $row["dob"];

  mysqli_free_result($userResult);
?>



<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Profile</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<style>
body {font-family: Arial, Helvetica, sans-serif;}

/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
  background-color: #fefefe;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%;
}

/* The Close Button */
.close {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}
</style>

<?php

function upPassword( $string ) { 

    $string = sha1($string);
    echo '<script>alert("inside php.")</script>';
} 

?>

</head>



<body> <!--  onclick="Update" -->
<?php

    // password update
    if (isset($_POST['updatePass'])) {

        if($_POST['pwd'] != $_POST['confirm_pwd']){
              echo '<script>alert("Passwords must match")</script>';
        }
        else{
            $updateP = "UPDATE USER_ACCOUNT SET password = '" .sha1($_POST['pwd']). "' WHERE email_id = '" .$_SESSION['username']."'";
            if (mysqli_query($mysqli, $updateP)) {
    
                echo '<script>alert("Password updated successfully.")</script>';
            } 
            else {
                echo '<script>alert("Error occured while updating your password. Please try again.")</script>';
            }
        }
    }


    // profile update 
    if (isset($_POST['updateButton'])) {

     //   echo '<script>alert("update button clicked.")</script>';
        
        $updateSql = "UPDATE USER_ACCOUNT SET first_name = '" .$_POST['firstName']. "', last_name = '" .$_POST['lastName']. "', 
        gender = '" .$_POST['gender']."', dob = '" .$_POST['dob']. "' WHERE email_id = '" .$_SESSION['username']."'";
        if (mysqli_query($mysqli, $updateSql)) {
       
            $_SESSION['firstname'] = $_POST["firstName"];
        
            echo '<script>alert("Account updated successfully.")</script>';
            echo '<script>location.href="home.php"</script>';
        } 
        else {
            echo '<script>alert("Error occured while updating your account. Please try again.")</script>';
        }
    
    }
    //close_db_connection();
?>



    <!-- The Modal -->
  <form method="post">
    <div id="myModal" class="modal">
      <!-- Modal content -->
      <div class="modal-content">
        <span class="close">&times;</span>
        <div class="form-popup" id="myForm">
          <form class="form-container">
            <h3><center>Update password</center></h3>
            <label for="pwd">New Password &nbsp;&nbsp;&nbsp;&nbsp;</label>
            <input type="password" class="form-control" id="pwd" name="pwd" minlength="8" required>
              <br>
              <br>
            <label for="confirm_pwd">Confirm password</label>
            <input type="password" class="form-control" id="confirm_pwd" name="confirm_pwd" minlength="8" required>
            <br>
            <br>
            <button type="button" class="btn cancel" onclick="closeForm()">Cancel</button>
            <a>&nbsp;&nbsp;</a>
            <button type="submit" class="btn" name="updatePass">Update Password</button>
          </form>
        </div>
      </div>
    </div>
  </form>

<p1><center>Update profile information</center></p1>

  <!-- This is update profile container  -->
   
<div class="container" name="updateCont" id="updateCont" style="width:50%;">
<form method="post">
    <label for="email">Email address</label>
    <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" value="<?php echo $email; ?>" disabled="disabled" required>
    <small id="emailHelp" class="form-text text-muted">E-mail id cannot be updated.</small>
    <br>

          <!-- Trigger/Open The Modal -->
    <button id="myBtn">Update Password</button>

    <br>

      
    <div class="form-group">
        <label for="firstName">First name</label>
        <input type="text" class="form-control" id="firstName" name="firstName" value="<?php echo $firstname; ?>" required>
    </div>
    <div class="form-group">
        <label for="lastName">Last name</label>
        <input type="text" class="form-control" id="lastName" name="lastName" value="<?php echo $lastname; ?>" required>
    </div>
    <div class="form-group">
        <label for="gender">Gender</label><br>
        <input type="radio" id="male" name="gender" value="M" <?php echo ($gender=='M')?'checked':'' ?> required>
        <label for="male">Male</label><br>
        <input type="radio" id="female" name="gender" value="F" <?php echo ($gender=='F')?'checked':'' ?>>
        <label for="female">Female</label><br>
        <input type="radio" id="other" name="gender" value="O" <?php echo ($gender=='O')?'checked':'' ?>>
        <label for="other">Other</label>
    </div>
    <div class="form-group">
        <label for="dob">Date of Birth</label>
        <input type="date" class="form-control" id="dob" name="dob" value="<?php echo $dob; ?>" required>
    </div>
    <div class="form-group form-check">
        <input type="checkbox" class="form-check-input" id="exampleCheck1" required>
        <label class="form-check-label" for="exampleCheck1">I confirm that above information is correct.</label>
    </div>
        <button type="button" class="btn cancel"  onclick="window.location.href = 'home.php';">Cancel</button>
        <button type="submit" class="btn btn-primary" name="updateButton">Update</button>
</form>
</div>




<script>

function closeForm() {
  modal.style.display = "none";
}

// Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
  modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
</script>

</body>

</html>