<?php
require("../classes/dbutils.php");

//Get ID from Session data
$qID = $_GET["questionID"];
$iID = $_GET["imageID"];

$sql = "DELETE FROM questions_images WHERE fk_QuestionID = '" . $qID . "' AND fk_ImageID = '" . $iID . "';"; //Delete image from database where ID matches
    
$db = new DbUtilities;
$db->executeQuery($sql);
echo($sql);

?>    
