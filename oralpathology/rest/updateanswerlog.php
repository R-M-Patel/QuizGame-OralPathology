<?php

require("../classes/dbutils.php");

/*retrieve session data */
$userID = $_POST["userID"];
$selectedImageID = $_POST["selectedImageID"];
$questionID = $_POST["questionID"];
$isCorrect = $_POST["isCorrect"];
$attemptID = $_POST["attemptID"];
$levelID = $_POST["levelID"];
$levelAttemptNumber = $_POST["levelAttemptNumber"];

/* display session data */
echo ("LEVEL ATTEMPT: " . $levelAttemptNumber);

echo("userID: " . $userID . "\n");
echo("selectedImageID: " . $selectedImageID . "\n");
echo("questionID: " . $questionID . "\n");
echo("isCorrect: " . $isCorrect . "\n");

$sql = "INSERT INTO answerlog (userID,fk_questionID,fk_imageID,isCorrect,attemptID,levelID,levelAttemptNumber) "; //insert session data into answerlog database
// $sql .= "VALUES (?,?,?,?,?,?,?,?,?);";
$sql .= "VALUES (?,?,?,?,?,?,?);";
echo($sql);

$db = new DbUtilities;
//$db->executeQuery($sql, "sssisiiss", array($userID, $questionID, $selectedImageID, $isBonus, $attemptID, $levelID, $scoreRecieved, $startDate, $endDate));
$db->executeQuery($sql, "sssisii", array($userID, $questionID, $selectedImageID, $isCorrect, $attemptID, $levelID, $levelAttemptNumber));

?>
