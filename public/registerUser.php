<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);


    include __DIR__ . '/../app/views/shared/_header.php';

    require_once __DIR__ . '/../app/controllers/registerController.php';

    $controller = new RegisterController($conn);
    $controller->register();

    include '../app/views/shared/_footer.php';

?>