<?php 
include "login.php";
session_start();
?>
<!doctype html>
<html lang="en-us" class="scroll-smooth"/>
<head>
<!-- Required meta tags --> 
<meta charset = "utf-8"/>
<meta name="sitePath" content="http://localhost/GenCyber/home.php" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no"/>
<!-- Add your name here one you have helped write this code -->
<meta name="author" content="Gatlin Zornes">
<title>Contact - Marshall University GenCyber</title>
<link rel="stylesheet" type="text/css" href="/GenCyber/stylesheets/newHome_stylesheet.css" /> 
<!-- Might need this -->
<!-- <base href="http://localhost/GenCyber/" target="_self"> -->

<body>
   <header>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
      <button class="button-general" type="submit" name="login">Log In</button>
      <p>
        <label for="">Email</label>
        <input type="text" name="user_email" value="<?php echo $user_email;?>">
      </p>
      <p>
        <label for="">Password</label>
        <input type="text" name="user_password" value="<?php echo $user_password;?>">
      </p>
      <a class="button-general" href="http://localhost/GenCyber/register.php">Register</a>
      <br>
      <div>
        <span class="error"><?php echo $email_error;?></span>
        <span class="error"><?php echo $login_error;?></span>
      </div>
      <div>
        <span class="error"><?php echo $password_error;?></span>
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
  <div class="wrapper-main">
    <div></div>
    <p class="center" style="font-size:1.5em"><span style="text-decoration:underline;text-decoration-color:green">GenCyber Camps</span><br>
      Marshall University<br>
	  1 John Marshall Drive<br>
	  Huntington, WV 25755<br>
	  gencyber@marshall.edu<br> 
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
