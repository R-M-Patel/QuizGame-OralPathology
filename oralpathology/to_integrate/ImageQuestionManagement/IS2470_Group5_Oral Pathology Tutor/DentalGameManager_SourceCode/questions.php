<!DOCTYPE html>
<html>
    <head>
        <title>Question Lists Version 1</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdn.static.runoob.com/libs/bootstrap/3.3.7/css/bootstrap.min.css">  
        <script src="https://cdn.static.runoob.com/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="https://cdn.static.runoob.com/libs/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link href="css/questionstyle.css" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            <div class="row clearfix">
                <div class="col-md-12 column">
                    <h3>Dental Game Question Lists</h3>
                    <form class = "addquestion" action="addquestions.php">
                        <button class="addquestion_btn" type="submit">Add a new question</button>
                    </form>
                    <div class="panel-group" id="panel-993148">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <a class="panel-title collapsed" data-toggle="collapse" data-parent="#panel-993148" href="#panel-element-796773">Level 1</a>
                            </div>
                            <div id="panel-element-796773" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <?php
                                    require 'viewquestions_level1_2.php';
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <a class="panel-title collapsed" data-toggle="collapse" data-parent="#panel-993148" href="#panel-element-425632">Level 2</a>
                            </div>
                            <div id="panel-element-425632" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <?php
                                    require 'viewquestions_level2.php';
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <a class="panel-title collapsed" data-toggle="collapse" data-parent="#panel-993148" href="#panel-element-22222">Level 3</a>
                            </div>
                            <div id="panel-element-22222" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <?php
                                    require 'viewquestions_level3.php';
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                </div>
            </div>
        </div>


    </body>
</html>
