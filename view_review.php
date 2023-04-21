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
    <meta name="sitePath" content="http://localhost/GenCyber/view_review.php" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no"/>
    <!-- Add your name here one you have helped write this code -->
    <meta name="author" content="Gatlin Zornes, Layne McNeely">
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
            grid-template-columns: 25% 35% 25%;
        }

        form p, div, span, label {
            font-size: 1.0em;
            margin: auto;
            padding-bottom: 10px;
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
            width: 100px;
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

        .wrapper-review-links {
            display: grid;
            grid-template-columns: repeat(5, [col-start] 1fr);
            position: fixed;
            bottom: 0;
            width: 100%;
            height: 90px;   /* Height of the footer */
            background: none;
            padding-bottom: 15px;
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
        <form>
            <!--<button class="button-general" type="submit" name="logout">Log Out</button>-->
            <div></div>
            <div></div>
            <p><?php
                $getJudgeID = "SELECT JudgeID FROM Judges WHERE UserID = " . $_SESSION['UserID'];
                $res = mysqli_query($connection, $getJudgeID);
                if (mysqli_num_rows($res) > 0) {
                    // Save row data to variable
                    $rid = mysqli_fetch_assoc($res);
                } else {
                    echo "No rows found";
                }
                ?></p>
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
    <div style="margin-top:30px; margin-left: 10px">
        <center>
            <h2><?php printf("Review Form, Project " . $_SESSION['ProjectID']); ?></h2><br>
            <table>
                <tr>
                    <th>Category</th>
                    <th>Score</th>
                    <th>Comment</th>
                </tr>
                <?php
                $sql = "SELECT Completeness_score, Completeness_comment, Originality_score, Originality_comment, Creativity_score, Creativity_comment, Clarity_score, Clarity_comment, Explanation_score, Explanation_comment "
                        . "FROM Reviews WHERE ProjectID = " . $_SESSION['ProjectID'] . " and JudgeID = " . $rid['JudgeID'] . ";";
                $result = mysqli_query($connection, $sql);

                if (mysqli_num_rows($result) > 0) {
                    // Save row data to variable
                    $row = mysqli_fetch_assoc($result);
                    // Print row data for testing
                    echo "<tr><td>Completeness</td><td>" . $row["Completeness_score"] . "</td><td>" . $row["Completeness_comment"] . "</td></tr>"
                    . "<tr><td>Originality</td><td>" . $row["Originality_score"] . "</td><td>" . $row["Originality_comment"] . "</td></tr>"
                    . "<tr><td>Creativity</td><td>" . $row["Creativity_score"] . "</td><td>" . $row["Creativity_comment"] . "</td></tr>"
                    . "<tr><td>Clarity</td><td>" . $row["Clarity_score"] . "</td><td>" . $row["Clarity_comment"] . "</td></tr>"
                    . "<tr><td>Video Explanation</td><td>" . $row["Explanation_score"] . "</td><td>" . $row["Explanation_comment"] . "</td></tr>";
                } else {
                    echo "No rows found";
                }

                mysqli_close($connection);
                ?>
            </table>
        </center>
        <div style="width: 100%; display: table; position: fixed; bottom: 0; left: 20">
            <div><button class="button-general" style="background-color: lightgray" type="button" name="cancel" onclick="window.location.href = 'project_evaluation.php';">Go Back</button></div>
        </div>
    </div>

</body>
</html>
