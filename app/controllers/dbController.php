<?php
$errors = []; // collect errors here

// echo "<br>Starting database setup...<br>";

$result = mysqli_query($conn, "SHOW DATABASES LIKE 'FAQUiaChatbot'");

// Database doesn't exist, create it
if (mysqli_num_rows($result) == 0) { 
    // echo "Database doesn't exist<br>";
    
    $createDb = "CREATE DATABASE FAQUiaChatbot";
    if (mysqli_query($conn, $createDb)) {
        // echo "Database created successfully.<br>";
        
        if (!mysqli_select_db($conn, 'FAQUiaChatbot')) {
            $errors[] = "Error selecting newly created database: " . mysqli_error($conn);
            die();
        }
    } else {
        $errors[] = "Error creating database: " . mysqli_error($conn);
        die();
    } 
} else {
    // echo "Database exists.<br>";
}

// Use database
mysqli_select_db($conn, 'FAQUiaChatbot');

$result = mysqli_query($conn, "SHOW TABLES LIKE 'chatUser'");

// If table exist dont create
if (mysqli_num_rows($result) == 0) {
    // echo "Tables don't exist, creating them...<br>";
    
    // Read schema.sql and run
    $sqlPath = __DIR__ . "/../database/schema.sql";
    
    if (!file_exists($sqlPath)) {
        $errors[] = "Error: schema.sql not found at: " . $sqlPath;
        die();
    }
    
    $sql = file_get_contents($sqlPath);
    
    if (mysqli_multi_query($conn, $sql)) {
        // echo "Tables created successfully<br>";
        
        // Clear remaining results from multi_query
        while (mysqli_next_result($conn)) {;}
    } else {
        $errors[] = "Error creating table: " . mysqli_error($conn);
        // no die here originally, so kept that behavior
    }
} else {
    // echo "Tables exist, skip creation<br>";
}

/*
    CHECK IF DATABASE HAS ANY ROWS
    We check one table (chatUser). If it's empty,
    assume the whole database needs seeding.
*/

$checkData = mysqli_query($conn, "SELECT COUNT(*) AS rowCount FROM chatUser");
$dataRow = mysqli_fetch_assoc($checkData);

if ($dataRow['rowCount'] == 0) {
    // echo "No data found — running seeder...<br>";

    $seedPath = __DIR__ . "/../database/seeder/seedingData.sql";

    if (!file_exists($seedPath)) {
        $errors[] = "Error: seedingData.sql not found at: " . $seedPath;
        die();
    }

    $seedSql = file_get_contents($seedPath);

    if (mysqli_multi_query($conn, $seedSql)) {
        // echo "Seeding completed.<br>";

        while (mysqli_next_result($conn)) {;} // flush buffer
    } else {
        $errors[] = "Error running seeder: " . mysqli_error($conn);
        die();
    }

} else {
    // echo "Data already exists — skipping seed.<br>";
}

// echo "Setup complete!<br>";
?>
