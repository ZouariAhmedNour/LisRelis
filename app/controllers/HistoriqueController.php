<?php
require_once __DIR__ . '/../models/Utilisateur.php';

class HistoriqueController {
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

        // Récupérer l'historique des emprunts de l'utilisateur connecté
        $userId = $_SESSION['user']['id'];
        $borrowHistory = $this->utilisateur->getUserBorrowHistory($userId);

        // Gérer l'action de retour d'un livre
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['return_book'])) {
            $livreId = $_POST['livre_id'];
            $empruntId = $_POST['emprunt_id'];
            $this->utilisateur->returnBook($livreId, $empruntId);
            // Rafraîchir la page après le retour
            header('Location: ' . BASE_URL . 'historique');
            exit;
        }

        // Charger la vue
        require_once __DIR__ . '/../views/historique.php';
    }
}