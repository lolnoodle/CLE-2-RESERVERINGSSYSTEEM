<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "prototype_cle";

$db = mysqli_connect($host, $user, $password, $database)
    or die("Error:".mysqli_connect_error());
