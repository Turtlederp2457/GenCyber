<?php 
include "login.php";
if(isset($_POST['logout'])){
	include "logout.php";
}
session_start();
require_once("database_conn.php");

//our function to create the table of teacher applications
//not currently used
function create_applications_table($connection){ 
  $stmt = mysqli_query($connection,"call AllTeacherApplications()");
  $first_row = true;
  while ($row = mysqli_fetch_assoc($stmt)) {
    if ($first_row) {
      $first_row = false;
      // Output header row from keys.
      echo '<tr>';
      foreach($row as $key => $field) {
        echo '<th>' . htmlspecialchars($key) . '</th>';
      }
      echo '<th>Approve</th>';
      echo '<th>Deny</th>';
      echo '</tr>';
    }
    echo '<tr>';
    foreach($row as $key => $field) {
      echo '<td>' . htmlspecialchars($field) . '</td>';
    }
  }
  $stmt->close();
}

/* Here we will transfer registration data from Teacher_applications -> users_tbl
* Then we will remove the associated row from Teacher_applications
*/

if (isset($_POST['approve'])){
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_email = $_POST['approve'];
    // Making the User table entry
    $approval_query = "INSERT INTO Users (Password, Active, user_email, User_role)".
    "values (?, 1, ?, 'T')";
    $stmt = mysqli_prepare($connection, $approval_query);
    $stmt->bind_param("ss", $user_email, $user_email);
    $stmt->execute();
    $stmt->close();
    //Creating the Teacher table entry for user
    $approval_query = "INSERT INTO Teachers (First_name, Last_name, School_name, School_address, School_city, School_state, UserID) ".
    "select apply.First_name, apply.Last_name, apply.School_name, apply.School_address, apply.School_city, apply.School_state, Users.UserID ".
    "from Teacher_applications apply ".
    "inner join Users ".
    "on apply.user_email = Users.user_email ".
    "where apply.user_email = ?";
    $stmt = mysqli_prepare($connection, $approval_query);
    $stmt->bind_param("s", $user_email);
    $stmt->execute();
    $stmt->close();
    //removes their old entry in teacher application
    $delete_query = "delete from Teacher_applications where Teacher_applications.user_email = ?";
    $stmt = mysqli_prepare($connection, $delete_query);
    $stmt->bind_param("s", $user_email);
    $stmt->execute();
    $stmt->close();
    /* 
    * This is a query to insert into users_tbl 
    * Not currently being used since we insert into teachers_tbl
    */
//     $approval_query = "INSERT INTO users_tbl (First_name, Last_name, School_address, School_city, School_role, School_state, user_email, user_role, School_name) ".
//       "SELECT First_name, Last_name, School_address, School_city, School_role, School_state, user_email, user_role, School_name ".
//       "FROM Teacher_applications WHERE user_email=? ";
//     $stmt = mysqli_prepare($connection, $approval_query);
//     $stmt->bind_param("s", $user_email);
//     $stmt->execute();
//     $stmt->close();
/* 
* Here is our query to insert applicants into teachers_tbl
*/
$approval_query = "INSERT INTO teachers_tbl ".
"(first_name, last_name, school_address, school_city, school_name, school_role, school_state, user_email, user_role) ".
"SELECT First_name, Last_name, user_email, School_name, School_address, School_city, School_state, School_role, user_role ".
"FROM `Teacher_applications` ".
"WHERE user_email = ?";
$stmt = mysqli_prepare($connection, $approval_query);
$stmt->bind_param("s", $user_email);
$stmt->execute();
$stmt->close();
/*
* Here is where we delete the application from Teacher_applications
* Need to verify record was successfully transferred BEFORE deletion to prevent problems
     */
    //     $remove_query = "DELETE FROM Teacher_applications WHERE user_email=? ";
    //     $stmt = mysqli_prepare($connection, $remove_query);
    //     $stmt->bind_param("s", $user_email);
    //     $stmt->execute();
//     $stmt->close();
}
}

