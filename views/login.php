<?php
// session_start();
require_once BASE_PATH . '/config/Database.php';
require_once BASE_PATH . '/classes/User.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $db = new Config\Database();
    $conn = $db->connect();
    $user = new \Classes\User($conn);

    $username = $_POST['username'];
    $password = $_POST['password'];

    echo $username;
    if ($loggedInUser = $user->login($username, $password)) {
        $_SESSION['user'] = $loggedInUser;
        header('Location: ' . BASE_URL . '?page=dashboard');
        exit();
    } else {
        $_SESSION['error'] = "Logowanie nieudane. Nieprawidłowy login lub hasło.";
        header('Location: ' . BASE_URL . '?page=login');
        exit();
    }
}
?>
<h2>Logowanie</h2>
<?php if (isset($_SESSION['error'])): ?>
    <p style="color:red;"><?php echo htmlspecialchars($_SESSION['error'], ENT_QUOTES, 'UTF-8');
                            unset($_SESSION['error']); ?></p>
<?php endif; ?>
<div class="box-w-200">
    <form method="POST" action="?page=login">
        <label>Nazwa użytkownika:</label>
        <input type="text" name="username" required>
        <label>Hasło:</label>
        <input type="password" name="password" required>
        <button type="submit" class="btn">Zaloguj się</button>
    </form>
</div>
<p>Nie masz konta? <a href="<?php echo BASE_URL; ?>?page=register">Zarejestruj się</a></p>