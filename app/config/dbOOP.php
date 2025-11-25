<?php
$errors = []; // collect errors

$serverName = "localhost";
$username = "root";
$password = "";

// Create OO connection
$conn = new mysqli($serverName, $username, $password);

// Check connection
if ($conn->connect_error) {
    $errors[] = "Connection failed: " . $conn->connect_error;
    die();
}
?>
