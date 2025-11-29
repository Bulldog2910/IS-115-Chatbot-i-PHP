<?php
    session_start();

    require_once __DIR__ . '/../app/controllers/loginController.php';

    require_once __DIR__ . '/../app/config/db.php';

    $controller = new LoginController($conn);
    $controller->handleRequest();
?>