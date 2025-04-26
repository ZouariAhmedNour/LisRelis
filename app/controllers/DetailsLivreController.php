<?php

require_once __DIR__ . '/../models/Livre.php';
require_once __DIR__ . '/../models/Emprunt.php';

class DetailsLivreController {
    private $livreModel;
    private $empruntModel;

    public function __construct() {
        $this->livreModel = new Livre();
        $this->empruntModel = new Emprunt();
    }

    public function index($id) {
        $livre = $this->livreModel->findById($id);

        if (!$livre) {
            // Rediriger ou afficher une erreur si le livre n'existe pas
            header('HTTP/1.1 404 Not Found');
            echo "Livre non trouvé.";
            exit;
        }

        require_once __DIR__ . '/../views/detailsLivre.php';
    }

    public function emprunter($livre_id) {
        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . 'login');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $utilisateur_id = $_SESSION['user_id'];

            // Fixer les dates
            $date_emprunt = date('Y-m-d'); // Date d'aujourd'hui
            $date_retour = date('Y-m-d', strtotime('+14 days')); // Aujourd'hui + 2 semaines

            $errors = [];

            // Vérifier si le livre est disponible
            $livre = $this->livreModel->findById($livre_id);
            if ($livre['disponible'] == 0) {
                $errors[] = "Ce livre n'est pas disponible pour l'emprunt.";
            }

            if (empty($errors)) {
                // Enregistrer l'emprunt
                $this->empruntModel->create($livre_id, $utilisateur_id, $date_emprunt, $date_retour);

                // Mettre à jour la disponibilité du livre
                $this->livreModel->updateDisponibilite($livre_id, 0);

                // Ajouter un message de succès pour SweetAlert2
                $_SESSION['success'] = "Livre emprunté avec succès ! Retour prévu le $date_retour.";
                header('Location: ' . BASE_URL . 'detailsLivre/' . $livre_id);
                exit();
            } else {
                // Stocker les erreurs dans la session pour les afficher dans la vue
                $_SESSION['errors'] = $errors;
                header('Location: ' . BASE_URL . 'detailsLivre/' . $livre_id);
                exit();
            }
        } else {
            // Si la méthode n'est pas POST, rediriger vers la page des détails du livre
            header('Location: ' . BASE_URL . 'detailsLivre/' . $livre_id);
            exit();
        }
    }
}