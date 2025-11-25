<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include __DIR__ . '/../models/chatbotModel.php';

if($_SERVER['REQUEST_METHOD'] == "POST")
{
    $chatBot = new chatbotModel($_POST);
    $chatBot->printQ();
}

include __DIR__ . '/../views/chatbotView.php';
?>