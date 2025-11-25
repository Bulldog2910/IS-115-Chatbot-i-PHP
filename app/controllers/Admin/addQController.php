<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require __DIR__ . '/../../config/dbOOP.php';
require __DIR__ . '/../../models/admin/addQModel.php';

$addQ = new addQModel($_POST);

$conn->select_db('FAQUiaChatbot');
$stmt = $conn->prepare("INSERT INTO questions 
    (questionDescription, questionAnswer, keyword1, keyword2, keyword3, keyword4, keyword5, keyword6, keyword7, keyword8, keyword9, keyword10, category)
    VALUES 
    (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param(
    'ssiiiiiiiiiis', 
    $addQ->QDesc, 
    $addQ->ADesc, 
    $addQ->keywordIds[0], 
    $addQ->keywordIds[1], 
    $addQ->keywordIds[2], 
    $addQ->keywordIds[3], 
    $addQ->keywordIds[4], 
    $addQ->keywordIds[5], 
    $addQ->keywordIds[6], 
    $addQ->keywordIds[7], 
    $addQ->keywordIds[8], 
    $addQ->keywordIds[9], 
    $addQ->category
);if($stmt->execute()){
    $log[] = 'Inserted correctly';
}else{
    $err['DB-03'] = 'Error inserting Question: ' . $stmt->error;
}
if(!empty($err)){
    foreach($err as $errorId => $errorMessage){
        echo $errorId . ": " . $errorMessage;
    }
}

