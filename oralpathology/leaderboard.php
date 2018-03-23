<?php
	require("classes/security.php");
	require("classes/dbutils.php");
	require("classes/question.php");

	$pageTitle = "Hall of Fame";
	require("header.php");
    $drupalUserID = $_SESSION["drupalUserID"];

?>
<script language="javascript" type="text/javascript">

	/* display leaderboard */
    var drupalUserID = '<?php echo $drupalUserID; ?>';
    
    $(document).ready(function(){
        
        var uri = "rest/leaderboard_ws.php?userID=" + drupalUserID; //append user id to url
        $.getJSON(uri, function(data){ //json the leaderboard data
            if(data){ //if data exists
                var overallHighestScoreList = data.overall; 
                for(var i = 0; i<overallHighestScoreList.length; i++){ //iterate through scores and display them
                    $tr = $('<tr></tr>');
                    $td = $('<td></td>');
                    $img = $('<img>');
                    $img.attr({
                        "id" : "avatar_thumb_" + i,
                        "src" : "images/anonymous.gif"
                    });
                    
                    $img.css({
                        "width" : "40px",
                        "border-radius" : "5px"
                    });
                    
                    $td.append($img);
                    $tr.append($td);
                    
                    $td = $('<td></td>');
                    $td.html("Anonymous");
                    $tr.append($td);
                    
                    $td = $('<td></td>');
                    $td.html(overallHighestScoreList[i].maxOverallScore);
                    $tr.append($td);
                    
                    // maxOverallScore
                    
                    $('#tblHallOfFame').append($tr);
                    
                }
                // $('#highestScore').html("Highest Score: " + overallHighestScore);
                console.log(overallHighestScoreList);
                
            }
        });
    });
</script>

<div class="container">
  <div class="row rules-row">
    <div class="col-md-12">
      <h2> Hall of Fame </h2>
    </div>
  </div>

  <div class="row rules-row">
      <div class="col-md-4 tutorial-col"></div>
      <div class="col-md-4 tutorial-col">
            <div id="highestScore">
                <table id="tblHallOfFame"></table>
            </div>
        </div>
      <div class="col-md-4 tutorial-col"></div>
    
  </div>
</div>


<?php
	require("footer.php");
?>
