<?php
	require("classes/security.php");
	require("classes/dbutils.php");
	require("classes/question.php");

	$pageTitle = "Level 1 Tutorial";
	require("header.php");

	// $_SESSION["gameAttemptID"] = uniqid();

?>
<div class="container">
  <div class="row rules-row">
    <div class="col-md-12">
      <h2> Level 3 Rules </h2>
    </div>
  </div>

  <div class="row rules-row">
    <div class="col-md-12 tutorial-col">
        <div class="question-box rules">
	      <ul class="instructions">
	        <li>You will be asked to match the diagnosis to the appropriate image.   </br> </br></li>
	        <li>There will be 3 questions in this level.  </br> </br></li>
	        <li>If you match the images incorrectly, you will be kicked out of the level.  </br> </br></li>
	        <li>If you answer all 3 questions correctly, you will receive a bonus.</li>
	      </ul>
            <div style="text-align: right">
                <input type="button" class="imageSelector" value="Continue to Level 3" onclick="document.location.href='level3.php';">
            </div>
		</div>
    </div>

    
  </div>
</div>


<?php
	require("footer.php");
?>
