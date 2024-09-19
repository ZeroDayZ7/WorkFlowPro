<?php
session_start();
include '../config.php';
include BASE_PATH . '/views/header.php';


if (!isset($_SESSION['user'])) {
    header('Location: ' . BASE_URL . '/index');
    exit();
}

$user = $_SESSION['user'];


?>
    <h2>Witaj, <?php echo $user['username']; ?>!</h2>
    <p>To jest twój panel użytkownika.</p>
    <a href="<?php echo BASE_URL; ?>/logout"><button>Wyloguj się</button></a>
<?php include BASE_PATH . '/views/footer.php'; ?>