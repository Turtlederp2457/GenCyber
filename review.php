<?php
include "login.php";
if (isset($_POST['logout'])) {
    include "logout.php";
}
session_start();
require_once("database_conn.php");

$completenessS = "";
$completenessC = "";
$originalityS = "";
$originalityC = "";
$creativityS = "";
$creativityC = "";
$clarityS = "";
$clarityC = "";
$explanationS = "";
$explanationC = "";

$general_error = "";
$score_error = "";

$getJudgeID = "SELECT JudgeID FROM Judges WHERE UserID = " . $_SESSION['UserID'];
$res = mysqli_query($connection, $getJudgeID);
if (mysqli_num_rows($res) > 0) {
    // Save row data to variable
    $rid = mysqli_fetch_assoc($res);
} else {
    echo "No rows found";
}

if (isset($_POST['save'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Store whatever is in fields to database; empty or not.
        $completenessS = test_input($_POST['completenessS']);
        $completenessC = test_input($_POST['completenessC']);
        $originalityS = test_input($_POST['originalityS']);
        $originalityC = test_input($_POST['originalityC']);
        $creativityS = test_input($_POST['creativityS']);
        $creativityC = test_input($_POST['creativityC']);
        $clarityS = test_input($_POST['clarityS']);
        $clarityC = test_input($_POST['clarityC']);
        $explanationS = test_input($_POST['explanationS']);
        $explanationC = test_input($_POST['explanationC']);
        
        if (empty($general_error)) {
            $sql = "UPDATE Reviews SET Completeness_score = " . $completenessS . ", Completeness_comment = '" . $completenessC . "', Originality_score = " . $originalityS . ", Originality_comment = '" . $originalityC . "',"
                    . "Creativity_score= " . $creativityS . ",Creativity_comment= '" . $creativityC . "',Clarity_score= " . $clarityS . ",Clarity_comment= '" . $clarityC . "',"
                    . "Explanation_score= " . $explanationS . ",Explanation_comment= '" . $explanationC . "', IsEvaluated= 0 WHERE "
                    . "ProjectID = " . $_SESSION['ProjectID'] . " and JudgeID = " . $rid['JudgeID'] . ";";
            if (mysqli_query($connection, $sql)) {
                header('location: project_evaluation.php');
            } else {
                //echo "Error updating row: " . mysqli_error($connection);
                header('location: judge_error_page.php');
            }
        }
        
        mysqli_close($connection);
    }
}

if (isset($_POST['confirm'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Make sure fields are not empty before storing in database
        if (test_input($_POST['completenessS']) <= 0 OR test_input($_POST['completenessS']) > 5) {
            $score_error = "Scores must be from 1 to 5.";
        } else {
            $completenessS = test_input($_POST['completenessS']);
            $score_error = "";
        }

        if (empty(test_input($_POST['completenessC']))) {
            $general_error = "All fields must be filled when submitting.";
        } else {
            $completenessC = test_input($_POST['completenessC']);
            $general_error = "";
        }

        if (test_input($_POST['originalityS']) <= 0 OR test_input($_POST['originalityS']) > 5) {
            $score_error = "Scores must be from 1 to 5.";
        } else {
            $originalityS = test_input($_POST['originalityS']);
            $score_error = "";
        }

        if (empty(test_input($_POST['originalityC']))) {
            $general_error = "All fields must be filled when submitting.";
        } else {
            $originalityC = test_input($_POST['originalityC']);
            $general_error = "";
        }

        if (test_input($_POST['creativityS']) <= 0 OR test_input($_POST['creativityS']) > 5) {
            $score_error = "Scores must be from 1 to 5.";
        } else {
            $creativityS = test_input($_POST['creativityS']);
            $score_error = "";
        }

        if (empty(test_input($_POST['creativityC']))) {
            $general_error = "All fields must be filled when submitting.";
        } else {
            $creativityC = test_input($_POST['creativityC']);
            $general_error = "";
        }

        if (test_input($_POST['clarityS']) <= 0 OR test_input($_POST['clarityS']) > 5) {
            $score_error = "Scores must be from 1 to 5.";
        } else {
            $clarityS = test_input($_POST['clarityS']);
            $score_error = "";
        }

        if (empty(test_input($_POST['clarityC']))) {
            $general_error = "All fields must be filled when submitting.";
        } else {
            $clarityC = test_input($_POST['clarityC']);
            $general_error = "";
        }

        if (test_input($_POST['explanationS']) <= 0 OR test_input($_POST['explanationS']) > 5) {
            $score_error = "Scores must be from 1 to 5.";
        } else {
            $explanationS = test_input($_POST['explanationS']);
            $score_error = "";
        }

        if (empty(test_input($_POST['explanationC']))) {
            $general_error = "All fields must be filled when submitting.";
        } else {
            $explanationC = test_input($_POST['explanationC']);
            $general_error = "";
        }

        if (empty($general_error) && empty($score_error)) {
            $sql = "UPDATE Reviews SET Completeness_score = " . $completenessS . ", Completeness_comment = '" . $completenessC . "', Originality_score = " . $originalityS . ", Originality_comment = '" . $originalityC . "',"
                    . "Creativity_score= " . $creativityS . ",Creativity_comment= '" . $creativityC . "',Clarity_score= " . $clarityS . ",Clarity_comment= '" . $clarityC . "',"
                    . "Explanation_score= " . $explanationS . ",Explanation_comment= '" . $explanationC . "', IsEvaluated= 1 WHERE "
                    . "ProjectID = " . $_SESSION['ProjectID'] . " and JudgeID = " . $rid['JudgeID'] . ";";
            if (mysqli_query($connection, $sql)) {
                header('location: project_evaluation.php');
            } else {
                //echo "Error updating row: " . mysqli_error($connection);
                header('location: judge_error_page.php');
            }
        }
        //mysqli_close($connection);
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
            font-size: 1.2em;
            margin: auto;
            padding-bottom: 10px;
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
            width: auto;
            height: 100%;
            background-color: rgb(51, 153, 255);
            font: caption;
            font-size: 1.2em;
            color: black;
            margin-bottom: 0;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
        }
        .button-modal {
            width: 90px;
            height: 100%;
            background-color: rgb(51, 153, 255);
            font: caption;
            font-size: 1.2em;
            color: black;
            margin-right: 15px;
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

        /* The Modal (background) */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            padding-top: 100px; /* Location of the box */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        }

        /* Modal Content */
        .modal-content {
            background-color: #fefefe;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }

        /* The Close Button */
        .close {
            color: #aaaaaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
<body>
    <header>
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


    <div style="margin-top:30px;">
        <center>
            <h2><?php printf("Review Form, Project " . $_SESSION['ProjectID']); ?></h2><br>
            <?php
            $sql = "SELECT Completeness_score, Completeness_comment, Originality_score, Originality_comment, Creativity_score, Creativity_comment, Clarity_score, Clarity_comment, Explanation_score, Explanation_comment "
                    . "FROM Reviews WHERE ProjectID = " . $_SESSION['ProjectID'] . " and JudgeID = " . $rid['JudgeID'] . ";";
            $result = mysqli_query($connection, $sql);

            if (mysqli_num_rows($result) > 0) {
                // Save row data to variable
                $row = mysqli_fetch_assoc($result);
            } else {
                echo "No rows found";
            }
            ?>
            <form style="display: inline-block;" id="review" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <label for="completenessS">Completeness: </label>
                <input type="number" name="completenessS" placeholder="Completeness Score" value="<?php echo $row['Completeness_score'] ?>">
                <textarea name="completenessC" placeholder="Comment" cols="50" rows="4"><?php echo $row['Completeness_comment'] ?></textarea><br>
                <label for="originalityS">Originality: </label>
                <input type="number" name="originalityS" placeholder="Originality Score" value="<?php echo $row['Originality_score'] ?>">
                <textarea name="originalityC" placeholder="Comment" cols="50" rows="4"><?php echo $row['Originality_comment'] ?></textarea><br>
                <label for="creativityS">Creativity: </label>
                <input type="number" name="creativityS" placeholder="Creativity Score" value="<?php echo $row['Creativity_score'] ?>">
                <textarea name="creativityC" placeholder="Comment" cols="50" rows="4"><?php echo $row['Creativity_comment'] ?></textarea><br>
                <label for="clarityS">Clarity: </label>
                <input type="number" name="clarityS" placeholder="Clarity Score" value="<?php echo $row['Clarity_score'] ?>">
                <textarea name="clarityC" placeholder="Comment" cols="50" rows="4"><?php echo $row['Clarity_comment'] ?></textarea><br>
                <label for="explanationS">Video Explanation: </label>
                <input type="number" name="explanationS" placeholder="Expalnation Score" value="<?php echo $row['Explanation_score'] ?>">
                <textarea name="explanationC" placeholder="Comment" cols="50" rows="4"><?php echo $row['Explanation_comment'] ?></textarea>
                <div style="width: 100%; display: table; position: fixed; bottom: 0; left: 150px;">
                    <div style="width: auto; display: table-cell;"><button class="button-general" style="background-color: lightgray; width: 110px" type="button" name="cancel" onclick="window.location.href = 'project_evaluation.php';">Cancel</button></div>
                    <div style="width: auto; display: table-cell;"><button class="button-general" style="background-color: lightgrey" type="submit" name="save">Save for Later</button></div>
                    <div id="sub" style="width: auto; display: table-cell;"><button class="button-general" style="background-color: yellow;" type="button" name="submit">Submit Review</button></div>
                </div>
                
                <!-- The Modal -->
                <div id="myModal" class="modal">

                    <!-- Modal content -->
                    <div class="modal-content">
                        <span class="close">&times;</span>
                        <p>Once you click <b>OK</b>, your review form will be submitted and archived.<br>
                            You will no longer be able to edit this form.</p>
                        <button class="button-modal" style="display: table-cell; background: lightgray; width: 110px" id="cancel" type="button">Cancel</button>
                        <button class="button-modal" style="display: table-cell; background: lightgreen; " name="confirm" type="submit">OK</button>
                    </div>

                </div>
            </form>
            
            <p><br><?php echo $general_error . "<br>"; echo $score_error; ?><br></p>
        </center>
    </div>
    <script>
        // Get the modal
        var modal = document.getElementById("myModal");

        // Get the button that opens the modal
        var btn = document.getElementById("sub");
        var can = document.getElementById("cancel");

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks the button, open the modal 
        btn.onclick = function () {
            modal.style.display = "block";
        };

        // When the user clicks on <span> (x), close the modal
        span.onclick = function () {
            modal.style.display = "none";
        };

        can.onclick = function () {
            modal.style.display = "none";
        };

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function (event) {
            if (event.target === modal) {
                modal.style.display = "none";
            }
        }
    </script>

</body>
</html>
