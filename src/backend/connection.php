<?php

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$db = "webprog";


$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $db);

if (!$conn) {
    die("Can't connect to database!");
}
