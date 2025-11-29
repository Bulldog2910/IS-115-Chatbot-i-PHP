<?php
require_once __DIR__ . '/../../config/dbOOP.php';
require_once __DIR__ . '/../../models/admin/editKeywordModel.php';

$identificator = $_POST['identificator'] ?? ' ';
if($_SERVER['REQUEST_METHOD'] == 'POST' && $identificator == 'keywordUpdate'){
    $editKeywordModel = new editkeyword($_POST['identificatorId'], $_POST['identificatorValue']);
    $editKeywordModel->editkeyword();
}


?>