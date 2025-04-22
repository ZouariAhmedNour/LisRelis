<?php
class Utilisateur {
    private $pdo;

    public function __construct(){
        require_once __DIR__ . '/../config/database.php';

        $this->pdo = dbConnect();
    }

    public function register($nom, $email ,$telephone, $password) {
        $stmt = $this->pdo->prepare("INSERT INTO utilisateur (nom, email, telephone, password) VALUES (?, ?, ?, ?)");
        $stmt ->execute([$nom, $email, $telephone, password_hash($password, PASSWORD_DEFAULT)]);
        return $stmt->rowCount() > 0;
    }

    public function emailExists($email) {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM utilisateur WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetchColumn() > 0;
    }

    public function login($email, $password) {
        $stmt = $this->pdo->prepare("SELECT * FROM utilisateur WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        
        if ($user && password_verify($password, $user['password'])) {
            return $user; // Retourne les données de l'utilisateur
        }
        return false; // Retourne false si l'email ou le mot de passe est incorrect
    }
}