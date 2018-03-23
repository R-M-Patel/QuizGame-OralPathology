<?php
	require("classes/security.php");
	require("classes/dbutils.php");
	require("classes/question.php");

	$pageTitle = "Game Scorecard";
	require("header.php");
    $drupalUserID = $_SESSION["drupalUserID"];

?>
<script language="javascript" type="text/javascript">
    var drupalUserID = '<?php echo $drupalUserID; ?>';
    
	/*display score */
    $(document).ready(function(){
        
        var uri = "rest/scorecard_ws.php?userID=" + drupalUserID;
        $.getJSON(uri, function(data){
            console.log(data);
            if(data){
                for(var i = 0; i<data.length; i++){
                    $tr = $('<tr></tr>');
                    
                    $td = $('<td></td>');
                    $td.html(data[i].logDateTime); //display time
                    $tr.append($td);
                    
                    $td = $('<td></td>');
                    $td.html(data[i].levelID); //display level ID
                    $tr.append($td);
                    
                    $td = $('<td></td>');
                    $td.html(data[i].levelAttemptNumber); //display level attempt
                    $tr.append($td);
                    
                    $td = $('<td></td>');
                    $td.html(data[i].numberQuestionsAnswered); //display number of questions answered
                    $tr.append($td);
                    
                    $td = $('<td></td>');
                    $td.html(data[i].numberCorrect); //display number correct
                    $tr.append($td);
                    
                    $td = $('<td></td>');
                    $td.html(data[i].numberIncorrect); //display number incorrect
                    $tr.append($td);
                    
                    $td = $('<td></td>');
                    $td.html(data[i].finalLevelScore); //display final score
                    $tr.append($td);
                    
                    $('#tblScorecard').append($tr);
                }
            }
        });
    });
</script>

<div class="container">
  <div class="row rules-row">
    <div class="col-md-12">
      <h2> Your Game Scorecard </h2>
    </div>
  </div>

  <div class="row rules-row">
      <div class="col-md-3 tutorial-col"></div>
    <div class="col-md-6 tutorial-col">
        <table id="tblScorecard">
            <tr>
                <th>Date/Time</th>
                <th>Level</th>
                <th># Attempts</th>
                <th>Questions<br />Answered</th>
                <th>Correct</th>
                <th>Incorrect</th>
                <th>Score</th>
            </tr>
        </table>
        <div class="col-md-3 tutorial-col">
    </div>

    
  </div>
</div>


<?php
	require("footer.php");
?>
