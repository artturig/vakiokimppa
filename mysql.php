<?php
// Database
$servername = "localhost";
$username = "change";
$password = "change";
$dbname = "vakio";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
//echo "Connected successfully";
?>