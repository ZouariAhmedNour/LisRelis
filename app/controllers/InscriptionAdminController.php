<?php 
require_once __DIR__ . '/../models/Utilisateur.php';

class InscriptionAdminController {
    private $utilisateur;

    public function __construct() {
        $this->utilisateur = new Utilisateur();   
    }

    public function index() {
        $message = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = trim($_POST['nom']);
            $email = trim($_POST['email']);
            $telephone = trim($_POST['telephone']);
            $password = $_POST['password'];
            $role = 0;

            // Validation
            if (empty($nom) || empty($email) || empty($telephone) || empty($password)) {
                $message = 'Tous les champs sont obligatoires.';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $message = 'Adresse e-mail invalide.';
            } elseif (!preg_match('/^\d{8}$/', $telephone)) {
                $message = 'Le numéro de téléphone doit contenir exactement 8 chiffres.';
            } elseif (strlen($password) < 6) {
                $message = 'Le mot de passe doit contenir au moins 6 caractères.';
            } elseif ($this->utilisateur->emailExists($email)) {
                $message = 'L\'adresse e-mail est déjà utilisée.';
            } else {
                if ($this->utilisateur->register($nom, $email, $telephone, $password, $role)) {
                    $message = 'Inscription admin réussie. Vous pouvez vous connecter.';
                } else {
                    $message = 'Erreur lors de l\'inscription admin. Veuillez réessayer.';
                }
            }
        }

        require_once __DIR__ . '/../views/inscriptionAdmin.php';
    }
}
