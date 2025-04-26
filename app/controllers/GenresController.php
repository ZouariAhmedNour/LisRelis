<?php

require_once __DIR__ . '/../models/Genre.php';

class GenreController {
    private $genreModel;

    public function __construct() {
        $this->genreModel = new Genre();
    }

    public function index() {
        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . 'login');
            exit();
        }

        // Récupérer tous les genres
        $genres = $this->genreModel->findAll();

        // Charger la vue
        require_once __DIR__ . '/../views/genres.php';
    }

    public function add() {
        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . 'login');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = trim($_POST['nom'] ?? '');
            $description = trim($_POST['description'] ?? '');

            $errors = [];

            // Valider les champs
            if (empty($nom)) {
                $errors[] = "Le nom est requis.";
            }
            if (empty($description)) {
                $errors[] = "La description est requise.";
            }

            if (empty($errors)) {
                $this->genreModel->create($nom, $description);
                header('Location: ' . BASE_URL . 'genres');
                exit();
            } else {
                // Stocker les erreurs dans la session pour les afficher dans la vue
                $_SESSION['errors'] = $errors;
                header('Location: ' . BASE_URL . 'genres');
                exit();
            }
        } else {
            // Si la méthode n'est pas POST, rediriger vers la liste des genres
            header('Location: ' . BASE_URL . 'genres');
            exit();
        }
    }

    public function edit($id) {
        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . 'login');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = trim($_POST['nom'] ?? '');
            $description = trim($_POST['description'] ?? '');

            $errors = [];

            // Valider les champs
            if (empty($nom)) {
                $errors[] = "Le nom est requis.";
            }
            if (empty($description)) {
                $errors[] = "La description est requise.";
            }

            if (empty($errors)) {
                $this->genreModel->update($id, $nom, $description);
                header('Location: ' . BASE_URL . 'genres');
                exit();
            } else {
                // Stocker les erreurs dans la session pour les afficher dans la vue
                $_SESSION['errors'] = $errors;
                header('Location: ' . BASE_URL . 'genres');
                exit();
            }
        } else {
            // Si la méthode n'est pas POST, rediriger vers la liste des genres
            header('Location: ' . BASE_URL . 'genres');
            exit();
        }
    }

    public function delete($id) {
        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . 'login');
            exit();
        }

        $this->genreModel->delete($id);
        header('Location: ' . BASE_URL . 'genres');
        exit();
    }
}