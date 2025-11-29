<?php
$identificator = $_POST['identificatorTable'] ?? 'wrong';

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
    
    // Sjekker at innlogget bruker har admin-rolle, ellers nektes tilgang
    if ($_SESSION['role'] !== 'admin') {
         header("Location: ../../../public/index.php");
        exit; 
    } 
if($_SERVER['REQUEST_METHOD'] == 'POST' && $identificator == 'keyword'){
    include __DIR__ . '/editKeywordController.php';
    include __DIR__ . '/../../views/admin/keywordForm.php'; 

}

if($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['identificatorTable'] == 'question'){
    if(isset($_POST['Qtype'])){
        if($_POST['Qtype'] == 'editQ'){
         require __DIR__ . '/editQController.php';
        }
        if($_POST['Qtype'] == 'addQ'){
            require_once __DIR__ . '/addQController.php';
        }
    }
    include __DIR__ . '/../../views/admin/questionsForm.php'; 


}

include __dir__ . '/../../models/admin/selectModel.php';
$selectViews = new select();

?>