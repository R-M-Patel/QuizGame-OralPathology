<?php
include("rest/getaccess.php");

/* function to detect if user is on a level that they shouldn't be able to access */
// echo("CURRENT SESSION: " . $_SESSION["drupalUserID"]);
if ($accessCollection[0]["levelAccess"] != basename($_SERVER['PHP_SELF'])) {
    // echo("Incorrect Level!");
    header("Location: caught_cheating.php");
}
?>