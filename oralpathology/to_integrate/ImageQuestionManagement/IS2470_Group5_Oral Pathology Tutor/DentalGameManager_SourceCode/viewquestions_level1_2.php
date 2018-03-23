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
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
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

        $level1_query = "SELECT questionID, diagnosisName, hint, numberOfImages FROM questions, questions_levels WHERE questions.questionID = questions_levels.fk_questionID and questions_levels.levelID = 1";
//        $level2_query = "SELECT diagnosisName, hint, numberOfImages FROM questions, questions_levels WHERE questions.questionID = questions_levels.fk_questionID and questions_levels.levelID = 2";
//        $level3_query = "SELECT diagnosisName, hint, numberOfImages FROM questions, questions_levels WHERE questions.questionID = questions_levels.fk_questionID and questions_levels.levelID = 3";

        $level1_query_execute = mysqli_query($conn1, $level1_query);
        $level1_count = mysqli_num_rows($level1_query_execute);
        if (!$level1_count) {
            echo "No questions in this level.";
        } else {
            /*
             * $level1_result[0] - questionID
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
                            <a data-toggle=\"modal\" data-target=\"#myModal\">Edit</a>
                            <div class=\"modal fade\" id=\"myModal\" role=\"dialog\">
                                 <div class=\"modal-dialog\">

                                    <!-- Modal content-->
                                    <div class=\"modal-content\">
                                        <div class=\"modal-header\">
                                            <button type=\"button\" class=\"close\" data-dismiss=\"modal\">&times;</button>
                                            <h4 class=\"modal-title\">Edit the question</h4>
                                        </div>
                                        <div class=\"modal-body\">
                                            <form id='editquestion' method='post' action='editquestions.php'>
                                               <input type='hidden' name='edit_qid' value='$level1_result[0]'>
                                               <p><label>Category</label></p>
                                               <p><select name='category'>
                                                  <option>Bone Lesions/ Tumors</option>
                                                    <option >Dental Anomalies</option>
                                                    <option >Odontogenic Cysts/Tumors</option>
                                                    <option >Soft Tissue Lesions/Tumors</option>
                                                    <option >Developmental Abnormalities</option>
                                                    <option >Radiology</option>
                                                    <option >Salivary</option>
                                                    <option >Syndromes</option>
                                                    <option >Benign Fibro-osseous Lesions</option>
                                                    <option >Other</option>
                                               </select></p>
                                               <p><label>Level</label></p>
                                               <p><select>
                                                   <option>Level 1</option>
                                                   <option>Level 2</option>
                                                   <option>Level 3</option>
                                               </select></p>
                                               <p><label>Diagnosis Name</label></p>
                                               <p><input type='text' value='$level1_result[1]'></p>
                                               <p><label>Hint</label></p>
                                               <p><textarea rows='4' cols='50' name='hint' form='editquestion'>$level1_result[2]</textarea></p>
                                                   <input type='submit' value='Save Change'>
                                            </form>
                                        </div>
                                    </div>

                                </div>
                            </div>
                      </td>
                      <td>
                          <form method='post' action='deactivequestions.php'>
                             <input type='hidden' name='deactive_qid' value='$level1_result[0]'>
                             <a href='deactivequestions.php' onclick=\"$(this).closest('form').submit()\">Deactive</a>
                          </form>
                      </td>
                      </tr>";
            }
            echo "</table>";
        }
        ?>
    </body>
</html>


