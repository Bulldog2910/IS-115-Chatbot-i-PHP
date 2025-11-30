<?php
/*Admin controller*/
    $identificatorTable = $_POST['identificatorTable'] ?? ' ';

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Check if user doesnt have permission to enter
    // True = redirect to Index.php
    if ($_SESSION['role'] !== 'admin') {
         header("Location: ../public/index.php");
        exit; 
    } 
    //POST keyword
    if($_SERVER['REQUEST_METHOD'] == 'POST' && $identificatorTable == 'keyword'){
        include __DIR__ . '/editKeywordController.php';
        include __DIR__ . '/../../views/admin/keywordForm.php'; 
        
            if(isset($editKeywordModel)){
                $error = $editKeywordModel->error();
                if(is_array($error)){
                    foreach($error as $errorId => $errorMessage){
                        echo "<p style='color: red;'>Error id: $errorId ($errorMessage)</p>";
                    }
                }
            }
    }

    //POST Reset Database
    if($_SERVER['REQUEST_METHOD'] == 'POST' && $identificatorTable == 'Reset Database'){
    include __DIR__ . '/../../config/dbOOP.php';
    $conn->query("DROP DATABASE IF EXISTS `faquiachatbot`");
    header("Location: ../public/index.php");

    }

    //POST Question
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
    //Gets data from database
    include __dir__ . '/../../models/admin/selectModel.php';
    $selectViews = new select();

?>