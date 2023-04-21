<?php
/*
 * This PHP doc is for uploading test data to the Attachments table
 * in the GenCyber database. To download the test data or any data from
 * the Attachments table, go to the Judge Project Evaluation page for the
 * Judge the file is assigned to by Admin.
 * 
 * IMPORTANT: Change AttachmentID and ProjectID before running the page. 
 * If not done so, it may override what is already in the table.
 */
require_once("database_conn.php");

if (isset($_POST['submit'])) {
    $AttachID = $_POST['attachID'];
    $ProjectID = $_POST['projectID'];
    $filename = $_FILES['file']['name'];
    $filetemp = $_FILES['file']['tmp_name'];
    $filesize = $_FILES['file']['size'];
    $filetype = $_FILES['file']['type'];

    // Check if the uploaded file is a DOCX file
    $allowed_types = array('docx');
    $file_ext = pathinfo($filename, PATHINFO_EXTENSION);
    if (!in_array($file_ext, $allowed_types)) {
        die("Error: Please upload a DOCX file");
    }

    // Open the DOCX file and convert it to BLOB
    $file = fopen($filetemp, 'r');
    $content = fread($file, filesize($filetemp));
    $content = addslashes($content);
    fclose($file);

    // Insert the BLOB into the database
    $sql = "INSERT INTO Attachments (AttachmentID, ProjectID, AttachmentName, AttachmentType, AttachmentSize, Attachment) VALUES ('$AttachID', '$ProjectID', '$filename', '$filetype', '$filesize', '$content')";
    if (mysqli_query($connection, $sql)) {
        echo "File uploaded successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($connection);
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Upload DOCX</title>
    </head>
    <body>
        <p>Hello</p>
        <form method="post" enctype="multipart/form-data">
            <label>AttachmentID (optional): </label><input type="number" name="attachID" placeholder="AttachmentID">
            <label>ProjectID: </label><input type="number" name="projectID" placeholder="ProjectID" required><br><br>
            <input type="file" name="file" required>
            <input type="submit" name="submit" value="Upload">
        </form>
    </body>
</html>
