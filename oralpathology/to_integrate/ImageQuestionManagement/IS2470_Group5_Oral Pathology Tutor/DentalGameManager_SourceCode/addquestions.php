<!DOCTYPE html>
<html>
    <head>
        <title>Add Questions</title>
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
                    <form id="addquestionform" method="post" action="addquestiontodb.php">
                        <fieldset>
                            <legend>Add a Question</legend>

                            <div>
                                <p>Please Choose the Category</p>
                                <p><select name="category">
                                        <?php
                                        require_once 'functions.php';
                                        $conn = connectDB();
                                        $get_category_count = mysqli_query($conn, "SELECT COUNT(*) FROM categories");
                                        $category_count_arr = mysqli_fetch_assoc($get_category_count);
                                        $category_count = $category_count_arr['COUNT(*)'];
                                        for ($i = 1; $i <= $category_count; $i++) {
                                            $select_category_query = "SELECT categoryName FROM categories WHERE categoryID = '$i'";
                                            $select_category = mysqli_query($conn, $select_category_query);
                                            $category_arr = mysqli_fetch_assoc($select_category);
                                            $category = $category_arr['categoryName'];
                                            echo "<option value='$i'>$category</option>";
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
<!--                                    <select name="level[]" multiple="multiple">
                                        <option value="1" selected="selected">Level 1</option>
                                        <option value="2">Level 2</option>
                                        <option value="3">Level 3</option>
                                    </select>-->
                                    <input type="checkbox" name="level[]" value="1" checked/>Level1
                                    <input type="checkbox" name="level[]" value="2" />Level2
                                    <input type="checkbox" name="level[]" value="3" />Level3
                                </p>
                            </div>
                            <hr>
                            <p><label>Diagnosis Name</label></p>
                            <p><input type="text" name="diagname" required></p>
                            <p><label>Hint</label></p>
                            <textarea rows="4" cols="50" name="hint" form="addquestionform">Enter hints here...</textarea>
                            <p><button class="btn btn-primary" type="submit">Save</button></p>
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