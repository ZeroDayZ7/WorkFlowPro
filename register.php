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

    if ($user->register($username, $password)) {
        $_SESSION['success'] = "Rejestracja udana! Możesz się teraz zalogować.";
        header('Location: login.php');
    } else {
        $_SESSION['error'] = "Rejestracja nie powiodła się. Spróbuj ponownie.";
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Rejestracja</title>
</head>
<body>
    <h2>Rejestracja</h2>
    <?php if (isset($_SESSION['error'])): ?>
        <p style="color:red;"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
    <?php endif; ?>
    <form method="POST" action="register.php">
        <label>Nazwa użytkownika:</label><br>
        <input type="text" name="username" required><br><br>
        <label>Hasło:</label><br>
        <input type="password" name="password" required><br><br>
        <button type="submit">Zarejestruj się</button>
    </form>
    <p>Masz już konto? <a href="login.php">Zaloguj się</a></p>
</body>
</html>
