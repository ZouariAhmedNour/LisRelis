<?php 
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
                    // Stocker les informations de l'utilisateur dans la session
                    $_SESSION['user'] = [
                        'id' => $user['id'],
                        'nom' => $user['nom'],
                        'email' => $user['email'],
                        'telephone' => $user['telephone'],
                        'role' => $user['role']
                    ];
                    $_SESSION['user_id'] = $user['id']; // Ajout de user_id pour detailsLivre.php
                    error_log("Connexion réussie : user_id=" . $_SESSION['user_id']);
                    error_log("Session après connexion : " . print_r($_SESSION, true));

                    // Rediriger selon le rôle
                    if ($user['role'] == 0) { // Admin
                        header('Location: ' . BASE_URL . 'profilAdmin');
                    } else { // Utilisateur standard
                        header('Location: ' . BASE_URL . 'accueil');
                    }
                    exit;
                } else {
                    $message = 'Email ou mot de passe incorrect.';
                    error_log("Échec de la connexion pour email=$email");
                }
            }
        }
        require_once __DIR__ . '/../views/login.php';
    }
}
?>