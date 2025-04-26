<?php

require_once __DIR__ . '/../models/Auteur.php';

class AuteursController {
    private $auteurModel;

    public function __construct() {
        $this->auteurModel = new Auteur();
    }

    public function index() {
        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . 'login');
            exit();
        }

        // Gestion de la recherche
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        $auteurs = $this->auteurModel->findAll($search);

        // Charger la vue
        require_once __DIR__ . '/../views/auteurs.php';
    }

    public function add() {
        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . 'login');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = trim($_POST['nom'] ?? '');
            $biographie = trim($_POST['biographie'] ?? '');
            $date_de_naissance = trim($_POST['date_de_naissance'] ?? '');

            $errors = [];

            // Valider les champs
            if (empty($nom)) {
                $errors[] = "Le nom est requis.";
            }
            if (empty($biographie)) {
                $errors[] = "La biographie est requise.";
            }
            if (empty($date_de_naissance)) {
                $errors[] = "La date de naissance est requise.";
            }

            if (empty($errors)) {
                $this->auteurModel->create($nom, $biographie, $date_de_naissance);
                header('Location: ' . BASE_URL . 'auteurs');
                exit();
            } else {
                // Stocker les erreurs dans la session pour les afficher dans la vue
                $_SESSION['errors'] = $errors;
                header('Location: ' . BASE_URL . 'auteurs');
                exit();
            }
        } else {
            // Si la méthode n'est pas POST, rediriger vers la liste des auteurs
            header('Location: ' . BASE_URL . 'auteurs');
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
            $biographie = trim($_POST['biographie'] ?? '');
            $date_de_naissance = trim($_POST['date_de_naissance'] ?? '');

            $errors = [];

            // Valider les champs
            if (empty($nom)) {
                $errors[] = "Le nom est requis.";
            }
            if (empty($biographie)) {
                $errors[] = "La biographie est requise.";
            }
            if (empty($date_de_naissance)) {
                $errors[] = "La date de naissance est requise.";
            }

            if (empty($errors)) {
                $this->auteurModel->update($id, $nom, $biographie, $date_de_naissance);
                header('Location: ' . BASE_URL . 'auteurs');
                exit();
            } else {
                // Stocker les erreurs dans la session pour les afficher dans la vue
                $_SESSION['errors'] = $errors;
                header('Location: ' . BASE_URL . 'auteurs');
                exit();
            }
        } else {
            // Si la méthode n'est pas POST, rediriger vers la liste des auteurs
            header('Location: ' . BASE_URL . 'auteurs');
            exit();
        }
    }

    public function delete($id) {
        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . 'login');
            exit();
        }

        // Tenter de supprimer l'auteur
        if ($this->auteurModel->delete($id)) {
            // Suppression réussie
            header('Location: ' . BASE_URL . 'auteurs');
        } else {
            // Suppression échouée : probablement l'auteur par défaut
            $_SESSION['errors'] = ["Impossible de supprimer cet auteur car il s'agit de l'auteur par défaut 'Auteur inconnu'."];
            header('Location: ' . BASE_URL . 'auteurs');
        }
        exit();
    }
}