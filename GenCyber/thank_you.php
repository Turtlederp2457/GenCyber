<!doctype html>
<html lang="en-us" class="scroll-smooth"/>
<head>
<!-- Required meta tags --> 
<meta charset = "utf-8"/>
<meta name="sitePath" content="http://localhost/GenCyber/home.php" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no"/>
<!-- Add your name here one you have helped write this code -->
<meta name="author" content="Gatlin Zornes">
<title>Thank You - Marshall University GenCyber</title>
<link rel="stylesheet" type="text/css" href="/GenCyber/stylesheets/newHome_stylesheet.css" />
<!-- Might need this -->
<!-- <base href="http://localhost/GenCyber/" target="_self"> -->

<p class="notes">Note: This is my post-registration landing page template</p>
<body>
  <header>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
      <button class="button-general" type="submit" name="login">Log in</button>
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
  <div class="wrapper-main">
    <div></div>
    <div>Thank you for your interest in joining Marshall's GenCyber Competition. You will be notified once you have been approved or denied.</div>
    <div></div>
  </div>
  <div class="wrapper-footer">
    <a href="http://localhost/GenCyber/about/about.php">About</a>
    <a href="http://localhost/GenCyber/contact/contact.php">Contact Us</a>
    <a href="http://localhost/GenCyber/help/help.php">Help</a>
  </div>
</body>
</html>