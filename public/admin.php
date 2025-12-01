<?php
session_start();

// 1) Check admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ./index.php");
    exit;
}

// 2) DB + header
require_once __DIR__ . '/../app/config/dbOOP.php';

include __DIR__ . '/../app/views/shared/_header.php';

// 3) Decide which controller to run
$page = $_GET['page'] ?? 'questions';

if ($page === 'users') {
    // Use EditUser for user admin
    require_once __DIR__ . '/../app/controllers/Admin/editUserController.php';
    $controller = new EditUser($conn);
    $controller->handleRequests();
} else {
    // Use AdminController for keywords/questions/etc.
    require_once __DIR__ . '/../app/controllers/Admin/adminController.php';
    $controller = new AdminController($conn);
    $controller->handle();
}

include __DIR__ . '/../app/views/shared/_footer.php';
?>
