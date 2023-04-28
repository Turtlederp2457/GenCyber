<?php 
include "login.php";
if(isset($_POST['logout'])){
	include "logout.php";
}
session_start();
if(isset($_POST['download'])) {
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $project_id = $_POST['download'];
      
      // Prepare the SQL statement to select the blobs
      $stmt = $connection->prepare("SELECT AttachmentName, Attachment FROM Attachments WHERE ProjectID = ?");
      $stmt->bind_param("i", $project_id);
      $stmt->execute();
      $result = $stmt->get_result();
      
      // Create a new zip archive
      $zip = new ZipArchive();
      $filename = "Project_" . $_POST['download'] . "_Files";
      
      // Create the zip archive if it doesn't already exist
      if ($zip->open($filename, ZipArchive::CREATE) !== TRUE) {
          exit("Unable to create zip archive");
      }
      
      // Loop through the results and add each blob to the zip archive
      while ($row = $result->fetch_assoc()) {
          // Add the blob data to the zip archive with the file name from the database
          $zip->addFromString($row['AttachmentName'], $row['Attachment']);
      }
      
      // Close the zip archive
      $zip->close();
      
      // Set the HTTP headers to force the file download
      header("Content-type: application/zip");
      header("Content-Disposition: attachment; filename=$filename");
      header("Content-length: " . filesize($filename));
      header("Pragma: no-cache");
      header("Expires: 0");
      
      // Output the file to the browser for download
      readfile("$filename");
      
      // Delete the file from the server
      unlink("$filename");
      
      // Close the database connection
      $connection->close();
     
  }
}
/* Need to update Projects based on EventID (FK)
 * needs work
 */
if(isset($_POST['archive'])){
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ProjectID = intval($_POST['archive']);

    $archive_query = "UPDATE Projects SET EventID = EventID +1 WHERE ProjectID = " .$ProjectID;
    $result = mysqli_query($connection, $sql);
    if (mysqli_affected_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result); 
        echo "hello";
    } else {
        echo "Error";
    }
   
  }
}
?>
<!doctype html>
<html lang="en-us" class="scroll-smooth"/>
<head>
<!-- Required meta tags --> 
<meta charset = "utf-8"/>
<meta name="sitePath" content="http://localhost/GenCyber/admin_project_management.php" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no"/>
<!-- Add your name here one you have helped write this code -->
<meta name="author" content="Gatlin Zornes">
<title>Project Management - Marshall University GenCyber</title>
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
    <a class="button-prior" href="http://localhost/GenCyber/judge_management.php">Judge Management</a>
    <a class="button-prior" style="background-color:#F0F0F0" href="http://localhost/GenCyber/admin_project_management.php">Project Management</a>
    <a class="button-prior" href="http://localhost/GenCyber/winner_management.php">Winner Management</a>
  </div>
  <div style="font-size:1.0em; min-height:60vh" class="wrapper-main">
    <div>
      <h2>Current Projects</h2>
    </div>
    <div>
      <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
      <table>
        <tr>
          <th>Project ID</th>
          <th>Project Title</th>
          <th>Project Description</th>
          <th>Download</th>
          <th>Archive</th>
        </tr>
      <?php 
        $eventID = 1;
        $query = "SELECT ProjectID, Title, Description FROM Projects WHERE EventID = '{$eventID}'";
        $result = mysqli_query($connection, $query);
        while($row=mysqli_fetch_assoc($result)){?>
            <tr><?php
            foreach($row as $key => $field)
                echo '<td>' . htmlspecialchars($field) . '</td>';?>
              <td><button style="all:revert; background-color:green; color: white; width: 100%;" type="submit" name="download" value="<?=$row['ProjectID']?>">Download</button></td>
              <td><button style="all:revert; background-color:purple; color: white; width: 100%;" type="submit" name="archive" value="<?=$row['ProjectID']?>">Archive</button></td>
            </tr>
        <?php }?>
      </table>
      </form>
    </div>
    <div>
      <p>
        To Do List:<br>
		1. Download project content upon completion/submission <br>
        2. Reactivate Event button <br>
        3. The project can be archived by admin for the next round of competition. <br>
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

