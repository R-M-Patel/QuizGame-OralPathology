<!DOCTYPE html>
<html>
    <head>
        <style>
            uploadimage {
                padding: 10px
            }
        </style>
    </head>
    <body>
        <div class="uploadimage">
        <p>Please select an image to upload: </p>
        <form id="uploadImage" action="uploadimagevalidate.php" method="post" enctype="multipart/form-data">
            <input type="file" name="fileToUpload" id="fileToUpload">
            <input type="submit" value="Save" name="submit">
        </form>
        </div>
    </body>
</html>
