
<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//Create new attribute "activeStatus" in table "questions", set the default value is true
//ALTER TABLE `questions` ADD `activeStatus` BOOLEAN NOT NULL DEFAULT TRUE AFTER `actveStatus`;

$deactive_qid = filter_input(INPUT_POST, "deactive_qid");
//echo "$deactive_qid";

require_once 'functions.php';
$conn = connectDB();

$deact_query = "UPDATE questions SET activeStatus=0 WHERE questionID = '$deactive_qid'";
mysqli_query($conn, $deact_query);

echo "Save successfully!";
require 'questions3.php';
