<?php 
require_once __DIR__ . '/../models/Utilisateur.php';



class InscriptionController {
    private $utilisateur;

    public function __construct() {
        $this->utilisateur = new Utilisateur();   
    }

    public function index() {
        $message = '';
        if ( $_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = $_POST['nom'];
            $email = $_POST['email'];
            $telephone = $_POST['telephone'];
            $password = $_POST['password'];

            if (empty($nom) || empty($email) || empty($telephone) || empty($password)) {
                $message = 'Tous les champs sont obligatoires.';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $message = 'Adresse e-mail invalide.';
            } elseif ($this->utilisateur->emailExists($email)) {
                $message = 'L\'adresse e-mail est déjà utilisée.';
            } else {
                if ($this->utilisateur->register($nom, $email, $telephone, $password)) {
                   // header('Location: /login'); // Rediriger vers la page de connexion
                    //exit;
                    $message = 'Inscription réussie. Vous pouvez vous connecter.';
                } else {
                    $message = 'Erreur lors de l\'inscription. Veuillez réessayer.';
                }
            }
        }
        require_once __DIR__ . '/../views/inscription.php';
        // Afficher la vue d'inscription
    }
}