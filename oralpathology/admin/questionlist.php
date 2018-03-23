<?php
require("../classes/dbutils.php");
?>
<html>
<head>
    <title>Manage Questions</title>
    <link href="../css/admin.css" type="text/css" rel="stylesheet" />
</head>
<body>
<?php
    $sql = "SELECT questionID, diagnosisName, hint, numberOfImages, categoryName FROM questions  JOIN categories ON fk_categoryID = categoryID ORDER BY diagnosisName;"; //Get data from the questions and categories databases where IDs match
    $db = new DbUtilities;
	$questions = $db->getDataset($sql); //submit query
    echo("<table class='dataTable'");
    echo("<tr><th>&nbsp;</th><th>Diagnosis</th><th>Hint</th><th>Number of Images</th><th>Category</th><th>Details</th>");
    $cnt = 1;
    for($i = 0; $i < sizeof($questions); $i++){ //Display data
        echo("<tr>");
        echo("<td>" . $cnt . "</td>");
        echo("<td>" . $questions[$i]["diagnosisName"] . "</td>");
        echo("<td>" . $questions[$i]["hint"] . "</td>");
        echo("<td>" . $questions[$i]["numberOfImages"] . "</td>");
        echo("<td>" . $questions[$i]["categoryName"] . "</td>");
        echo("<td>[<a href='questiondetails.php?questionID=" . $questions[$i]["questionID"] . "' title='View question details'>details</a>]</td>");
        echo("</tr>");
        $cnt++;
    }
    echo("</table>");
?>    
</body>
</html>


