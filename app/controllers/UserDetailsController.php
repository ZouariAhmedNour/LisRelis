<?php
require_once __DIR__ . '/../models/Utilisateur.php';

class UserDetailsController {
    private $utilisateur;

    public function __construct() {
        $this->utilisateur = new Utilisateur();
    }

    public function index($userId) {
        // Récupérer les détails de l'utilisateur
        $user = $this->utilisateur->getUserById($userId);
        if (!$user) {
            // Gérer le cas où l'utilisateur n'existe pas
            header('Location: ' . BASE_URL . 'profilAdmin');
            exit;
        }

        // Récupérer l'historique des emprunts
        $borrowHistory = $this->utilisateur->getUserBorrowHistory($userId);

        // Charger la vue
        require_once __DIR__ . '/../views/userDetails.php';
    }
}