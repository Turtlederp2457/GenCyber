<?php
$login_user_email = "";
$user_password = "";
$user_name = "";
$user_role = "";

$login_email_error = "";
$login_password_error = "";
$login_error = "";
$login_query = "";

function test_input($data) {
  $data = trim($data);         
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;    
}

include "database_conn.php";
//flow will be: 
//(1)check if empty, 
//(2)if not empty, ensure correct email format
//(3)if not empty AND correct format, query database for entered email
//(4)fetch password and compare to input
if (isset($_POST['login'])) {
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
  	if (empty($_POST['login_user_email'])) {
      $login_email_error = "Email cannot be empty";
  	} elseif (!filter_var($_POST['login_user_email'], FILTER_VALIDATE_EMAIL)) {
        $login_email_error = "Check to make sure email format is correct";
  	} else {
  		$login_user_email = $_POST['login_user_email'];
  	}
  	
  	if (empty($_POST['user_password'])){
  		$login_password_error = "Password cannot be empty";
  	} else {
  		$user_password = $_POST['user_password'];
  	}
  
  	if (empty($email_error) && empty($password_error)){
      $login_query = "call LoginCheck(?,?)";
      $stmt = mysqli_prepare($connection, $login_query);
      $stmt->bind_param("ss", $login_user_email, $user_password);
      $stmt->execute();
      $stmt->bind_result($login_user_email, $user_password, $user_role);
      $result = $stmt->fetch();
      $stmt->close();
      if (!$result){
      	$login_error = "No valid user found. Please try again.";
      } else {
      	session_start();
      	$_SESSION['user_role'] = $user_role;
      	switch ($_SESSION['user_role']) {
      	  case 'A': 
      	    header('location: admin_landing.php');
      		break;
      	  case 'T':
      		header('location: teacher_landing.php');
      		break;
      	  case 'J':
      		header('location: judge_landing.php');
      		break;
      	}
      }
    }
  }  
}
?>