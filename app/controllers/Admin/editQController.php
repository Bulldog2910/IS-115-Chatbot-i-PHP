<?php
/* Edit questions controller */
require __DIR__ . '/../../config/dbOOP.php'; // Start db connection
require __DIR__ . '/../../models/admin/editQModel.php';

$addQ = new editQModel($_POST);
$addQ->updateQ();