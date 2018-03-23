<html>
<head>
<script type="text/javascript" src="http://www.francescomalagrino.com/BootstrapPageGenerator/3/js/jquery-2.0.0.min.js"></script>
<script type="text/javascript" src="http://www.francescomalagrino.com/BootstrapPageGenerator/3/js/jquery-ui"></script>
<link href="http://www.francescomalagrino.com/BootstrapPageGenerator/3/css/bootstrap-combined.min.css" rel="stylesheet" media="screen">
<script type="text/javascript" src="http://www.francescomalagrino.com/BootstrapPageGenerator/3/js/bootstrap.min.js"></script>
</head>
<body>
<?php

/*
 * ! If diagnosis name changes, the question id will change as well.
 * The question id is generated by MD5, question ID changes to make sure that new added question
 * may have the same diagnosis name with the diag name before edit
 */

/* To be implemented: 
 * 1. Image upload!
 * 2. If question ID changes, questions_images table should also be updated
 */

require_once 'functions.php';
$conn = connectDB();

//Values from form: category, level, diagname, hint
$categoryid = filter_input(INPUT_POST, "category");
$levelids = $_POST['level'];
$diagname = filter_input(INPUT_POST, "diagname");
$hint = filter_input(INPUT_POST, "hint");
//Using md5 to generate question id
$qid = filter_input(INPUT_POST, "qid");
$newqid = md5($diagname);


/* * Value passing test* */
//echo "categoryID: ".$categoryid."<br>";
//echo "level id: ".$levelid."<br>";
//echo "Diagnosis Name: ".$diagname."<br>";
//echo "hint: ".$hint."<br>";
//echo "question id:".$qid."<br>";
//echo $qid." ".$newqid;

//To check if the required fields are empty
if (!$categoryid || !$diagname) {
    alert("Please not leave required fields empty!");
    die();
}

//To check if the new diagnosis name has already exists
$findDiagName_query = mysqli_query($conn, "SELECT * FROM questions WHERE diagnosisName = '$diagname'");
$diagname_count = mysqli_num_rows($findDiagName_query);
if ($diagname_count && $newqid != $qid) {
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
    die();
}


//To update the table "questions"
$editquestion_query1 = "UPDATE questions SET questionID='$newqid', diagnosisName = '$diagname',fk_categoryID='$categoryid',hint='$hint' WHERE questionID='$qid'";
mysqli_query($conn, $editquestion_query1);


//To update the table "questions_levels" - delete origal level info and insert new level info if level info changes

//To get the original levels
$editquestion_get_original_levels_query = "SELECT levelID FROM questions_levels WHERE fk_questionID='$qid'";
$editquestion_get_original_levels = mysqli_query($conn, $editquestion_get_original_levels_query);
$original_levels = mysqli_fetch_all($editquestion_get_original_levels);
$store_original_levels = array();
foreach ($original_levels as $original_level) {
    $store_original_levels[] = $original_level[0];
}


//print_r($store_original_levels);


//if original levels  == modified levels, only need to update question id
if ($levelids == $store_original_levels) {
    $editquestion_query2 = "UPDATE questions_levels SET fk_questionID='$newqid' WHERE fk_questionID='$qid'";
    mysqli_query($conn, $editquestion_query2);
//    echo "same";
} else { //level id changed
    mysqli_query($conn, "DELETE FROM questions_levels WHERE fk_questionID='$qid'");
    foreach($levelids as $levelid) {
        mysqli_query($conn,"INSERT INTO questions_levels (fk_questionID, levelID) VALUES ('$newqid', '$levelid')");
    }
//    echo "diff";
}


//echo "Update successfully!";
echo "<div class='container-fluid'>
	<div class='row-fluid'>
		<div class='span12'>
			<div class='alert alert-success'>
				
				<h4>
					Succeed!
				</h4> <strong>Succeed!</strong> Update successfully!
			</div>
		</div>
	</div>
</div>";
echo "<div align='center'><a class=\"alert-link\" href=\"#\" role=\"button\" onclick=\"window.location.href='questions3.php'\">Back to Question List</a><div>";
//echo "<a class=\"alert-link\" href=\"#\" role=\"button\" onclick=\"window.location.href='questions.php'\">Add another question</a>";

?>
</body>
</html>