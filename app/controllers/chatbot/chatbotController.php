<?php
    /* Chatbot controller */

    $chatbotLog = $_SESSION['chatbotLog'] ?? [];

    // POST quick question or chatbot input
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($_POST['quickQuestion'])){
            require __DIR__ . '/../../models/chatbot/quickQModel.php';
            
            $quickQ = new quickQ($_POST);
            $chatbotLog[] = $quickQ->info;
            $_SESSION['chatbotLog'] = $chatbotLog;

            echo "<style> #quick-action" . $quickQ->value . "{background-color: #FF6B6B; color: white;} </style>";

        }else{
            require_once __DIR__ . '/../../models/chatbot/chatbotModel.php';
            require_once __DIR__ . '/../../models/chatbot/scoringModel.php';
            require_once __DIR__ . '/../../models/inputProcessing/stopwordv2.php';
            require_once __DIR__ . '/../../models/inputProcessing/lemma.php';

            // Convert the entire user question to lowercase
            // This ensures consistent matching regardless of casing
            $lowerCaseInput = strtolower($_POST['question']);

            // Split input into individual words separated by spaces
            $inputArr = preg_split("/[\s\.,!?]+/", $lowerCaseInput, -1, PREG_SPLIT_NO_EMPTY);

            //Removes stopwords from question, making the inpput only have relevant words
            $stopword = new stopwordV2($inputArr);
            $stopwordArr = $stopword->getStopwordsV2();

            //Lemmanize input to make it more likely to match with keyword
            //Api
            $lemma = new lemma($stopwordArr);
            $lemmaArr = $lemma->getLemma();

            //If lemma api didnt work then do it without lemmanized input
            if(!empty($lemmaArr)){
                $chatbot = new chatbotModel($lemmaArr);
                $score = new scoring($chatbot);
            }else{
                $chatbot = new chatbotModel($stopwordArr);
                $score = new scoring($chatbot);
            }
            
            //Store output
            $chatbotLog[] = $score->bestScore;
            $_SESSION['chatbotLog'] = $chatbotLog;
        }
    
    }
?>