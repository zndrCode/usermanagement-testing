<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "exam"; // Change this to your database name //DIRI E ILIS

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>