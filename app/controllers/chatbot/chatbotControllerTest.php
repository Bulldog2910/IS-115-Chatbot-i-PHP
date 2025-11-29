<?php 
include __DIR__ . '/../../models/chatbot/chatbotModel.php';
include __DIR__ . '/../../models/chatbot/scoringModel.php';

if($_SERVER['REQUEST_METHOD'] == "POST")
{
    $chatBot = new chatbotModel($_POST);
    $chatBot->printQ();
}

/* include __DIR__ . '/../views/chatbotView.php';  */
?>