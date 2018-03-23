<html>
<head>
<script type="text/javascript" src="http://www.francescomalagrino.com/BootstrapPageGenerator/3/js/jquery-2.0.0.min.js"></script>
<script type="text/javascript" src="http://www.francescomalagrino.com/BootstrapPageGenerator/3/js/jquery-ui"></script>
<link href="http://www.francescomalagrino.com/BootstrapPageGenerator/3/css/bootstrap-combined.min.css" rel="stylesheet" media="screen">
<script type="text/javascript" src="http://www.francescomalagrino.com/BootstrapPageGenerator/3/js/bootstrap.min.js"></script>
<style>
            a.alert-link {
                padding: 0px 10px;
                word-wrap: normal;
                display: inline-block;
            }
        </style>
</head>
<body>
<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'functions.php';
$conn = connectDB();

//Values from form: category, level, diagname, hint
$categoryid = filter_input(INPUT_POST, "category");
$levelids = $_POST['level'];
$diagname = filter_input(INPUT_POST, "diagname");
$hint = filter_input(INPUT_POST, "hint");
//Using md5 to generate question id
$qid = md5($diagname);

//foreach ($levelids as $le) {
//    echo $le;
//}

session_start();
$_SESSION['add_question_id'] = $qid;

/* * Value passing test* */
//echo "categoryID: ".$categoryid."<br>";
//echo "level id: ".$levelid."<br>";
//echo "Diagnosis Name: ".$diagname."<br>";
//echo "hint: ".$hint."<br>";
//echo "question id:".$qid."<br>";

//To check if the required fields are empty
if (!$categoryid || !$levelids || !$diagname) {
    alert("Please not leave required fields empty!");
    die();
}

//To check if the diagnosis name has already exists
$findDiagName_query = mysqli_query($conn, "SELECT * FROM questions WHERE diagnosisName = '$diagname'");
$diagname_count = mysqli_num_rows($findDiagName_query);
if ($diagname_count) {
//    echo "Diagnosis Name already exists!";
    echo "<div class='container-fluid'>
	<div class='row-fluid'>
		<div class='span12'>
			<div class='alert'>
				 <button type='button' class='close' data-dismiss='alert'>×</button>
				<h4>
					Warning!
				</h4> <strong>Warning!</strong> Diagnosis Name already exists!
			</div>
		</div>
	</div>
</div>";
         echo "<div align='center'><a class=\"alert-link\" href=\"#\" role=\"button\" onclick=\"window.location.href='questions3.php'\">Back to Question List</a>";
        echo "<a class=\"alert-link\" href=\"#\" role=\"button\" onclick=\"window.location.href='addquestions.php'\">    Add another question</a></div>";
    die();
}

//To update the table "questions"
$addquestion_query1 = "
INSERT INTO questions (questionID, diagnosisName, fk_categoryID, hint, numberOfImages) VALUES ('$qid', '$diagname', '$categoryid', '$hint', '0')";
mysqli_query($conn, $addquestion_query1);

//To update the table "questions_levels"
if(isset($levelids) && is_array($levelids)) {
    foreach ($levelids as $levelid) {
        $addquestion_query2 = "INSERT INTO questions_levels (fk_questionID, levelID) VALUES ('$qid', '$levelid')";
        mysqli_query($conn, $addquestion_query2);
    }
}

//echo "Question successfully added!"."<br>";
echo "<div class='container-fluid'>
	<div class='row-fluid'>
		<div class='span12'>
			<div class='alert alert-success'>
				 
				<h4>
					Succeed!
				</h4> <strong>Succeed!</strong> Question successfully added!
			</div>
		</div>
	</div>
</div>";
//echo "Please select images to upload"."<br>";
//echo "<a class=\"alert-link\" href=\"#\" role=\"button\" onclick=\"window.location.href='questions3.php'\">    Back to Question List</a><br>";
//echo "<a class=\"alert-link\" href=\"#\" role=\"button\" onclick=\"window.location.href='addquestions.php'\">    Add another question</a>";
require 'uploadimage.php';


/* To be implemented: 
 * 1. "Add another question" & "Back to question lists" ok --> improve UI
 * 2. Add category/level to the list
 * 3. Upload image file in question lists page
 */
?>
</body>
</html>