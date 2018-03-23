<?php
	require("classes/security.php");
	require("classes/dbutils.php");
	require("classes/question.php");

	$pageTitle = "Quiz Scorecard";
	require("header.php");
    $drupalUserID = $_SESSION["drupalUserID"];

?>
<script language="javascript" type="text/javascript">
    var drupalUserID = '<?php echo $drupalUserID; ?>';
    
    $(document).ready(function(){
        
        var uri = "rest/quizscorecard_ws.php?userID=" + drupalUserID; //append user id to url
        console.log(uri);
        $.getJSON(uri, function(data){
            console.log(data);
            if(data){ //if data exists
                for(var i = 0; i<data.length; i++){
                    $tr = $('<tr></tr>');
                    
                    $td = $('<td></td>');
                    $td.html(data[i].answerDate); //display date answered
                    $tr.append($td);
                    
                    $td = $('<td></td>');
                    if(data[i].isCorrect == "1"){ //if item is correct
                        $td.html("Correct");    
                    }
                    else{
                        $td.html("Incorrect");
                    }
                    
                    $tr.append($td);
                    
                    $td = $('<td></td>');
                    $td.html(data[i].answerCount);
                    $tr.append($td);
                    
                    
                    
                    
                    
                    $('#tblScorecard').append($tr); //append score card to page
                }
            }
        });
    });
</script>

<div class="container">
  <div class="row rules-row">
    <div class="col-md-12">
      <h2> Your Quiz Scorecard </h2>
    </div>
  </div>

  <div class="row rules-row">
      <div class="col-md-3 tutorial-col"></div>
    <div class="col-md-6 tutorial-col">
        <table id="tblScorecard">
            <tr>
                <th>Date</th>
                <th>Is Correct?</th>
                <th>Count</th>
            </tr>
        </table>
        <div class="col-md-3 tutorial-col">
    </div>

    
  </div>
</div>


<?php
	require("footer.php");
?>
