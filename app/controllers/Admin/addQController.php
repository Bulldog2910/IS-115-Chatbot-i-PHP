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
$stmt->bind_param('sssssssssssss', $addQ->QDesc, $addQ->ADesc, $addQ->keyword1, $addQ->keyword2, $addQ->keyword3, $addQ->keyword4, $addQ->keyword5, $addQ->keyword6, $addQ->keyword7, $addQ->keyword8, $addQ->keyword9, $addQ->keyword10, $addQ->category);
if($stmt->execute()){
    $log[] = 'Inserted correctly';
}else{
    $err['DB-03'] = 'Error inserting Question: ' . $stmt->error;
}
if(!empty($err)){
    foreach($err as $errorId => $errorMessage){
        echo $errorId . ": " . $errorMessage;
    }
}

