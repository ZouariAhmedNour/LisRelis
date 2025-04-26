<?php
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

// Debug: Log the BASE_URL and request URI
error_log('BASE_URL: ' . BASE_URL);
$requestUri = rtrim($_SERVER['REQUEST_URI'], '/');
error_log('Request URI: ' . $requestUri);

// Extract the path relative to the base
$path = parse_url($requestUri, PHP_URL_PATH);
$basePath = parse_url(BASE_URL, PHP_URL_PATH); // e.g., /lis-relis/public/
$relativePath = ltrim(substr($path, strlen($basePath)), '/'); // Remove base path and leading slash
error_log('Relative Path: ' . $relativePath);

// Routing
if ($relativePath === 'login') {
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
} else {
    require_once __DIR__ . '/../app/controllers/InscriptionController.php';
    $controller = new InscriptionController();
    $controller->index();
}