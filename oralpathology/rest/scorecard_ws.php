<?php
require("../classes/dbutils.php");
$db = new DbUtilities;

$userID = $_GET["userID"];

$sql = "SELECT levelID, logDateTime, levelAttemptNumber, finalLevelScore, ";  //get data
$sql .= "numberQuestionsAnswered, numberCorrect, numberIncorrect ";
$sql .= "FROM scorelog WHERE fk_userID = " . $userID . " AND isLevelComplete = 1 "; //from the scorelog where user id matches and level was completed
$sql .= "ORDER BY logDateTime DESC, levelID ASC; "; //order by log date and time descending, and by level id ascending

$collectionList = $db->getDataset($sql); //submit query
    
$scorecard = json_encode($collectionList); //encode in json

echo($scorecard);


?>