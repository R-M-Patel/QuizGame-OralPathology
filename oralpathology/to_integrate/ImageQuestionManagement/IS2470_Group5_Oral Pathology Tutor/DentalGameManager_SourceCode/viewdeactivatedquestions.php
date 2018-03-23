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

        $deactive_query = "SELECT questions.questionID, questions.diagnosisName, questions.hint, questions.numberOfImages, questions_levels.levelID "
                . "FROM questions, questions_levels "
                . "WHERE questions.questionID = questions_levels.fk_questionID and questions.activeStatus=false "
                . "ORDER BY questions_levels.levelID ASC";
//        $level2_query = "SELECT diagnosisName, hint, numberOfImages FROM questions, questions_levels WHERE questions.questionID = questions_levels.fk_questionID and questions_levels.levelID = 2";
//        $level3_query = "SELECT diagnosisName, hint, numberOfImages FROM questions, questions_levels WHERE questions.questionID = questions_levels.fk_questionID and questions_levels.levelID = 3";

        $deactive_query_execute = mysqli_query($conn1, $deactive_query);
        $deactive_count = mysqli_num_rows($deactive_query_execute);
        if (!$deactive_count) {
            echo "No deactivated questions.";
        } else {
            /* 
             * $deactive_result[0] - questionID
             * $deactive_result[1] - diagnosisName
             * $deactive_result[2] - hint
             * $deactive_result[3] - numberOfImages
             * $deactive_result[4] - levelID
             */
            $deactive_results = mysqli_fetch_all($deactive_query_execute);
            echo "$deactive_result[0]"." "."$deactive_result[1]"." "."$deactive_result[2]"." "."$deactive_result[3]"." "."$deactive_result[4]";
            echo "<table>
                  <tr>
                  <th>Diagnosis Name</th>
                  <th>Hint</th>
                  <th>Number of Images</th>
                  <th>Level</th>
                  </tr>";
            foreach ($deactive_results as $deactive_result) {
                echo "<tr>
                      <td>$deactive_result[1]</td>
                      <td>$deactive_result[2]</td>
                      <td>$deactive_result[3]</td>
                      <td>$deactive_result[4]</td>
                      <td>
                          <form method='post' action='activequestions.php'>
                             <input type='hidden' name='active_qid' value='$deactive_result[0]'>
                             <a href='activequestions.php' onclick=\"$(this).closest('form').submit()\">Activate</a>
                          </form>
                      </td>
                      </tr>";
            }
            echo "</table>";
        }
        ?>
    </body>
</html>
