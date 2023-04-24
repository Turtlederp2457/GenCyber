<?php
include "login.php";
if (isset($_POST['logout'])) {
    include "logout.php";
}
session_start();
require_once("database_conn.php");

$getTeacherID = "SELECT TeacherID FROM Teachers WHERE UserID = " . $_SESSION['UserID'];
$res = mysqli_query($connection, $getTeacherID);
if (mysqli_num_rows($res) > 0) {
    // Save row data to variable
    $rid = mysqli_fetch_assoc($res);
} else {
    echo "No rows found";
}

if (isset($_POST['save'])) {
    $title = test_input($_POST['title']);
    $description = test_input($_POST['description']);
    $sql = "UPDATE Projects SET Title = '" . $title . "', Description = '" . $description . "' WHERE ProjectID = " . $_SESSION['ProjectID'];

    if (mysqli_query($connection, $sql)) {
        //if (isset($_FILES['file'])) {
            // Check if the file was uploaded without errors
            if ($_FILES['file']['error'] == 0) {
                //Actual File
                $file = $_FILES['file'];
                // Get the file name
                $filename = $_FILES['file']['name'];
                // Get the file size
                $filesize = $_FILES['file']['size'];
                // Get the temporary location of the file
                $filetmp = $_FILES['file']['tmp_name'];
                // Get the file type
                $filetype = $_FILES['file']['type'];
                
                $fileContent = file_get_contents($file['tmp_name']);

                $stmt = mysqli_prepare($connection, "UPDATE Attachments SET AttachmentName = ?, AttachmentType = ?, Attachment = ? WHERE ProjectID = ". $_SESSION['ProjectID']);
                mysqli_stmt_bind_param($stmt, "sss", $filename, $filetype, $fileContent);
                $stmt->execute();
            }
        //}
        mysqli_close($connection);
        header('location: teacher_project_management.php');
    } else {
        mysqli_close($connection);
        header('location: teacher_error_page.php');
    }
}
?>
<!doctype html>
<html lang="en-us" class="scroll-smooth"/>
<head>
    <!-- Required meta tags --> 
    <meta charset = "utf-8"/>
    <meta name="sitePath" content="http://localhost/GenCyber/teacher_project_edit.php" />
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
            <h2><?php printf("Project " . $_SESSION['ProjectID']); ?></h2><br>
            <?php
            $sql = "SELECT ProjectID, Title, Description "
                    . "FROM Projects WHERE ProjectID = " . $_SESSION['ProjectID'] . " and TeacherID = " . $rid['TeacherID'] . ";";
            $result = mysqli_query($connection, $sql);

            if (mysqli_num_rows($result) > 0) {
                // Save row data to variable
                $row = mysqli_fetch_assoc($result);
            } else {
                echo "No rows found";
            }
            ?>
            <form style="display: inline-block;" id="editProj" method="post" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <label>Project Title:</label><br>
                <input type="text" name="title" placeholder="Title" size="40" required value="<?php echo $row['Title'] ?>"><br><br>
                <label>Project Description:</label><br>
                <textarea style="resize: none;" name="description" placeholder="Short Description" cols="36" rows="6"><?php echo $row['Description'] ?></textarea><br><br>
                <label for="file">Select a file to upload:</label><br>
                <input type="file" name="file" id="file"><br><br>
                <div style="width: 100%; display: table; position: fixed; bottom: 0; left: 150px;">
                    <div style="width: auto; display: table-cell;"><button class="button-general" style="background-color: lightgray; width: 110px" type="button" name="cancel" onclick="window.location.href = 'teacher_project_management.php';">Cancel</button></div>
                    <div id="sub" style="width: auto; display: table-cell;"><button class="button-general" style="background-color: yellow;" type="submit" name="save">Save Changes</button></div>
                </div>

            </form>
        </center>
    </div>

</body>
</html>
