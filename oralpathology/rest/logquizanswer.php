<?php
require("../classes/dbutils.php");

//log various IDs
$userID = $_POST["userID"];
$questionID = $_POST["questionID"];
$choiceID = $_POST["choiceID"];
$isCorrect = $_POST["isCorrect"];


$sql = "INSERT INTO quizanswerlog (userID, fk_quizQuestionID, fk_quizChoiceID, isCorrect) VALUES "; //insert IDs and if answer is correct to database
$sql .= " (?, ?, ?, ?); ";


$db = new DbUtilities;
$db->executeQuery($sql, "sssi", array($userID, $questionID, $choiceID, $isCorrect)); //submit to database



?>