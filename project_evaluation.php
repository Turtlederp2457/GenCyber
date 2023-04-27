<?php
include "login.php";
if (isset($_POST['logout'])) {
    include "logout.php";
}
session_start();
require_once("database_conn.php");

if (isset($_POST['download'])) {
// Set the project ID
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

if (isset($_POST['review'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $ProjectID = $_POST['review'];
        $_SESSION['ProjectID'] = $ProjectID;
        header('location: review.php');
    }
}

if (isset($_POST['viewreview'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $ProjectID = $_POST['viewreview'];
        $_SESSION['ProjectID'] = $ProjectID;
        header('location: view_review.php');
    }
}
?>
<!doctype html>
<html lang="en-us" class="scroll-smooth"/>
<head>
    <!-- Required meta tags --> 
    <meta charset = "utf-8"/>
    <meta name="sitePath" content="http://localhost/GenCyber/project_evaluation.php" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no"/>
    <!-- Add your name here one you have helped write this code -->
    <meta name="author" content="Gatlin Zornes, Layne McNeely">
    <title>Project Evaluation - Marshall University GenCyber</title>
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
            grid-template-rows: 20% 80%;
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

        #squares div {
            /* these styles will let the divs line up next to each other
               while accepting dimensions */
            display: block;
            float: left;

            width: 350px;
            height: 600px;


            /* a small margin to separate the blocks */
            margin-right: 5px;
        }
        #BluePanel {  
            background: rgb(51, 153, 255);
            padding: 25px 40px 75px;
        }
        table, th, td {
            border: 1px solid;
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
                    echo "Welcome";
                }

                $getJudgeID = "SELECT JudgeID FROM Judges WHERE UserID = " . $_SESSION['UserID'];
                $res = mysqli_query($connection, $getJudgeID);
                if (mysqli_num_rows($res) > 0) {
                    // Save row data to variable
                    $rid = mysqli_fetch_assoc($res);
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
        <a style="color:white" class="better-title center" href="http://localhost/GenCyber/judge_landing.php">Marshall University GenCyber</a>
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
        <a class="button-prior" style="background-color:#F0F0F0"; href="http://localhost/GenCyber/project_evaluation.php">Project Evaluation</a>
    </div>
    <!-- Side Panel -->
    <div style="font-size:1.0em; min-height:60vh; text-align:left;" class="wrapper-main">
        <div style="margin:0">
            <div id="squares">
                <div id="BluePanel">
                    <?php
                    $sql2 = "SELECT IsEvaluated FROM Reviews WHERE JudgeID = '" . $rid["JudgeID"] . "' and IsEvaluated = 0";
                    if ($res = mysqli_query($connection, $sql2)) {
                        // Return the number of rows in result set
                        $unev = mysqli_num_rows($res);
                    }
                    $sql3 = "SELECT IsEvaluated FROM Reviews WHERE JudgeID = '" . $rid["JudgeID"] . "' and IsEvaluated = 1";
                    if ($res = mysqli_query($connection, $sql3)) {
                        // Return the number of rows in result set
                        $eval = mysqli_num_rows($res);
                    }
                    ?>
                    <h4>Needs Evaluating: <?php echo $unev; ?></h4><br>
                    <button class="button-prior" style="background-color: #F0F0F0; font-size: 1.0em;" onclick="toggleEvaluate()">Unevaluated Projects</button><br><br><br>
                    <h4>Already Evaluated: <?php echo $eval; ?></h4><br>
                    <button class="button-prior" style="background-color: #F0F0F0; font-size: 1.0em;" onclick="toggleEvaluated()">Evaluated Projects</button>
                </div>
            </div>
        </div>
        <div style="margin-top:10px;font-size:1.1em">
            <div id="tip">
                📝️ View assigned projects with the buttons on the left.
            </div>
            <form id="eval" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" style="display:none">
                <h2>Unevaluated Projects:</h2>
                <table>
                    <tr style="text-align: center;">
                        <th>Project #</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Attachments</th>
                        <th>Review</th>
                    </tr>
                    <?php
                    $sql = "SELECT P.ProjectID, P.Title, P.Description FROM Projects as P
                    INNER JOIN Reviews as R on P.ProjectID = R.ProjectID
                    WHERE JudgeID = " . $rid["JudgeID"] . " AND IsEvaluated = 0;";
                    $result = mysqli_query($connection, $sql);
                    while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <tr><?php
                    foreach ($row as $key => $field)
                        echo '<td>' . htmlspecialchars($field) . '</td>';
                        ?>
                            <td><button style="all:revert; background-color:lightgreen; width:100%" type="submit" name="download" value="<?= $row['ProjectID'] ?>">Download</button></td>
                            <td><button style="all:revert; background-color:lightblue; width:100%" type="submit" name="review" value="<?= $row['ProjectID'] ?>">Review</button></td>
                        </tr>
                        <?php
                    }
                    //mysqli_close($connection);
                    ?>
                </table> 
            </form>

            <form id="uneval" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" style="display:none">
                <h2>Evaluated Projects:</h2>
                <table>
                    <tr>
                        <th>Project #</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Reviews [archived]</th>
                    </tr>
                    <?php
                    $sql = "SELECT P.ProjectID, P.Title, P.Description FROM Projects as P
                    INNER JOIN Reviews as R on P.ProjectID = R.ProjectID
                    WHERE JudgeID = " . $rid["JudgeID"] . " AND IsEvaluated = 1;";
                    $result = mysqli_query($connection, $sql);
                    while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <tr><?php
                    foreach ($row as $key => $field)
                        echo '<td>' . htmlspecialchars($field) . '</td>';
                        ?>
                            <td><button style="all:revert; background-color:lightgray; width:100%" type="submit" name="viewreview" value="<?= $row['ProjectID'] ?>">View Review</button></td>
                        </tr>
                        <?php
                    }
                    mysqli_close($connection);
                    ?>
                </table> 
            </form>

            <script>
                function toggleEvaluate() {
                    var t = document.getElementById("tip");
                    var e = document.getElementById("eval");
                    var u = document.getElementById("uneval");
                    if (e.style.display === "none") {
                        t.style.display = "none";
                        e.style.display = "block";
                        u.style.display = "none";
                    } else {
                        t.style.display = "block";
                        e.style.display = "none";
                    }
                }

                function toggleEvaluated() {
                    var t = document.getElementById("tip");
                    var e = document.getElementById("eval");
                    var u = document.getElementById("uneval");
                    if (u.style.display === "none") {
                        t.style.display = "none";
                        u.style.display = "block";
                        e.style.display = "none";
                    } else {
                        t.style.display = "block";
                        u.style.display = "none";
                    }
                }
            </script>
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

