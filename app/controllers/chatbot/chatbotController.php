<?php
$chatbotLog = $_SESSION['chatbotLog'] ?? [];

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    require __DIR__ . '/../../models/chatbot/chatbotModel.php';
    include __DIR__ . '/../../models/chatbot/scoringModel.php';
    $chatbot = new chatbotModel($_POST);
    $score = new scoring($chatbot);
    
    $chatbotLog[] = $score->bestScore;

    $_SESSION['chatbotLog'] = $chatbotLog;
}
?>