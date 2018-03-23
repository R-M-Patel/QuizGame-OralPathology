<html>
    <head>
        <script type="text/javascript" src="http://www.francescomalagrino.com/BootstrapPageGenerator/3/js/jquery-2.0.0.min.js"></script>
        <script type="text/javascript" src="http://www.francescomalagrino.com/BootstrapPageGenerator/3/js/jquery-ui"></script>
        <link href="http://www.francescomalagrino.com/BootstrapPageGenerator/3/css/bootstrap-combined.min.css" rel="stylesheet" media="screen">
        <script type="text/javascript" src="http://www.francescomalagrino.com/BootstrapPageGenerator/3/js/bootstrap.min.js"></script>
        <style>
            a.alert-link {
                padding: 0px 10px;
                word-wrap: normal;
                display: inline-block;
            }
        </style>
    </head>
    <body>
        <?php
        /*
         * To change this license header, choose License Headers in Project Properties.
         * To change this template file, choose Tools | Templates
         * and open the template in the editor.
         */

        $target_dir = "dentalimages/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

        session_start();
        $qid = $_SESSION['add_question_id'];
//        echo $qid;

// Check if image file is an actual image or fake image
        if (isset($_POST["submit"])) {
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if ($check !== false) {
//                echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
//        echo "File is not an image.";
                echo "<div class='container-fluid'>
	<div class='row-fluid'>
		<div class='span12'>
			<div class='alert'>
				 <button type='button' class='close' data-dismiss='alert'>×</button>
				<h4>
					Warning!
				</h4> <strong>Warning!</strong> File is not an imgae!
			</div>
		</div>
	</div>
</div>";
                $uploadOk = 0;
            }
        }
// Check if file already exists
        if (file_exists($target_file)) {
//    echo "Sorry, file already exists.";
            echo "<div class='container-fluid'>
	<div class='row-fluid'>
		<div class='span12'>
			<div class='alert'>
				 <button type='button' class='close' data-dismiss='alert'>×</button>
				<h4>
					Warning!
				</h4> <strong>Warning!</strong> Sorry, file already exists!
			</div>
		</div>
	</div>
</div>";
            $uploadOk = 0;
        }
// Check file size
        if ($_FILES["fileToUpload"]["size"] > 500000) {
//            echo "Sorry, your file is too large.";
            echo "<div class='container-fluid'>
	<div class='row-fluid'>
		<div class='span12'>
			<div class='alert'>
				 <button type='button' class='close' data-dismiss='alert'>×</button>
				<h4>
					Warning!
				</h4> <strong>Warning!</strong> Sorry, your file is too large!
			</div>
		</div>
	</div>
</div>";
            $uploadOk = 0;
        }
// Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" && $imageFileType != "JPG" && $imageFileType != "PNG" && $imageFileType != "JPEG" && $imageFileType != "GIF") {
//            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            echo "<div class='container-fluid'>
	<div class='row-fluid'>
		<div class='span12'>
			<div class='alert'>
				 <button type='button' class='close' data-dismiss='alert'>×</button>
				<h4>
					Warning!
				</h4> <strong>Warning!</strong> Sorry, only JPG, JPEG, PNG & GIF files are allowed!
			</div>
		</div>
	</div>
</div>";
            $uploadOk = 0;
        }
// Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
//            echo "Sorry, your file was not uploaded.";
            echo "<div class='container-fluid'>
	<div class='row-fluid'>
		<div class='span12'>
			<div class='alert'>
				 <button type='button' class='close' data-dismiss='alert'>×</button>
				<h4>
					Warning!
				</h4> <strong>Warning!</strong> Sorry, your file was not uploaded!
			</div>
		</div>
	</div>
</div>";

// if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                //If image uploaded successfully
                //Update table 'questions' - numOfImage ++
                //Insert new tuple into table 'questions_images', $qid $imageID
                $imageID = md5($_FILES["fileToUpload"]["name"]);
                require_once 'functions.php';
                $conn = connectDB();

                //Insert into questions_images
                $insert_image_query = "INSERT INTO questions_images (fk_questionID, fk_imageID) VALUES ('$qid', '$imageID')";
                mysqli_query($conn, $insert_image_query);
//                echo "insert done" . "<br>";

                //Update num of images in questions
                $update_image_num_query = "UPDATE questions SET numberOfImages = numberOfImages + 1 WHERE questionID = '$qid'";
                mysqli_query($conn, $update_image_num_query);
//                echo "update done" . "<br>";

//                echo "The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.";
                echo "<div class='container-fluid'>
	<div class='row-fluid'>
		<div class='span12'>
			<div class='alert alert-success'>
				 
				<h4>
					Succeed!
				</h4> <strong>Succeed!</strong> The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.
			</div>
		</div>
	</div>
</div>";
            } else {
//                echo "Sorry, there was an error uploading your file.";
                echo "<div class='container-fluid'>
	<div class='row-fluid'>
		<div class='span12'>
			<div class='alert'>
				 <button type='button' class='close' data-dismiss='alert'>×</button>
				<h4>
					Warning!
				</h4> <strong>Warning!</strong> Sorry, file already exists!
			</div>
		</div>
	</div>
</div>";
            }
        }

        echo "<div align='center'><a class=\"alert-link\" href=\"#\" role=\"button\" onclick=\"window.location.href='questions3.php'\">Back to Question List</a>";
        echo "<a class=\"alert-link\" href=\"#\" role=\"button\" onclick=\"window.location.href='uploadimage.php'\">Add another image</a></div>";
        ?>

    </body>
</html>