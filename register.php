<?php
include "login.php";
session_start();
$first_name = "";
$last_name = "";
$user_email = "";
$school_name = "";
$school_address = "";
$school_city = "";
$school_state = "";
$school_role = "";
// $middle_name = "";
// $user_password = "";
// $phone_number = ""; 
// $subject_area = "";

$first_name_error = "";
$last_name_error = "";
$user_email_error = "";
$school_name_error = "";
$school_address_error = "";
$school_city_error = "";
$school_state_error = "";
$school_role_error = "";
// $middle_name_error = "";
// $password_error = "";
// $phone_number_error = "";
// $subject_area_error = "";
  
function prepared_query($mysqli, $sql, $params, $types = "") {
  $types = $types ?: str_repeat("s", count($params));
  $stmt = $mysqli->prepare($sql);
  $stmt->bind_param($types, ...$params);
  $stmt->execute();
  return $stmt;
}

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
    
//     currently not using middle name	
//     if (!preg_match("/^[a-zA-Z]*$/", test_input($_POST['middle_name']))) {
//       $middle_name_error = "Only letters allowed.";
//     } else {
//     	$middle_name = test_input($_POST['middle_name']);
//     }
    
    if (empty(test_input($_POST['last_name']))){
      $last_name_error = "Last name cannot be empty";
    } elseif (!preg_match("/^[a-zA-Z]*$/",test_input($_POST['last_name']))) { 
        $last_name_error = "Only letters allowed";
    } else {
    	$last_name = test_input($_POST['last_name']);
    }
    
    //user_email needs to be confirmed unique and not already in database
    if (empty(test_input($_POST['user_email']))){
      $user_email_error = "Email cannot be empty";
    } elseif (!filter_var(test_input($_POST['user_email']), FILTER_VALIDATE_EMAIL)) {
        $user_email_error = "Check to make sure email is correct";
    } else {  //check email uniqueness here
    	$email_query = "SELECT user_email FROM Teacher_applications WHERE user_email = ?";
    	if ($stmt = mysqli_prepare($connection, $email_query)){
    	  mysqli_stmt_bind_param($stmt, "s", $param_user_email);
    	  $param_user_email = test_input($_POST['user_email']);
    	  if (mysqli_stmt_execute($stmt)){
    	  	mysqli_stmt_store_result($stmt);
              if(mysqli_stmt_num_rows($stmt) == 1){
                $user_email_error = "This email is already in use. Please try logging in";
              } else {
              	$user_email = test_input($_POST['user_email']);
              }
    	  } else {
    	  	echo "something went wrong. Please try again later.";
    	  }
    	}
        mysqli_stmt_close($stmt);
    }
  
    
    //currently not using password, phone number, or subject area
//     if (empty(test_input($_POST['user_password']))){
//       $password_error = "Password cannot be empty";
//     } else {
//     	$user_password = test_input($_POST['user_password']);
//     }
    
//     if (empty(test_input($_POST["phone_number"]))){
//   	  $phone_number_error = "Phone number cannot be empty";
//     } elseif (!preg_match("/^\d{10}$/",test_input($_POST['phone_number']))) { 
//         $phone_number_error = "Please enter your 10-digit phone number with no spaces";
//     } else {
//     	$phone_number = test_input($_POST['phone_number']);
//     }
    
//     if (empty(test_input($_POST['subject_area']))) {
//       $subject_area_error = "Subject cannot be empty";
//     } elseif (!preg_match("/^[a-zA-Z ]*$/", test_input($_POST['subject_area']))) {
//         $subject_area_error = "Only letters allowed";
//     } else {
//     	  $subject_area = test_input($_POST['subject_area']);
//     }
    
    if (empty(test_input($_POST['school_name']))) {
      $school_name_error = "School name cannot be empty";
    } elseif (!preg_match("/^[a-zA-Z ]*$/", test_input($_POST['school_name']))) {
        $school_name_error = "Only letters allowed";
    } else {
    	$school_name = test_input($_POST['school_name']);
    }
    //this leads to an undefined array key "school_address" error
