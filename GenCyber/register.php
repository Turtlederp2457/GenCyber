<?php
$first_name = "";
$middle_name = "";
$last_name = "";
$user_email = "";
$user_password = "";
$phone_number = ""; 
$subject_area = "";
$school = "";
$school_address = "";

$first_name_error = "";
$middle_name_error = "";
$last_name_error = "";
$email_error = "";
$password_error = "";
$phone_number_error = "";
$subject_area_error = "";
$school_error = "";
$school_address_error = "";

  
function prepared_query($mysqli, $sql, $params, $types = "") {
  $types = $types ?: str_repeat("s", count($params));
  $stmt = $mysqli->prepare($sql);
  $stmt->bind_param($types, ...$params);
  $stmt->execute();
  return $stmt;
}
include "login.php";
session_start();
if(isset($_POST['register'])){
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
  //Validate our user input before setting values
  //We will follow this order: 
  //check if empty (if needed) -> ensure matches regex -> set value if no errors
    if (empty(test_input($_POST['first_name']))){
      $first_name_error = "First name cannot be empty";
    } elseif (!preg_match("/^[a-zA-Z]*$/",test_input($_POST['first_name']))) { 
         $first_name_error = "Only letters allowed";
    } else {
    	$first_name = test_input($_POST['first_name']);
    }
    
    //middle name can be empty, no need to check for that
    if (!preg_match("/^[a-zA-Z]*$/", test_input($_POST['middle_name']))) {
      $middle_name_error = "Only letters allowed.";
    } else {
    	$middle_name = test_input($_POST['middle_name']);
    }
    
    if (empty(test_input($_POST['last_name']))){
      $last_name_error = "Last name cannot be empty";
    } elseif (!preg_match("/^[a-zA-Z]*$/",test_input($_POST['last_name']))) { 
        $last_name_error = "Only letters allowed";
    } else {
    	$last_name = test_input($_POST['last_name']);
    }
    
    //user_email needs to be confirmed unique and not already in database
    if (empty(test_input($_POST['user_email']))){
      $email_error = "Email cannot be empty";
    } elseif (!filter_var(test_input($_POST['user_email']), FILTER_VALIDATE_EMAIL)) {
        $email_error = "Check to make sure email is correct";
    } else {  //check email uniqueness here
    	$email_query = "SELECT user_email FROM register_tbl WHERE user_email = ?";
    	if ($stmt = mysqli_prepare($connection, $email_query)){
    	  mysqli_stmt_bind_param($stmt, "s", $param_user_email);
    	  $param_user_email = test_input($_POST['user_email']);
    	  if (mysqli_stmt_execute($stmt)){
    	  	mysqli_stmt_store_result($stmt);
              if(mysqli_stmt_num_rows($stmt) == 1){
                $email_error = "This email is already in use. Visit the login page";
              } else {
              	$user_email = test_input($_POST['user_email']);
              }
    	  } else {
    	  	echo "something went wrong. Please try again later.";
    	  }
    	}
        mysqli_stmt_close($stmt);
    }
  
    
    //need to hash password and set minimum length (Ex. min length = 7 chars)
    if (empty(test_input($_POST['user_password']))){
      $password_error = "Password cannot be empty";
    } else {
    	$user_password = test_input($_POST['user_password']);
    }
    
    if (empty(test_input($_POST["phone_number"]))){
  	  $phone_number_error = "Phone number cannot be empty";
    } elseif (!preg_match("/^\d{10}$/",test_input($_POST['phone_number']))) { 
        $phone_number_error = "Please enter your 10-digit phone number with no spaces";
    } else {
    	$phone_number = test_input($_POST['phone_number']);
    }
    
    if (empty(test_input($_POST['subject_area']))) {
      $subject_area_error = "Subject cannot be empty";
    } elseif (!preg_match("/^[a-zA-Z ]*$/", test_input($_POST['subject_area']))) {
        $subject_area_error = "Only letters allowed";
    } else {
    	  $subject_area = test_input($_POST['subject_area']);
    }
    
    if (empty(test_input($_POST['school']))) {
      $school_error = "School cannot be empty";
    } elseif (!preg_match("/^[a-zA-Z ]*$/", test_input($_POST['school']))) {
        $school_error = "Only letters allowed";
    } else {
    	$school = test_input($_POST['school']);
    }
    //this leads to an undefined array key "school_address" error
//     if (empty(test_input($_POST['school_address']))) {
//       $school_address_error = "School Address cannot be empty";
//     } else {
//     	$school = $_POST['school_address'];
//     }
  
  
    if (empty($first_name_error) && empty($middle_name_error) && empty($last_name_error) && empty($email_error) &&
    		empty($password_error) && empty($phone_number_error) && 
    		empty($subject_area_error) && empty($school_address_error)){
       $register_query = "INSERT INTO register_tbl".
         "(first_name, middle_name, last_name, user_email, user_password,".
         "phone_number, subject_area, school, school_address)".
         "VALUES (?,?,?,?,?,?,?,?,?)";
       prepared_query($connection, $register_query, [$first_name, $middle_name, $last_name, $user_email, $user_password,
       		$phone_number, $subject_area, $school, $school_address]);
       header('location: thank_you.php');
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
<meta name="sitePath" content="http://localhost/GenCyber/newHome.php" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no"/>
<!-- Add your name here once you have helped write this code -->
<meta name="author" content="Gatlin Zornes">
<title>Sign Up - Marshall University GenCyber</title>
<link rel="stylesheet" type="text/css" href="/GenCyber/stylesheets/newHome_stylesheet.css" />
<!-- <link rel="stylesheet" type="text/css" href="/GenCyber/stylesheets/register_stylesheet.css" /> -->
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
    <div><p><?php if(isset($_SESSION['user_name'])) { printf("Welcome, <span class=error>".$_SESSION['user_name']); } else { printf("Welcome. Please log in");}?></p></div>
    <div>
      <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <div>
          <label>First Name:
            <input type="text" name="first_name"/>
          </label>
        </div>
        <div>
          <span class="error"><?php echo $first_name_error;?></span>
        </div>
        <div>
          <label>Middle Name:
            <input type="text" name="middle_name"/>
          </label>
        </div>
        <div>
		  <span class="error"><?php echo $middle_name_error;?></span>
        </div>
        <div>
          <label>Last Name:
            <input type="text" name="last_name"/>
          </label>
        </div>
        <div>
		  <span class="error"><?php echo $last_name_error;?></span>
        </div>
        <div>
          <label>Email: 
            <input type="text" name="user_email"/>
          </label>
        </div>
        <div class="email-error">
		  <span class="error"><?php echo $email_error;?></span>
        </div>
        <div>  
          <label>Password:
            <input type="text" name="user_password"/>
          </label>
        </div>
        <div class="password-error">
		  <span class="error"><?php echo $password_error;?></span>
        </div>
        <div>
          <label>Phone Number:
            <input type="text" name="phone_number"/>
          </label>
        </div>
        <div>
		  <span class="error"><?php echo $phone_number_error;?></span>
        </div>
        <div>
          <label>Subject Area:
            <input type="text" name="subject_area"/>
          </label>
        </div>
        <div>
		  <span class="error"><?php echo $subject_area_error;?></span>
        </div>
        <div>
          <label>School:
            <input type="text" name="school"/>
          </label>
        </div>
        <div>
		  <span class="error"><?php echo $school_error;?></span>
        </div>
        <div>
          <label>School Address:
            <input type="text" name="school_adress"/>
          </label>
        </div>
        <div>
		  <span class="error"><?php echo $school_address_error;?></span>
        </div>
        <div>
          <input type="submit" value="Register" name="register"/>
          <a class="password-reset" href="http://localhost/GenCyber/login.php">Have an account? Login</a>
        </div>
      </form>
    </div>
    <div></div>
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
