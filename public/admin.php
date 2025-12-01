<?php
session_start(); // hvis ikke startet allerede

// 1) Sjekk admin FØR output
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ./index.php");
    exit;
}

// 2) Deretter last alt annet
require_once __DIR__ . '/../app/config/dbOOP.php';
require_once __DIR__ . '/../app/controllers/Admin/adminController.php';

include __DIR__ . '/../app/views/shared/_header.php';

$controller = new AdminController($conn);
$controller->handle();

include __DIR__ . '/../app/views/shared/_footer.php';

?>