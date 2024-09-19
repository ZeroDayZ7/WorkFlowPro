<?php

namespace Classes;

use PDO;

class User
{
    private $conn;
    private $table = 'users';

    public $id;
    public $username;
    public $password;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Metoda do logowania
    public function login($username, $password)
    {
        // Zapytanie do pobrania hasła, ID i roli użytkownika
        $query = "SELECT id, username, password, role FROM " . $this->table . " WHERE username = :username";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($user && password_verify($password, $user['password'])) {
            // Zwróć dane użytkownika bez hasła
            return [
                'id' => $user['id'],
                'username' => $user['username'],
                'role' => $user['role']
            ];
        } else {
            // Nieprawidłowy login lub hasło
            return false;
        }
    }
    // Metoda do rejestracji
    public function register($username, $password)
    {
        $query = "INSERT INTO " . $this->table . " (username, password) VALUES (:username, :password)";
        $stmt = $this->conn->prepare($query);

        // Bind parameters
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', password_hash($password, PASSWORD_DEFAULT));

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
