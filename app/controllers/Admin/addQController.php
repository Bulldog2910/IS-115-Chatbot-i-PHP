<?php
/*Add question controller*/
require __DIR__ . '/../../models/admin/addQModel.php';

$addQ = new addQModel($_POST);
$addQ->addQuestion();

