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

if (isset($_POST['addS'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $fname = test_input($_POST['fname']);
        $lname = test_input($_POST['lname']);
        $email = test_input($_POST['semail']);
        $sql = "INSERT INTO Students (First_name, Last_name, Email, ProjectID) VALUES ('" . $fname . "', '" . $lname . "', '" . $email . "', " . $_SESSION['ProjectID'] . ")";

        if (mysqli_query($connection, $sql)) {
            mysqli_close($connection);
            header('location: teacher_project_edit.php');
        } else {
            mysqli_close($connection);
            header('location: teacher_error_page.php');
        }
    }
}

if (isset($_POST['removeS'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $studentID = test_input($_POST['removeS']);
        $sql = "DELETE FROM Students WHERE StudentID = ". $studentID;

        if (mysqli_query($connection, $sql)) {
            mysqli_close($connection);
            header('location: teacher_project_edit.php');
        } else {
            mysqli_close($connection);
            header('location: teacher_error_page.php');
        }
    }
}

if (isset($_POST['deleteA'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $attachmentID = test_input($_POST['deleteA']);
        $sql = "DELETE FROM Attachments WHERE AttachmentID = ". $attachmentID;

        if (mysqli_query($connection, $sql)) {
            mysqli_close($connection);
            header('location: teacher_project_edit.php');
        } else {
            mysqli_close($connection);
            header('location: teacher_error_page.php');
        }
    }
}

if (isset($_POST['save'])) {
    $title = test_input($_POST['title']);
    $description = test_input($_POST['description']);
    $sql = "UPDATE Projects SET Title = '" . $title . "', Description = '" . $description . "' WHERE ProjectID = " . $_SESSION['ProjectID'];

    if (mysqli_query($connection, $sql)) {
        mysqli_close($connection);
        header('location: teacher_project_edit.php');
    } else {
        mysqli_close($connection);
        header('location: teacher_error_page.php');
    }
}

if (isset($_POST['uploadA'])) {
    $filename = $_FILES['file']['name'];
    $filetemp = $_FILES['file']['tmp_name'];
    $filesize = $_FILES['file']['size'];
    $filetype = $_FILES['file']['type'];
    
    // Open the file and convert it to BLOB
    $file = fopen($filetemp, 'r');
    $content = fread($file, filesize($filetemp));
    $content = addslashes($content);
    fclose($file);

    // Insert the BLOB into the database
    $sql = "INSERT INTO Attachments (ProjectID, AttachmentName, AttachmentType, AttachmentSize, Attachment) VALUES (". $_SESSION['ProjectID'] ." , '$filename', '$filetype', '$filesize', '$content')";
    if (mysqli_query($connection, $sql)) {
        echo "File uploaded successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
    mysqli_close($connection);
    header('location: teacher_project_edit.php');
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
    <title>Edit Project - Marshall University GenCyber</title>
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
    <div style="font-size:1.0em; min-height:60vh" class="wrapper-main">
        <div style="margin:30px; border: solid;">
            <!-- Left Panel -->
            <center><h2>Student Roster</h2></center>
            <form style="display: inline-block;" id="studentRoster" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <table>
                    <tr>
                        <th>Student #</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Remove Student</th>
                    </tr>
                    <?php
                    $sql = "SELECT StudentID, First_name, Last_name, Email "
                            . "FROM Students WHERE ProjectID = " . $_SESSION['ProjectID'];
                    $result = mysqli_query($connection, $sql);

                    while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <tr><?php
                            foreach ($row as $key => $field)
                                echo '<td>' . htmlspecialchars($field) . '</td>';
                            ?>
                            <td><button style="all:revert; background-color:orange; color: white; width:100%" type="submit" name="removeS" value="<?= $row['StudentID'] ?>">Remove</button></td>
                        </tr>
                        <?php
                    }
                    //mysqli_close($connection);
                    ?>
                </table>
            </form><br>
            <form style="display: inline-block;" id="addStudent" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <h3>Add Student</h3><br>
                <label>Student Name:</label><br>
                <input type="text" name="fname" placeholder="First Name" required><br>
                <input type="text" name="lname" placeholder="Last Name" required><br>
                <label>Email:</label>
                <input type="text" name="semail" placeholder="Email" required><br><br>
                <button class="button-general" style="background-color: yellow;" type="submit" name="addS">Save & Add</button>
            </form>
        </div>

        <div style="margin-top:30px; border: solid;">
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
                    <button class="button-general" style="background-color: yellow;" type="submit" name="save">Save Changes</button>
                    <!--                    <label for="file">Select a file to upload:</label><br>
                                        <input type="file" name="file" id="file"><br><br>
                    -->

                </form>
            </center>
        </div>
        <div style="margin:30px; border: solid;">
            <!--Right panel-->
            <center><h2>File Management</h2></center>
            <form style="display: inline-block;" id="studentRoster" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <table>
                    <tr>
                        <th>File #</th>
                        <th>Attachment Name</th>
                        <th>Delete</th>
                    </tr>
                    <?php
                    $sql = "SELECT AttachmentID, AttachmentName "
                            . "FROM Attachments WHERE ProjectID = " . $_SESSION['ProjectID'];
                    $result = mysqli_query($connection, $sql);

                    while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <tr><?php
                            foreach ($row as $key => $field)
                                echo '<td>' . htmlspecialchars($field) . '</td>';
                            ?>
                            <td><button style="all:revert; background-color:orange; color: white; width:100%" type="submit" name="deleteA" value="<?= $row['AttachmentID'] ?>">Remove</button></td>
                        </tr>
                        <?php
                    }
                    //mysqli_close($connection);
                    ?>
                </table>
            </form><br>
            <form style="display: inline-block;" id="uploadAttachment" method="post" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <h3>Upload New File</h3><br>
                <label>Select file:</label><br>
                <input type="file" name="file" id="file" required><br><br>
                <button class="button-general" style="background-color: yellow;" type="submit" name="uploadA">Save & Upload</button>
            </form>
        </div>
    </div>
    <div style="width: 100%; position: fixed; left: 50px;">
        <button class="button-general" style="background-color: lightgray; width: 110px" type="button" name="cancel" onclick="window.location.href = 'teacher_project_management.php';">Go Back</button>
    </div>

</body>
</html>
