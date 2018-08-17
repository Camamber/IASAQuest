<?php
require_once 'constants.php';
 
$link = mysqli_connect(DB_SERVER , DB_USER, DB_PASS, DB_NAME)
    or die("Error: " . mysqli_error($link));
$link->set_charset("utf8")
?>