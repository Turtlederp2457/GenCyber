<?php
$new_phonenum = "";
$confirm_phonenum = "";
$new_email = "";
$confirm_email = "";
$current_password = "";
$new_password = "";
$confirm_password = "";

$new_phonenum_error = "";
$confirm_phonenum_error = "";
$new_email_error = "";
$confirm_email_error = "";
$current_password_error = "";
$new_password_error = "";
$confirm_password_error = "";
$general_error = "";
include "login.php";
if(isset($_POST['logout'])){
	include "logout.php";
}
session_start();
require_once("database_conn.php");

//email:
if (isset($_POST['emailSubmit'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (test_input($_POST['new_email']) == test_input($_POST['confirm_email'])) {
            if (empty(test_input($_POST['new_email']))) {
                $new_email_error = "Field cannot be empty";
                $general_error = "Something went wrong. Please try again.";
            } elseif (!filter_var(test_input($_POST['new_email']), FILTER_VALIDATE_EMAIL)) {
                $new_email_error = "Invalid email address";
                $general_error = "Something went wrong. Please try again.";
            } else {  //check email uniqueness here
                $email_query = "SELECT user_email FROM Users WHERE user_email = ?";
                if ($stmt = mysqli_prepare($connection, $email_query)) {
                    mysqli_stmt_bind_param($stmt, "s", $param_new_email);
                    $param_new_email = test_input($_POST['new_email']);
                    if (mysqli_stmt_execute($stmt)) {
                        mysqli_stmt_store_result($stmt);
                        if (mysqli_stmt_num_rows($stmt) == 1) {
                            $new_email_error = "Email already in use";
                            $general_error = "Something went wrong. Please try again.";
                        } else {
                            $new_email = test_input($_POST['new_email']);
                        }
                    } else {
                        echo "something went wrong. Please try again later.";
                    }
                }
                mysqli_stmt_close($stmt);
            }
            
            if (empty(test_input($_POST['confirm_email']))) {
                $confirm_email_error = "Field cannot be empty";
                $general_error = "Something went wrong. Please try again.";
            } elseif (!filter_var(test_input($_POST['confirm_email']), FILTER_VALIDATE_EMAIL)) {
                $confirm_email_error = "Invalid email address";
                $general_error = "Something went wrong. Please try again.";
            } else {  //check email uniqueness here
                $email_query = "SELECT user_email FROM Users WHERE user_email = ?";
                if ($stmt = mysqli_prepare($connection, $email_query)) {
                    mysqli_stmt_bind_param($stmt, "s", $param_confirm_email);
                    $param_confirm_email = test_input($_POST['confirm_email']);
                    if (mysqli_stmt_execute($stmt)) {
                        mysqli_stmt_store_result($stmt);
                        if (mysqli_stmt_num_rows($stmt) == 1) {
                            $confirm_email_error = "Email already in use";
                            $general_error = "Something went wrong. Please try again.";
                        } else {
                            $new_email = test_input($_POST['confirm_email']);
                        }
                    } else {
                        echo "something went wrong. Please try again later.";
                    }
                }
                mysqli_stmt_close($stmt);
            }
        } else{
            $new_email_error = "Input fields must match";
            $confirm_email_error = "Input fields must match";
            $general_error = "Something went wrong. Please try again.";
        }
    }
    
    if (empty($new_email_error) && empty($confirm_email_error) && empty($general_error)) {
        if ($stmt = $connection->prepare('SELECT user_email FROM Users WHERE user_email = ?')) {
            // Bind parameters (s = string, i = int, b = blob, etc)
            $stmt->bind_param('s', $new_email);
            $stmt->execute();
            $stmt->store_result();
            // Store the result so we can check if the account exists in the database.
            if ($stmt->num_rows > 0) {
                // Email already exists
                header('location: teacher_error_page.php');
            } else {
                $sql = "UPDATE Users SET user_email = '". $new_email . "' WHERE UserID = ". $_SESSION['UserID'];
                if (mysqli_query($connection, $sql)) {
                    echo "Row updated successfully";
                    header('location: teacher_profile_management.php');
                } else {
                    header('location: teacher_error_page.php');
                }
            }
            mysqli_close($connection);
        } else {
            // Something is wrong with the SQL statement
            echo 'Could not prepare statement!';
            header('location: teacher_error_page.php');
        }
        $connection->close();
    }
}
//password
if (isset($_POST['passwordSubmit'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (test_input($_POST['new_password']) == test_input($_POST['confirm_password'])) {
            if (empty(test_input($_POST['current_password']))) {
                $current_password_error = "Field cannot be empty";
                $general_error = "Something went wrong. Please try again.";
            } else {
                $current_password = test_input($_POST['current_password']);
                $general_error = "";
            }
            
            if (empty(test_input($_POST['new_password']))) {
                $new_password_error = "Field cannot be empty";
                $general_error = "Something went wrong. Please try again.";
            } else {
                $new_password = test_input($_POST['new_password']);
                $general_error = "";
            }

            if (empty(test_input($_POST['confirm_password']))) {
                $confirm_password_error = "Field cannot be empty";
                $general_error = "Something went wrong. Please try again.";
            } else {
                $confirm_password = test_input($_POST['confirm_password']);
                $general_error = "";
            }
        } else {
            $new_password_error = "Input fields must match";
            $confirm_password_error = "Input fields must match";
            $general_error = "Something went wrong. Please try again.";
        }
    }
    
    if (empty($new_password_error) && empty($confirm_password_error) && empty($general_error)) {
        $sql = "SELECT Password FROM Users WHERE UserID = ". $_SESSION['UserID'] ." and Password = '". $current_password ."'";
        $result = mysqli_query($connection, $sql);
        if (mysqli_num_rows($result) > 0) {
            // Password is good
            $sql = "UPDATE Users SET `Password` = '" . $new_password . "' WHERE UserID = " . $_SESSION['UserID'];
            if (mysqli_query($connection, $sql)) {
                header('location: teacher_profile_management.php');
            } else {
                echo "Error updating row: " . mysqli_error($connection);
                $general_error = "Something went wrong. Please try again.";
                header('location: teacher_error_page.php');
            }
            mysqli_close($connection);
        } else {
            // Something is wrong with the SQL statement
            header('location: teacher_error_page.php');
        }
        mysqli_close($connection);
    }
}
?>
<!doctype html>
<html lang="en-us" class="scroll-smooth"/>
<head>
<!-- Required meta tags --> 
<meta charset = "utf-8"/>
<meta name="sitePath" content="http://localhost/GenCyber/teacher_profile_management.php" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no"/>
<!-- Add your name here one you have helped write this code -->
<meta name="author" content="Gatlin Zornes, Layne McNeely">
<title>Profile Management - Marshall University GenCyber</title>
<!-- <link rel="stylesheet" type="text/css" href="/GenCyber/stylesheets/newHome_stylesheet.css" />  -->
<!-- Might need this -->
<!-- <base href="http://localhost/GenCyber/" target="_self"> -->
<style>
* { 
  margin: 0;
  padding: 0;
  box-sizing: border-box; 
}

body {
  min-height: 100vh;
}

header {
  background-image: linear-gradient(to right, rgba(0, 102, 0, 0.6), rgba(0, 0, 102, 0.6)),
    url("http://localhost/GenCyber/imgs/GettyImages-cyber.jpg");
  background-color: black;
  color: white;
}

form {
  display: grid;
  margin-bottom: 0;
  grid-template-columns: 25% 50% 25%;
}

form p, div, span, label {
  font-size: 1.2em;
  margin: auto;
}

button[type=submit] {
  width: 50%;
  height: 100%;
  background-color: rgb(51, 153, 255);
  border: none;
  font: caption;
  color: black;
  margin: auto;
  cursor: pointer;
  font-size: 1.2em;
  text-align: center;
}

button[type=submit]:hover {
  background-color: #F0F0F0;
  border: 1px solid #F0F0F0;
  color: green;
  text-decoration: underline;
  text-decoration-color: green;
  text-decoration-thickness: 2px;
  position: relative;
}

.wrapper-logos {
  display: grid;
  grid-template-columns: 25% 50% 25%;
  grid-template-rows: 20% 80%;
  background-image: linear-gradient(to right, rgba(0, 102, 0, 0.6), rgba(0, 0, 102, 0.6)),
    url("http://localhost/GenCyber/imgs/GettyImages-cyber.jpg");
/*   in case image doesnt load */
  background-color: black;
}

.better-title {
  text-decoration: none;
  font-size: 2.8em;
/*   -webkit-text-stroke-width:1px; */
/*   -webkit-text-stroke-color:black; */
}

.error {
  font-size: 1em;
  color: red;
  background: #F0F0F0;
  opacity: 0.7;
}

.button-general {
  width: 50%;
  height: 100%;
  background-color: rgb(51, 153, 255);
  font: caption;
  font-size: 1.2em;
  color: black;
  margin: auto;
  margin-bottom: 0;
  cursor: pointer;
  text-align: center;
  text-decoration: none;
}
.button-menu {
  width: 50%;
  height: 100%;
  background-color: rgb(51, 153, 255);
  border: none;
  font: caption;
  margin: auto;
}
a.button-menu:hover,
button.button-general:hover,
a.button-general:hover {
  background-color: #F0F0F0;
  color: green;
  text-decoration: underline;
  text-decoration-color: green;
  text-decoration-thickness: 2px;
  position: relative;
}

.center {
  margin: auto;
}

.wrapper-menu {
  display: grid;
  grid-template-columns: repeat(3, [col-start] 1fr);
}

.button-prior {
  background-color: rgb(51, 153, 255);
  border: none;
  color: black;
  cursor: pointer;
  font-size: 1.2em;
  padding-bottom: 5px;
  text-align: center;
  width: 100%;
}

.button-prior:hover {
  background-color: #F0F0F0;
  text-decoration: underline;
  text-decoration-color: green;
  text-decoration-thickness: 2px;
  position: relative;
}

a.button-prior {
  text-decoration: none;
  color: initial;
}

.wrapper-teacher-links {
  display: grid;
  grid-template-columns: repeat(2, [col-start] 1fr);
  border: 1px solid black;
}

.wrapper-main {
  display: grid;
  grid-template-columns: repeat(3, [col-start] 1fr);
  grid-template-rows: 20% 80%;
  padding-top: 10px;
  padding-bottom: 10px;
}

.wrapper-footer {
  border: 1px solid green;
  background-color: #F0F0F0;
  width: 100%;
  position:fixed; 
  bottom: 0;
  display: grid;
  grid-template-columns: repeat(4, [col-start] 1fr);
  margin: auto;
  text-align: center;
  font-size: 1.2em;
}

#squares div {
    /* these styles will let the divs line up next to each other
       while accepting dimensions */
    display: block;
    float: left;

    width: 350px;
    height: 600px;


    /* a small margin to separate the blocks */
    margin-right: 5px;
}
#BluePanel {  
    background: rgb(51, 153, 255);
    padding: 25px 40px 75px;
}
#changePhoneNum {
  z-index: 1;
  top: 40px;
  left: 460px;
  width: 400px;
  border: 10px  rgb(217,217,217);
  background-color: rgb(239,239,239);
  padding: 25px 40px 75px;
}
#changeEmail {
  z-index: 1;
  top: 40px;
  left: 460px;
  width: 400px;
  border: 10px  rgb(217,217,217);
  background-color: rgb(239,239,239);
  padding: 25px 40px 75px;
}
#changePassword {
  z-index: 1;
  top: 40px;
  left: 460px;
  width: 400px;
  border: 10px  rgb(217,217,217);
  background-color: rgb(239,239,239);
  padding: 25px 40px 75px;
}
#newForm {
  z-index: 2;
}
#done{
    background: yellow;
}
</style>
<body>
  <header>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
      <button class="button-general" type="submit" name="logout">Log Out</button>
      <div></div>
      <p>
      <?php
      $sql = "SELECT First_name FROM Teachers WHERE UserID = " . $_SESSION['UserID'];
      $result = mysqli_query($connection, $sql);

      if (mysqli_num_rows($result) > 0) {
          // Save row data to variable
          $row = mysqli_fetch_assoc($result);
          // Print row data for testing
          echo "Welcome, " . $row["First_name"];
          //print_r($row);
      } else {
          echo "No rows found";
      }
      
      mysqli_close($connection);
      ?>
      </p>
    </form>
  </header>
  <div class="wrapper-logos">
    <a class="center" target="_blank" href="https://www.marshall.edu/">
      <img src="//www.marshall.edu/gencyber/wp-content/themes/marsha/images/m_primary.svg" 
        style="height:100px;width:120px" alt="Marshall University logo" class="marshall-logo"/>
    </a>
    <a style="color:white" class="better-title center" href="http://localhost/GenCyber/teacher_landing.php">Marshall University GenCyber</a>
    <a class="center" target="_blank" href="https://www.gen-cyber.com/">
      <img src="https://www.gen-cyber.com/static/gencyber_public_web/img/gencyber-logo-small.png" 
        style="height:100px;width:150px" alt="GenCyber Logo" class="gencyber-logo"/>
    </a>
  </div>
