<?php

require("image.php");

/*class for question object */
class Question{
	/* Global variables */
	public $attempt = "";
	public $questionID  = "";
	public $diagnosisName = "";
	public $hint = "";
	public $level = 0;
	public $imageList = array();
	
	/*constructor function for question */
	function __construct($attemptID, $levelID, $maxCorrect = 1, $numOfDistractors = 3, $categories = ""){
		$this->attempt = $attemptID;
		$db = new DbUtilities; //Sets up new database utilities
		
		//Constructs an SQL statement
        if($categories == ""){
            $sql = "SELECT questionID, diagnosisName, hint, numberOfImages "; //select data
            $sql .= "FROM questions q "; //from questions database
            $sql .= "JOIN questions_levels ql ON q.questionID = ql.fk_questionID "; //join where IDs match
            $sql .= "WHERE levelID = " . $levelID . " ";
            $sql .= "AND questionID NOT IN (SELECT questionID FROM used_question_log WHERE attemptID = '" . $attemptID . "' AND levelID = " . $levelID . ") "; //where question is not in used_question_log
            $sql .= "AND questionID IN (SELECT fk_questionID FROM questions_images) ";
            $sql .= "ORDER BY RAND() LIMIT 1; "; //limit it 1
        }
        else{
            // This is the practice mode!
            $sql = "SELECT questionID, diagnosisName, hint, numberOfImages "; //select data
            $sql .= "FROM questions q "; //from questions database
            $sql .= "WHERE fk_categoryID IN (" . $categories . ") "; //where category id is in categories database
            $sql .= "AND questionID IN (SELECT fk_questionID FROM questions_images) "; //where question id is from questions_images database
            $sql .= "ORDER BY RAND() LIMIT 1; "; //limit to 1
        }

		// echo $sql . "<br />";

		$collectionList = $db->getDataset($sql);
    
		//Iterates through SQL dataset and sets global variables to each aspect
		foreach($collectionList as &$row){
			$this->questionID = $row["questionID"];
			$this->level = $levelID;
			$this->diagnosisName = $row["diagnosisName"];
			$this->hint = $row["hint"];
		}
		
		//Creates a new sql dataset query for images
		$sql = "SELECT fk_questionID, imageID, imageFolder, imageName FROM questions_images qi JOIN images i ON qi.fk_imageID = i.imageID "; //select data
		$sql .= "WHERE fk_questionID = '" . $this->questionID . "' ORDER BY RAND() LIMIT " . $maxCorrect . "; "; //where ID matches this question's ID, order randomly, limit by maximum number of questions correct
		
		// echo($sql . "<br />");
		
		//recovers new dataset
		$collectionList = $db->getDataset($sql);
		
		//Iterate through new data set and sets image aspects
		foreach($collectionList as &$row){
			$image = new Image($row["imageID"], $row["imageFolder"], $row["imageName"], true, $this->questionID, $this->diagnosisName, $this->hint);
			array_push($this->imageList, $image);
			// echo($image->getImageID() . "<br />");
            
		}

		$this->loadDistractors($this->questionID, $numOfDistractors);
		$this->logUsedQuestion();
		
	}
	
	//inserts a question that has been used into a database
	private function logUsedQuestion(){
		$sql = "INSERT INTO used_question_log(attemptID,questionID,levelID) VALUES (?,?,?);";
		$db = new DbUtilities;
		$db->executeQuery($sql, "ssi", array($this->attempt, $this->questionID, $this->level));
	}
	
	//Load distractors images for questions
	private function loadDistractors($questionID, $numOfDistractors){
		$db = new DbUtilities;
		/*
		$sql = "SELECT questionID, diagnosisName, hint, numberOfImages, imageID, imageFolder, imageName ";
		$sql .= "FROM questions q JOIN questions_images qi ON q.questionID = qi.fk_questionID ";
		$sql .= "JOIN images i ON qi.fk_imageID = i.imageID ";
		$sql .= "JOIN questions_levels ql ON q.questionID = ql.fk_questionID ";
		$sql .= "WHERE levelID = " . $levelID . " ";
		$sql .= "ORDER BY RAND() LIMIT " . $numOfDistractors . "; ";
		*/
		
		$sql = "SELECT questionID, diagnosisName, hint, imageID, imageFolder, imageName "; //Select data
		$sql .= "FROM distractors d JOIN questions q ON d.fk_distructorQuestionID = q.questionID "; //from distractions and questions databases
		$sql .= "JOIN questions_images qi ON q.questionID = qi.fk_questionID  "; //where IDs match
		$sql .= "JOIN images i ON qi.fk_imageID = i.imageID ";
		$sql .= "WHERE fk_forQuestionID = '" . $questionID . "' ";
		$sql .= "ORDER BY RAND() LIMIT " . $numOfDistractors . " "; //order randomly, limit by number of distractors

		// echo $sql . "<br />";

		$collectionList = $db->getDataset($sql);
		// echo("Distractors: <br />");
		foreach($collectionList as &$row){
			$image = new Image($row["imageID"], $row["imageFolder"], $row["imageName"], false, $row["questionID"], $row["diagnosisName"], $row["hint"]); //create new image object based on retrieved data
			array_push($this->imageList, $image); //add image to the image list
			// echo($image->getImageID() . "<br />");
		}
		
		$db->closeConnection();
	}
	
	public function getQuestionID(){ //get question ID
		return $this->questionID;
	}
	
	public function getImageList(){ //get image list
		return $this->imageList;
	}
	
	public function getHint(){ //get hint
		return $this->hint;
	}
	
	public function getDiagnosisName(){ //get diagnosis name
		return $this->diagnosisName;
	}
	
	/*function to convert to JSON */
	public function toJSON(){
		$list = array(); //Creates a list
		
		/*iterates through the imageList that was passed in and adds them to list array */
		for($i=0; $i < count($this->imageList); $i++){
			$image = $this->imageList[$i];

			$list[] = array('imageID' => $image->getImageID(), 'isCorrect' => $image->isCorrectChoice(), 'diagnosis' => $image->getAssociatedDiagnosis(), 'questionID' => $this->questionID);
		}
		return json_encode($list);
	}

}


?>
