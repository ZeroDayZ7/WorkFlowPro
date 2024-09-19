<?php
namespace Classes;

class Auth {
    public static function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    public static function login($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role']; 
    }

    public static function logout() {
        session_unset();
        session_destroy();
    }
}
