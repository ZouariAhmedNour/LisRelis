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
        error_log("DetailsLivreController::index(id=$id)");
        $livre = $this->livreModel->findById($id);

        if (!$livre) {
            error_log("Livre non trouvé pour id=$id");
            header('HTTP/1.1 404 Not Found');
            echo "Livre non trouvé.";
            exit;
        }

        require_once __DIR__ . '/../views/detailsLivre.php';
    }

    public function emprunter($livre_id) {
        error_log("DetailsLivreController::emprunter(livre_id=$livre_id)");
        
        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['user_id'])) {
            error_log("Utilisateur non connecté, redirection vers login");
            header('Location: ' . BASE_URL . 'login');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $utilisateur_id = $_SESSION['user_id'];
            error_log("Utilisateur connecté : utilisateur_id=$utilisateur_id");

            // Fixer les dates
            $date_emprunt = date('Y-m-d'); // Date d'aujourd'hui
            $date_retour = date('Y-m-d', strtotime('+14 days')); // Aujourd'hui + 2 semaines

            $errors = [];

            // Vérifier si le livre est disponible
            $livre = $this->livreModel->findById($livre_id);
            if (!$livre) {
                error_log("Livre non trouvé pour id=$livre_id");
                $errors[] = "Livre non trouvé.";
            } elseif ($livre['disponible'] == 0) {
                error_log("Livre non disponible pour id=$livre_id");
                $errors[] = "Ce livre n'est pas disponible pour l'emprunt.";
            }

            if (empty($errors)) {
                // Enregistrer l'emprunt
                $success = $this->empruntModel->create($livre_id, $utilisateur_id, $date_emprunt, $date_retour);
                if ($success) {
                    // Mettre à jour la disponibilité du livre
                    $this->livreModel->updateDisponibilite($livre_id, 0);
                    error_log("Emprunt réussi pour livre_id=$livre_id, utilisateur_id=$utilisateur_id");
                    $_SESSION['success'] = "Livre emprunté avec succès ! Retour prévu le $date_retour.";
                } else {
                    error_log("Échec de l'enregistrement de l'emprunt pour livre_id=$livre_id");
                    $errors[] = "Une erreur est survenue lors de l'enregistrement de l'emprunt.";
                }
            }

            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
            }
            header('Location: ' . BASE_URL . 'detailsLivre/' . $livre_id);
            exit();
        } else {
            error_log("Méthode non POST, redirection vers detailsLivre/$livre_id");
            header('Location: ' . BASE_URL . 'detailsLivre/' . $livre_id);
            exit();
        }
    }
}
?>