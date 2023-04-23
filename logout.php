<?php

//headers to make the browser refresh

header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

header("Cache-Control: private");

//create or continue a session

session_start();

// Clear destroy the session

if($_SESSION['UserID']){
	

// 	$_SESSION["user_name"] = false;
//     $_SESSION['project_id'] = false;
//     $_SESSION['judge_id'] = false;
    session_unset();
	session_destroy();

}

//finally redirect the user to the start page

header("location: newHome.php");

?>