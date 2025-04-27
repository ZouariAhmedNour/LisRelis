<?php
require_once __DIR__ . '/../models/Utilisateur.php';

class ProfilAdminController {
    private $utilisateur;

    public function __construct() {
        $this->utilisateur = new Utilisateur();
    }

    public function index() {
        // Récupérer les utilisateurs avec des emprunts proches de la date de retour
        $upcomingReturns = $this->utilisateur->getUsersWithUpcomingReturns();

        // Gérer la recherche d'utilisateurs
        $searchResults = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
            $query = trim($_POST['search']);
            if (!empty($query)) {
                $searchResults = $this->utilisateur->searchUsers($query);
            }
        }

        // Charger la vue
        require_once __DIR__ . '/../views/profilAdmin.php';
    }
}