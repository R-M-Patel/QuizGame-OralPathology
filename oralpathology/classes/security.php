<?php
session_start();
// echo("CURRENT SESSION: " . $_SESSION["drupalUserID"]);

/* checks to see if user ID is blank or 'invalid'. Redirects to authfailed.php if so*/
if(($_SESSION['drupalUserID'] == "") || ($_SESSION['drupalUserID'] == "INVALID")){
	// echo("Not logged in!");
	header("Location: authfailed.php");
}
?>
