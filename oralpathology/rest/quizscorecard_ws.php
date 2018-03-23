<?php
require("../classes/dbutils.php");
$db = new DbUtilities;

$userID = $_GET["userID"];

/*
$sql = "SELECT questionID, choiceID, questionStem, choiceText, dateTimeAnswered,  quizquestionchoices.isCorrect FROM quizanswerlog ";
$sql .= "JOIN quizquestions ON fk_quizQuestionID = questionID JOIN quizquestionchoices ON fk_quizChoiceID = choiceID ";
$sql .= "WHERE userID = " . $userID . " ORDER BY dateTimeAnswered; ";
*/

$sql = "SELECT DATE(dateTimeAnswered) AS answerDate, isCorrect, COUNT(isCorrect) AS answerCount "; //get date answered, if correct, and count
$sql .= "FROM quizanswerlog WHERE userID = " . $userID . " "; //where user id matches
$sql .= "GROUP BY DATE(dateTimeAnswered), isCorrect;"; //group by date and if correct

// echo($sql);

$collectionList = $db->getDataset($sql); //submit sql query
    
$scorecard = json_encode($collectionList); //encode in json

echo($scorecard);


?>