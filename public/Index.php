
<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include __DIR__ . '/../app/views/_header.php';
include __DIR__ . '/../app/controllers/chatbotController.php';
include __DIR__ . '/../app/views/chatbot.view.php';
include '../app/views/_footer.php';?>