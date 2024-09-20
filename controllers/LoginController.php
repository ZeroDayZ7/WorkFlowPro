<?php
session_start();
if (!Auth::check()) {
    header('Location: index.php?page=login');
    exit;
}

// Wczytanie dashboardu
$title = 'Panel Administratora';
require_once 'app/views/header.php';
require_once 'app/views/dashboard.php';
require_once 'app/views/footer.php';