<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/../../models/admin/addQModel.php';

$addQ = new addQModel($_POST);
$addQ->addQuestion();

