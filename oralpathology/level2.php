<?php
require("classes/security.php");
$pageTitle = "Level 2";
require("header.php");
$drupalUserID = $_SESSION["drupalUserID"];
if (isset($_GET["debug"])) {
    $_SESSION["debug"] = true;
}
//var_dump($_SESSION) // for testing
?>


<script language="javascript" type="text/javascript">
    /*
        RULES FOR LEVEL 2:
        1. This level has 4 questions
        2. Each question shows 6 images - between 1 and 4 represent the correct answer / match
            for the presented diagnosis
        3. Each correct answer earns 200 points
        4. If learner misses 1 questions, the learner fails Level 2 and has to repeat it
        5. If learner answers all 4 questions correctly, the Level 2 awards a 300-point bonus
        6. All levels have a time-based performance bonus:
                a. Time-based bonus has an initial value of 400 points
                b. For each second spent on Level 2 learner loses 5 points from the time-based bonus
    */
    
    
    
    /******************************************************************************
    Global variable declarations
    ******************************************************************************/
    
    var levelQuestionList = null;   // All questions for this level
    
    /*
        Object that stores a single question retrieved from the JSON array stored in levelQuestionList
    */
    var levelID = 2;
    var question = null;            
    var levelAttempts = 1;          // Number of times this level has been attempted
    var questionsCompleted = 0;     // Number of questions answered (correctly or incorrectly)
    var imagesSelected = 0;         // Number of images selected (correctly or incorrectly)
    var numberCorrect = 0;          // Number of correct answers in a level attempt
    var numberIncorrect = 0;        // Number of incorrect answers in a level attempt
    var numberImagesCorrect = 0;    // Number of correct images in a question attempt
    var numberImagesIncorrect = 0;  // Number of incorrect images in a question attempt
    var currentScore = 0;           // Learner's current score
    var imageList = null;           // ????
    var timerID = 0;                // Tracks ID generated by setInterval()
    var redirectTimerID = 0;
    var timeBonus = 400;            // Time-based bonus for Level 2
    var levelPassed = false;
    var numberAvailableCorrect = 0;
    var gameAttemptID = '<?php echo $_SESSION["gameAttemptID"]; ?>';
    var drupalUserID = '<?php echo $drupalUserID; ?>';
    
    // Wait until the document has been loaded into the browser
    $(document).ready(function(){
        if(getUrlParameter('levelAttempts')){
            levelAttempts = getUrlParameter('levelAttempts');
        }
        updateScoreBoard();
        initQuestion();
        
        /* Hide overlay (zoom window) when escape key is pressed */
        $(document).keyup(function(evt){
            if(evt.keyCode == 27){
                $('#overlay').css('display', 'none');
            } 
        }); // end of "hide zoom overlay" logic
        
        /* 
            All levels use time-based bonuses.  For Level 2, the initial value of a time-based
            bonus is 300 points.  For each second spent on the level, learner loses 5 points from 
            the time-based bonus. 
            The following line initializes a timer-based function that subtracts 5 points from the 
            initial bonus value every 5 seconds
        */
        timerID = setInterval('updateTimeBonus', 1000);
    });
    
    
    function initQuestion(){
        /* Reset image counters */
        numberImagesCorrect = 0; 
        numberImagesIncorrect = 0;
        
        /* When new question is loaded, clear green buttons from previous correct selections */
        $('.imageSelector').removeAttr('style');
        /* Show overlay with loading icon */
        $('#loadingOverlay').css('display', 'block');
        
        // Concat. URI to the web service
        var uri = "rest/question_ws_obj.php?levelID=" + levelID + "&gameAttemptID=" + gameAttemptID;
        $.getJSON(uri, function(data){
            /* Set global variable to the value of the JSON array retreived from the web service */
            levelQuestionList = data; 
            
            /* Load the question */
            getQuestion(levelQuestionList);
            
            /* Get number of correct images available in this question */
            numberAvailableCorrect = getNumberAvailableCorrect();
            // console.log(numberAvailableCorrect);
            
            /* Hide overlay with loading icon */
            $('#loadingOverlay').css('display', 'none');
        });    
    }
    
	/*select image */
    function selectDxImage(buttonObj){
        var selectedImage = getSelectedImageData($(buttonObj));
        imagesSelected = imagesSelected + 1; // Update selectedImages counter
        
        if(selectedImage){
            $(buttonObj).css({
                "background-color": "blue",
                "border-color": "blue"
            });
            if(selectedImage.isCorrectChoice){ //answered right
                numberImagesCorrect = numberImagesCorrect + 1;
            }
            else{ //answered wrong
                numberImagesIncorrect = numberImagesIncorrect + 1;
            }
            updateAnswerLog(gameAttemptID, 2, levelAttempts, drupalUserID, selectedImage.associatedDiagnosisID, selectedImage.imageID, selectedImage.isCorrectChoice); 
                    
            
        }
        
    }
    
	/* submit answers */
    function submitLevel2Answers(){
        questionsCompleted = questionsCompleted + 1;
        highlightCorrectIncorrect(levelQuestionList);
        processAnswerChoices();
        
        // Load next question
        // initQuestion();
        
        
    }
    
    function processAnswerChoices(){
        /********************************************************
        Logic for answered question
        ********************************************************/
        if(numberImagesCorrect == numberAvailableCorrect){
            numberCorrect = numberCorrect + 1; // question answered correctly
            currentScore = currentScore + 200;
        }
        else{
            numberIncorrect = numberIncorrect + 1; // missed some of the correct images or selected incorrect ones
        }
        
        /********************************************************
        End logic for answered question
        ********************************************************/
        
        /********************************************************
        Logic for success on level 2
        ********************************************************/
        if(questionsCompleted == 3){
            if(numberCorrect == 3){
                currentScore = currentScore + 400;
            }
            currentScore = currentScore + timeBonus;
            clearInterval(timerID);
            levelPassed = true;
            var msgText = "";
            updateScoreLog(gameAttemptID, 2, drupalUserID, levelAttempts, 1, currentScore, questionsCompleted, numberCorrect, numberIncorrect);

        }
        /********************************************************
        End logic for success on level 2
        ********************************************************/




        /********************************************************
        Logic for failed level 2
        ********************************************************/
        if(questionsCompleted == 3 && numberIncorrect > 1){
            // Reset all counters
            // levelAttempts = levelAttempts + 1;
            numberCorrect = 0;
            numberIncorrect = 0;
            questionsCompleted = 0;
            timeBonus = 400;
            currentScore = 0;
            updateScoreLog(gameAttemptID, 2, drupalUserID, levelAttempts, 0, currentScore, questionsCompleted, numberCorrect, numberIncorrect);
            document.location.href = "completedlevelsummary.php?levelID=2";
        }
        /********************************************************
        End logic for failed level 2
        ********************************************************/


        updateScoreBoard();
        redirectTimerID = setInterval(countRedirect, 2000);
    }
    
	/*function to get number available correct */
    function getNumberAvailableCorrect(){
        var numCorrect = 0;
        for(var i = 0; i < imageList.length; i++){
            if(imageList[i].isCorrectChoice){
                numCorrect ++;
            }
        }
        return numCorrect;
    }

