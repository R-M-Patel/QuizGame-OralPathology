<?php
require("../classes/dbutils.php");
$db = new DbUtilities;

$gameAttemptID = $_GET["gameAttemptID"];
$levelID = $_GET["levelID"];
$userID = $_GET["userID"];

$sql = "SELECT MAX(levelAttemptNumber) AS lastAttemptNumber FROM scorelog "; //Get max level attempt number from score log
$sql .= "WHERE fk_userID = " . $userID . " AND attemptID = '" . $gameAttemptID . "';"; //where user ID and game attempt ID equal current user and game attempt IDs
    
$collectionList = $db->getDataset($sql); //submit sql query above
$levelAttemptNumber = $collectionList[0]["lastAttemptNumber"];


$sql = "SELECT levelAttemptNumber, isLevelComplete, finalLevelScore, numberQuestionsAnswered,numberCorrect,numberIncorrect "; //get level attempt number, completion of level, final score, total questions answered, number correct, number incorect
$sql .="FROM scorelog WHERE attemptID = '" . $gameAttemptID . "' AND fk_userID = " . $userID . " AND levelID = " . $levelID . " AND levelAttemptNumber = " . $levelAttemptNumber . ";"; //where attempt id, user id, level id, and level attempt number all match

// echo($sql);
$collectionList = $db->getDataset($sql); //submit sql query from above
    
$score = json_encode($collectionList); //encode it as json



$sql = "SELECT a.fk_questionID AS questionID, a.fk_imageID AS imageID, diagnosisName, imageFolder, imageName, isCorrect "; //get question id, image id, diagnosis name, folder, image name, and whether it is correct or not
$sql .= "FROM answerlog a, questions_images qi, questions q, images i "; //from four different databases
$sql .= "WHERE a.fk_imageID = qi.fk_imageID  AND qi.fk_questionID = q.questionID  "; //where ids match
$sql .= "AND a.fk_questionID = q.questionID AND a.fk_imageID = i.imageID ";
$sql .= "AND attemptID = '" . $gameAttemptID . "' AND userID = " . $userID . " AND levelID = " . $levelID . " AND levelAttemptNumber = " . $levelAttemptNumber . ";";


$collectionList = $db->getDataset($sql);
    
$answers = json_encode($collectionList);

$summary = '{"score" : ' . $score . ', "answers" : ' . $answers . '}'; //represent previous sql queries as summaries

echo($summary);


?>