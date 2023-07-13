<?php

$servername = "localhost";
$username = "victor";
$password = "admin123";
$dbname = "LMN-Test";

$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);