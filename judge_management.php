<?php
include "login.php";
if(isset($_POST['logout'])) {
  include "logout.php";
}
session_start();
require_once("database_conn.php");

/*
 * This is where we will begin our query to insert
 * judge values into judges_tbl
 */
if (isset($_POST['submit_judge'])) {
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
  	$first_name = $_POST['first_name'];
  	$last_name = $_POST['last_name'];
  	$user_email = $_POST['user_email'];
    $password = $_POST['password'];
  	$phone_number = $_POST['phone_number'];
  	$company_name = $_POST['company_name'];
  	$company_role = $_POST['company_role'];
    $user_role = "J";
    $active = 1;
    //creates an entry into the Users table
    $create_user_query = "insert into Users ".
      "(Password, Active, user_email, User_role)".
      "values (?, ?, ?, ?)";
      $stmt = mysqli_prepare($connection, $create_user_query);
      $stmt->bind_param("ssss", $password, $active, $user_email, $user_role);
      $stmt->execute();
    //Finds the UserID given by the database to the user
    $UserID_query = "SELECT UserID FROM Users where user_email = '{$user_email}'";
    $result = mysqli_query($connection, $UserID_query);
    $userID = mysqli_fetch_assoc($result);
    //Creates Judge entry using fetched UserID
    $create_judge_query = "insert into Judges ".
    "(First_name, Last_name, Phone, Company_name, UserID, company_role) ".
    "values (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($connection, $create_judge_query);
    $stmt->bind_param("ssssss", $first_name, $last_name, $phone_number, $company_name, $userID["UserID"], $company_role);
    $stmt->execute();
    $stmt->close();
//     Need to display success or error messaging
  }
}

/* Here we will set the active status of Judges to 0
 */
if (isset($_POST['deactivate'])){
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_email = $_POST['deactivate'];
    $deactivate_query = "UPDATE Users SET Active=0 WHERE user_email = ?";
    $stmt = mysqli_prepare($connection, $deactivate_query);
    $stmt->bind_param("s", $user_email);
    $stmt->execute();
    $stmt->close();
  }
}

/* Here we will set the active status of Judges to 1
 */  
if (isset($_POST['activate'])) {
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_email = $_POST['activate'];
    $activate_query = "UPDATE Users SET Active=1 WHERE user_email = ?";
    $stmt = mysqli_prepare($connection, $activate_query);
    $stmt->bind_param("s", $user_email);
    $stmt->execute();
    $stmt->close();
  }
}

/* Here we will retrieve the values of selected judge
 * Then we will set SESSION values to use as needed
 */
if (isset($_POST['assign_judge'])) {
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_email = $_POST['assign_judge'];
    $_SESSION['judge_email'] = $user_email;
    $query = "SELECT Users.UserID, Users.user_email, Judges.First_name, Judges.Last_name ".
      "FROM Users inner join Judges on Users.UserID = Judges.UserID ".
      "WHERE Users.user_email = '{$_SESSION['judge_email']}'";
    $result = mysqli_query($connection, $query);
    $judge = mysqli_fetch_assoc($result);
    $_SESSION['judge_first_name'] = $judge['First_name'];
    $_SESSION['judge_last_name'] = $judge['Last_name'];
    $_SESSION['judge_id'] = $judge['UserID'];
    header('location: admin_assign_judge.php');
  }
}

function clearStoredResults($mysqli_link){
  while($mysqli_link->next_result()){
    if($l_result = $mysqli_link->store_result()){
      $l_result->free();
    }
  }
}                     
?>
<!doctype html>
<html lang="en-us" class="scroll-smooth"/>
<head>
<!-- Required meta tags --> 
<meta charset = "utf-8"/>
<meta name="sitePath" content="http://localhost/GenCyber/judge_management.php" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no"/>
<!-- Add your name here one you have helped write this code -->
<meta name="author" content="Gatlin Zornes">
<title>Judge Management - Marshall University GenCyber</title>
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

