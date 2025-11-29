<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once __DIR__ . '/../../config/dbOOP.php';
require_once __DIR__ . '/../../models/admin/editKeywordModel.php';
$editKeywordModel = new editkeyword($_POST['identificatorId'], $_POST['identificatorValue']);
$editKeywordModel->editkeyword();

?>