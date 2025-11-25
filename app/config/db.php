<?php
$errors = []; // collect errors

$serverName = "localhost";
$username = "root";
$password = "";

// Create connection
$conn = mysqli_connect($serverName, $username, $password);

// Check connection
if (!$conn) {
    $errors[] = "Connection failed: " . mysqli_connect_error();
    die(); // stop script but do not echo
}

// Connection success is ignored (no echo)
?>

