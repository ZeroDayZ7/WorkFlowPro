<?php
session_start();
include 'config.php';
include BASE_PATH . '/views/header.php';

require_once BASE_PATH . '/config/Database.php';
require_once BASE_PATH . '/classes/User.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $db = new Config\Database();
    $conn = $db->connect();
    $user = new \Classes\User($conn);

    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($user->register($username, $password)) {
        $_SESSION['success'] = "Registration successful! You can now log in.";
        header('Location: ' . BASE_URL . '/login');
        exit();
    } else {
        $_SESSION['error'] = "Registration failed. Please try again.";
    }
}
?>

<h2>Register</h2>
<?php if (isset($_SESSION['error'])): ?>
    <p style="color:red;"><?php echo htmlspecialchars($_SESSION['error'], ENT_QUOTES, 'UTF-8');
                            unset($_SESSION['error']); ?></p>
<?php endif; ?>
<form method="POST" action="">
    <label>Username:</label><br>
    <input type="text" name="username" required><br><br>
    <label>Password:</label><br>
    <input type="password" name="password" required><br><br>
    <button type="submit">Register</button>
</form>
<p>Masz już konto? <a href="<?php echo BASE_URL; ?>/login">Zaloguj się</a></p>


<?php include 'views/footer.php'; ?>