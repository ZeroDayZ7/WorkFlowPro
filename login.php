<?php
session_start();

require_once 'classes/User.php';
require_once 'config/Database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $db = new Database();
    $conn = $db->getConnection();
    $user = new \Classes\User($conn);

    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($loggedInUser = $user->login($username, $password)) {
        $_SESSION['user'] = $loggedInUser;
        header('Location: dashboard.php');
    } else {
        $_SESSION['error'] = "Logowanie nieudane. Nieprawidłowy login lub hasło.";
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Logowanie</title>
</head>
<body>
    <h2>Logowanie</h2>
    <?php if (isset($_SESSION['error'])): ?>
        <p style="color:red;"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
    <?php endif; ?>
    <form method="POST" action="login.php">
        <label>Nazwa użytkownika:</label><br>
        <input type="text" name="username" required><br><br>
        <label>Hasło:</label><br>
        <input type="password" name="password" required><br><br>
        <button type="submit">Zaloguj się</button>
    </form>
    <p>Nie masz konta? <a href="register.php">Zarejestruj się</a></p>
</body>
</html>
