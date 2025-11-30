<?php
/*Edit keyword controller*/
require_once __DIR__ . '/../../config/dbOOP.php'; // DB connection
require_once __DIR__ . '/../../models/admin/editKeywordModel.php';

$identificator = $_POST['identificator'] ?? ' ';

//POST keywordUpdate
if($_SERVER['REQUEST_METHOD'] == 'POST' && $identificator == 'keywordUpdate'){
    $editKeywordModel = new editkeyword($_POST['identificatorId'], $_POST['identificatorValue']);
    $editKeywordModel->editkeyword();
}


?>