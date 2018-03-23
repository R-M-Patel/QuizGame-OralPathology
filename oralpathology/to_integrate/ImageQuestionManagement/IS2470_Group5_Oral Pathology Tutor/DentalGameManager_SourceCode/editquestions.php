<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//!!!
//One question may belong to several levels

/* Attributes that can be edited:
 * @Diagnosis Name - tabel questions
 * @Categories - ?
 *             table questions & categories
 * @Levels - a question can belong to multiple levels - using radio buttons that support multiple choice
 *         - table question_levels
 * @Hint - table questions
 */
//echo "hello" . "<br>";

$edit_qid = filter_input(INPUT_POST, "edit_qid");
//echo $edit_qid . "<br>";

require_once 'functions.php';
$conn = connectDB();

//To get the category id of the question
$get_category_id_query = "SELECT fk_categoryID FROM questions WHERE questionID = '$edit_qid'";
$get_category_id = mysqli_query($conn, $get_category_id_query);
$get_category_id_arr = mysqli_fetch_assoc($get_category_id);
$category_id = $get_category_id_arr['fk_categoryID'];
//echo $category_id . "<br>";

//To get the category name of the question
$get_category_name_query = "SELECT categoryName FROM categories WHERE categoryID = $category_id";
$get_category_name = mysqli_query($conn, $get_category_name_query);
$get_category_name_arr = mysqli_fetch_assoc($get_category_name);
$category_name = $get_category_name_arr['categoryName'];
//echo $category_name . "<br>";

//To get the diagnosis name and hint of the question
$get_question_info_query = "SELECT diagnosisName, hint FROM questions WHERE questionID = '$edit_qid'";
$get_question_info = mysqli_query($conn, $get_question_info_query);
$get_question_info_arr = mysqli_fetch_assoc($get_question_info);
$diag_name = $get_question_info_arr['diagnosisName'];
$question_hint = $get_question_info_arr['hint'];
//echo $diag_name . "<br>";
//echo $question_hint . "<br>";

//To get the level id of the selected question
$get_level_id_query = "SELCT levelID FROM questions_levels WHERE fk_questionID = '$edit_qid'";
$get_level_id = mysqli_query($conn, $get_level_id_query);
$levels_num = mysqli_num_rows($get_level_id);
$get_level_id_arr = mysqli_fetch_assoc($get_level_id);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Edit Questions</title>
        <link href="css/addquestions-style.css" rel="stylesheet" media="screen">
    </head>
    <body>
        <div class="container-fluid">
            <div class="row-fluid">
                <div class="span12">
                    <!--category, level, diagname, hint-->
                    <div align="right">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="window.location.href = 'questions3.php'">×</button>
                    </div>
                    <form id="addquestionform" method="post" action="editquestiontodb.php">
                        <fieldset>
                            <legend>Edit a Question</legend>

                            <div>
                                <p>Please Choose the Category</p>
                                <p><select name="category">
                                        <?php
//                                        require_once 'functions.php';
//                                        $conn1 = connectDB();
                                        $get_category_count = mysqli_query($conn, "SELECT COUNT(*) FROM categories");
                                        $category_count_arr = mysqli_fetch_assoc($get_category_count);
                                        $category_count = $category_count_arr['COUNT(*)'];
                                        for ($i = 1; $i <= $category_count; $i++) {
                                            $select_category_query = "SELECT categoryName FROM categories WHERE categoryID = '$i'";
                                            $select_category = mysqli_query($conn, $select_category_query);
                                            $category_arr = mysqli_fetch_assoc($select_category);
                                            $category = $category_arr['categoryName'];
                                            if ($category_name == $category) {
                                                echo "<option value='$i' selected='selected'>$category</option>";
                                            } else {
                                                echo "<option value='$i'>$category</option>";
                                            }
                                        }
                                        ?>
                                        <!--                                        <option value="1">Bone Lesions/ Tumors</option>
                                                                                <option value="2">Dental Anomalies</option>
                                                                                <option value="3">Odontogenic Cysts/Tumors</option>
                                                                                <option value="4">Soft Tissue Lesions/Tumors</option>
                                                                                <option value="6">Developmental Abnormalities</option>
                                                                                <option value="7">Radiology</option>
                                                                                <option value="8">Salivary</option>
                                                                                <option value="9">Syndromes</option>
                                                                                <option value="10">Benign Fibro-osseous Lesions</option>
                                                                                <option value="5">Other</option>-->
                                    </select></p>
                            </div>

                            <div>
                                <p>Please Choose the Level</p>
                                <p>
<!--                                    <select name="level">
                                        <option value="1" selected="selected">Level 1</option>
                                        <option value="2">Level 2</option>
                                        <option value="3">Level 3</option>
                                    </select>-->
                                    <?php
                                    $get_levels = mysqli_query($conn, "SELECT levelID FROM questions_levels WHERE fk_questionID='$edit_qid'");
                                    $levels = mysqli_fetch_all($get_levels);
                                    $levelids = array(1, 1, 1); //means that initially all levels are unckecked
                                    foreach ($levels as $level) { //set the value of checked level as 0
                                        $levelids[$level[0] - 1] = 0;
                                    }
                                    for ($i = 1; $i <= 3; $i++) {
                                        if ($levelids[$i - 1] == 0) {
                                            echo "<input type='checkbox' name='level[]' value='$i' checked/>Level" . $i;
                                        } else {
                                            echo "<input type='checkbox' name='level[]' value='$i' />Level" . $i;
                                        }
                                    }
                                    ?>
                                </p>
                            </div>
                            <hr>
                            <?php
                            echo "<p><label>Diagnosis Name</label></p>
                            <p><input type=\"text\" name=\"diagname\" value=\"$diag_name\" required></p>
                            <p><label>Hint</label></p>
                            <textarea rows=\"4\" cols=\"50\" name=\"hint\" form=\"addquestionform\">$question_hint</textarea>
                            <p><button class=\"btn btn-primary\" type=\"submit\">Save</button></p>
                            <input type='hidden' name='qid' value='$edit_qid'/>"
                            ?>
                        </fieldset>
                    </form>
                    <!--<form action="uploadimage.php" method="post" enctype="multipart/form-data">
                            <p>Select image to upload:</p>
                            <input type="file" name="fileToUpload" id="fileToUpload">
                            <input type="submit" value="Upload Image" name="submit">
                        </form>-->
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>