</script>

<?php

?>
<div class="container">
  <div class="questions-div">
    <div class="question-box">
      <h1 class="level-num"> Level 2: Select all correct matches </h1>
      <h3>
          <!--
          The following php code brings up the different questions and hints tied to each question.
          -->
          Which of these images represents: </br> <h3 class='disease' id='questionText'></h3>
          
      </h3>
      <div class = "hint">
          <button type="button" id="hintButton" class="hintBtn" data-toggle="tooltip" data-placement="top" title=  ""; data-original-title="Tooltip on top">HINT</button>
          <input type="button" class="levelSubmitBtn" id="btnSubmitLevel2" value="SUBMIT" onclick="submitLevel2Answers();" />
      </div>
      
    </div>

    <div class="scores-parent">
      <div class="scores-child dark" id="divLevelAttempts"> # Level Attempts: 1</div>
      <div class="scores-child" id="divQuestionsAnswered"> Questions Completed: 0</div>
      <div class="scores-child dark" id="divNumberCorrect"> Number Correct: 0</div>
      <div class="scores-child" id="divCurrentScore"> Your Score: 0</div>
    </div>
  </div><!--end questions -->

  <div class="answers-div">
    <!--
    The following php code creates an image container and slider that contain the images  that are randomly generated from the database and based off of the question and answer.
    -->
    <div class='answers-row'>
        <div class='imageContainer'>
            <div class='selectors' style='width:55%;'>
                <input type='button' value='SELECT' class='imageSelector' onclick='selectDxImage(this);' />
            </div>
            <div class='selectors' style='width:45%;'>
                <img src='images/magnify.png' class='magnify' />
            </div>
            
            <img class='intense' height='250' />
        </div>
        <div class='imageContainer'>
            <div class='selectors' style='width:55%;'>
                <input type='button' value='SELECT' class='imageSelector' onclick='selectDxImage(this);' />
            </div>
            <div class='selectors' style='width:45%;'>
                <img src='images/magnify.png' class='magnify' />
            </div>
            
            <img class='intense' height='250' />
        </div>
    </div>
    <div class='answers-row'>
        <div class='imageContainer'>
            <div class='selectors' style='width:55%;'>
                <input type='button' value='SELECT' class='imageSelector' onclick='selectDxImage(this);' />
            </div>
            <div class='selectors' style='width:45%;'>
                <img src='images/magnify.png' class='magnify' />
            </div>
            
            <img class='intense' height='250' />
        </div>
        <div class='imageContainer'>
            <div class='selectors' style='width:55%;'>
                <input type='button' value='SELECT' class='imageSelector' onclick='selectDxImage(this);' />
            </div>
            <div class='selectors' style='width:45%;'>
                <img src='images/magnify.png' class='magnify' />
            </div>
            
            <img class='intense' height='250' />
        </div>
    </div>
    <div class='answers-row'>
        <div class='imageContainer'>
            <div class='selectors' style='width:55%;'>
                <input type='button' value='SELECT' class='imageSelector' onclick='selectDxImage(this);' />
            </div>
            <div class='selectors' style='width:45%;'>
                <img src='images/magnify.png' class='magnify' />
            </div>
            
            <img class='intense' height='250' />
        </div>
        <div class='imageContainer'>
            <div class='selectors' style='width:55%;'>
                <input type='button' value='SELECT' class='imageSelector' onclick='selectDxImage(this);' />
            </div>
            <div class='selectors' style='width:45%;'>
                <img src='images/magnify.png' class='magnify' />
            </div>
            
            <img class='intense' height='250' />
        </div>
    </div>

    
    <div id='dialog-confirm' title='Important'>
        <p>
            <span class='ui-icon ui-icon-alert' style='visibility: hidden; float:left; margin:0 7px 20px 0;'>
            </span>
        </p>
      </div>
  </div>
</div><!--end container -->



<?php
require("footer.php");
?>
