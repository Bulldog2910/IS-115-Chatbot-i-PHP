<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require __DIR__ . '/../../config/dbOOP.php';
require __DIR__ . '/../../models/admin/editQModel.php';

$addQ = new editQModel($_POST);
$addQ->updateQ();