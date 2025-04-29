<?php
// Définir la page actuelle
$currentPage = 'landing';

// Démarrer la bufférisation de sortie pour capturer le contenu de la vue
ob_start();
?>

<div class="landing-container">
    <!-- Logo du projet -->
    <img src="<?php echo BASE_URL; ?>assets/images/logo.png" alt="Logo Lis & Relis" class="logo">
    <!-- Nom du projet -->
    <h1>Lis & Relis</h1>
    <p class="lead">Votre bibliothèque en ligne pour lire et relire vos livres préférés.</p>
    <!-- Boutons Se connecter et S'inscrire -->
    <div>
        <a href="<?php echo BASE_URL; ?>login" class="btn btn-primary">Se connecter</a>
        <a href="<?php echo BASE_URL; ?>inscription" class="btn btn-success">S'inscrire</a>
    </div>
</div>

<?php
// Capturer le contenu de la vue
$content = ob_get_clean();

// Inclure le layout principal
require_once __DIR__ . '/layouts/main.php';
?>