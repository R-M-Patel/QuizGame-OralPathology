<?php
require("../classes/dbutils.php");
require("../classes/question.php");

/*get data from session */
$gameAttemptID = $_GET["gameAttemptID"];
$levelID = $_GET["levelID"];
$practiceCategories = "";
if(isset($_GET["practiceCategories"])){
    $practiceCategories = $_GET["practiceCategories"];
}

/*Level 1 */
if($levelID == 1){
    if($practiceCategories == ""){ //if practice category is not specified
        $question = new Question($gameAttemptID, 1);
    }
    else{ //if practice category is specified
        $question = new Question($gameAttemptID, 1, 1, 3, $practiceCategories);
    }
    echo(json_encode($question)); //encode in json
}

/*level 2 */
if($levelID == 2){
    $maxCorrect = rand(2, 4); //random number of correct between 2 and 4
    $numOfDistractors = (6 - $maxCorrect); //number of distractors is 6 - number of correct answers

    $question = new Question($gameAttemptID, 2, $maxCorrect, $numOfDistractors); //new question
    echo(json_encode($question)); //encode in json
}

/* level 3 */
if($levelID == 3){ 
    $questionList = array(); //array for questions
    for ($i = 0; $i < 6; $i++) { //loop 6 times
        $question = new Question($gameAttemptID, 3, 1, 0); //variables in order: game attempt ID, level ID, max correct, number of distractors
        array_push($questionList, $question);
    }
    shuffle($questionList); //shuffle question list
    echo(json_encode($questionList)); //encode in json
}



?>