<?php
$chatbotLog = $_SESSION['chatbotLog'] ?? [];

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_POST['quickQuestion'])){
        require __DIR__ . '/../../models/chatbot/quickQModel.php';
        $quickQ = new quickQ($_POST);
        $chatbotLog[] = $quickQ->info;
        $_SESSION['chatbotLog'] = $chatbotLog;
        echo "<style> #quick-action" . $quickQ->value . "{background-color: #FF6B6B; color: white;} </style>";

    }else{
        require __DIR__ . '/../../models/chatbot/chatbotModel.php';
        include __DIR__ . '/../../models/chatbot/scoringModel.php';
        $chatbot = new chatbotModel($_POST);
        $score = new scoring($chatbot);
        
        $chatbotLog[] = $score->bestScore;

        $_SESSION['chatbotLog'] = $chatbotLog;
    }
   
}
?>