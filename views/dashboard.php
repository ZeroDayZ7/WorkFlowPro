<?php
if (!isset($_SESSION['user'])) {
    header('Location: ' . BASE_URL . '/index');
    exit();
}

$user = $_SESSION['user'];
?>

<!-- Sidebar -->
<div class="sidebar">
    <h2>Menu</h2>
    <ul class="flex-left">
        <li><a href="?page=dashboard&task=users">Użytkownicy</a></li>
        <li><a href="?page=dashboard&task=schedule">Harmonogram</a></li>
        <li><a href="?page=dashboard&task=messages">Wiadomości</a></li>
        <li><a href="?page=dashboard&task=settings">Ustawienia</a></li>
    </ul>
</div>

<!-- Dynamic Content -->
<div id="main-content">
    <?php
    // Wczytanie dynamicznego taska w dashboardzie
    $task = isset($_GET['task']) ? $_GET['task'] : 'main';

    // Ścieżka do pliku na podstawie zadania (task)
    $taskPath = BASE_PATH . "/views/dashboard/{$task}.php";

    if (file_exists($taskPath)) {
        include $taskPath; // Ładowanie odpowiedniego taska
    } else {
        echo "<h1>Strona nie znaleziona</h1>";
    }
    ?>
</div>
<style>
    #main-content {
        flex: 1;
        margin: 0px 200px;
        overflow: auto;
        max-height: 630px;
    }
</style>