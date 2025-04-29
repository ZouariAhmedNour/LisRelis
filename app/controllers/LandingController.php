<?php
class LandingController {
    public function index() {
        // Définir la page actuelle pour le layout
        $currentPage = 'landing';
        require_once __DIR__ . '/../views/landing.php';
    }
}
?>