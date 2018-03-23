<!DOCTYPE html>
<html>
    <head>
        <title>Question Lists Version 2</title>
        <script type="text/javascript" src="http://www.francescomalagrino.com/BootstrapPageGenerator/3/js/jquery-2.0.0.min.js"></script>
        <script type="text/javascript" src="http://www.francescomalagrino.com/BootstrapPageGenerator/3/js/jquery-ui"></script>
        <link href="http://www.francescomalagrino.com/BootstrapPageGenerator/3/css/bootstrap-combined.min.css" rel="stylesheet" media="screen">
        <script type="text/javascript" src="http://www.francescomalagrino.com/BootstrapPageGenerator/3/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="container-fluid">
            <div class="row-fluid">
                <div class="span12">
                    <h3>Dental Game Question Lists
                        <p></p>
                        <a id="modal-44530" href="#modal-container-44530" role="button" class="btn" data-toggle="modal">Add a Question</a>
                        <div id="modal-container-44530" class="modal hide fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h3 id="myModalLabel">
                                    Manage New Question
                                </h3>
                            </div>
                            <div class="modal-body">
                                <p>
                                <form id="addquestionform" method="post" action="addquestiontodb.php">
                                    <fieldset>
                                        <legend>Add a Question</legend>

                                        <div>
                                            <label>Please Choose the Category</label>
                                            <p><select name="category">
                                                    <option value="1">Bone Lesions/ Tumors</option>
                                                    <option value="2">Dental Anomalies</option>
                                                    <option value="3">Odontogenic Cysts/Tumors</option>
                                                    <option value="4">Soft Tissue Lesions/Tumors</option>
                                                    <option value="6">Developmental Abnormalities</option>
                                                    <option value="7">Radiology</option>
                                                    <option value="8">Salivary</option>
                                                    <option value="9">Syndromes</option>
                                                    <option value="10">Benign Fibro-osseous Lesions</option>
                                                    <option value="5">Other</option>
                                                </select></p>
                                        </div>

                                        <div>
                                            <label>Please Choose the Level</label>
                                            <p><select name="level">
                                                    <option value="1">Level 1</option>
                                                    <option value="2">Level 2</option>
                                                    <option value="3">Level 3</option>
                                                </select></p>
                                        </div>
                                        <hr>
                                        <p><label>Diagnosis Name</label></p>
                                        <p><input type="text" name="diagname" required></p>
                                        <p><label>Hint</label></p>
                                        <textarea rows="4" cols="50" name="hint" form="addquestionform">Enter hints here...</textarea>
                                        <p><button class="btn btn-primary" type="submit">Save</button></p>
                                    </fieldset>
                                </form>
                                </p>
                            </div>
                            <div class="modal-footer">
                                <!--<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button> -->
                            </div>
                        </div>
                    </h3>
                    <p></p>
                    <div class="tabbable" id="tabs-435449">
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a href="#panel-278002" data-toggle="tab">Level 1</a>
                            </li>
                            <li>
                                <a href="#panel-97165" data-toggle="tab">Level 2</a>
                            </li>
                            <li>
                                <a href="#panel-97169" data-toggle="tab">Level 3</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="panel-278002">
                                <p>
                                    <?php
                                    require 'viewquestions_level1.php';
                                    ?>
                                </p>
                            </div>
                            <div class="tab-pane" id="panel-97165">
                                <p>
                                    <?php
                                    require 'viewquestions_level2.php';
                                    ?>
                                </p>
                            </div>
                            <div class="tab-pane" id="panel-97169">
                                <p>
                                    <?php
                                    require 'viewquestions_level3.php';
                                    ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <p align="center">@lajbrc</p>
                </div>
            </div>
        </div>
    </body>
</html>

