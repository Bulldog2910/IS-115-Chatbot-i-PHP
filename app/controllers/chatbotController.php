<?php
$chatbotLog = $_SESSION['chatbotLog'] ?? [];

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    require __DIR__ . '/../models/chatbotModel.php';
    $chatbot = new chatbotModel($_POST);
    foreach ($chatbot->QArr as $Q){
        $chatbotLog[] = $Q;
    }

    $_SESSION['chatbotLog'] = $chatbotLog;

}
?>