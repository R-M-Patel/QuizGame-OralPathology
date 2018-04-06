<?php
if (isset($_POST["userID"])) { //If user ID is set
    $userID = $_POST["userID"]; //set user and attempt IDs
    $attemptID = $_POST["attemptID"];
    require("../classes/dbutils.php");
} else {
    $userID = $_SESSION["drupalUserID"];
    $attemptID = $_SESSION["gameAttemptID"];
}

$sql = "Select * "; //get everything
$sql .= "FROM pageaccess "; //from page access
$sql .= "WHERE  userID = '" . $userID . "' AND attemptID = '" . $attemptID . "' "; //where user and attempt IDs match
$sql .= "AND accessDateTime = (SELECT max(accessDateTime) "; //and the date/time matches
$sql .= "FROM pageaccess "; //from page access database
$sql .= "WHERE userID = '" . $userID . "' AND attemptID = '" . $attemptID . "')"; //where user and attempt IDs match

$db = new DbUtilities;
$accessCollection = $db->getDataset($sql); //submit above sql query
