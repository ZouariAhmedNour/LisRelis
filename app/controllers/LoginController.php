<?php 
session_start();
require_once __DIR__ . '/../models/Utilisateur.php';

class LoginController {
    private $utilisateur;

    public function __construct() {
        $this->utilisateur = new Utilisateur();   
    }

    public function index() {
        $message = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            // Validation des champs
            if (empty($email) || empty($password)) {
                $message = 'Tous les champs sont obligatoires.';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $message = 'Adresse e-mail invalide.';
            } else {
                // Vérifier les identifiants
                $user = $this->utilisateur->login($email, $password);
                if ($user) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_nom'] = $user['nom']; // On garde le nom pour l'affichage
                    header('Location: ' . BASE_URL . 'accueil');
                    exit;
                    // Redirection éventuelle
                    // header('Location: /dashboard');
                    // exit;
                } else {
                    $message = 'Email ou mot de passe incorrect.';
                }
            }
        }
        require_once __DIR__ . '/../views/login.php';
    }
}