//     if (empty(test_input($_POST['school_address']))) {
//       $school_address_error = "School Address cannot be empty";
//     } else {
//     	$school = $_POST['school_address'];
//     }
    if (empty(test_input($_POST['school_address']))) {
      $school_address_error = "School address cannot be empty";
    } elseif (!preg_match("/^[a-zA-Z-0-9 ]*$/", test_input($_POST['school_address']))) {
        $school_address_error = "Please enter only numbers or letters";
    } else {
    	$school_address = test_input($_POST['school_address']);
    }

    if (empty(test_input($_POST['school_city']))) {
      $school_city_error = "School city cannot be empty";
    } elseif (!preg_match("/^[a-zA-Z ]*$/", test_input($_POST['school_city']))) {
        $school_city_error = "Only letters allowed";
    } else {
    	$school_city = test_input($_POST['school_city']);
    }
    
    if ($_POST['school_state'] == "") {
      $school_state_error = "School state cannot be empty";
    } else {
    	$school_state = ($_POST['school_state']);
    }
    
    if (empty(test_input($_POST['school_role']))) {
      $school_role_error = "School role cannot be empty";
    } elseif (!preg_match("/^[a-zA-Z ]*$/", test_input($_POST['school_role']))) {
        $school_role_error = "Only letters allowed";
    } else {
    	$school_role = test_input($_POST['school_role']);
    }
    
    if (empty($first_name_error) && empty($last_name_error) && empty($user_email_error) &&
    		empty($school_name_error) && empty($school_address_error) && 
    		empty($school_city_error) && empty($school_state_error) && empty($school_role_error)){
    	// We need to check if the account with that username exists.
        if ($stmt = $connection->prepare('SELECT user_email FROM Teacher_applications WHERE user_email = ?')) {
	    // Bind parameters (s = string, i = int, b = blob, etc), hash the password using the PHP password_hash function.
	    $stmt->bind_param('s', $_POST['user_email']);
	    $stmt->execute();
	    $stmt->store_result();
	    // Store the result so we can check if the account exists in the database.
	    if ($stmt->num_rows > 0) {
		  // Username already exists
		  echo 'Account already exists, please try logging in';
	    } else {
		  // Username doesn't exists, insert new account
	      if ($stmt = $connection->prepare('INSERT INTO Teacher_applications (first_name, last_name, user_email, school_name, school_address, school_city, school_state, school_role)'.
	      		'VALUES (?, ?, ?, ?, ?, ?, ?, ?)')) {
          // We do not want to expose passwords in our database, so hash the password and use password_verify when a user logs in.
	      	$stmt->bind_param('ssssssss', $first_name, $last_name, $user_email, $school_name, $school_address, $school_city, $school_state, $school_role);
          	$stmt->execute();
          	header('location: thank_you.php');
          	
          } else {
            // Something is wrong with the SQL statement
          	echo 'Could not prepare statement!';
          }
	    }
	$stmt->close();
    } else {
	// Something is wrong with the SQL statement
	  echo 'Could not prepare statement!';
    }
    $connection->close();
    }
  }
}
?>
<!doctype html>
<html lang="en-us" class="scroll-smooth"/>
<head>
<!-- Required meta tags --> 
<meta charset = "utf-8"/>
<meta name="sitePath" content="http://localhost/GenCyber/register.php" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no"/>
<!-- Add your name here once you have helped write this code -->
<meta name="author" content="Gatlin Zornes">
<title>Sign Up - Marshall University GenCyber</title>
<!-- <link rel="stylesheet" type="text/css" href="/GenCyber/stylesheets/newHome_stylesheet.css" /> -->
<!-- <link rel="stylesheet" type="text/css" href="/GenCyber/stylesheets/register_stylesheet.css" /> -->
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
/*   grid-template-columns: repeat(4, [col-start] 1fr); */
}

form p, div, span, label {
  font-size: 1.2em;
  margin: auto;
}

.login-form {
  display: grid;
  margin-bottom: 0;
  grid-template-columns: repeat(4, [col-start] 1fr);
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
  width: 100%;
  position:fixed; 
  bottom: 0;
  display: grid;
  grid-template-columns: repeat(4, [col-start] 1fr);
  margin: auto;
  text-align: center;
  font-size: 1.2em;
}

.registration-form {
  font-size: 0.8em;
  min-height:50vh;
}
</style>
<body>
  <header>
    <form class="login-form" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
      <button class="button-general" type="submit" name="login">Log In</button>
      <p>
        <label for="">Email</label>
        <input type="text" name="login_user_email" value="<?php echo $login_user_email;?>">
      </p>
      <p>
        <label for="">Password</label>
        <input type="password" name="user_password">
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
    <a class="button-prior" href="http://localhost/GenCyber/contact.php">Contact Us</a>
  </div>
  <div>
