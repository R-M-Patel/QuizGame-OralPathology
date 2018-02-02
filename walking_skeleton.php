<!--This walking skeleton's purpose is to make sure each member's machine can run the following-->
<!--HTML and CSS (View), Javascript (Controller), PHP and MySQL (model)-->
<!--Code is very basic and not completely indicative of final product-->

<!DOCTYPE html>
<html>
<head>

<!--Random style choices to make sure machines recognize css -->
<style>
body {background-color: yellow;}
h1 {font-size: 250%;}
p{font-size: 150%;}
</style>

<!--Checks each of the correct answers and adds the total, displaying it to user. Makes sure Javascript can run on machine.-->
<script>
function grade_answers(){
	var num_correct, num_total, final_grade;
	
	num_correct = 0; //Number user got correct
	num_total = 3; //Number of questions total
	
	if(document.getElementById('Acetaminophen').checked){ //Checks if Question 1 was answered correctly
		num_correct++;
	}
	
	if(document.getElementById('Xanax').checked){ //Checks if Question 2 was answered correctly
		num_correct++;
	}
	
	if(document.getElementById('Albuterol').checked){ //Checks if Question 3 was answered correctly
		num_correct++;
	}
	
	final_grade = "You got " + num_correct + " out of " + num_total + " correct!"; //Creates a string saying how many the user got right
	window.alert(final_grade); //Displays grade to user
}
</script>
</head>
<body>

<h1>PHARMGENIUS (Pre-Alpha)</h1>

<!--Form for sample questions. Radio button checkboxes used to record user's answer. Just to make sure HTML works on machine-->
<form>
	<p>Question 1</p><br>
	Which of the following is not an NSAID?<br>
	<input type = "radio" name = "q1_answer" id="Celexocib">Celexocib
	<input type = "radio" name = "q1_answer" id="Ibuprofen">Ibuprofen
	<input type = "radio" name = "q1_answer" id="Naproxen">Naproxen
	<input type = "radio" name = "q1_answer" id="Acetaminophen">Acetaminophen

	<br><br><br>
	<p>Question 2</p><br>
	What is the brand name of alphrazolam?<br>
	<input type = "radio" name = "q2_answer" id="Vicodin">Vicodin
	<input type = "radio" name = "q2_answer" id="Xanax">Xanax
	<input type = "radio" name = "q2_answer" id="Ativan">Ativan
	<input type = "radio" name = "q2_answer" id="Zolpidem">Zolpidem
	<br><br><br>
	<p>Question 3</p><br>
	Which of the following is a rescue inhaler?<br>
	<input type = "radio" name = "q3_answer" id="Spiriva">Spiriva
	<input type = "radio" name = "q3_answer" id="Flonase">Flonase
	<input type = "radio" name = "q3_answer" id="Albuterol">Albuterol
	<input type = "radio" name = "q3_answer" id="Advair">Advair
	<br><br><br>

<button type = "button" onclick ="grade_answers()">Submit Answers</button>
</form>
<br><br><br>


<?php
//Uses PHP to create a MySQL database. Makes sure that machine can run both PHP and MySQL
//Only creates database and table. Does not input any data
$servername = "localhost"; //Server Name
$username = "username"; //Username for MySQL database
$password= "password"; //Password for MySQL database
$dbName = "testDB"; //Database name

$connection = mysqli_connect($servername, $username, $password, $dbName);

if(!$connection){ //Checks if database cannot be connected too
	die("Failed Connection: " . mysqli_connect_error());
}

//Uncheck line below if no database is created yet
//$sql = "CREATE DATABASE testDB";


//Creates first table in database "testDB"
$sql = "CREATE TABLE students (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(30) NOT NULL,
score INT(6) NOT NULL
)";

//Checks if table was created successfully
if($connection->query($sql) === TRUE){
	echo "Table created successfully";
}
else{
	echo "Error creating table: " . $connection->error;
}
//Close connection to MySQL
$connection->close();

?>
</body>
</html>