<?php
    $servername = "localhost"; // Or the IP address of your MySQL server
    $username = "root"; // Default XAMPP username for MySQL
    $password = ""; // Default XAMPP password for MySQL (often empty)
    $dbname = "FAQuia"; // Replace with your actual database name

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

     // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    echo "Connected successfully";

    // You can now execute SQL queries using $conn->query() or prepared statements
    // ...

    // Close connection
    $conn->close();
    ?>


    ?>


