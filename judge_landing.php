<?php
include "login.php";
if (isset($_POST['logout'])) {
    include "logout.php";
}
session_start();
require_once("database_conn.php");
?>
<!doctype html>
<html lang="en-us" class="scroll-smooth"/>
<head>
    <!-- Required meta tags --> 
    <meta charset = "utf-8"/>
    <meta name="sitePath" content="http://localhost/GenCyber/judge_landing.php" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no"/>
    <!-- Add your name here one you have helped write this code -->
    <!doctype html>
<html lang="en-us" class="scroll-smooth"/>
<head>
    <!-- Required meta tags --> 
    <meta charset = "utf-8"/>
    <meta name="sitePath" content="http://localhost/GenCyber/judge_landing.php" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no"/>
    <!-- Add your name here one you have helped write this code -->
    <meta name="author" content="Gatlin Zornes, Layne McNeely">
    <title>Judge - Marshall University GenCyber</title>
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

        .wrapper-judge-links {
            display: grid;
            grid-template-columns: repeat(2, [col-start] 1fr);
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
    </style>
<body>
    <header>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <button class="button-general" type="submit" name="logout">Log Out</button>
            <div></div>
            <p>
                <?php
                $sql = "SELECT First_name FROM Judges WHERE UserID = " . $_SESSION['UserID'];
                $result = mysqli_query($connection, $sql);
                
                if (mysqli_num_rows($result) > 0) {
                    // Save row data to variable
                    $row = mysqli_fetch_assoc($result);
                    // Print row data for testing
                    echo "Welcome, " . $row["First_name"];
                    //print_r($row);
                } else {
                    echo "No rows found";
                }
                
                //mysqli_close($connection);
                ?>
            </p>
        </form>
    </header>
    <div class="wrapper-logos">
        <a class="center" target="_blank" href="https://www.marshall.edu/">
            <img src="//www.marshall.edu/gencyber/wp-content/themes/marsha/images/m_primary.svg" 
                 style="height:100px;width:120px" alt="Marshall University logo" class="marshall-logo"/>
        </a>
        <a style="color:white" class="better-title center">Marshall University GenCyber</a>
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
    <div class="wrapper-judge-links">
        <a class="button-prior" href="http://localhost/GenCyber/judge_profile_management.php">Profile Management</a>
        <a class="button-prior" href="http://localhost/GenCyber/project_evaluation.php">Project Evaluation</a>
    </div>
    <div style="font-size:1.0em; min-height:60vh" class="wrapper-main">
        <div style="margin:0">
            <!--Left panel-->
        </div>
        <div style="font-size:24px; min-height:60vh;">
            <center>
                <?php
                printf("Hey👋, 👨‍⚖ " . $row["First_name"]);
                
                //Get JudgeID
                $getJudgeID = "SELECT JudgeID FROM Judges WHERE UserID = ". $_SESSION['UserID'];
                $res = mysqli_query($connection, $getJudgeID);
                if (mysqli_num_rows($res) > 0) {
                    // Save row data to variable
                    $rid = mysqli_fetch_assoc($res);
                } else {
                    echo "No rows found";
                }
                
                //Get # of unevaluated projects
                $sql2 = "SELECT IsEvaluated FROM Reviews WHERE JudgeID = '". $rid["JudgeID"] ."' and IsEvaluated = 0";
                if ($res = mysqli_query($connection, $sql2)) {
                    // Return the number of rows in result set
                    $rowcount = mysqli_num_rows($res);
                }
                mysqli_close($connection);
                ?>!<br><br>
                You have <b><?php echo $rowcount; ?></b> projects that need evaluating.<br>
                Head over to Project Evaluation to get started.<br><br>
                Use the two buttons above to <br>navigate the Judge Dashboard.
                <!--Hey👋, 👨‍⚖!-->
            </center>
        </div>
        <div>
            <!--Right panel-->
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