<!--   <div class="wrapper-menu"> -->
<!--     <a class="button-prior" href="http://localhost/GenCyber/newHome.php">Home</a> -->
<!--     <a class="button-prior" href="http://localhost/GenCyber/prior_winners.php">Prior Winner's</a> -->
<!--     <a class="button-prior" href="http://localhost/GenCyber/contact/contact.php">Contact Us</a> -->
<!--   </div> -->
  <div class="wrapper-teacher-links">
    <a class="button-prior" style="background-color:#F0F0F0"; href="http://localhost/GenCyber/teacher_profile_management.php">Profile Management</a>
    <a class="button-prior" href="http://localhost/GenCyber/teacher_project_management.php">Project Management</a>
  </div>
<!-- Side Panel -->
  <div style="font-size:1.0em; min-height:60vh; text-align:right;" class="wrapper-main">
	<div style="margin:0">
        <div id="squares">
            <div id="BluePanel">
                <h3><strong> Update Contact Information:</strong></h3><br>
                <button class="button-prior" style="background-color: #F0F0F0; font-size: 1.0em;" onclick="toggleEmail()">Change Email</button><br><br>
                <h3><strong> Update Password:</strong></h3><br>
                <button class="button-prior" style="background-color: #F0F0F0; font-size: 1.0em;" onclick="togglePassword()">Change Password</button><br>
            </div>
            
        </div>
            
    </div>
      <div>
          <div id="tip">
              🔧 Manage your profile with the buttons on the left.<br><br>
              <p class="error"><?php echo $general_error;?></p>
          </div>
          
          <form id="changeEmail" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" style="display:none">
              <div id="newForm">
                  <div>
                      <label for="newNum">Enter your new Email Address:</label><br>
                      <input type="text" id="newEmail" name="new_email">
                  </div>
                  <div>
                      <span class="error"><?php echo $new_email_error; ?></span>
                  </div>
                  <div>
                      <label for="confirmNum">Confirm new Email Address:</label><br>
                      <input type="text" id="confirmEmail" name="confirm_email">
                  </div>
                  <div>
                      <span class="error"><?php echo $confirm_email_error; ?></span>
                  </div><br>
                  <button id="done" class="button-general" type="submit" name="emailSubmit">Done</button>
              </div>
          </form>
          
          <form id="changePassword" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" style="display:none">
              <div id="newForm">
                  <div>
                      <label for="newNum">Enter your current Password:</label><br>
                      <input type="text" id="oldPassword" name="current_password">
                  </div>
                  <div>
                      <span class="error"><?php echo $current_password_error; ?></span>
                  </div>
                  <div>
                      <label for="newNum">Enter new Password:</label><br>
                      <input type="text" id="newPassword" name="new_password">
                  </div>
                  <div>
                      <span class="error"><?php echo $new_password_error; ?></span>
                  </div>
                  <div>
                      <label for="confirmNum">Confirm new Password:</label><br>
                      <input type="text" id="confirmPassword" name="confirm_password">
                  </div>
                  <div>
                      <span class="error"><?php echo $confirm_password_error; ?></span>
                  </div><br>
                  <button id="done" class="button-general" type="submit" name="passwordSubmit">Done</button>
              </div>
          </form>
          
          <script>
          
          function toggleEmail() {
            var e = document.getElementById("changeEmail");
            var t = document.getElementById("tip");
            var p = document.getElementById("changePassword");
            if (e.style.display === "none") {
              e.style.display = "block";
              t.style.display = "none";
              p.style.display = "none";
            } else {
              e.style.display = "none";
              t.style.display = "block";
            }
          }
          
          function togglePassword() {
            var e = document.getElementById("changeEmail");
            var t = document.getElementById("tip");
            var p = document.getElementById("changePassword");
            if (p.style.display === "none") {
              p.style.display = "block";
              t.style.display = "none";
              e.style.display = "none";
            } else {
              p.style.display = "none";
              t.style.display = "block";
            }
          }
          </script>
      </div>
    
  </div>
  <div class="wrapper-footer">
    <div>Date Created</div>
    <div>Copyright</div>
    <div>Contact Email</div>
    <div>Address</div>
<!--     <a href="http://localhost/GenCyber/about/about.php">About</a> -->
<!--     <a href="http://localhost/GenCyber/contact/contact.php">Contact Us</a> -->
<!--     <a href="http://localhost/GenCyber/help/help.php">Help</a> -->
  </div>
 
</body>
</html>

