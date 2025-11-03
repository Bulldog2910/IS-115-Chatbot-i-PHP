<?php
echo "<br>Starting database setup...<br>";


$result = mysqli_query($conn, "SHOW DATABASES LIKE 'FAQUiaChatbot'");

// Database doesn't exist, create it
if(mysqli_num_rows($result) == 0) { 
    echo "Database doesn't exist<br>";
    
    $createDb = "CREATE DATABASE FAQUiaChatbot";
    if (mysqli_query($conn, $createDb)) {
        echo "Database created successfully.<br>";
        
        if (!mysqli_select_db($conn, 'FAQUiaChatbot')) {
            die("Error selecting newly created database: " . mysqli_error($conn));
        }
    } else {
        die("Error creating database: " . mysqli_error($conn));
    } 
} else {
    echo "Database exists.<br>";
}

// Use database
mysqli_select_db($conn, 'FAQUiaChatbot');

$result = mysqli_query($conn, "SHOW TABLES LIKE 'chatUser'");

// If table exist dont create
if (mysqli_num_rows($result) == 0) {
    echo "Tables don't exist, creating them...<br>";
    
    // Read schema.sql and run
    $sqlPath = __DIR__ . "/../database/schema.sql";
    
    if (!file_exists($sqlPath)) {
        die("Error: schema.sql not found at: " . $sqlPath);
    }
    
    $sql = file_get_contents($sqlPath);
    
    if (mysqli_multi_query($conn, $sql)) {
        echo "Tables created successfully<br>";
        
        // Clear remaining results from multi_query
        while (mysqli_next_result($conn)) {;}
    } else {
        echo "Error creating table: " . mysqli_error($conn);
    }
} else {
    echo "Tables exist, skip creation<br>";
}

echo "Setup complete!<br>";
?>