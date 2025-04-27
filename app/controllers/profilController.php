<?php
require_once __DIR__ . '/../models/Utilisateur.php';

class ProfilController {
    private $utilisateur;

    public function __construct() {
        $this->utilisateur = new Utilisateur();
    }

    public function index() {
        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASE_URL . 'login');
            exit;
        }

        // Récupérer les informations de l'utilisateur connecté
        $user = $_SESSION['user'];

        // Charger la vue
        require_once __DIR__ . '/../views/profil.php';
    }
}