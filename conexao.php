<?php

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "galeria_videos";

$conn = new PDO("mysql:host=$host;dbname=" . $dbname, $user, $pass);