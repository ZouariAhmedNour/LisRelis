<?php
require_once __DIR__ . '/../models/Auteur.php';

class AuteursController {
    private $auteurModel;

    public function __construct() {
        $this->auteurModel = new Auteur();
    }

    public function index() {
        // Débogage : Vérifier le contenu de la session
        error_log("AuteursController::index - Contenu de la session : " . print_r($_SESSION, true));

        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['user'])) {
            error_log("AuteursController::index - Utilisateur non connecté, redirection vers login");
            header('Location: ' . BASE_URL . 'login');
            exit();
        }

        // Vérifier si l'utilisateur est un admin (role = 0)
        if ($_SESSION['user']['role'] != 0) {
            error_log("AuteursController::index - Utilisateur non admin, redirection vers accueil");
            $_SESSION['error_message'] = "Accès refusé : Vous n'avez pas les permissions nécessaires pour accéder à cette page.";
            header('Location: ' . BASE_URL . 'accueil');
            exit();
        }

        // Gestion de la recherche
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        $auteurs = $this->auteurModel->findAll($search);

        // Charger la vue
        require_once __DIR__ . '/../views/auteurs.php';
    }

    public function add() {
        // Débogage : Vérifier le contenu de la session
        error_log("AuteursController::add - Contenu de la session : " . print_r($_SESSION, true));

        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['user'])) {
            error_log("AuteursController::add - Utilisateur non connecté, redirection vers login");
            header('Location: ' . BASE_URL . 'login');
            exit();
        }

        // Vérifier si l'utilisateur est un admin (role = 0)
        if ($_SESSION['user']['role'] != 0) {
            error_log("AuteursController::add - Utilisateur non admin, redirection vers accueil");
            $_SESSION['error_message'] = "Accès refusé : Vous n'avez pas les permissions nécessaires pour accéder à cette page.";
            header('Location: ' . BASE_URL . 'accueil');
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
                $_SESSION['success'] = "Auteur ajouté avec succès.";
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

    public function edit() {
        // Débogage : Vérifier le contenu de la session
        error_log("AuteursController::edit - Contenu de la session : " . print_r($_SESSION, true));

        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['user'])) {
            error_log("AuteursController::edit - Utilisateur non connecté, redirection vers login");
            header('Location: ' . BASE_URL . 'login');
            exit();
        }

        // Vérifier si l'utilisateur est un admin (role = 0)
        if ($_SESSION['user']['role'] != 0) {
            error_log("AuteursController::edit - Utilisateur non admin, redirection vers accueil");
            $_SESSION['error_message'] = "Accès refusé : Vous n'avez pas les permissions nécessaires pour accéder à cette page.";
            header('Location: ' . BASE_URL . 'accueil');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupérer l'ID à partir de $_POST
            $id = isset($_POST['id']) ? (int)$_POST['id'] : null;
            if (!$id) {
                $_SESSION['errors'] = ["ID de l'auteur manquant."];
                header('Location: ' . BASE_URL . 'auteurs');
                exit();
            }

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
                $_SESSION['success'] = "Auteur modifié avec succès.";
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
        // Débogage : Vérifier le contenu de la session
        error_log("AuteursController::delete - Contenu de la session : " . print_r($_SESSION, true));

        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['user'])) {
            error_log("AuteursController::delete - Utilisateur non connecté, redirection vers login");
            header('Location: ' . BASE_URL . 'login');
            exit();
        }

        // Vérifier si l'utilisateur est un admin (role = 0)
        if ($_SESSION['user']['role'] != 0) {
            error_log("AuteursController::delete - Utilisateur non admin, redirection vers accueil");
            $_SESSION['error_message'] = "Accès refusé : Vous n'avez pas les permissions nécessaires pour accéder à cette page.";
            header('Location: ' . BASE_URL . 'accueil');
            exit();
        }

        // Tenter de supprimer l'auteur
        if ($this->auteurModel->delete($id)) {
            // Suppression réussie
            $_SESSION['success'] = "Auteur supprimé avec succès.";
            header('Location: ' . BASE_URL . 'auteurs');
        } else {
            // Suppression échouée : probablement l'auteur par défaut
            $_SESSION['errors'] = ["Impossible de supprimer cet auteur car il s'agit de l'auteur par défaut 'Auteur inconnu'."];
            header('Location: ' . BASE_URL . 'auteurs');
        }
        exit();
    }
}