<!--     echo htmlspecialchars($_SERVER["PHP_SELF"]);?> -->
<!-- 	 thank_you.php -->
    <form class="registration-form" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
      <div>
        <p>
          <label for="">First Name</label>
          <input type="text" name="first_name" value="<?php echo $first_name;?>">
        </p>
      </div>
      <div>
        <span class="error"><?php echo $first_name_error;?></span>
      </div>
      <div>
        <p>
          <label for="">Last Name</label>
          <input type="text" name="last_name" value="<?php echo $last_name;?>">
        </p>
      </div>
      <div>
        <span class="error"><?php echo $last_name_error;?></span>
      </div>
      <div>
        <p>
          <label for="">Email Address</label>
          <input type="text" name="user_email" value="<?php echo $user_email;?>">
        </p>
      </div>
      <div>
        <span class="error"><?php echo $user_email_error;?></span>
      </div>
      <div>
        <p>
          <label for="">School Name</label>
          <input type="text" name="school_name" value="<?php echo $school_name;?>">
        </p>
      </div>
      <div>
        <span class="error"><?php echo $school_name_error;?></span>
      </div>
      <div>
        <p>
          <label for="">School Address</label>
          <input type="text" name="school_address" value="<?php echo $school_address;?>">
        </p>
      </div>
      <div>
        <span class="error"><?php echo $school_address_error;?></span>
      </div>
      <div>
        <p>
          <label for="">School City</label>
          <input type="text" name="school_city" value="<?php echo $school_city;?>">
        </p>
      </div>
      <div>
        <span class="error"><?php echo $school_city_error;?></span>
      </div>
      <div>
        <p>
          <label for="">School State</label>
          <select name="school_state" placeholder="Pick a state...">
            <option value="">Select a state...</option>
            <option value="AL">Alabama</option>
            <option value="AK">Alaska</option>
            <option value="AZ">Arizona</option>
            <option value="AR">Arkansas</option>
            <option value="CA">California</option>
            <option value="CO">Colorado</option>
            <option value="CT">Connecticut</option>
            <option value="DE">Delaware</option>
            <option value="DC">District of Columbia</option>
            <option value="FL">Florida</option>
            <option value="GA">Georgia</option>
            <option value="HI">Hawaii</option>
            <option value="ID">Idaho</option>
            <option value="IL">Illinois</option>
            <option value="IN">Indiana</option>
            <option value="IA">Iowa</option>
            <option value="KS">Kansas</option>
            <option value="KY">Kentucky</option>
            <option value="LA">Louisiana</option>
            <option value="ME">Maine</option>
            <option value="MD">Maryland</option>
            <option value="MA">Massachusetts</option>
            <option value="MI">Michigan</option>
            <option value="MN">Minnesota</option>
            <option value="MS">Mississippi</option>
            <option value="MO">Missouri</option>
            <option value="MT">Montana</option>
            <option value="NE">Nebraska</option>
            <option value="NV">Nevada</option>
            <option value="NH">New Hampshire</option>
            <option value="NJ">New Jersey</option>
            <option value="NM">New Mexico</option>
            <option value="NY">New York</option>
            <option value="NC">North Carolina</option>
            <option value="ND">North Dakota</option>
            <option value="OH">Ohio</option>
            <option value="OK">Oklahoma</option>
            <option value="OR">Oregon</option>
            <option value="PA">Pennsylvania</option>
            <option value="RI">Rhode Island</option>
            <option value="SC">South Carolina</option>
            <option value="SD">South Dakota</option>
            <option value="TN">Tennessee</option>
            <option value="TX">Texas</option>
            <option value="UT">Utah</option>
            <option value="VT">Vermont</option>
            <option value="VA">Virginia</option>
            <option value="WA">Washington</option>
            <option value="WV">West Virginia</option>
            <option value="WI">Wisconsin</option>
            <option value="WY">Wyoming</option>
          </select>
        </p>
      </div>
       <div>
        <span class="error"><?php echo $school_state_error;?></span>
      </div>
      <div>
        <p>
          <label for="">Role at School</label>
          <input type="text" name="school_role" value="<?php echo $school_role;?>">
        </p>
      </div>
      <div>
        <span class="error"><?php echo $school_role_error;?></span>
      </div>
      <div>
        <p>reCaptcha should go here</p>
      </div>
      <button class="button-general" type="submit" name="register">Register</button>
    </form>
   </div>
   <div style="font-size:1.0em">
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
