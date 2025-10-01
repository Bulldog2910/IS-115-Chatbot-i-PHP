<?php
$serverName = "localhost";
$username = "root";
$password = "";
$dbName = "FAQUiaChatbot";

// Create connection
$conn = mysqli_connect($serverName, $username, $password, $dbName);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
echo "Connection to database succesfull";
?>



