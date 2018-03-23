<?php
require("../classes/dbutils.php");
if(isset($_GET["levelID"])){
    $levelID = $_GET["levelID"];

    $db = new DbUtilities;
    $sql = "SELECT questionID, diagnosisName, hint, imageID, imageFolder, imageName "; //select data
    $sql .= "FROM questions q JOIN questions_levels ql ON q.questionID = ql.fk_questionID "; //from question database from appropriate level
    $sql .= "JOIN questions_images qi ON q.questionID = qi.fk_questionID ";
    $sql .= "JOIN images i ON qi.fk_imageID = i.imageID "; //where image id matches
    $sql .= "WHERE levelID = " . $levelID . " ORDER BY RAND(); "; // order randomly

    // echo($sql);
    
    $collectionList = $db->getDataset($sql); //submit sql query
    
    $questions = json_encode(utf8ize($collectionList)); //encode to json
    
    // echo($questions);
    
    
    $sql = "SELECT questionID, diagnosisName, fk_forQuestionID, "; //select question id, diagnosis name, and forQuestionID
    $sql .= "imageID, imageFolder, imageName "; //with image id, folder, name
    $sql .= "FROM distractors d JOIN questions q ON d.fk_distructorQuestionID = q.questionID "; //from distractor database and question database where ids match
    $sql .= "JOIN questions_levels ql ON q.questionID = ql.fk_questionID  "; //join with levels
    $sql .= "JOIN questions_images qi ON q.questionID = qi.fk_questionID  "; //join with images
    $sql .= "JOIN images i ON qi.fk_imageID = i.imageID ";
    $sql .= "WHERE levelID = " . $levelID . " "; //where level id matches
    $sql .= "ORDER BY RAND(); "; //randomize
    
    
    /*
    $sql = "SELECT * FROM distractors JOIN questions_levels ON fk_forQuestionID = fk_questionID ";
    $sql .= "WHERE levelID = " . $levelID . " ";
    $sql .= "ORDER BY RAND(); ";
    
    
    $sql = "SELECT fk_forQuestionID, fk_distructorQuestionID, imageID, imageFolder, imageName ";
    $sql .= "FROM distractors d JOIN questions_levels ql ON d.fk_forQuestionID = ql.fk_questionID ";
    $sql .= "JOIN questions_images qi ON d.fk_distructorQuestionID = qi.fk_questionID ";
    $sql .= "JOIN images i ON qi.fk_imageID = i.imageID ";
    $sql .= "WHERE levelID = " . $levelID . " ";
    $sql .= "ORDER BY RAND(); ";
    */
    // echo $sql . "<br />";

    $collectionList = $db->getDataset($sql); //retrieve dataset
    
    $distractors = json_encode(utf8ize($collectionList)); //encode to json
    
    $levelQuestionList = '{"questions" : ' . $questions . ', "distractors" : ' . $distractors . '}';
    echo($levelQuestionList);
}

/*encode to utf8 */
function utf8ize($d) {
    if (is_array($d)) {
        foreach ($d as $k => $v) {
            $d[$k] = utf8ize($v);
        }
    } else if (is_string ($d)) {
        return utf8_encode($d);
    }
    return $d;
}
?>