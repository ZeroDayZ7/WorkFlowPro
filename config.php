<?php
// config.php
require 'vendor/autoload.php';

use Dotenv\Dotenv;

// Załaduj zmienne z pliku .env
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Uzyskaj zmienne środowiskowe
$dbHost = $_ENV['DB_HOST'];
$dbUser = $_ENV['DB_USER'];
$dbPass = $_ENV['DB_PASS'];

$NAME = $_ENV['APP_NAME'];

// Użyj zmiennych
// echo "NAME: $NAME";
// $fullUrl = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
// echo "Full URL: " . $fullUrl;

define('BASE_URL', 'http://' . $_SERVER['SERVER_NAME'] . "/WorkFlowPro/");
define('BASE_PATH', __DIR__ );
// define('BASE_PATH', 'http://localhost/WorkflowPro');


echo "BASE_URL: " . BASE_URL;
echo '<br>';
echo "BASE_PATH: " . BASE_PATH;

error_reporting(E_ALL);
ini_set('display_errors', 1);

?>