if (isset($_POST['deny'])){
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_email = $_POST['deny'];
    $stmt = mysqli_prepare($connection, "Call DeleteApplication(?)");
    $stmt->bind_param("s", $user_email);
    $stmt->execute();
    $stmt->close();
  }
}
?>
<!doctype html>
<html lang="en-us" class="scroll-smooth"/>
<head>
  <!-- Required meta tags --> 
  <meta charset = "utf-8"/>
  <meta name="sitePath" content="http://localhost/GenCyber/teacher_management.php" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no"/>
  <!-- Add your name here one you have helped write this code -->
  <meta name="author" content="Gatlin Zornes">
  <title>Teacher Management - Marshall University GenCyber</title>
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
  display: grid;
  grid-template-columns: repeat(4, [col-start] 1fr);
  margin: auto;
  text-align: center;
  font-size: 1.2em;
  padding-bottom: 3px;
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
  <div class="wrapper-admin-links">
    <a class="button-prior" href="http://localhost/GenCyber/teacher_management.php">Teacher Management</a>
    <a class="button-prior" href="http://localhost/GenCyber/judge_management.php">Judge Management</a>
    <a class="button-prior" href="http://localhost/GenCyber/admin_project_management.php">Project Management</a>
    <a class="button-prior" href="http://localhost/GenCyber/winner_management.php">Winner Management</a>
  </div>
  <div style="margin-top:10px;font-size:1.0em; min-height:30vh" >
    <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
      <h2>Teacher Applications</h2>
      <table>
        <tr>
          <th>First Name</th>
          <th>Last Name</th>
          <th>User Email</th>
          <th>School Name</th>
          <th>School State</th>
          <th>School Role</th>
          <th>Approve</th>
          <th>Deny</th>
        </tr>
        <?php
          $result = mysqli_query($connection,"call AllTeacherApplications()");
          while($row=mysqli_fetch_assoc($result)){?>
          <tr><?php 
          foreach($row as $key => $field)
          echo '<td>' . htmlspecialchars($field) . '</td>';?>
            <td><button style="all:revert; background-color:green" type="submit" name="approve" value="<?=$row['user_email']?>">Approve</button></td>
            <td><button style="all:revert; background-color:red" type="submit" name="deny" value="<?=$row['user_email']?>">Deny</button></td>
          </tr>
          <?php } mysqli_next_result($connection);?>
      </table> 
    </form>  
    </div>
    <div style="margin-top:10px;font-size:1.0em; min-height:30vh" >
    <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
      <h2>Active Teachers</h2>
      <table>
        <tr>
          <th>User Email</th>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Deactive</th>
        </tr>
        <?php
          $result = mysqli_query($connection,"call AllActiveTeachers()");
          while($row=mysqli_fetch_assoc($result)){?>
          <tr><?php 
          foreach($row as $key => $field)
          	echo '<td>' . htmlspecialchars($field) . '</td>';?>
            <td><button style="all:revert; background-color:green" type="submit" name="Deactive" value="<?=$row['user_email']?>">Approve</button></td>
          </tr>
          <?php } mysqli_next_result($connection);?>
      </table> 
    </form>  
    </div>
    <div style="margin-top:10px;font-size:1.0em; min-height:30vh" >
    <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
      <h2>Inactive Teachers</h2>
      <table>
        <tr>
          <th>User Email</th>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Deactive</th>
        </tr>
        <?php
          $result = mysqli_query($connection,"call AllInactiveTeachers()");
          while($row=mysqli_fetch_assoc($result)){?>
          <tr><?php 
          foreach($row as $key => $field)
          	echo '<td>' . htmlspecialchars($field) . '</td>';?>
            <td><button style="all:revert; background-color:green" type="submit" name="Deactive" value="<?=$row['user_email']?>">Approve</button></td>
          </tr>
          <?php } mysqli_next_result($connection);?>
      </table> 
    </form> 
    </div>
  </div>
  <div>
    <p>
        To Do List:<br>
        1. Need to update DB to hold Active Status <br>
        2. Show the list of active teachers with "inactivate" button. <br>
        3. Show the list of old/inactive teachers with "activate" button<br>
        4. add CSS for table(s) <br>
      </p>
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