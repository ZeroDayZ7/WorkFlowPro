<?php
session_start();
include 'config.php';
include BASE_PATH . '/views/header.php';

// echo $_SESSION['user']['id'];
// echo '<br>';
// echo $_SESSION['user']['username'];
// echo '<br>';
// echo $_SESSION['user']['role'];
// echo '<br>';
?>

<div id="app">
    <?php if (isset($_SESSION['user'])): ?>
        <!-- Układ wyśrodkowany dla użytkowników niezalogowanych -->
        <div id="content-center">
            <?php 
            $page = isset($_GET['page']) ? $_GET['page'] : 'home';
            $pagePath = BASE_PATH . "/views/{$page}.php";
            
            if (file_exists($pagePath)) {
                include $pagePath;
            } else {
                echo "<h1>Strona nie znaleziona</h1>";
            }
            ?>
        </div>
    <?php else: ?>
        <!-- Układ po zalogowaniu -->
        <div id="content">
            
            <?php
            $page = isset($_GET['page']) ? $_GET['page'] : 'home';
            $pagePath = BASE_PATH . "/views/{$page}.php";
            
            if (file_exists($pagePath)) {
                include $pagePath;
            } else {
                echo "<h1>Strona nie znaleziona</h1>";
            }
            ?>
        </div>
    <?php endif; ?>
</div>

<?php include BASE_PATH . '/views/footer.php'; ?>
