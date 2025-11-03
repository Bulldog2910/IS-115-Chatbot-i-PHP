<?php
const ERR_TOM = "feltet er tomt.";
const ERR_UGYLDIG = "feltet har ugyldig format";

function rensInput($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    return $data;
}

function validateMessage($message){
    if (empty($message)) {
        return ERR_TOM;
    }
    $message = rensInput($message);
    
    if (!preg_match('/^[A-Za-zÆØÅæøå \-]+$/u', $message)) {
        return ERR_UGYLDIG;
    }
    
    return $message;
}

function spiltString($message){
    $messageKeyWords = explode(" ", mb_convert_case($message, MB_CASE_UPPER, "UTF-8"));
    sort($messageKeyWords);

}


// TEST FUNKSJON PROOF OF CONCEPT
function processChatbotMessage($message) {
    // Simple keyword-based responses
    $message_lower = strtolower($message);
    
    if (strpos($message_lower, 'hei') !== false || strpos($message_lower, 'hallo') !== false) {
        return "Hei! Hvordan kan jeg hjelpe deg i dag?";
    } elseif (strpos($message_lower, 'hjelp') !== false) {
        return "Jeg kan hjelpe deg med informasjon om våre tjenester.";
    } elseif (strpos($message_lower, 'takk') !== false) {
        return "Bare hyggelig! Er det noe annet jeg kan hjelpe med?";
    } else {
        return "Jeg forstår. Kan du fortelle meg mer?";
    }
}
?>