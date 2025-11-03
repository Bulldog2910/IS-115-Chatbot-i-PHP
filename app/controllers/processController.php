<?php
session_start();

// Since ProcessController is in /app/controllers/, we need to adjust the paths
// Option 1: Include files in the same directory
include __DIR__ . '/chatbotController.php';
include __DIR__ . '/dbController.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['createdb'])) {
        createdb();
    } elseif (isset($_POST['Send']) && isset($_POST['message'])) {
        $resultat = validateMessage($_POST['message']);
        if ($resultat === ERR_TOM || $resultat === ERR_UGYLDIG) {
            $_SESSION['error']['Message'] = $resultat;
            $_SESSION['message'] = $_POST['message'];
        } else {
            $_SESSION['message'] = $resultat;
            $_SESSION['output'] = processChatbotMessage($resultat);
        }
    }
}

// Redirect back to the public directory where index.php is
header('Location: ../../public/index.php');
exit;
?>