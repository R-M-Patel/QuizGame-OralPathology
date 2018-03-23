<?php
if (isset($_POST["userID"])) {
    $userID = $_POST["userID"];
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
$sql .= "FROM pageaccess ";
$sql .= "WHERE userID = '" . $userID . "' AND attemptID = '" . $attemptID . "')"; //where user and attempt IDs match

$db = new DbUtilities;
$accessCollection = $db->getDataset($sql); //submit above sql query
