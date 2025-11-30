<?php
/* DB creation controller */
$dbCreationLog = [];

$result = mysqli_query($conn, "SHOW DATABASES LIKE 'FAQUiaChatbot'");

// Database doesn't exist, create it
if (mysqli_num_rows($result) == 0) { 
    $dbCreationLog[] = "Database doesn't exist";
    
    $createDb = "CREATE DATABASE FAQUiaChatbot";
    if (mysqli_query($conn, $createDb)) {
        $dbCreationLog[] = "Database created successfully";
        
        if (!mysqli_select_db($conn, 'FAQUiaChatbot')) {
            $errors[] = "Error selecting newly created database: " . mysqli_error($conn);
            die();
        }
    } else {
        $errors[] = "Error creating database: " . mysqli_error($conn);
        die();
    } 
} else {
    $dbCreationLog[] = "Database exists.<br>";
}

// Use database
mysqli_select_db($conn, 'FAQUiaChatbot');

$result = mysqli_query($conn, "SHOW TABLES LIKE 'chatUser'");

// If table exist dont create
if (mysqli_num_rows($result) == 0) {
    $dbCreationLog[] = "Tables don't exist, creating them...";
    
    // Read schema.sql and run
    $sqlPath = __DIR__ . "/../database/schema.sql";
    
    if (!file_exists($sqlPath)) {
        $errors[] = "Error: schema.sql not found at: " . $sqlPath;
        die();
    }
    
    $sql = file_get_contents($sqlPath);
    
    if (mysqli_multi_query($conn, $sql)) {
        $dbCreationLog[] = "Tables created successfully";
        
        // Clear remaining results from multi_query
        while (mysqli_next_result($conn)) {;}
    } else {
        $errors[] = "Error creating table: " . mysqli_error($conn);
        // no die here originally, so kept that behavior
    }
} else {
    $dbCreationLog[] = "Tables exist, skip creation";
}

/*
    CHECK IF DATABASE HAS ANY ROWS
    We check one table (chatUser). If it's empty,
    assume the whole database needs seeding.
*/

$checkData = mysqli_query($conn, "SELECT COUNT(*) AS rowCount FROM chatUser");
$dataRow = mysqli_fetch_assoc($checkData);

if ($dataRow['rowCount'] == 0) {
    $dbCreationLog[] = "No data found, running seeder...";

    $seedPath = __DIR__ . "/../database/seeder/seedingData.sql";

    if (!file_exists($seedPath)) {
        $errors[] = "Error: seedingData.sql not found at: " . $seedPath;
        die();
    }

    $seedSql = file_get_contents($seedPath);

    if (mysqli_multi_query($conn, $seedSql)) {
        $dbCreationLog[] = "Seeding completed";
        while (mysqli_next_result($conn)) {;} // flush buffer

        $hashedpassword = password_hash('Password123@', PASSWORD_DEFAULT);

        $stmt = $conn->prepare("
            INSERT INTO chatUser (firstName, lastName, userpassword, mail, username, role)
            VALUES (?, ?, ?, ?, ?, ?)
        ");

        $stmt->bind_param(
            "ssssss",
            $firstName,
            $lastName,
            $hashedpassword,
            $email,
            $username,
            $role
        );

        $firstName = "Admin";
        $lastName = "Admin";
        $email = "admin@gmail.com";
        $username = "admin";
        $role = "admin";

        $stmt->execute();

    } else {
        $dbCreationLog[] = "Data already exists, skipping seed.";
    }
}

$dbCreationLog[] = "Setup complete!";
?>
