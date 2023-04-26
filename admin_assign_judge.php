<?php
include "login.php";
if(isset($_POST['logout'])) {
  include "logout.php";
}
session_start();
print_r($_SESSION);
if (isset($_POST['submit_assign'])){
  if ($_SERVER["REQUEST_METHOD"] == "POST"){ 
      if ($_POST['project_selection'] == "") {
          $_SESSION['project_id'] = false;
      } else {
          $project = $_POST['project_selection'];
          $project_info = json_decode($project);
          $_SESSION['project_id'] = $project_info->{'id'};
          $_SESSION['project_title'] = $project_info->{'title'};
          $_SESSION['project_description'] = $project_info->{'desc'};
          $pid = $_SESSION['project_id'];
          $jid = $_SESSION['judge_id'];
          //set ids as integer variables instead of string for testing
          $proj_id = intval($_SESSION['project_id']);
          $judge_id = intval($_SESSION['judge_id']);
          //set ids as static values for testing MakeReview
          $isEvaluated = 0;
          $b = 29;
          //begin query
//           $make_review_query = "call MakeReview(?, ?)";
          /* Judges -> JudgeID (FK in Reviews) (stored in $_SESSION)
           * Projects ->ProjectID (stored in $_SESSION)
           */
          echo "judgeID: " . $_SESSION['judge_user_id'] . " " . "projectID: ". $_SESSION['project_id'];
          $make_review_query = "INSERT INTO Reviews (ProjectID, JudgeID, isEvaluated) 
            VALUES(
            (SELECT ProjectID FROM Projects WHERE ProjectID='{$_SESSION['project_id']}') ,     
            (SELECT JudgeID FROM Judges WHERE UserID='{$_SESSION['judge_user_id']}'),
            0
            )";
          $result = mysqli_query($connection, $make_review_query);
          //clear created session values
          $_SESSION['project_id'] = false;
          $_SESSION['project_title'] = false;
          $_SESSION['project_description'] = false;
          $_SESSION['judge_first_name'] = false;
          $_SESSION['judge_last_name'] = false;
          $_SESSION['judge_user_id'] = false;
          $_SESSION['judge_email'] = false;
          header('location: judge_management.php');

      }
  }
}
if (isset($_POST['cancel_assign'])){
  if ($_SERVER["REQUEST_METHOD"] == "POST"){
      $_SESSION['judge_first_name'] = false;
      $_SESSION['judge_last_name'] = false;
      $_SESSION['judge_user_id'] = false;
      $_SESSION['judge_email'] = false;
      header('location: judge_management.php');
  }
}
?>
<!doctype html>
<html lang="en-us" class="scroll-smooth"/>
<head>
<!-- Required meta tags --> 
<meta charset = "utf-8"/>
<meta name="sitePath" content="http://localhost/GenCyber/admin_assign_judge.php" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no"/>
<!-- Add your name here one you have helped write this code -->
<meta name="author" content="Gatlin Zornes">
<title>Assign Judge - Marshall University GenCyber</title>
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

#assign_judge_div{
  min-height: 50vh;
  display: block;
  width: 50%;
  background: #B0B0B0;
  border: 3px solid green;
  position: relative;
/* the commented lines were used to make a form centered on window/screen  */
/*   position: absolute; */ 
/*   top: 50%; */ 
/*   left: 50%; * */
/*    margin-right: -50%; */ 
/*    transform: translate(-50%, -50%); */ 
/*    min-height: 50vh; */ 
/*    min-width: 75vh; */ 
/*   grid-template-rows: repeat(4, [row-start] 1fr); */
}
#assign_judge_form {
  grid-template-columns: repeat(2, [col-start] 1fr);
  grid-template-rows: repeat(5, [row-start] 1fr);
  display: grid;
  position:relative;
  grid-template-areas: 
    'first_name last_name'
    'dropdown dropdown'
    'title title_div'
    'description description_div'
    'cancel submit';
}

#submit_assign_btn {
  all:revert; 
  background-color:green;
  height:100%;
  width:100%;
  grid-area: submit;
  position: absolute;
  bottom: 0;
  right: 0;
}

#cancel_btn {
  all:revert;
  background-color:red;
  width: 100%; 
  height:100%;
  grid-area: cancel;
  position: absolute;
  bottom: 0;
  left: 0;
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
  <div id="assign_judge_div">
    <form method="post" id="assign_judge_form" action="<?php echo $_SERVER['PHP_SELF'];?>">
      <label style="grid-area:first_name; margin-top:0" type="text" for="first_name"><?php echo $_SESSION['judge_first_name'];?></label>
      <!--  <input hidden type="text" id="first_name" name="first_name" value="<?=$_SESSION['judge_first_name'];?>"</input> -->
      <label style="grid-area:last_name; margin-top:0" type="text" for="last_name"><?php echo $_SESSION['judge_last_name'];?></label>
      <!--  <input hidden type="text" id="last_name" name="last_name" value="<?=$_SESSION['judge_last_name'];?>"</input> -->
      <?php
        $eventID = 1;
        $query = "SELECT ProjectID, Title, Description FROM Projects WHERE EventID = '{$eventID}'";
        $result = mysqli_query($connection, $query);?>
      <div style="grid-area:dropdown; width:100%">
        <select onchange="onChange()" id="proj_dropdown" style="height:50%; width:100%" name="project_selection">
          <option value="">Select a Project</option>
          <?php
            foreach ($result as $key => $field) {
              $project_id = $field['ProjectID'];
              $project_title = $field['Title'];
              $project_description = $field['Description'];?>
          	  <option id="proj_option" value='{"id":"<?=$project_id?>", "title":"<?=$project_title?>", "desc":"<?=$project_description?>"}'><?php echo $project_id . ". " . $project_title;?></option>
          <?php }?>
	    </select>
	  </div>
      <label style="grid-area:title" id="project_title" for="project_title">Title</label>
      <div style="grid-area:title_div" id="title_div"><?php echo "Title here";?></div>
      <label style="grid-area:description" id="project_description" for="project_description">Description</label>
      <div style="grid-area:description_div" id="description_div"><?php echo "Description here"?></div>
      <button type="submit" id="submit_assign_btn" name="submit_assign">Confirm</button>
      <button type="submit" id="cancel_btn" name="cancel_assign">Cancel</button>
    </form>
  </div>
<!--   this is our script to change title and description based on selection -->
  <script type="text/javascript">
    var select = document.getElementById("proj_dropdown");
    var title_div = document.getElementById("title_div");
    var desc_div = document.getElementById("description_div");
    function onChange() {
      const json = select.options[select.selectedIndex].value; //selected value is now JSON formatted for parsing on submit
      const obj = JSON.parse(json);
//       alert("this is your title: " + obj.title + "this is your desc: " + obj.desc);
	  desc_div.innerHTML = obj.desc;
	  title_div.innerHTML = obj.title
    }
  </script>
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