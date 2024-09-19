<?php
session_start();
include 'config.php';
require_once BASE_PATH . '/classes/Auth.php';

Classes\Auth::logout();
header('Location: ' . BASE_URL . '/index');
exit();
