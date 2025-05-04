<?php
require_once __DIR__ . '/../models/Utilisateur.php';

class ProfilController {
    private $utilisateur;

    public function __construct() {
        $this->utilisateur = new Utilisateur();
    }

    public function index() {
        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['user'])) {
            error_log("Session utilisateur non définie pour index()");
            header('Location: ' . BASE_URL . 'login');
            exit;
        }

        // Récupérer les informations de l'utilisateur connecté
        $user = $_SESSION['user'];
        error_log("Utilisateur dans index() : " . print_r($user, true));

        // Charger la vue
        require_once __DIR__ . '/../views/profil.php';
    }

    public function edit() {
        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['user'])) {
            error_log("Session utilisateur non définie pour edit()");
            header('Location: ' . BASE_URL . 'login');
            exit;
        }

        $user = $_SESSION['user'];
        $message = '';
        $errors = [];
        error_log("Utilisateur dans edit() : " . print_r($user, true));

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            error_log("Soumission POST reçue : " . print_r($_POST, true));
            try {
                // Récupérer et nettoyer les données
                $nom = htmlspecialchars(trim($_POST['nom']), ENT_QUOTES, 'UTF-8');
                $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
                $telephone = preg_replace('/[^0-7]/', '', $_POST['telephone']);
                $password = $_POST['password'] ?? '';
                $mot_de_passe_confirm = $_POST['mot_de_passe_confirm'] ?? '';

                // Validations
                if (empty($nom) || strlen($nom) > 255) {
                    throw new Exception('Le nom est requis et ne doit pas dépasser 255 caractères.');
                }

                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    throw new Exception('L\'email est invalide.');
                }

                if ($this->utilisateur->emailExists($email) && $email !== $user['email']) {
                    throw new Exception('Cet email est déjà utilisé.');
                }

                if (!empty($telephone) && !preg_match('/^[0-7]{8}$/', $telephone)) {
                    throw new Exception('Le numéro de téléphone doit contenir 8 chiffres.');
                }

                if (!empty($password)) {
                    if (strlen($password) < 6) {
                        throw new Exception('Le mot de passe doit contenir au moins 6 caractères.');
                    }
                    if ($password !== $mot_de_passe_confirm) {
                        throw new Exception('Les mots de passe ne correspondent pas.');
                    }
                }
                

                // Mettre à jour l'utilisateur
                $role = $user['role']; // Utiliser la valeur numérique (0 ou 1)
                $success = $this->utilisateur->updateUser(
                    $user['id'],
                    $nom,
                    $email,
                    $telephone ?: null,
                    $role,
                    !empty($password) ? $password : null
                );

                if ($success) {
                    // Mettre à jour la session
                    $_SESSION['user'] = $this->utilisateur->getUserById($user['id']);
                    $message = 'Profil mis à jour avec succès.';
                    error_log("Profil mis à jour pour email={$email}");
                    header('Location: ' . BASE_URL . 'profil');
                    exit;
                } else {
                    throw new Exception('Erreur lors de la mise à jour du profil.');
                }
            } catch (Exception $e) {
                error_log("Erreur lors de la modification du profil : " . $e->getMessage());
                $errors[] = $e->getMessage();
            }
        }

        // Charger la vue
        require_once __DIR__ . '/../views/editProfil.php';
    }
}
?>