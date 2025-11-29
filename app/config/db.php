<?php
$errors = []; // collect errors

$serverName = "localhost";
$username   = "root";
$password   = "";
$dbName     = "FAQUiaChatbot";

$conn = new mysqli($serverName, $username, $password, $dbName);

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Connection success is ignored (no echo)
?>

