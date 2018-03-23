<?php
	//reset session IDs
	session_start();
	$_SESSION["drupalUserID"] = "INVALID";
	$_SESSION["drupalUserName"] = "INVALID";
	$_SESSION["drupalUserEmail"] = "INVALID";
	
	$_SESSION["gameAttemptID"] = "";
	
	session_unset();
	session_destroy();
	
	header('Location: http://oralpathologyatlas.net/'); exit();
?>
