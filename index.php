<?php
include 'config.php';
include BASE_PATH . '/views/header.php';


?>

<div id="app">
    <div id="content">
        <?php 
        $page = isset($_GET['page']) ? $_GET['page'] : 'home';
        $pagePath = BASE_PATH . "/{$page}.php";
        if (file_exists($pagePath)) {
            include $pagePath;
        } else {
            echo "<h1>Strona nie znaleziona</h1>";
        }
        ?>
    </div>


</div>

<?php include BASE_PATH . '/views/footer.php'; ?>