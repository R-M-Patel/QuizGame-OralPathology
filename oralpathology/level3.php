<?php
require("classes/security.php");
$pageTitle = "Level 3";
require("header.php");
$drupalUserID = $_SESSION["drupalUserID"];
if (isset($_GET["debug"])) {
    $_SESSION["debug"] = true;
}
//var_dump($_SESSION) // for testing
?>


<script language="javascript" type="text/javascript">
    /*
        RULES FOR LEVEL 3:
        1. This level has 3 questions
        2. Each question shows 6 images and 6 corresponding diagnoses
        3. Learners must match diagnoses with images by dragging diagnoses to a corresponding
                image and dropping it
        4. Each correct answer earns 300 points
        5. If learner misses 1 questions, the learner fails Level 3 and has to repeat it
        5. If learner answers all 3 questions correctly, the Level 3 awards a 500-point bonus
        6. All levels have a time-based performance bonus:
                a. Time-based bonus has an initial value of 500 points
                b. For each second spent on Level 1 learner loses 5 points from the time-based bonus
    */
    
    
    
    /******************************************************************************
    Global variable declarations
    ******************************************************************************/
    
    var levelQuestionList = null;   // All questions for this level
    
    /*
        Object that stores a single question retrieved from the JSON array stored in levelQuestionList
    */
    var levelID = 3;
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
    var timeBonus = 500;            // Time-based bonus for Level 3
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
            All levels use time-based bonuses.  For Level 1, the initial value of a time-based
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
            console.log(levelQuestionList);
            
            /* Load the question */
            loadLevel3Questions(levelQuestionList);
            randomizeSelectableTerms();
            
            /* Hide overlay with loading icon */
            $('#loadingOverlay').css('display', 'none');
        });    
    }
    
    /*load questions */
    function loadLevel3Questions(data){
        var questIdx = 0;

        // Iterate through all image containers
        $('.imageContainer').each(function(index){
            if(levelQuestionList[questIdx]){
                if(!levelQuestionList[questIdx].imageList[0]){
                    return;
                }
                /****************************** 
                Set properties for the images
                ******************************/
                $img = $(this).children('.intense'); // Get image object

                /*
                $img.attr({
                    "src" : levelQuestionList[questIdx].imageList[0].fullThumbnailPath,    // set ID of the image
                    "id" : "img_" + levelQuestionList[questIdx].questionID,   // set image source (path to thumbnail)
                    "title" : levelQuestionList[questIdx].diagnosisName   // This line is for debugging only!!! 
                });
                */
                
                $img.attr({
                    "src" : levelQuestionList[questIdx].imageList[0].fullThumbnailPath,    // set ID of the image
                    "id" : "img_" + levelQuestionList[questIdx].questionID   // set image source (path to thumbnail)
                });
                
                // Create on-click event for zoom / preview functionality
                $img.click(function(){
                    var largeImagePath = $(this).attr('src').replace("dentalthumbnails", "dentalimages");
                    showImagePreview(largeImagePath);
                });
                
                $dxtarget = $(this).children('.matchDrop');
                $dxtarget.attr({
                   "id" :  "match_" + levelQuestionList[questIdx].questionID
                });
                $dxtarget.empty();
                
                $img.droppable({
                    drop: function( event, ui ) {
                        var targetImageID = $(this).attr("id");
                        $targetDxDiv = $('#' + targetImageID.replace("img", "match"));
                        
                        $(ui.draggable).css({
                           "left" : "0px",
                            "top" : "0px",
                            "margin-left" : "auto",
                            "margin-right" : "auto"
                        });

                        for(var i = 0; i < $targetDxDiv.children().length; i++){
                            $('#selectableTerms').append($targetDxDiv.children()[i]);
                        }
                        $targetDxDiv.append($(ui.draggable));
                        
                    }
                });

                /****************************** 
                End properties for the images
                ******************************/

                
                
                /*************************************
                Create selectable terms
                **************************************/
                $dxSelDiv = $('<div></div>');
                $dxSelDiv.attr(
                    {
                        'id' : 'dx_' + levelQuestionList[questIdx].questionID,
                        'class' : 'dxDraggable'
                    });
                
                $dxSelDiv.css('z-index', '1');
                
                $dxSelDiv.mouseover(function(){
                    $(this).css( 'cursor', 'pointer' );    
                });
                
                $dxSelDiv.draggable(
                {   
                    stop: function() {
                        
                    }
                });
                
                $dxSelDiv.html(levelQuestionList[questIdx].diagnosisName);
                $('#selectableTerms').append($dxSelDiv);
                
                $('#selectableTerms').droppable({
                    drop: function( event, ui ) {
                        
                        $(ui.draggable).css({
                           "left" : "0px",
                            "top" : "0px"
                        });

                        $(this).append($(ui.draggable));
                        
                    }
                });
                
                
                
                questIdx = questIdx + 1;
            } // end if valid image
        });

    }
    
	/*iterate through images and get data */
    function getImageDataFromSelection(dxID){
        for(var i = 0; i<levelQuestionList.length; i++){
            var imgObj = levelQuestionList[i].imageList[0];
            
            if(imgObj.associatedDiagnosisID == dxID){
                return imgObj;
            }
        }
        return null;
    }
    
	/*randomize choices for question */
    function randomizeSelectableTerms(){
        $selectableTermsDiv = $('#selectableTerms');
        var itemList = shuffle($selectableTermsDiv.children());
        $.each(itemList, function( index, value ) {
            // console.log( $(value) );
            $(value).detach();
            $selectableTermsDiv.prepend($(value));
        });

    }
    
    function submitLevel3Answers(){
        questionsCompleted = questionsCompleted + 1;
        
        // Iterate through all image containers
        $('.imageContainer').each(function(index){
            $img = $(this).children('.intense'); // Get image object
            
            $dx = $(this).children('.matchDrop');
            if($dx.children()[0]){
                var isCorrectChoice = false;
                var imgID = $img.attr("id").replace("img_", "");
                var dxID = $($dx.children()[0]).attr("id").replace("dx_", "");
                // console.log(dxID + ' = ' + imgID);
                if(imgID == dxID){ //if answer is correct
                    numberImagesCorrect ++;    
                    $img.css("border", "10px solid green");
                    isCorrectChoice = true;
                }
                else{ //if answer is wrong
                    numberImagesIncorrect ++;
                    $img.css("border", "10px solid red");
                    isCorrectChoice = false
                }
                var imgObj = getImageDataFromSelection(imgID); //retrieve data for image
                
                if(imgObj){
                    updateAnswerLog(gameAttemptID, 3, levelAttempts, drupalUserID, imgObj.associatedDiagnosisID, imgObj.imageID, isCorrectChoice); //update answer log with image data    
                }
                
            }
            
        });
        
        /********************************************************
        Logic for answered question
        ********************************************************/
        if(numberImagesCorrect == 6){
            numberCorrect = numberCorrect + 1; // question answered correctly
            currentScore = currentScore + 300;
        }
        else{
            numberIncorrect = numberIncorrect + 1; // missed some of the correct images or selected incorrect ones
        }
        
        /********************************************************
        End logic for answered question
        ********************************************************/
        
        /********************************************************
        Logic for success on level 3
        ********************************************************/
        if(questionsCompleted == 2){
            if(numberCorrect == 2){
                currentScore = currentScore + 500;
            }
            currentScore = currentScore + timeBonus;
            clearInterval(timerID);
            levelPassed = true;
            /*
            showAnswerConfirm("Congratulations!  You have successfully completed Level 3 with a score of " + 
                              currentScore, "green", "Completed Level 3!");
            */
            updateScoreLog(gameAttemptID, 3, drupalUserID, levelAttempts, 1, currentScore, questionsCompleted, numberCorrect, numberIncorrect);

        }
        /********************************************************
        End logic for success on level 3
        ********************************************************/
        
        /********************************************************
        Logic for failed level 3
        ********************************************************/
        if(numberIncorrect == 1){
            /*
            showAnswerConfirm("You answered one questions incorrectly and will have to repeat this level!", 
                                      "red", "Repeat Level 3");
            */

            // Reset all counters
            levelAttempts = levelAttempts + 1;
            numberCorrect = 0;
            numberIncorrect = 0;
            questionsCompleted = 0;
            timeBonus = 500;
            currentScore = 0;
            updateScoreLog(gameAttemptID, 3, drupalUserID, levelAttempts, 0, currentScore, questionsCompleted, numberCorrect, numberIncorrect);
        }
        /********************************************************
        End logic for failed level 3
        ********************************************************/
        
        updateScoreBoard();
        redirectTimerID = setInterval(countRedirect, 2000);
        // Load next question
        // initQuestion();
        
    }
    
    

