<?php
	require("classes/security.php");
	require("classes/dbutils.php");
	require("classes/question.php");

	$pageTitle = "Level 1 Tutorial";
	require("header.php");

	$_SESSION["gameAttemptID"] = uniqid();

?>
<div class="container">
  <div class="row rules-row">
    <div class="col-md-12">
      <h2> Level 1 Rules </h2>
    </div>
  </div>

  <div class="row rules-row">
    <div class="col-md-12 tutorial-col">
        <div class="question-box rules">
	      <ul class="instructions">
	        <li>You will be asked to match the diagnosis to an image. </br> </br></li>
	        <li>There will be 5 questions in this level.  </br> </br></li>
	        <li>There is only one correct answer to each question. </br> </br></li>
	        <li>If you choose 1 incorrect image, it will bring up a new question.  </br> </br></li>
	        <li>After 2 failed questions, you will be kicked out of the level. </br> </br></li>
	        <li>If you answer all 5 questions correctly, you will receive a bonus.</li>
	      </ul>
            <div style="text-align: right">
                <input type="button" class="imageSelector" value="Continue to Level 1" onclick="document.location.href='level1.php';">
            </div>
		</div>
    </div>

    
  </div>
</div>


<?php
	require("footer.php");
?>
