<?php

require_once __DIR__ . '/../models/Livre.php';
require_once __DIR__ . '/../models/Auteur.php';
require_once __DIR__ . '/../models/Genre.php';

class LivreController {
    private $livreModel;
    private $auteurModel;
    private $genreModel;

    public function __construct() {
        $this->livreModel = new Livre();
        $this->auteurModel = new Auteur();
        $this->genreModel = new Genre();
    }

    public function index() {
        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . 'login');
            exit();
        }

        // Gestion de la recherche
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';

        // Si la recherche est vide et que le paramètre search est présent dans l'URL, rediriger vers /livres
        if (isset($_GET['search']) && $search === '') {
            header('Location: ' . BASE_URL . 'livres');
            exit();
        }

        // Charger les livres
        $livres = $this->livreModel->findAll($search);

        // Convertir les images BLOB en base64
        foreach ($livres as &$livre) {
            if (!empty($livre['image'])) {
                $livre['image'] = 'data:image/jpeg;base64,' . base64_encode($livre['image']);
            } else {
                $livre['image'] = BASE_URL . 'assets/images/default-book.jpg';
            }
        }
        unset($livre);

        // Récupérer les auteurs et genres pour le formulaire d'ajout
        $auteurs = $this->auteurModel->findAll();
        $genres = $this->genreModel->findAll();

        // Charger la vue
        require_once __DIR__ . '/../views/livres.php';
    }

    public function add() {
        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . 'login');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titre = trim($_POST['titre'] ?? '');
            $auteur_id = trim($_POST['auteur_id'] ?? '');
            $genre_id = trim($_POST['genre_id'] ?? '');
            $isbn = trim($_POST['isbn'] ?? '');

            $errors = [];

            // Valider les champs
            if (empty($titre)) {
                $errors[] = "Le titre est requis.";
            }
            if (empty($auteur_id)) {
                $errors[] = "L'auteur est requis.";
            }
            if (empty($genre_id)) {
                $errors[] = "Le genre est requis.";
            }
            if (empty($isbn)) {
                $errors[] = "L'ISBN est requis.";
            } elseif (!preg_match('/^[0-9]{5,13}$/', $isbn)) {
                $errors[] = "L'ISBN doit contenir entre 10 et 13 chiffres.";
            }

            // Gestion de l'image
            $imageData = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $image = $_FILES['image'];
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                if (!in_array($image['type'], $allowedTypes)) {
                    $errors[] = "L'image doit être au format JPEG, PNG ou GIF.";
                } elseif ($image['size'] > 2 * 1024 * 1024) { // Limite de 2 Mo
                    $errors[] = "L'image ne doit pas dépasser 2 Mo.";
                } else {
                    $imageData = file_get_contents($image['tmp_name']);
                    if ($imageData === false) {
                        $errors[] = "Erreur lors de la lecture de l'image.";
                    }
                }
            } else {
                $errors[] = "L'image est requise.";
            }

            if (empty($errors)) {
                $this->livreModel->create($titre, $auteur_id, $genre_id, $isbn, $imageData);
                header('Location: ' . BASE_URL . 'livres');
                exit();
            } else {
                // Stocker les erreurs dans la session pour les afficher dans la vue
                $_SESSION['errors'] = $errors;
                header('Location: ' . BASE_URL . 'livres');
                exit();
            }
        } else {
            // Si la méthode n'est pas POST, rediriger vers la liste des livres
            header('Location: ' . BASE_URL . 'livres');
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
            $titre = trim($_POST['titre'] ?? '');
            $auteur_id = trim($_POST['auteur_id'] ?? '');
            $genre_id = trim($_POST['genre_id'] ?? '');
            $isbn = trim($_POST['isbn'] ?? '');

            $errors = [];

            // Valider les champs
            if (empty($titre)) {
                $errors[] = "Le titre est requis.";
            }
            if (empty($auteur_id)) {
                $errors[] = "L'auteur est requis.";
            }
            if (empty($genre_id)) {
                $errors[] = "Le genre est requis.";
            }
            if (empty($isbn)) {
                $errors[] = "L'ISBN est requis.";
            } elseif (!preg_match('/^[0-9]{5,10}$/', $isbn)) {
                $errors[] = "L'ISBN doit contenir entre 10 et 13 chiffres.";
            }

            // Gestion de l'image (facultative lors de la modification)
            $imageData = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $image = $_FILES['image'];
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                if (!in_array($image['type'], $allowedTypes)) {
                    $errors[] = "L'image doit être au format JPEG, PNG ou GIF.";
                } elseif ($image['size'] > 2 * 1024 * 1024) { // Limite de 2 Mo
                    $errors[] = "L'image ne doit pas dépasser 2 Mo.";
                } else {
                    $imageData = file_get_contents($image['tmp_name']);
                    if ($imageData === false) {
                        $errors[] = "Erreur lors de la lecture de l'image.";
                    }
                }
            }

            if (empty($errors)) {
                $this->livreModel->update($id, $titre, $auteur_id, $genre_id, $isbn, $imageData);
                header('Location: ' . BASE_URL . 'livres');
                exit();
            } else {
                // Stocker les erreurs dans la session pour les afficher dans la vue
                $_SESSION['errors'] = $errors;
                header('Location: ' . BASE_URL . 'livres');
                exit();
            }
        } else {
            // Si la méthode n'est pas POST, rediriger vers la liste des livres
            header('Location: ' . BASE_URL . 'livres');
            exit();
        }
    }

    public function delete($id) {
        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . 'login');
            exit();
        }

        $this->livreModel->delete($id);
        header('Location: ' . BASE_URL . 'livres');
        exit();
    }
}