<?php
   
   include __DIR__ . '/../app/views/shared/_header.php';


// Only admins allowed
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ./index.php");
    exit;
}

// DB connection
require_once __DIR__ . '/../app/config/dbOOP.php';

// AdminController for questions/keywords/reset
require_once __DIR__ . '/../app/controllers/Admin/adminController.php';

$controller = new AdminController($conn);
$controller->handle();
?>