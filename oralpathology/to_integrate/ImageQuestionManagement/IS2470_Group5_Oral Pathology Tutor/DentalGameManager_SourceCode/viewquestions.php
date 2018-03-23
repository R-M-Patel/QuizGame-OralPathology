<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Question Manager</title>
        <style>
            table {
                font-family: arial, sans-serif;
                border-collapse: collapse;
                width: 100%;
            }

            td {
                border: 1px solid #ffffff;
                text-align: left;
                padding: 8px;
            }

            th {
                text-align: left;
                padding: 8px;
            }
            tr:nth-child(even) {
                background-color: #dddddd;
            }
        </style>
    </head>
    <body>
        <?php
        require_once 'functions.php';
        $conn1 = connectDB();

        $levelid = filter_input(INPUT_POST, "levelid");
        echo $levelid;
        $level_query = "SELECT diagnosisName, hint, numberOfImages FROM questions, questions_levels WHERE questions.questionID = questions_levels.fk_questionID and questions_levels.levelID = '$levelid'";
//        $level2_query = "SELECT diagnosisName, hint, numberOfImages FROM questions, questions_levels WHERE questions.questionID = questions_levels.fk_questionID and questions_levels.levelID = 2";
//        $level3_query = "SELECT diagnosisName, hint, numberOfImages FROM questions, questions_levels WHERE questions.questionID = questions_levels.fk_questionID and questions_levels.levelID = 3";

        $level_query_execute = mysqli_query($conn1, $level_query);
        $level_count = mysqli_num_rows($level_query_execute);
        if (!$level_count) {
            echo "No questions in this level.";
        } else {
            $level_results = mysqli_fetch_all($level_query_execute);
            echo "<table>
                  <tr>
                  <th>Diagnosis Name</th>
                  <th>Hint</th>
                  <th>Number of Images</th>
                  </tr>";
            foreach ($level_results as $level_result) {
                echo "<tr>
                      <td>$level_result[0]</td>
                      <td>$level_result[1]</td>
                      <td>$level_result[2]</td>
                      <td><a href=\"editquestions.php\">Edit</a></td>
                      <td><a href=\"deactivequestions.php\">Deactive</a></td>
                      </tr>";
            }
            echo "</table>";
        }
        ?>
    </body>
</html>


