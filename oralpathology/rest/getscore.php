<?php

require("../classes/dbutils.php");

$userID = $_POST["userID"];
$levelID = $_POST["levelID"];
$attemptID = $_POST["attemptID"];


/*
$sql = "SELECT questionID, imageID, isBonus, scoreDate, scoreTime, levelID, attemptID ";
$sql .= "FROM score a JOIN questions_levels b ON a.questionID = b.fk_questionID ";
$sql .= "WHERE levelID = " . $levelID . " AND attemptID = '" . $attemptID . "' AND userID = '" . $userID . "';";
*/
// echo($sql);
if($userID=="TOPFIVE"){ //Retrieve the top five scores
	$sql = "SELECT userID,SUM(scoreRecieved) AS Score FROM score GROUP BY attemptID ORDER BY Score DESC LIMIT 5;"; //get the top five scores, order by score
	$db = new DbUtilities;
	$scoreCollection = $db->getDataset($sql); //retrieve sql query and convert to json
	$scoreData = '"score" : ' . json_encode($scoreCollection);
	echo('{' . $scoreData . '}');
}else{ //get data of user's attempt
	$sql = "SELECT questionID, imageID, isBonus, levelID, attemptID, scoreRecieved, startDateTime, endDateTime ";
	$sql .= "FROM score WHERE attemptID = '" . $attemptID . "' AND userID = '" . $userID . "';";
	
	$db = new DbUtilities;
	$scoreCollection = $db->getDataset($sql); //submit above sql query and convert to json
	$scoreData = '"score" : ' . json_encode($scoreCollection);

	$sql = "SELECT questionID, scoreDate, scoreTime, levelID, attemptID "; //get data from questionComplete where IDs match
	$sql .= "FROM questioncomplete WHERE levelID = " . $levelID . " AND attemptID = '" . $attemptID . "' AND userID = '" . $userID . "';";

	$questionScoreCollection = $db->getDataset($sql); //retrieve dataset and convert to json

	$questionData = '"questionComplete" : ' . json_encode($questionScoreCollection);


	echo('{' . $scoreData . ', ' . $questionData . '}');
}
?>
