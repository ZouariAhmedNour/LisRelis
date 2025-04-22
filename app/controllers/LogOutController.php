<?php
class LogoutController {
    public function index() {
        session_start();
        session_unset();  // Supprime toutes les variables de session
        session_destroy(); // Détruit la session

        header('Location: ' . BASE_URL . 'login'); // Redirige vers login
        exit;
    }
}
