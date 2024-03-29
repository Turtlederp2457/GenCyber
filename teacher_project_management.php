<?php
include "login.php";
if (isset($_POST['logout'])) {
    include "logout.php";
}
session_start();

$getTeacherID = "SELECT TeacherID FROM Teachers WHERE UserID = " . $_SESSION['UserID'];
$res = mysqli_query($connection, $getTeacherID);
if (mysqli_num_rows($res) > 0) {
    // Save row data to variable
    $rid = mysqli_fetch_assoc($res);
} else {
    echo "No rows found";
}

//mysqli_close($connection);

if (isset($_POST['addProject'])) {
    $title = test_input($_POST['title']);
    $description = test_input($_POST['description']);
    $sql = "INSERT INTO Projects (Title, Description, TeacherID, EventID) VALUES ('" . $title . "', '" . $description . "', " . $rid['TeacherID'] . ", 1)";

    if (mysqli_query($connection, $sql)) {
        //need to get projectID that was assigned
        $stmt = mysqli_prepare($connection, "Select ProjectID from Projects where Title = ?");
        mysqli_stmt_bind_param($stmt, "s", $title);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        $projectID = $row['ProjectID'];
        if(isset($_FILES['file'])) {
            // Check if the file was uploaded without errors
            if($_FILES['file']['error'] == 0) {
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
                //insert sql function to upload to sql server here
                $stmt = mysqli_prepare($connection, "INSERT INTO Attachments (ProjectID, AttachmentName, AttachmentType, Attachment) VALUES (?, ?, ?, ?)");
                mysqli_stmt_bind_param($stmt, "isss", $projectID, $filename, $filetype, $fileContent);
                $stmt->execute();
            }
        }
       mysqli_close($connection);
        header('location: teacher_project_management.php');
    } else {
        mysqli_close($connection);
        header('location: teacher_error_page.php');
    }
}

if (isset($_POST['edit'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $ProjectID = $_POST['edit'];
        $_SESSION['ProjectID'] = $ProjectID;
        header('location: teacher_project_edit.php');
    }
}

if (isset($_POST['delete'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $ProjectID = $_POST['delete'];
        $sql = "DELETE FROM `Students` WHERE ProjectID = ". $ProjectID;
        if (mysqli_query($connection, $sql)) {
            echo "Project successfully deleted";
        } else {
            echo "error deleting project";
        }
        $sql = "DELETE FROM `Attachments` WHERE ProjectID = ". $ProjectID;
        if (mysqli_query($connection, $sql)) {
            echo "Project successfully deleted";
        } else {
            echo "error deleting project";
        }
        $sql = "DELETE FROM `Reviews` WHERE ProjectID = ". $ProjectID;
        if (mysqli_query($connection, $sql)) {
            echo "Project successfully deleted";
        } else {
            echo "error deleting project";
        }
        $sql = "DELETE FROM `Projects` WHERE ProjectID = ". $ProjectID;
        if (mysqli_query($connection, $sql)) {
            echo "Project successfully deleted";
        } else {
            echo "error deleting project";
        }
        mysqli_close($connection);
        header('location: teacher_project_management.php');
    }
}
?>
<!doctype html>
<html lang="en-us" class="scroll-smooth"/>
<head>
    <!-- Required meta tags --> 
    <meta charset = "utf-8"/>
    <meta name="sitePath" content="http://localhost/GenCyber/teacher_project_management.php" />
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

        #headform {
            display: grid;
            margin-bottom: 0;
            grid-template-columns: 25% 50% 25%;
        }

        form p, div, span {
            font-size: 1.2em;
            margin: auto;
        }

        label {
            font-size: 0.9em;
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

        .wrapper-teacher-links {
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
        <form id="headform" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <button class="button-general" type="submit" name="logout">Log Out</button>
            <div></div>
            <p>
                <?php
                $sql = "SELECT First_name FROM Teachers WHERE UserID = " . $_SESSION['UserID'];
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
                ?>
            </p>
        </form>
    </header>
    <div class="wrapper-logos">
        <a class="center" target="_blank" href="https://www.marshall.edu/">
            <img src="//www.marshall.edu/gencyber/wp-content/themes/marsha/images/m_primary.svg" 
                 style="height:100px;width:120px" alt="Marshall University logo" class="marshall-logo"/>
        </a>
        <a style="color:white" class="better-title center" href="http://localhost/GenCyber/teacher_landing.php">Marshall University GenCyber</a>
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
    <div class="wrapper-teacher-links">
        <a class="button-prior" href="http://localhost/GenCyber/teacher_profile_management.php">Profile Management</a>
        <a class="button-prior" style="background-color:#F0F0F0" href="http://localhost/GenCyber/teacher_project_management.php">Project Management</a>
    </div>

    <div style="font-size:1.0em; min-height:60vh" class="wrapper-main">
        <!-- side panel -->
        <div style="margin:0">
            <div id="squares">
                <div id="BluePanel">
                    <h3>Add New Project</h3><br>
                    <form style="display: inline-block;" id="addProject" method="post" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <label>Project Title</label><br>
                        <input type="text" name="title" placeholder="Title" size="40" required><br><br>
                        <label>Project Description</label><br>
                        <textarea style="resize: none;" name="description" placeholder="Short Description" cols="36" rows="6" required></textarea><br><br>
                        <label for="file">Select a file to upload:</label>
		                <input type="file" name="file" id="file"><br><br>
                        <br>
                        <button class="button-general" style="background-color: yellow; font-size: 1.0em; width: 260px;" type="submit" name="addProject">Add Project</button>
                    </form>
                </div>
            </div>
        </div>
        <!-- center panel -->
        <div style="margin-top:10px;font-size:1.1em">
            <h2>Your Projects:</h2><br>
            <form id="projects" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <table>
                <tr>
                    <th>Project #</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
                <?php
                $sql = "SELECT ProjectID, Title, Description "
                . "FROM Projects WHERE TeacherID = " . $rid['TeacherID'] . ";";
                $result = mysqli_query($connection, $sql);

                while ($row = mysqli_fetch_assoc($result)) {
                ?>
                    <tr><?php
                    foreach ($row as $key => $field)
                        echo '<td>' . htmlspecialchars($field) . '</td>';
                    ?>
                        <td><button style="all:revert; background-color:lightblue; width:100%" type="submit" name="edit" value="<?= $row['ProjectID'] ?>">Edit</button></td>
                            <td><button id='sub' style="all:revert; background-color:red; color: white; width:100%" type="submit" name="delete" value="<?= $row['ProjectID'] ?>">Delete</button></td>
                    </tr>
                <?php
                }
                mysqli_close($connection);
                ?>
            </table>

                </div>
            </form>
        </div>
        <!-- right panel -->
        <div>
            
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

<?php
// Project management page will display all projects (teacher may manage multiple student teams/projects) 
// with Add new project button and Teacher can edit projects until due date.
// Get all projects from the database 
?>