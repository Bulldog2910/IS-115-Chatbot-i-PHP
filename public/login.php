<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require_once __DIR__ . '/../app/controllers/loginController.php';

// DB-tilkobling kommer via db.php inne i controller-fila
// men vi trenger $conn her også:
require_once __DIR__ . '/../app/config/db.php';

$controller = new LoginController($conn);
$controller->handleRequest();
?>