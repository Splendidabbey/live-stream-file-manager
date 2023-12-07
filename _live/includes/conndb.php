<?php
// Database configuration
$host = "localhost";
$username = "root";
$password = "";
$database = "onewebinar";

// Connect to the database
$mysqli = new mysqli($host, $username, $password, $database);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}