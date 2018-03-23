<?php
	require("classes/security.php");

	$pageTitle = "Quiz";
	require("header.php");
    $drupalUserID = $_SESSION["drupalUserID"];
    // echo($drupalUserID . "<br />");

?>
<script language="javascript" type="text/javascript">
    var questionList = null;
    var currentQuestion = null;
    $(document).ready(function(){
        
        var uri = "rest/quizquestion_ws.php";
        $.getJSON(uri, function(data){
            if(data){
                questionList = data;
                loadQuestion();
            }
        });
    });
    
	/* load question */
    function loadQuestion(){
        $("#quizQuestion").empty();
        var questionIndex = Math.floor(Math.random() * questionList.length) + 1;
        // console.log(questionIndex);
        var questionObj = questionList[questionIndex];
        if(!questionObj){
            loadQuestion();
        }
        // console.log(questionObj);
        currentQuestion = questionObj;
                $q = $("<div></div>");
                $q.attr({
                    "id": questionObj.questionID,
                    "class": "quizQuestionStem"
                });
                $q.css({
                    "font-size":"20px",
                    "padding-bottom": "20px"
                });
                $q.html(questionObj.questionStem);
                $("#quizQuestion").append($q);
                for(var i = 0; i<questionObj.choiceList.length; i++){ //iterate through question choices
                    var choice = questionObj.choiceList[i];
                    // console.log(choice);
                    $rad = $("<input>");
                    $rad.attr({
                        "id" :  questionObj.questionID + "_" + choice.choiceID,
                        "type" : "radio",
                        "name" : "quizquestion"
                    });
                    $rad.val(choice.choiceID);
                    
                    $lbl = $("<label>");
                    $lbl.attr({
                       "for" : questionObj.questionID
                    });
                    $lbl.html("&nbsp;" + choice.choiceText);
                    
                    $("#quizQuestion").append($rad); //append questions
                    $("#quizQuestion").append($lbl);
                    $("#quizQuestion").append($("<br />"));
                    
                }
    }
    
    function submitQuestion(){
        var radioValue = $("input[name='quizquestion']:checked").val();
        // alert(radioValue);
        for(var i = 0; i<currentQuestion.choiceList.length; i++){
            var logData = {};
            logData.userID = '<?php echo $drupalUserID; ?>';
            logData.questionID = currentQuestion.questionID;
            logData.choiceID = currentQuestion.choiceList[i].choiceID;
            
            // console.log(currentQuestion.choiceList[i].choiceID + " = " + radioValue);
            if(currentQuestion.choiceList[i].choiceID == radioValue){
                if(currentQuestion.choiceList[i].isCorrect == 'y'){
                    showHint("Correct");
                    logData.isCorrect = 1;
                    
                }
                else{
                    // showHint("Incorrect! The correct answer to " + currentQuestion.questionStem + " is <b>" + getCorrectQuestionChoice() + "</b>.");
                    showHint("Incorrect! The correct answer is <b>" + getCorrectQuestionChoice() + "</b>.");
                    logData.isCorrect = 0;
                    
                }
                // console.log(logData);
                
                $.post('rest/logquizanswer.php', logData, function(result){
                    // console.log(result);
                });
                
                break;
            }
        }
        loadQuestion();
    }
    
	/*function to get correct question choice */
    function getCorrectQuestionChoice(){
        for(var i = 0; i<currentQuestion.choiceList.length; i++){
            if(currentQuestion.choiceList[i].isCorrect == 'y'){
                return currentQuestion.choiceList[i].choiceText;
            }
        }
        return "";
    }
</script>

<div class="container">
  <div class="row rules-row">
    <div class="col-md-12">
      <h2> Quiz </h2>
    </div>
  </div>

  <div class="row rules-row">
      <div class="col-md-2 tutorial-col"></div>
      <div class="col-md-8 tutorial-col">
            <div id="quizQuestion">
                
            </div>
      </div>
      
    
  </div>

    <div class="row rules-row">
      <div class="col-md-2 tutorial-col"></div>
      <div class="col-md-8 tutorial-col">
            <input type="button" id="btnAnswer" value="Submit your answer" onclick="submitQuestion();" class="btn" />
            <input type="button" id="btnNextQuestion" value="I don't know, give me a different question" onclick="loadQuestion();" class="btn" />
      </div>
      
    
  </div>
    
    
</div>

<div id='dialog-confirm' title='Important'>
        <p>
            <span class='ui-icon ui-icon-alert' style='visibility: hidden; float:left; margin:0 7px 20px 0;'>
            </span>
        </p>
      </div>

<?php
	require("footer.php");
?>
