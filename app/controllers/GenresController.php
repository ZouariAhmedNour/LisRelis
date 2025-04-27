<?php
require_once __DIR__ . '/../models/Genre.php';

class GenreController {
    private $genreModel;

    public function __construct() {
        $this->genreModel = new Genre();
    }

    public function index() {
        // Débogage : Vérifier le contenu de la session
        error_log("GenreController::index - Contenu de la session : " . print_r($_SESSION, true));

        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['user'])) {
            error_log("GenreController::index - Utilisateur non connecté, redirection vers login");
            header('Location: ' . BASE_URL . 'login');
            exit();
        }

        // Vérifier si l'utilisateur est un admin (role = 0)
        if ($_SESSION['user']['role'] != 0) {
            error_log("GenreController::index - Utilisateur non admin, redirection vers accueil");
            $_SESSION['error_message'] = "Accès refusé : Vous n'avez pas les permissions nécessaires pour accéder à cette page.";
            header('Location: ' . BASE_URL . 'accueil');
            exit();
        }

        // Récupérer tous les genres
        $genres = $this->genreModel->findAll();

        // Charger la vue
        require_once __DIR__ . '/../views/genres.php';
    }

    public function add() {
        // Débogage : Vérifier le contenu de la session
        error_log("GenreController::add - Contenu de la session : " . print_r($_SESSION, true));

        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['user'])) {
            error_log("GenreController::add - Utilisateur non connecté, redirection vers login");
            header('Location: ' . BASE_URL . 'login');
            exit();
        }

        // Vérifier si l'utilisateur est un admin (role = 0)
        if ($_SESSION['user']['role'] != 0) {
            error_log("GenreController::add - Utilisateur non admin, redirection vers accueil");
            $_SESSION['error_message'] = "Accès refusé : Vous n'avez pas les permissions nécessaires pour accéder à cette page.";
            header('Location: ' . BASE_URL . 'accueil');
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
        // Débogage : Vérifier le contenu de la session
        error_log("GenreController::edit - Contenu de la session : " . print_r($_SESSION, true));

        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['user'])) {
            error_log("GenreController::edit - Utilisateur non connecté, redirection vers login");
            header('Location: ' . BASE_URL . 'login');
            exit();
        }

        // Vérifier si l'utilisateur est un admin (role = 0)
        if ($_SESSION['user']['role'] != 0) {
            error_log("GenreController::edit - Utilisateur non admin, redirection vers accueil");
            $_SESSION['error_message'] = "Accès refusé : Vous n'avez pas les permissions nécessaires pour accéder à cette page.";
            header('Location: ' . BASE_URL . 'accueil');
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
        // Débogage : Vérifier le contenu de la session
        error_log("GenreController::delete - Contenu de la session : " . print_r($_SESSION, true));

        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['user'])) {
            error_log("GenreController::delete - Utilisateur non connecté, redirection vers login");
            header('Location: ' . BASE_URL . 'login');
            exit();
        }

        // Vérifier si l'utilisateur est un admin (role = 0)
        if ($_SESSION['user']['role'] != 0) {
            error_log("GenreController::delete - Utilisateur non admin, redirection vers accueil");
            $_SESSION['error_message'] = "Accès refusé : Vous n'avez pas les permissions nécessaires pour accéder à cette page.";
            header('Location: ' . BASE_URL . 'accueil');
            exit();
        }

        $this->genreModel->delete($id);
        header('Location: ' . BASE_URL . 'genres');
        exit();
    }
}