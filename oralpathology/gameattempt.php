<?php
require("classes/security.php");
require("classes/dbutils.php");
$_SESSION["gameAttemptID"] = uniqid();
include("rest/updateaccess.php");

$levelID = 1;

if (isset($_GET["levelID"])) { //if session level ID is already set, user is in the wrong place
    $levelID = $_GET["levelID"];
    header("Location: incorrect_level.php");
} else {  //send user to level 1 tutorial
    header("Location: level1tutorial.php");
}

?>