<?php
if( isset($_POST["levelAccess"]) ) //If level access is already set
{
    $levelAccess = $_POST["levelAccess"];
    $userID = $_POST["userID"];
    $attemptID = $_POST["attemptID"];
    require("../classes/dbutils.php");
} else { //set default access
    $userID = $_SESSION["drupalUserID"];
    $attemptID = $_SESSION["gameAttemptID"];
    $levelAccess = "level1.php";
}

// echo("userID: " . $userID . "\n");
// echo("attemptID: " . $attemptID);
// echo("levelAccess: " . $levelAccess . "\n");

$sql = "INSERT INTO pageaccess (userID,attemptID,levelAccess,accessDateTime) "; //insert user id, attempt id, allowed access, and datetime to database
$sql .= "VALUES (?,?,?, NOW());";

$db = new DbUtilities;
$db->executeQuery($sql, "sss", array($userID, $attemptID, $levelAccess)); //submit sql query

/*
echo("userID: " . $userID . "<br />");
echo("attemptID: " . $attemptID . "<br />");
echo("levelAccess: " . $levelAccess  . "<br />");
echo($sql);
*/