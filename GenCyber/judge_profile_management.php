<?php 
include "login.php";
if(isset($_POST['logout'])){
	include "logout.php";
}
session_start();
require_once("database_conn.php");
?>
<!doctype html>
<html lang="en-us" class="scroll-smooth"/>
<head>
<!-- Required meta tags --> 
<meta charset = "utf-8"/>
<meta name="sitePath" content="http://localhost/GenCyber/judge_profile_management.php" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no"/>
<!-- Add your name here one you have helped write this code -->
<meta name="author" content="Gatlin Zornes">
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

.wrapper-judge-links {
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
  display: grid;
  grid-template-columns: repeat(4, [col-start] 1fr);
  margin: auto;
  text-align: center;
  font-size: 1.2em;
  padding-bottom: 3px;
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
      <p><?php printf("Welcome, ".$_SESSION['first_name']);?></p>
    </form>
  </header>
  <div class="wrapper-logos">
    <a class="center" target="_blank" href="https://www.marshall.edu/">
      <img src="//www.marshall.edu/gencyber/wp-content/themes/marsha/images/m_primary.svg" 
        style="height:100px;width:120px" alt="Marshall University logo" class="marshall-logo"/>
    </a>
    <a style="color:white" class="better-title center" href="http://localhost/GenCyber/newHome.php">Marshall University GenCyber</a>
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
  <div class="wrapper-judge-links">
    <a class="button-prior" style="background-color:#F0F0F0"; href="http://localhost/GenCyber/judge_profile_management.php">Profile Management</a>
    <a class="button-prior" href="http://localhost/GenCyber/project_evaluation.php">Project Evaluation</a>
  </div>
<!-- Side Panel -->
  <div style="font-size:1.0em; min-height:60vh; text-align:right;" class="wrapper-main">
	<div style="margin:0">
        <div id="squares">
            <div id="BluePanel">
                <h3><strong> Update Contact Information:</strong></h3>
                <button onclick="togglePhoneNum()">Change Phone Number</button><br>
                <button onclick="toggleEmail()">Change Email</button><br><br>
                <h3><strong> Update Password:</strong></h3>
                <button onclick="togglePassword()">Change Password</button><br>
            </div>
            
        </div>
            
    </div>
      <div>
          <div id="tip">Manage your profile with the buttons on the left.🔧</div>
          
          <!-- put forms here -->
          <form id="changePhoneNum" style="display:none">
              <div id="newForm">
                  <label for="newNum">Enter your new Phone Number:</label><br>
                  <input type="text" id="newPhoneNum" name="newPhoneNum"><br>
                  <label for="confirmNum">Confirm new Phone Number:</label><br>
                  <input type="text" id="confirmNum" name="confirmNum"><br><br>
                  <button id="done" class="button-general" type="submit" name="register">Done</button>
              </div>
          </form>
          
          <form id="changeEmail" style="display:none">
              <div id="newForm">
                  <label for="newNum">Enter your new Email Address:</label><br>
                  <input type="text" id="newEmail" name="newEmail"><br>
                  <label for="confirmNum">Confirm new Email Address:</label><br>
                  <input type="text" id="confirmEmail" name="confirmEmail"><br><br>
                  <button id="done" class="button-general" type="submit" name="register">Done</button>
              </div>
          </form>
          
          <form id="changePassword" style="display:none">
              <div id="newForm">
                  <label for="newNum">Enter your current Password:</label><br>
                  <input type="text" id="oldPassword" name="oldPassword"><br>
                  <label for="newNum">Enter new Password:</label><br>
                  <input type="text" id="newPassword" name="newPassword"><br>
                  <label for="confirmNum">Confirm new Password:</label><br>
                  <input type="text" id="confirmPassword" name="confirmPassword"><br><br>
                  <button id="done" class="button-general" type="submit" name="register">Done</button>
              </div>
          </form>
          
          <script>
          function togglePhoneNum() {
            var x = document.getElementById("changePhoneNum");
            var e = document.getElementById("changeEmail");
            var t = document.getElementById("tip");
            var p = document.getElementById("changePassword");
            if (x.style.display === "none") {
              x.style.display = "block";
              e.style.display = "none";
              t.style.display = "none";
              p.style.display = "none";
            } else {
              x.style.display = "none";
              t.style.display = "block";
            }
          }
          
          function toggleEmail() {
            var e = document.getElementById("changeEmail");
            var x = document.getElementById("changePhoneNum");
            var t = document.getElementById("tip");
            var p = document.getElementById("changePassword");
            if (e.style.display === "none") {
              e.style.display = "block";
              x.style.display = "none";
              t.style.display = "none";
              p.style.display = "none";
            } else {
              e.style.display = "none";
              t.style.display = "block";
            }
          }
          
          function togglePassword() {
            var e = document.getElementById("changeEmail");
            var x = document.getElementById("changePhoneNum");
            var t = document.getElementById("tip");
            var p = document.getElementById("changePassword");
            if (p.style.display === "none") {
              p.style.display = "block";
              x.style.display = "none";
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

