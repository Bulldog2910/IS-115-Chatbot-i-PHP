<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
    include_once '_header.php';
    // Sjekker at innlogget bruker har admin-rolle, ellers nektes tilgang
    /* if ($_SESSION['role'] !== 'admin') {
         header("Location: index.php?feil=Ikke_tilgang.");
        exit; 
    } */
if($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['identificatorTable'] == 'keyword'){
    if ($_POST['identificator'] == 'keywordUpdate'){
        include __DIR__ . '/editKeywordController.php';
    }
    include __DIR__ . '/../../views/admin/keywordForm.php'; 

}

if($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['identificatorTable'] == 'question'){
    if($_POST['Qtype'] == 'editQ'){
        /* require __DIR__ . '/' */
    }
    if($_POST['Qtype'] == 'addQ'){
        require_once __DIR__ . '/addQController.php';
    }
    include __DIR__ . '/../../views/admin/questionsForm.php'; 


}

include __DIR__ . '/../../config/dbOOP.php';


$conn->select_db('FAQUiaChatbot');
$stmt = $conn->prepare('SELECT * FROM questions');
$stmt->execute();
$resultQ = $stmt->get_result();

$stmt = $conn->prepare('SELECT * FROM chatUser');
$stmt->execute();
$resultChat = $stmt->get_result();

$stmt = $conn->prepare('SELECT * FROM keyWords');
$stmt->execute();
$resultKey = $stmt->get_result();
?>