.wrapper-admin-links {
  display: grid;
  grid-template-columns: repeat(4, [col-start] 1fr);
  background-color: none;	
/*   border-top: 1px solid black; */
  border: 1px solid black;
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

table, th, td {
  border: 1px solid;
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
    <a style="color:white" class="better-title center" href="http://localhost/GenCyber/admin_landing.php">Marshall University GenCyber</a>
    <a class="center" target="_blank" href="https://www.gen-cyber.com/">
      <img src="https://www.gen-cyber.com/static/gencyber_public_web/img/gencyber-logo-small.png" 
        style="height:100px;width:150px" alt="GenCyber Logo" class="gencyber-logo"/>
    </a>
  </div>
  <div class="wrapper-admin-links">
    <a class="button-prior" href="http://localhost/GenCyber/teacher_management.php">Teacher Management</a>
    <a class="button-prior" style="background-color:#F0F0F0" href="http://localhost/GenCyber/judge_management.php">Judge Management</a>
    <a class="button-prior" href="http://localhost/GenCyber/admin_project_management.php">Project Management</a>
    <a class="button-prior" href="http://localhost/GenCyber/winner_management.php">Winner Management</a>
  </div>
  <div style="margin-top:10px; font-size:1.0em">
    <button id="create_judge_btn">Create New Judge</button>
      <form style="all:revert;display:none" method="post" id="create_judge_form" action="<?php echo $_SERVER['PHP_SELF'];?>">
        <label for="">First Name</label>
        <input type="text" name="first_name" placeholder="First Name" required> <br>
        <label for="">Last Name</label>
        <input type="text" name="last_name" placeholder="Last Name" required> <br>
        <label for="">Email</label>
        <input type="text" name="user_email" placeholder="Judge Email" required> <br>
        <label for="">Phone Number</label>
        <input type="tel" name="phone_number" placeholder="Judge Phone" required> <br>
        <label for="">Password</label>
        <input type="text" name="password" placeholder="Password" required> <br>
        <label for="">Company Name</label>
        <input type="text" name="company_name" placeholder="Judge Company" required> <br>
        <label for="">Company Role</label>
        <input type="text" name="company_role" placeholder="Company Role" required> <br>
        <button type="submit" name="submit_judge">Submit</button>
      </form>
  </div>
<!--   This is our judge creation script -->
  <script src="create_judge.js"></script>
  <div style="margin-top:20px;min-height:30vh">
    <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
      <h2>Active Judges</h2>
      <table>
        <tr>
          <th>User Email</th>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Deactivate</th>
          <th>Assign to Project</th>
        </tr>
        <?php
          $result = mysqli_query($connection,"call AllActiveJudges()", MYSQLI_STORE_RESULT);
          while($row=mysqli_fetch_assoc($result)){?>
            <tr><?php
            foreach($row as $key => $field)
          	  echo '<td>' . htmlspecialchars($field) . '</td>';?>
              <td><button style="all:revert; background-color:red; width: 100%;" type="submit" name="deactivate" value="<?=$row['user_email']?>">Deactivate</button></td>
              <td>
  			    <button style="all:revert; width:100%" id="assign_judge_btn" name="assign_judge" type="submit" value="<?=$row['user_email'];?>">Assign</button>        
      		  </td>
            </tr>
        <?php }?>
      </table> 
    </form>    
  </div>
  <?php clearStoredResults($connection);?>
  <div style="margin-top:20px;min-height:30vh">
    <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
      <h2>Inactive Judges</h2>
      <table style="min-width:50vh">
        <tr>
          <th>User Email</th>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Activate</th>
        </tr>
        <?php     
          $result = mysqli_query($connection, "call GetInactiveJudges()");
          while($row=mysqli_fetch_assoc($result)){?>
          <tr><?php 
          foreach($row as $key => $field)
          	echo '<td>' . htmlspecialchars($field) . '</td>';?>
            <td><button style="all:revert; background-color:green; width:100%" type="submit" name="activate" value="<?=$row['user_email']?>">Activate</button></td>
          </tr>
          <?php }?>
      </table> 
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