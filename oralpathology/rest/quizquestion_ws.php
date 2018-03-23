<?php
require("../classes/dbutils.php");
// require("../classes/quizquestion.php");

class QuizQuestion{
	/* Global variables */
	
	public $questionID = ""; //question id
	public $questionStem = ""; 
    public $choiceList = []; //array of choices

}

class QuizQuestionChoice{
	/* Global variables */
	
	public $choiceID = ""; //id
	public $choiceText = ""; //text description
    public $isCorrect = ""; //if question is correct

}

$db = new DbUtilities;



$sql = "SELECT questionID, questionStem, choiceID, choiceText, isCorrect "; //get listed data
$sql .= "FROM quizquestions q JOIN quizquestionchoices c ON questionID = fk_questionID WHERE  isActive = 1 ORDER BY questionID;"; //from quiz questions and question choices where ids match and question is active

// echo($sql . "<br />");
$collectionList = $db->getDataset($sql); //submit sql query

$questionList = [];
// $scorecard = json_encode($collectionList);

// echo($scorecard);

// echo(sizeof($collectionList));

$prevQuestion = "";
$quizQuestion = null;
for($i = 0; $i < sizeof($collectionList); $i++){ //iterate through number of retrieved questions
    if($prevQuestion != $collectionList[$i]["questionID"]){ //if previous question is not equal to current question index
        if($quizQuestion != null){ //if question isnt null
            array_push($questionList, $quizQuestion); //push to question array
        }
        // echo($collectionList[$i]["questionStem"] . "<br />");
        $quizQuestion = new QuizQuestion;
        $quizQuestion->questionID = $collectionList[$i]["questionID"];
        $quizQuestion->questionStem = $collectionList[$i]["questionStem"];
        $prevQuestion = $collectionList[$i]["questionID"]; //add previous question to question list
    }
    
    $quizQuestionChoice = new QuizQuestionChoice;
    $quizQuestionChoice->choiceID = $collectionList[$i]["choiceID"];
    $quizQuestionChoice->choiceText = $collectionList[$i]["choiceText"];
    $quizQuestionChoice->isCorrect = $collectionList[$i]["isCorrect"];
    
    array_push($quizQuestion->choiceList, $quizQuestionChoice); //add current question to question array
    
    // echo(" - " . $collectionList[$i]["choiceText"] . "<br />");
}

// echo(sizeof($questionList));

echo(json_encode($questionList)); //encode to json


?>