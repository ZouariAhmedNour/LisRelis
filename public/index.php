<?php
// Configurer les paramètres de session avant session_start()
ini_set('session.cookie_path', '/lis-relis/public/'); // Ajustez selon votre sous-répertoire
ini_set('session.gc_maxlifetime', 3600); // Durée de vie de la session : 1 heure
ini_set('session.cookie_lifetime', 3600);
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Dynamically compute the base URL
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'];
$scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
$baseUrl = rtrim($protocol . '://' . $host . $scriptDir, '/') . '/';
define('BASE_URL', $baseUrl);

// Define the layouts path
define('LAYOUTS_PATH', realpath(__DIR__ . '/../app/views/layouts') . '/');

// Debug: Log the BASE_URL, session ID, and request URI
error_log('BASE_URL: ' . BASE_URL);
error_log('Session ID: ' . session_id());
error_log('LAYOUTS_PATH: ' . LAYOUTS_PATH);
$requestUri = rtrim($_SERVER['REQUEST_URI'], '/');
error_log('Request URI: ' . $requestUri);

// Extract the path relative to the base
$path = parse_url($requestUri, PHP_URL_PATH);
$basePath = parse_url(BASE_URL, PHP_URL_PATH); // e.g., /lis-relis/public/
$relativePath = ltrim(substr($path, strlen($basePath)), '/'); // Remove base path and leading slash
error_log('Relative Path: ' . $relativePath);

// Routing
if ($relativePath === '') { // Route par défaut pour la page d'accueil principale
    require_once __DIR__ . '/../app/controllers/LandingController.php';
    $controller = new LandingController();
    $controller->index();
} elseif ($relativePath === 'login') {
    require_once __DIR__ . '/../app/controllers/LoginController.php';
    $controller = new LoginController();
    $controller->index();
} elseif ($relativePath === 'accueil') {
    require_once __DIR__ . '/../app/controllers/AccueilController.php';
    $controller = new AccueilController();
    $controller->index();
} elseif ($relativePath === 'logout') {
    require_once __DIR__ . '/../app/controllers/LogoutController.php';
    $controller = new LogoutController();
    $controller->index();
} elseif (preg_match('/^detailsLivre\/(\d+)$/', $relativePath, $matches)) {
    require_once __DIR__ . '/../app/controllers/DetailsLivreController.php';
    $controller = new DetailsLivreController();
    $controller->index($matches[1]);
} elseif (preg_match('/^detailsLivre\/emprunter\/(\d+)$/', $relativePath, $matches)) {
    require_once __DIR__ . '/../app/controllers/DetailsLivreController.php';
    $controller = new DetailsLivreController();
    $controller->emprunter($matches[1]);
} elseif ($relativePath === 'auteurs') {
    require_once __DIR__ . '/../app/controllers/AuteursController.php';
    $controller = new AuteursController();
    $controller->index();
} elseif (preg_match('/^auteurs\/delete\/(\d+)$/', $relativePath, $matches)) {
    require_once __DIR__ . '/../app/controllers/AuteursController.php';
    $controller = new AuteursController();
    $controller->delete($matches[1]);
} elseif ($relativePath === 'auteurs/add') {
    require_once __DIR__ . '/../app/controllers/AuteursController.php';
    $controller = new AuteursController();
    $controller->add();
} elseif ($relativePath === 'auteurs/edit') {
    require_once __DIR__ . '/../app/controllers/AuteursController.php';
    $controller = new AuteursController();
    $controller->edit();
} elseif ($relativePath === 'livres') {
    require_once __DIR__ . '/../app/controllers/LivreController.php';
    $controller = new LivreController();
    $controller->index();
} elseif (preg_match('/^livres\/delete\/(\d+)$/', $relativePath, $matches)) {
    require_once __DIR__ . '/../app/controllers/LivreController.php';
    $controller = new LivreController();
    $controller->delete($matches[1]);
} elseif ($relativePath === 'livres/add') {
    require_once __DIR__ . '/../app/controllers/LivreController.php';
    $controller = new LivreController();
    $controller->add();
} elseif (preg_match('/^livres\/edit\/(\d+)$/', $relativePath, $matches)) {
    require_once __DIR__ . '/../app/controllers/LivreController.php';
    $controller = new LivreController();
    $controller->edit($matches[1]);
} elseif ($relativePath === 'genres') {
    require_once __DIR__ . '/../app/controllers/GenresController.php';
    $controller = new GenreController();
    $controller->index();
} elseif (preg_match('/^genres\/delete\/(\d+)$/', $relativePath, $matches)) {
    require_once __DIR__ . '/../app/controllers/GenresController.php';
    $controller = new GenreController();
    $controller->delete($matches[1]);
} elseif ($relativePath === 'genres/add') {
    require_once __DIR__ . '/../app/controllers/GenresController.php';
    $controller = new GenreController();
    $controller->add();
} elseif ($relativePath === 'inscriptionAdmin') {
    require_once __DIR__ . '/../app/controllers/InscriptionAdminController.php';
    $controller = new InscriptionAdminController();
    $controller->index();
} elseif ($relativePath === 'profilAdmin') {
    require_once __DIR__ . '/../app/controllers/ProfilAdminController.php';
    $controller = new ProfilAdminController();
    $controller->index();
} elseif ($relativePath === 'profilAdmin/sendAlert') {
    require_once __DIR__ . '/../app/controllers/ProfilAdminController.php';
    $controller = new ProfilAdminController();
    $controller->sendAlert();
} elseif (preg_match('/^profilAdmin\/userDetails\/(\d+)$/', $relativePath, $matches)) {
    require_once __DIR__ . '/../app/controllers/ProfilAdminController.php';
    $controller = new ProfilAdminController();
    $controller->userDetails($matches[1]);
} elseif (preg_match('/^profilAdmin\/returnBook\/(\d+)\/(\d+)$/', $relativePath, $matches)) {
    require_once __DIR__ . '/../app/controllers/ProfilAdminController.php';
    $controller = new ProfilAdminController();
    $controller->returnBook($matches[1], $matches[2]);
} elseif (preg_match('/^profilAdmin\/editUser\/(\d+)$/', $relativePath, $matches)) {
    require_once __DIR__ . '/../app/controllers/ProfilAdminController.php';
    $controller = new ProfilAdminController();
    $controller->editUser($matches[1]);
} elseif ($relativePath === 'profil') {
    require_once __DIR__ . '/../app/controllers/ProfilController.php';
    $controller = new ProfilController();
    $controller->index();
} elseif ($relativePath === 'editProfil') {
    require_once __DIR__ . '/../app/controllers/ProfilController.php';
    $controller = new ProfilController();
    $controller->edit();
} elseif ($relativePath === 'profilController/edit') {
    require_once __DIR__ . '/../app/controllers/ProfilController.php';
    $controller = new ProfilController();
    $controller->edit();
} elseif ($relativePath === 'historique') {
    require_once __DIR__ . '/../app/controllers/HistoriqueController.php';
    $controller = new HistoriqueController();
    $controller->index();
} elseif ($relativePath === 'inscription') {
    require_once __DIR__ . '/../app/controllers/InscriptionController.php';
    $controller = new InscriptionController();
    $controller->index();
} else {
    // Redirection vers la page d'accueil principale si la route n'est pas reconnue
    require_once __DIR__ . '/../app/controllers/LandingController.php';
    $controller = new LandingController();
    $controller->index();
}
?>