<?php
require("../classes/dbutils.php");
$questionID = $_GET["questionID"];
?>
<html>
<head>
    <title>Question Details</title>
    <link href="../css/admin.css" type="text/css" rel="stylesheet" />
</head>
<body>
<?php
    $sql = "SELECT questionID, diagnosisName, hint, numberOfImages, categoryName "; //Select following data
    $sql .= "FROM questions  JOIN categories ON fk_categoryID = categoryID WHERE questionID = '" . $questionID . "';"; //From questions and categories database where IDs match
    
    $db = new DbUtilities;
	$questions = $db->getDataset($sql); //Submit SQL query
    
    if(sizeof($questions) != 0){ //If at least one question
		/*Display data */
        echo("<b>Question ID</b>: " . $questions[0]["questionID"] . "<br />"); 
        echo("<b>Diagnosis</b>: " . $questions[0]["diagnosisName"] . "<br />");
        echo("<b>Hint</b>: " . $questions[0]["hint"] . "<br />");
        echo("<b>Number of Images</b>: " . $questions[0]["numberOfImages"] . "<br />");
        echo("<b>Category</b>: " . $questions[0]["categoryName"] . "<br />");
        
    }
    
    echo("<b>Correct Images:</b><br />");
    $sql = "SELECT  fk_questionID, imageID, imageFolder, imageName FROM questions_images qi JOIN images i ON qi.fk_imageID = i.imageID "; //Select following data from question_images database
    $sql .= "WHERE fk_questionID = '" . $questionID . "'; "; //where IDs match
	
    // echo($sql . "<br />");
		
    $correctImageList = $db->getDataset($sql);
    $imgCounter = 0;
    foreach($correctImageList as &$row){ //Iterate through list of correct images and display
        // $image = new Image($row["imageID"], $row["imageFolder"], $row["imageName"], true, $this->questionID, $this->diagnosisName, $this->hint);
        echo($row["imageName"] . ' (' . $row["imageID"] . ")<br />");
        echo("<a href='remove_image.php?questionID=" . $row["fk_questionID"] . "&imageID=" . $row["imageID"] . "'>[remove image link]</a><br />");
        echo("<img src='../dentalthumbnails/" . $row["imageFolder"] . "/" . $row["imageName"] . "' class='imgThumb' /><br />");
        $imgCounter++;
    }
    if($imgCounter == 0){ //No images that match
        echo("There are no 'CORRECT' images associated with this question");
    }
    
    $sql = "SELECT distractorID, questionID, diagnosisName, hint, imageID, imageFolder, imageName "; //select following data
    $sql .= "FROM distractors d JOIN questions q ON d.fk_distructorQuestionID = q.questionID "; //from distractors and questions databases
    $sql .= "JOIN questions_images qi ON q.questionID = qi.fk_questionID  "; //where IDs match
    $sql .= "JOIN images i ON qi.fk_imageID = i.imageID ";
    $sql .= "WHERE fk_forQuestionID = '" . $questionID . "' ";

    // echo $sql . "<br />";

    $imgCounter = 0;
    $incorrectImageList = $db->getDataset($sql); //submit query
    echo("<br /><b>Distractors</b>: <br />");
    foreach($incorrectImageList as &$row){ //iterate through list of distractors and display
        echo("Distraftor ID: " . $row["distractorID"] . "<br />");
        echo("Distractor question ID: " . $row["questionID"] . "<br />");
        echo("Image" . $row["imageName"] . ' (' . $row["imageID"] . ")<br />");
        echo("<a href='remove_image.php?questionID=" . $row["questionID"] . "&imageID=" . $row["imageID"] . "'>[remove duplicate distractor image link]</a><br />");
        echo("<img src='../dentalthumbnails/" . $row["imageFolder"] . "/" . $row["imageName"] . "' class='imgThumb' /><br />");
        $imgCounter++;
    }
    if($imgCounter == 0){ //this question has no wrong answers
        echo("There are no 'DISTRACTOR' images associated with this question");
    }
?>    
</body>
</html>


