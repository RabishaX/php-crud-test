<?php
// Database configuration file
//Make database connection Variables
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "product_management";

//Create database connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }
?>