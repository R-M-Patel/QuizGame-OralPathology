<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Sign in for Dental Game</title>
        <link href="css/loginstyle.css" rel="stylesheet">
    </head>
    <body>

        <?php
        require_once 'functions.php';

        $conn = connectDB();

        /* @var $_POST type */
        $username = $_POST['username'];
        $password = $_POST['password'];
        $userType = $_POST['userType'];

        if ($userType == 'Student') {//user type is Student
            echo "Hello, " . $username;
            echo "<br>"
            . "<a class=\"alert-link\" href=\"#\" role=\"button\" onclick=\"window.location.href='http://studentprojects.sis.pitt.edu/projects/oralpath/auth.php?userID=1'\">Go to Dental Game</a>";
            die();
        } else {//user type is Admin
            $result = mysqli_query($conn, "select * from Manager where username = '$username' and password = '$password'");
            $data_count = mysqli_num_rows($result);

            if (!$data_count) {//username or password is wrong
                echo "<div class=\"container\">
            <div class=\"alert alert-danger\" role=\"alert\">
                Username or Password is wrong. Please return and try again!
            <p><a class=\"alert-link\" href=\"#\" role=\"button\" onclick=\"window.location.href='Login.html'\">Return</a></p>

            </div>";
                die();
            }
            $result_arr = mysqli_fetch_assoc($result);
            $userID = $result_arr['userID'];
        }


//        echo "userID: $userID <br/>";
//        echo "username: $username <br/>";
//        echo "password: $password <br/>";
//        echo "userType: $userType <br/>";
        require 'questions3.php';
        ?>
    </body>
</html>
