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
} else {
    require_once __DIR__ . '/../app/controllers/InscriptionController.php';
    $controller = new InscriptionController();
    $controller->index();
}
