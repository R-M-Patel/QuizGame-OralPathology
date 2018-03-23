<?php
require("../classes/dbutils.php");
$db = new DbUtilities;

$sql = "SELECT fk_userID, levelID, MAX(finalLevelScore) AS maxLevelScore "; //get user id, level id, and max level score
$sql .= "FROM dentalgame.scorelog "; //from score log
$sql .= "WHERE isLevelComplete = 1 "; //where level has been completed
$sql .= "GROUP BY fk_userID, levelID "; //group by id
$sql .= "ORDER BY maxLevelScore DESC "; //order by score
$sql .= "LIMIT 3; ";

$collectionList = $db->getDataset($sql); //submit sql query
    
$leaderboard = '{"levels" : ' . json_encode($collectionList) . ','; //encode to json

$sql = "SELECT fk_userID AS userID, SUM(maxLevelScore) AS maxOverallScore FROM "; //select id and sum of score
$sql .= "(SELECT fk_userID, levelID, MAX(finalLevelScore) AS maxLevelScore ";
$sql .= "FROM dentalgame.scorelog  "; //from score log
$sql .= "WHERE isLevelComplete = 1  "; //where level has been completed
$sql .= "GROUP BY fk_userID, levelID) AS maxLevelScoreList "; //group by id
$sql .= "GROUP BY fk_userID  "; 
$sql .= "ORDER BY maxOverallScore DESC LIMIT 5; "; //limit to five

$collectionList = $db->getDataset($sql); //submit sql query

$leaderboard .= '"overall" : ' . json_encode($collectionList); //encode to json
$leaderboard .= '}';


echo($leaderboard);


?>