<?php 
include "login.php";
session_start();
?>
<!doctype html>
<html lang="en-us" class="scroll-smooth"/>
<head>
<!-- Required meta tags --> 
<meta charset = "utf-8"/>
<meta name="sitePath" content="http://localhost/GenCyber/newHome.php" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no"/>
<!-- Add your name here one you have helped write this code -->
<meta name="author" content="Gatlin Zornes">
<title>Home - Marshall University GenCyber</title>
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
  grid-template-columns: repeat(4, [col-start] 1fr);
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

.wrapper-main {
  display: grid;
  grid-template-columns: repeat(3, [col-start] 1fr);
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
</style>
<body>
  <header>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
      <button class="button-general" type="submit" name="login">Log In</button>
      <p>
        <label for="">Email</label>
        <input type="text" name="login_user_email" value="<?php echo $login_user_email;?>">
      </p>
      <p>
        <label for="">Password</label>
        <input type="text" name="user_password" value="<?php echo $user_password;?>">
      </p>
      <a class="button-general" href="http://localhost/GenCyber/register.php">Register</a>
      <br>
      <div>
<!--   		need to fix this area -->
        <span class="error"><?php echo $login_email_error ?></span>
        <span class="error"><?php echo $login_error;?></span>
      </div>
      <div>
        <span class="error"><?php echo $login_password_error;?></span>
      </div>
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
  <div class="wrapper-menu">
    <a class="button-prior" href="http://localhost/GenCyber/newHome.php">Home</a>
    <a class="button-prior" href="http://localhost/GenCyber/prior_winners.php">Prior Winner's</a>
    <a class="button-prior" href="http://localhost/GenCyber/contact/contact.php">Contact Us</a>
  </div>
  <div style="min-height:65vh" class="wrapper-main">
    <div style="margin:0">
      <!-- <p><?php if(isset($_SESSION['user_name'])) { printf("Welcome, <span class=error>".$_SESSION['user_name']); } else { printf("Welcome. Please log in");}?></p><br> -->
      <?php echo "valid login creds: ". "<br>". "[Admin] Admin@Admin.com, Admin". "<br>"."[Teacher] Teacher@Teacher.com, Teacher". "<br>". "[Judge] Judge@Judge.com, Judge"?>
    </div>
    <div>
      <p>
        Marshall University's GenCyber program provides summer cybersecurity & cyber forensics camp experiences for both students <br> and teachers at the K-12 level. <br>
        <br>The goals of the program are to increase interest in cybersecurity careers and diversity in the cybersecurity workforce of the nation, <br> help all students 
        understand correct and safe online behavior and how they can be good digital citizens, and improve teaching methods for the delivery of cybersecurity content in K-12 curricula. <br>
        <br>If you are interested in joining, please click <a href="http://localhost/GenCyber/register.php">here</a>
      </p>
    </div>
    <div style="font-size:1.0em; margin:0">
      <p>To Do List:<br>
        1. Fix errors on login form to prevent $login_error from always showing up<br>
        2. Finalize layout for content area <br>
      </p>
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
