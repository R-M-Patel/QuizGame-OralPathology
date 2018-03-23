<?php

require("../classes/dbutils.php");


$questionID = $_POST["questionID"];
$numOfDistractors = $_POST["numDistractors"];

$sql = "SELECT questionID, diagnosisName, hint, imageID, imageFolder, imageName "; //Get question ID, diagnosis name, a hint, image id, image folder, and image name
$sql .= "FROM distractors d JOIN questions q ON d.fk_distructorQuestionID = q.questionID "; //from database of distractors for each particular question
$sql .= "JOIN questions_images qi ON q.questionID = qi.fk_questionID  ";
$sql .= "JOIN images i ON qi.fk_imageID = i.imageID ";
$sql .= "WHERE fk_forQuestionID = '" . $questionID . "' "; //where question ID matches
$sql .= "ORDER BY RAND() LIMIT " . $numOfDistractors . " "; //randomize distractors

$db = new DbUtilities;
$questionCollection = $db->getDataset($sql); //submit above sql query
$distractionData = '"distractors" : ' . json_encode($questionCollection); //encode distractors in json


echo('{' . $distractionData . '}');
//echo($sql);
?>

