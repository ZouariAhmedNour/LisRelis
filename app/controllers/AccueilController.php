<?php

class AccueilController {
    public function index() {
        // Tu peux plus tard récupérer des livres depuis la base de données ici
        $livresPopulaires = [
            [
                'image' => BASE_URL . 'assets/images/book1.jpg',
                'titre' => 'Le Petit Prince',
                'auteur' => 'Antoine de Saint-Exupéry'
            ],
            // Ajoute d'autres livres ici
        ];

        require_once __DIR__ . '/../views/accueil.php';
    }
}
