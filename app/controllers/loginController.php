<?php
session_start();

// Inkluder modellen som har all funksjonell kode
include __DIR__ . '/../models/User.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {

}

// Redirect eller inkluder view
include "../views/login.php";
