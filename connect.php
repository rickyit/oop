<?php
include('config.php');
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if($mysqli->connect_errno) {
    die('Can\'t Please contact system administrator.');
}