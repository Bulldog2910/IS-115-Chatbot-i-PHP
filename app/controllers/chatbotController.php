<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    require __DIR__ . '/../models/chatbotModel.php';
    $chatbot = new chatbotModel($_POST);

}
?>