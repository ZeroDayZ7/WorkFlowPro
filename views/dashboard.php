<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

$user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Panel użytkownika</title>
</head>
<body>
    <h2>Witaj, <?php echo $user['username']; ?>!</h2>
    <p>To jest twój panel użytkownika.</p>
    <a href="logout.php"><button>Wyloguj się</button></a>
</body>
</html>
