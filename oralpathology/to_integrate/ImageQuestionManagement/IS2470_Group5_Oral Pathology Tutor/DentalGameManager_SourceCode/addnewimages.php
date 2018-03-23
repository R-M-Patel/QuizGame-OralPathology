<?php
$upload_qid = filter_input(INPUT_POST, "image_qid");
session_start();
$SESSION['upload_question_id'] = $upload_qid;


echo"<!DOCTYPE html>
<html>
    <head>

    </head>
    <body>
        <p>Please select an image to upload: </p>
        <form id='uploadImage' action='addnewimagevalidate.php' method='post' enctype='multipart/form-data'>
            <input type='hidden' name ='upload_qid' value='$upload_qid'/>
            <input type='file' name='fileToUpload' id='fileToUpload'>
            <input type='submit' value='Save' name='submit'>
        </form>
    </body>
</html>";
        


