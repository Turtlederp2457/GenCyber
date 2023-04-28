<?php
include "login.php";
if(isset($_POST['logout'])){
    include "logout.php";
}
session_start();
/* get and set judge ID
 * Not currently being used
 */
if(isset($_GET['confirm_btn'])){
  if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if ($_GET['judge_selection'] == ""){
      $_SESSION['judge_id'] = false;
    } else {
      $_SESSION['judge_id'] = $_GET['judge_selection'];
      
    }
  }
}

?>
<!doctype html>
<html lang="en-us" class="scroll-smooth"/>
<head>
<!-- Required meta tags --> 
<meta charset = "utf-8"/>
<meta name="sitePath" content="http://localhost/GenCyber/admin_view_comments.php" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no"/>
<!-- Add your name here one you have helped write this code -->
<meta name="author" content="Gatlin Zornes">
<title>View Comments - Marshall University GenCyber</title>
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

#judge_selection_div{
  height: 100%; 
  width: 100%;
  display: block;
}

#judge_selection_form{
  height: 100%;
  display: grid;
  grid-template-areas:
    'prompt prompt'
    'dropdown dropdown'
    'confirm confirm';
}

#judge_comments_div{
  height: 100%; 
  width: 100%;
  display: grid;
  grid-template-rows: repeat(5, [row-start] 1fr);
  grid-template-columns: repeat(2, [col-start] 1fr);
  grid-template-areas:
    'completeness completeness_div'
    'originality originality_div'
    'creativity creativity_div'
    'clarity clarity_div'
    'explanation explanation_div';
}
#confirm_btn{
  all:revert; 
  background-color:green;
  height: 50%;
  width: 100%;
  grid-area: confirm;
  position: relative;
  bottom: 0;
  right: 0;
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
    <a class="button-prior" href="http://localhost/GenCyber/admin_project_management.php">Project Management</a>
    <a class="button-prior" style="background-color:#F0F0F0" href="http://localhost/GenCyber/winner_management.php">Winner Management</a>
  </div>
  <div style="font-size:1.0em; min-height:60vh" class="wrapper-main">
<!--     something previously being worked on (outdated) -->
    <div id="judge_selection_div" style="display:none">
      <form id="judge_selection_form" method="get" action="<?php echo $_SERVER['PHP_SELF'];?>">
        <div style="height:50%; grid-area:prompt; margin-top: 0; margin-bottom:0">Select a judge from the dropdown menu to view their comments</div>
        <?php //$review_query = "SELECT R.JudgeID, J.First_name, J.Last_name FROM Reviews as R 
//               INNER JOIN Judges as J on R.JudgeID = J.JudgeID
//               WHERE ProjectID = " . $_SESSION['project_id'];
        //$result = mysqli_query($connection, $review_query);?>
        <select onchange="displayComments()" id="judge_dropdown" style="grid-area: dropdown;" name="judge_selection">
          <option value="">Select a Judge</option>>
          <?php foreach($result as $key=> $field){?>
          <option id="judge_option" value="<?=$field['JudgeID']?>"><?php echo $field['First_name'] . " " . $field['Last_name'];?></option>
          <?php }?>
        </select>
        <button type="submit" id="confirm_btn" name="confirm_btn">Confirm</button>
      </form>
    </div>
    <div id="judge_comments_div">
      <?php $query = "SELECT Completeness_comment, Originality_comment, Creativity_comment, Clarity_comment, Explanation_comment
              FROM Reviews WHERE ReviewID= " .$_SESSION['reviewID'];
        $result = mysqli_query($connection, $query);
        $row=mysqli_fetch_assoc($result);
        $completeness = $row['Completeness_comment'];
        $originality = $row['Originality_comment'];
        $creativity = $row['Creativity_comment'];
        $clarity = $row['Clarity_comment'];
        $explanation = $row['Explanation_comment'];      

      ?>
        <label style="grid-area:completeness; margin-left: 0" id="completeness" for="completeness">Completeness :</label>
        <div style="grid-area:completeness_div" id="completeness_div"><?php echo $completeness;?></div>
        <label style="grid-area:originality; margin-left: 0" id="originality" for="originality">Originality :</label>
        <div style="grid-area:originality_div" id="originality_div"><?php echo "$originality";?></div>
        <label style="grid-area:creativity; margin-left: 0" id="creativity" for="creativity">Creativity :</label>
        <div style="grid-area:creativity_div" id="creativity_div"><?php echo $creativity;?></div>
        <label style="grid-area:clarity; margin-left: 0" id="clarity" for="project_title">Clarity :</label>
        <div style="grid-area:clarity_div" id="clarity_div"><?php echo $clarity;?></div>
        <label style="grid-area:explanation; margin-left: 0" id="explanation" for="project_title">Explanation :</label>
        <div style="grid-area:explanation_div" id="explanation_div"><?php echo $explanation;?></div>
    </div>
<!--     Used for dropdown value retrieval/change. not currently being used -->
    <script type="text/javascript">
      var judge_select = document.getElementById("judge_dropdown");
      var comp_div = document.getElementById("completeness_div");
      var orig_div = document.getElementById("originality_div");
      var create_div = document.getElementById("creativity_div");
      var clarity_div = document.getElementById("clarity_div");
      var explan_div = document.getElementById("explanation_div");
      function displayComments(){
        comp_div.innerHTML = $_SESSION['completeness_comment'];
      }
    </script>
    <div>
      <?php 
        
      ?>
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

