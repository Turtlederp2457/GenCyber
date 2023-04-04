<?php

//headers to make the browser refresh

header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

header("Cache-Control: private");

//create or continue a session

session_start();

// Clear destroy the session

if(@$_SESSION["user_name"]){
	

	$_SESSION["user_name"] = false;


	session_destroy();

}

//finally redirect the user to the start page

header("location: newHome.php");

?>