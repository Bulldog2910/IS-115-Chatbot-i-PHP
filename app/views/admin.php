<?php
    include_once '_header.php';

    // Sjekker at innlogget bruker har admin-rolle, ellers nektes tilgang
    if ($_SESSION['role'] !== 'admin') {
        header("Location: index.php?feil=Ikke_tilgang.");
        exit;
    }
?>