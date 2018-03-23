<?php

require("../classes/dbutils.php");
// attemptID, levelID, userID, levelAttemptNumber, isLevelComplete, finalLevelScore
/*retrieve session data */
$userID = $_POST["userID"];
$levelAttemptNumber = $_POST["levelAttemptNumber"];
$attemptID = $_POST["attemptID"];
$levelID = $_POST["levelID"];
$isLevelComplete = $_POST["isLevelComplete"];
$finalLevelScore = $_POST["finalLevelScore"];
$numberQuestionsAnswered = $_POST["numberQuestionsAnswered"];
$numberCorrect = $_POST["numberCorrect"];
$numberIncorrect = $_POST["numberIncorrect"];


$sql = "INSERT INTO scorelog  "; //insert session data into score log database 
$sql .= "(attemptID,levelID,fk_userID,levelAttemptNumber,isLevelComplete,finalLevelScore,numberQuestionsAnswered,numberCorrect,numberIncorrect) ";
$sql .= "VALUES (?,?,?,?,?,?,?,?,?);";

// echo($sql . "<br />");
// echo("Final score: " + $finalLevelScore);


$db = new DbUtilities;
$db->executeQuery($sql, "sssiiiiii", array($attemptID, $levelID, $userID, $levelAttemptNumber, $isLevelComplete, $finalLevelScore,$numberQuestionsAnswered,$numberCorrect,$numberIncorrect));

?>
