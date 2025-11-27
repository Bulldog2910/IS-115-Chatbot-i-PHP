<?php 
    // Start session if none exists
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Include database connection and controller
    include __DIR__ . '/../config/db.php';
    include __DIR__ . '/../controllers/dbController.php';
    mysqli_close($conn);
    
    // Do not redirect if already on the login page
    $current = basename($_SERVER['PHP_SELF']);

    if (!isset($_SESSION['user_id']) && $current !== 'login.php') {
        header("Location: ../public/login.php");
        exit();
    }

    // Handle logout
    if (isset($_POST['logout'])) {
        session_destroy();
        header("Location: ../public/login.php");
        exit();
    }

    // Get session values if they exist
    $message = $_SESSION['message'] ?? '';
    $output = $_SESSION['output'] ?? '';
    $error = $_SESSION['error'] ?? [];



    // Session timeout (10 minutes)
    $timeout = 6000;

    // Check last activity timestamp
    if (isset($_SESSION['last_active'])) {
        // If time since last activity exceeds timeout → log out
        if (time() - $_SESSION['last_active'] > $timeout) {
            session_unset();
            session_destroy();
            header("Location: ../public/login.php");
            exit;
        }
    }

    // Update last activity timestamp
    $_SESSION['last_active'] = time();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./CSS/site.css">

</head>
<body>
    <nav>
        <div class="user-info">
            <a class="button" href="../app/views/userCreation.php">User creation</a>
        </div>
        <div class="user-info">
            <a class="button" href="../app/controllers/chatbotControllerTest.php">chatbotTest</a>
        </div>
        <div class="user-info">
            <a class="button" href="../app/views/admin.php">Admin</a>
        </div>
    </nav>
            <div class="logout">
            <?php if (isset($_SESSION['username'])): ?>
                <form method="POST" >
                    <input type="submit" name="logout" class="button" value="Logg ut">
                </form>  
            <?php endif; ?>
            </div>
    