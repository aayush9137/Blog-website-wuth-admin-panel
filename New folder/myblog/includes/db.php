<?php
$host = 'localhost';  // Database host
$username = 'root';  // Database username
$password = '';  // Database password
$database = 'myblog2';  // Database name

// Create a database connection
$db = mysqli_connect($host, $username, $password, $database);

// Check if the connection was successful
if (!$db) {
    die('Database connection error: ' . mysqli_connect_error());
}
?>
