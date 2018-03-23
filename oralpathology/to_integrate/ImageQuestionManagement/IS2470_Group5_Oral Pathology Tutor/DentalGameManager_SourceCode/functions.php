<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'config.php';

function connectDB(){
    return mysqli_connect(MYSQL_HOST,MYSQL_USER,MYSQL_PW,MYSQL_DB);
}

function connectDB_Dental() {
    return mysqli_connect(MYSQL_HOST_DENTAL,MYSQL_USER_DENTAL,MYSQL_PW_DENTAL,MYSQL_DB_DENTAL);
}