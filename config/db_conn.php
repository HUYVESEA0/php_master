<?php
$servername = "localhost";
$username = "huyviesea";
$password = "huyviesea_db";
$dbname = "data_center";


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>