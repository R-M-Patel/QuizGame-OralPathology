<!DOCTYPE html>
<html>
    <head>
        <title>Question Lists Version 3</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdn.static.runoob.com/libs/bootstrap/3.3.7/css/bootstrap.min.css">  
        <script src="https://cdn.static.runoob.com/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="https://cdn.static.runoob.com/libs/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link href="css/questionstyle.css" rel="stylesheet">
        <script type="text/javascript" src="http://www.francescomalagrino.com/BootstrapPageGenerator/3/js/jquery-2.0.0.min.js"></script>
        <script type="text/javascript" src="http://www.francescomalagrino.com/BootstrapPageGenerator/3/js/jquery-ui"></script>
        <link href="http://www.francescomalagrino.com/BootstrapPageGenerator/3/css/bootstrap-combined.min.css" rel="stylesheet" media="screen">
        <script type="text/javascript" src="http://www.francescomalagrino.com/BootstrapPageGenerator/3/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
    
    <body>
        <div class="container">
            <div class="row clearfix">
                <div class="col-md-12 column">
                    <h3>Dental Game Question Lists <i class="fa fa-info-circle" style="font-size:24px" onclick="window.location.href='userinstruction.html'"></i></h3>
                    <form class = "addquestion" action="addquestions.php">
                        <button class="addquestion_btn" type="submit">Add a new question</button>
                    </form>
                    
                    <!--<a class="alert-link" href="#" role="button" onclick="window.location.href='sortquestionlist.php'">Sort</a>-->
                    
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
                            <li>
                                <a href="#panel-97160" data-toggle="tab">Deactivated Questions</a>
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
                            <div class="tab-pane" id="panel-97160">
                                <p>
                                    <?php
                                    require 'viewdeactivatedquestions.php';
                                    ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <hr>
                </div>
            </div>
        </div>


    </body>
</html>
