<?php
require_once __DIR__ . '/../../config/dbOOP.php';
require_once __DIR__ . '/../../models/admin/editKeywordModel.php';
$editKeywordModel = new editkeyword($_POST['identificatorId'], $_POST['identificatorValue']);
$editKeywordModel->editkeyword();

?>