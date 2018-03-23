<?php

require("../classes/dbutils.php");

/*get session data */
$userID = $_POST["userID"];
$selectedImageID = $_POST["selectedImageID"];
$questionID = $_POST["questionID"];
$isCorrect = $_POST["isCorrect"];
$attemptID = $_POST["attemptID"];
$levelID = $_POST["levelID"];
$scoreRecieved = $_POST["scoreRecieved"];

/*display session data */
echo("userID: " . $userID . "\n");
echo("selectedImageID: " . $selectedImageID . "\n");
echo("questionID: " . $questionID . "\n");
echo("isCorrect: " . $isCorrect . "\n");
echo("scoreRecieved: " . $scoreRecieved . "\n");

$sql = "INSERT INTO score (userID,questionID,imageID,isCorrect,attemptID,levelID,scoreRecieved) "; //insert session data to score dattabase */
// $sql .= "VALUES (?,?,?,?,?,?,?,?,?);";
$sql .= "VALUES (?,?,?,?,?,?,?);";
// echo($sql);

$db = new DbUtilities;
//$db->executeQuery($sql, "sssisiiss", array($userID, $questionID, $selectedImageID, $isBonus, $attemptID, $levelID, $scoreRecieved, $startDate, $endDate));
$db->executeQuery($sql, "sssisii", array($userID, $questionID, $selectedImageID, $isCorrect, $attemptID, $levelID, $scoreRecieved)); //execute sql query

?>
