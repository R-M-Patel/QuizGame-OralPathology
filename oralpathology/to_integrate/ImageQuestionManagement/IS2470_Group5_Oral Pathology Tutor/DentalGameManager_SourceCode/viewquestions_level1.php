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

        $level1_query = "SELECT questionID, diagnosisName, hint, numberOfImages FROM questions, questions_levels WHERE questions.questionID = questions_levels.fk_questionID and questions_levels.levelID = 1 and questions.activeStatus=1";
//        $level2_query = "SELECT diagnosisName, hint, numberOfImages FROM questions, questions_levels WHERE questions.questionID = questions_levels.fk_questionID and questions_levels.levelID = 2";
//        $level3_query = "SELECT diagnosisName, hint, numberOfImages FROM questions, questions_levels WHERE questions.questionID = questions_levels.fk_questionID and questions_levels.levelID = 3";

        $level1_query_execute = mysqli_query($conn1, $level1_query);
        $level1_count = mysqli_num_rows($level1_query_execute);
        if (!$level1_count) {
            echo "No questions in this level.";
        } else {
            /* $level1_result[0] - questionID
             * $level1_result[1] - diagnosisName
             * $level1_result[2] - hint
             * $level1_result[3] - numberOfImages
             */
            $level1_results = mysqli_fetch_all($level1_query_execute);
            echo "<table>
                  <tr>
                  <th>Diagnosis Name</th>
                  <th>Hint</th>
                  <th>Number of Images</th>
                  </tr>";
            foreach ($level1_results as $level1_result) {
                echo "<tr>
                      <td>$level1_result[1]</td>
                      <td>$level1_result[2]</td>
                      <td>$level1_result[3]</td>
                      <td>
                          <form method='post' action='editquestions.php'>
                             <input type='hidden' name='edit_qid' value='$level1_result[0]'>
                             <a href='editquestions.php' onclick=\"$(this).closest('form').submit()\">Edit</a>
                          </form>
                      </td>
                      <td>
                          <form method='post' action='addnewimages.php'>
                             <input type='hidden' name='image_qid' value='$level1_result[0]'>
                             <a href='addnewimages.php' onclick=\"$(this).closest('form').submit()\">Upload Images</a>
                          </form>
                      </td>
                      <td>
                          <form method='post' action='deactivequestions.php'>
                             <input type='hidden' name='deactive_qid' value='$level1_result[0]'>
                             <a href='deactivequestions.php' onclick=\"$(this).closest('form').submit()\">Deactivate</a>
                          </form>
                      </td>
                      </tr>";
            }
            echo "</table>";
        }
        ?>
    </body>
</html>
