<?php

//Page to show summary of completed level
require("classes/security.php");
$pageTitle = "Level 1";
require("header.php");
$drupalUserID = $_SESSION["drupalUserID"];
if (isset($_GET["debug"])) {
    $_SESSION["debug"] = true;
}

?>


<script language="javascript" type="text/javascript">
    
    var levelID = getUrlParameter('levelID');
    
    var levelAttempts = 1;          // Number of times this level has been attempted
    var questionsCompleted = 0;     // Number of questions answered (correctly or incorrectly)
    var numberCorrect = 0;          // Number of correct answers in a level attempt
    var numberIncorrect = 0;        // Number of incorrect answers in a level attempt
    var currentScore = 0;           // Learner's current score
    
    var gameAttemptID = '<?php echo $_SESSION["gameAttemptID"]; ?>'; //Retrieve game attempt ID
    var drupalUserID = '<?php echo $drupalUserID; ?>'; //retrieve user ID
    var scoreSummary = null;
    var answersSummary = null;
    var reviewTimer = 0;
    
    // Wait until the document has been loaded into the browser
    $(document).ready(function(){
        setupTimerBar(); //Ready timer
        var sessionInfo = {}; //Array for session info
        sessionInfo.gameAttemptID = gameAttemptID; //Set all session info
        sessionInfo.userID = drupalUserID;
        sessionInfo.levelID = levelID;
        sessionInfo.levelAttemptNumber = 0;
        
        console.log(gameAttemptID);
        $('#levelSummaryTitle').html("Level " + levelID + " Summary"); //Display level information
        
        $.getJSON("rest/levelsummary.php", sessionInfo, function(data){ //retrieve information on completion of level from level summary
            console.log(data); //log the retrieved information from levelsummary.php
            scoreSummary = data.score[0];
            
            answersSummary = data.answers;
            levelAttempts = scoreSummary.levelAttemptNumber;
            currentScore = scoreSummary.finalLevelScore;
            questionsCompleted = scoreSummary.numberQuestionsAnswered;
            numberCorrect = scoreSummary.numberCorrect;
            numberIncorrect = scoreSummary.numberIncorrect;
            
            var feedbackMessage = "";
            var imgClass = "imgCorrect";
            
			/* Iterate through all the answers */
            for(var i = 0; i<answersSummary.length; i++){
                if(answersSummary[i].isCorrect == 1){ //user answered question correctly
                    feedbackMessage = 'You answered this question correctly.  This image represents ' + answersSummary[i].diagnosisName;
                    imgClass = "imgCorrect";
                }
                else{ //user answered incorrectly
                    feedbackMessage = 'You answered this question incorrectly.  This image represents ' + answersSummary[i].diagnosisName;
                    imgClass = "imgIncorrect";
                }
                
                
                $tr = $('<tr></tr>');
                
                $img = $('<img>');
                $img.attr({ //display answer's thumbnail and class
                    "src" : "dentalthumbnails/" + answersSummary[i].imageFolder + "/" + answersSummary[i].imageName,
                    "class" : imgClass
                });
                
                $td = $('<td></td>');
                $td.append($img); //append image to page
                $tr.append($td);
                
                $td = $('<td></td>');
                $td.attr({
                    "class" : "summaryAnswerCaption"
                });
                
                $td.html(feedbackMessage);
                
                $tr.append($td);
                
                $('#selectedAnswers').append($tr); //append answers
                
            }
            updateScoreBoard();
            if(scoreSummary.isLevelComplete == 1){ //indicates that user has successfully completed level
                $('#levelSummaryDetails').html("You have successfully completed Level " + levelID);
                if(levelID == 3){ //user has completed all three levels
                    $('#summaryNavButton').text("Scorecard");
                    $('#summaryNavButton').click(function(){
                        document.location.href="scorecard.php";
                    });
                }
                else{ //user has completed either level 1 or 2
                    $('#summaryNavButton').text("Continue to Level " + (parseInt(levelID) + 1));
                    $('#summaryNavButton').click(function(){
                        document.location.href="level" + (parseInt(levelID) + 1) + "tutorial.php"; //if level 1, advance to level 2. If level 2, advance to level 3
                    });
                }
                
            }
            else{ //user has failed
                $('#levelSummaryDetails').html("You made " + numberIncorrect + " mistakes and will have to repeat Level " + levelID);
                $('#summaryNavButton').text("Repeat Level " + levelID);
                $('#summaryNavButton').css({
                    "background-color" : "red",
                    "border-color" : "dark-green"
                });
                $('#summaryNavButton').click(function(){ //offer user to repeat the level
                    document.location.href="level" + levelID + ".php?levelAttempts=" + (parseInt(scoreSummary.levelAttemptNumber) + 1);
                });
            }
            // Update timer bar
            // setInterval(updateTimerBar, 1000);
        });
    });
    
	/*set up the timer for level */
    function setupTimerBar(){ 
        $bar = $('#reviewTimerProgressBar');
        for(var i = 1; i<=20; i++){
            $timerSect = $('<div></div>');
            $timerSect.attr('id', 'sect_'+i);
            $timerSect.css({
                "height": "6px",
                "width" : parseInt((parseInt($bar.width()) / 20)) + "px",
                "float" : "left",
                "z-index": 0
            });
            $bar.append($timerSect);
        }
    }
    
	/*change timer appearance upon completion of level (is this used?) */
    function updateTimerBar(){
        reviewTimer++;
        // console.log($('#sect_'+reviewTimer).width());
        $('#sect_'+reviewTimer).css({
            "background-color" : "green"
        });
        if(reviewTimer == 20){
            $('#reviewTimerProgressBar').css({
               "background-color" : "green" 
            });
            if(scoreSummary.isLevelComplete == 1){
                if(levelID == 3){
                    document.location.href = "scorecard.php";
                }
                else{
                    document.location.href="level" + (parseInt(levelID) + 1) + "tutorial.php";
                }
            }
            else{
                document.location.href="level" + levelID + ".php?levelAttempts=" + (parseInt(scoreSummary.levelAttemptNumber) + 1);
            }
            
        }
        
    }
    
    
</script>

<?php

?>
<div class="container">
    <!--div id="reviewTimerProgressBar"></div-->
  <div class="questions-div">
    <div class="question-box">
        <h1 class="level-num" id="levelSummaryTitle"></h1>
        <h2 id="levelSummaryDetails"></h2>
        <div class = "hint" id="summaryNav">
            <br />
            <button class="levelSubmitBtn" id="summaryNavButton"></button>
        </div>
    </div>

    <div class="scores-parent">
      <div class="scores-child dark" id="divLevelAttempts"> # Level Attempts: </div>
      <div class="scores-child" id="divQuestionsAnswered"> Questions Completed: </div>
      <div class="scores-child dark" id="divNumberCorrect"> Number Correct: </div>
      <div class="scores-child" id="divCurrentScore"> Your Score: </div>
    </div>
  </div><!--end questions -->

  <table id="selectedAnswers">
        
  </table>
</div><!--end container -->



<?php
require("footer.php");
?>
