<?php

require_once __DIR__ . '/../models/Livre.php';

class AccueilController {
    private $livreModel;

    public function __construct() {
        $this->livreModel = new Livre();
    }

    public function index() {
        $searchQuery = isset($_GET['search']) ? trim($_GET['search']) : '';
        
        // Toujours charger les livres populaires
        $livresPopulaires = $this->livreModel->findAll();

        // Convertir les images BLOB en base64 pour les livres populaires
        foreach ($livresPopulaires as &$livre) {
            if (!empty($livre['image'])) {
                $livre['image'] = 'data:image/jpeg;base64,' . base64_encode($livre['image']);
            } else {
                // Si aucune image, utiliser une image par défaut (optionnel)
                $livre['image'] = BASE_URL . 'assets/images/default-book.jpg';
            }
        }
        unset($livre); // Nettoyer la référence

        // Charger les résultats de la recherche si une recherche est effectuée
        $livresRecherches = [];
        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

        if ($searchQuery) {
            $livresRecherches = $this->livreModel->findAll($searchQuery);
            // Convertir les images BLOB en base64 pour les livres recherchés
            foreach ($livresRecherches as &$livre) {
                if (!empty($livre['image'])) {
                    $livre['image'] = 'data:image/jpeg;base64,' . base64_encode($livre['image']);
                } else {
                    $livre['image'] = BASE_URL . 'assets/images/default-book.jpg';
                }
            }
            unset($livre); // Nettoyer la référence
        }

        if ($isAjax) {
            // Répondre en JSON pour les requêtes AJAX
            header('Content-Type: application/json');
            echo json_encode($livresRecherches);
            exit;
        }

        require_once __DIR__ . '/../views/accueil.php';
    }
}