<?php
require_once __DIR__ . '/../models/Utilisateur.php';
require_once __DIR__ . '/../utils/EmailSender.php';

class ProfilAdminController {
    private $utilisateur;

    public function __construct() {
        $this->utilisateur = new Utilisateur();
    }

    public function index() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 0) {
            header('Location: ' . BASE_URL . 'login');
            exit;
        }

        $upcomingReturns = $this->utilisateur->getUsersWithUpcomingReturns();

        $searchResults = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
            $query = trim($_POST['search']);
            if (!empty($query)) {
                $searchResults = $this->utilisateur->searchUsers($query);
            }
        }

        require_once __DIR__ . '/../views/profilAdmin.php';
    }

    public function userDetails($id) {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 0) {
            header('Location: ' . BASE_URL . 'login');
            exit;
        }

        $user = $this->utilisateur->getUserById($id);
        if (!$user) {
            $_SESSION['errors'] = ["Utilisateur non trouvé."];
            header('Location: ' . BASE_URL . 'profilAdmin');
            exit;
        }

        $borrowHistory = $this->utilisateur->getUserBorrowHistory($id);
        require_once __DIR__ . '/../views/userDetails.php';
    }

    public function editUser($id) {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 0) {
            header('Location: ' . BASE_URL . 'login');
            exit;
        }

        $user = $this->utilisateur->getUserById($id);
        if (!$user) {
            $_SESSION['errors'] = ["Utilisateur non trouvé."];
            header('Location: ' . BASE_URL . 'profilAdmin');
            exit;
        }

        $errors = [];
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = trim($_POST['nom'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $telephone = trim($_POST['telephone'] ?? '');
            $role = (int)($_POST['role'] ?? 1);
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            if (empty($nom) || empty($email) || empty($telephone)) {
                $errors[] = "Tous les champs obligatoires doivent être remplis.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "L'email n'est pas valide.";
            } elseif ($this->utilisateur->emailExists($email) && $email !== $user['email']) {
                $errors[] = "Cet email est déjà utilisé par un autre utilisateur.";
            } elseif ($password && $password !== $confirmPassword) {
                $errors[] = "Les mots de passe ne correspondent pas.";
            } elseif ($password && strlen($password) < 6) {
                $errors[] = "Le mot de passe doit contenir au moins 6 caractères.";
            }

            if (empty($errors)) {
                $passwordToUpdate = $password ? $password : null;
                if ($this->utilisateur->updateUser($id, $nom, $email, $telephone, $role, $passwordToUpdate)) {
                    $_SESSION['success'] = "Utilisateur mis à jour avec succès !";
                    header('Location: ' . BASE_URL . 'profilAdmin/userDetails/' . $id);
                    exit;
                } else {
                    $errors[] = "Une erreur est survenue lors de la mise à jour.";
                }
            }
        }

        require_once __DIR__ . '/../views/editUser.php';
    }

    public function sendAlert() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['send_alert'])) {
            $userId = (int)$_POST['user_id'];
            $bookTitle = $_POST['book_title'];
            $returnDate = $_POST['return_date'];

            error_log("sendAlert appelé : user_id=$userId, book_title=$bookTitle, return_date=$returnDate");

            $user = $this->utilisateur->getUserById($userId);
            if ($user) {
                error_log("Utilisateur trouvé pour envoi d'alerte : " . print_r($user, true));
                $emailSender = new EmailSender();
                $sent = $emailSender->sendAlert($user['email'], $user['nom'], $bookTitle, $returnDate);

                if ($sent) {
                    error_log("Alerte envoyée avec succès à {$user['email']}");
                    echo json_encode(['success' => true, 'message' => 'Alerte envoyée avec succès !']);
                } else {
                    error_log("Erreur lors de l'envoi de l'alerte à {$user['email']}");
                    echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'envoi de l\'alerte.']);
                }
            } else {
                error_log("Utilisateur non trouvé pour user_id=$userId");
                echo json_encode(['success' => false, 'message' => 'Utilisateur non trouvé.']);
            }
            exit;
        }
    }

    public function returnBook($livre_id, $emprunt_id) {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 0) {
            header('Location: ' . BASE_URL . 'login');
            exit;
        }

        $success = $this->utilisateur->returnBook($livre_id, $emprunt_id);
        if ($success) {
            $_SESSION['success'] = "Livre marqué comme rendu avec succès.";
        } else {
            $_SESSION['errors'] = ["Une erreur est survenue lors du retour du livre."];
        }

        $user_id = $this->utilisateur->getUserIdByEmpruntId($emprunt_id);
        if ($user_id) {
            header('Location: ' . BASE_URL . 'profilAdmin/userDetails/' . $user_id);
        } else {
            header('Location: ' . BASE_URL . 'profilAdmin');
        }
        exit;
    }
}
?>