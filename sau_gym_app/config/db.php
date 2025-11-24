<?php
$host = "127.0.0.1";
$port = "3307"; // because MySQL is running on 3307
$user = "root";
$pass = "";
$dbname = "sau_gym_wellness";

// Create connection
$conn = new mysqli($host, $user, $pass, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