</script>

<?php

?>
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="question-box level3">
                <h1 class="level-num">Level 3: Matching Game</h1>
                <h3>Please match diagnoses to the corresponding images. 
                    Drag and drop each diagnosis onto a corresponding image. </h3>
                <div class = "hint">
                    <input type="button" class="levelSubmitBtn" id="btnSubmitLevel2" value="SUBMIT" onclick="submitLevel3Answers();" />
                </div>
            </div>
            
        </div>
        <div class="col-md-6">
            <div class="scores-parent level3">
                <div class="scores-child dark" id="divLevelAttempts"> # Level Attempts: 1</div>
                <div class="scores-child" id="divQuestionsAnswered"> Questions Completed: 0</div>
                <div class="scores-child dark" id="divNumberCorrect"> Number Correct: 0</div>
                <div class="scores-child" id="divCurrentScore"> Your Score: 0</div>
            </div>
        </div>
    </div>
    <div class="col-md-3 terms" id="selectableTerms">
            
    </div>
    
    <div  class="row">
        <div class="col-md-3">
            &nbsp;
        </div>
        

        <div class="col-md-9">
            <div class='answers-row'>
                <div class='imageContainer'>
                    <div class='matchDrop'></div>
                    <img class='intense' height='250' />
                </div>
                <div class='imageContainer'>
                    <div class='matchDrop'></div>
                    <img class='intense' height='250' />
                </div>
            </div>
            <div class='answers-row'>
                <div class='imageContainer'>
                    <div class='matchDrop'></div>
                    <img class='intense' height='250' />
                </div>
                <div class='imageContainer'>
                    <div class='matchDrop'></div>
                    <img class='intense' height='250' />
                </div>
            </div>
            <div class='answers-row'>
                <div class='imageContainer'>
                    <div class='matchDrop'></div>
                    <img class='intense' height='250' />
                </div>
                <div class='imageContainer'>
                    <div class='matchDrop'></div>
                    <img class='intense' height='250' />
                </div>
            </div>
        </div> 
        <div id='dialog-confirm' title='Important'>
            <p>
                <span class='ui-icon ui-icon-alert' style='visibility: hidden; float:left; margin:0 7px 20px 0;'>
                </span>
            </p>
          </div>
        </div>
    </div>
</div><!--end container -->



<?php
require("footer.php");
?>
