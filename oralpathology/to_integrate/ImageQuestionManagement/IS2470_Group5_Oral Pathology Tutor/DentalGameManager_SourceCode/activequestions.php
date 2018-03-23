<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$active_qid = filter_input(INPUT_POST, "active_qid");
echo "$active_qid";

require_once 'functions.php';
$conn = connectDB();

$active_query = "UPDATE questions SET activeStatus=1 WHERE questionID = '$active_qid'";
mysqli_query($conn, $active_query);

echo "Save successfully!";
require 'questions3.php';

