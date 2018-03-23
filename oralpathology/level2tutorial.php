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
      <h2> Level 2 Rules </h2>
    </div>
  </div>

  <div class="row rules-row">
    <div class="col-md-12 tutorial-col">
        <div class="question-box rules">
	      <ul class="instructions">
	        <li>You will be asked to click on all the images that match the diagnosis. </br> </br></li>
	        <li>There will be 4 questions in this level.  </br> </br></li>
	        <li>There are 1-4 correct answers to each question.  </br> </br></li>
	        <li>If you choose 2 incorrect images, it will bring up a new question. </br> </br> </li>
	        <li>After 1 failed question, you will be kicked out of the level.  </br> </br></li>
	        <li>If you answer 3 out of 4 questions correctly, you will receive a bonus.</li>
	      </ul>
            <div style="text-align: right">
                <input type="button" class="imageSelector" value="Continue to Level 2" onclick="document.location.href='level2.php';">
            </div>
		</div>
    </div>

    
  </div>
</div>


<?php
	require("footer.php");
?>
