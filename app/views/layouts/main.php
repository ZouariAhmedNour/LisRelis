<?php
// Fichier de mise en page principal (layout)
$currentPage = isset($currentPage) ? $currentPage : '';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lis & Relis - Gestion de Livres</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/style.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/header.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/footer.css">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;700&display=swap" rel="stylesheet">

    <!-- Inclure des styles spécifiques à la page -->
    <?php if ($currentPage === 'auteurs'): ?>
        <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/auteurs.css">
    <?php endif; ?>
    <?php if ($currentPage === 'accueil'): ?>
        <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/accueil.css">
    <?php endif; ?>
    <?php if ($currentPage === 'livres'): ?>
        <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/livres.css">
    <?php endif; ?>
    <?php if ($currentPage === 'genres'): ?>
        <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/genres.css">
    <?php endif; ?>
    <?php if ($currentPage === 'detailsLivre'): ?>
        <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/detailsLivre.css">
    <?php endif; ?>
    <?php if ($currentPage === 'login'): ?>
        <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/login.css">
    <?php endif; ?>
    <?php if ($currentPage === 'inscription'): ?>
        <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/inscription.css">
    <?php endif; ?>
    <?php if ($currentPage === 'inscriptionAdmin'): ?>
        <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/inscriptionAdmin.css">
    <?php endif; ?>
    <?php if ($currentPage === 'profilAdmin'): ?>
        <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/profilAdmin.css">
    <?php endif; ?>
    <?php if ($currentPage === 'userDetails'): ?>
        <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/userDetails.css">
    <?php endif; ?>
    <?php if ($currentPage === 'historique'): ?>
        <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/historique.css">
    <?php endif; ?>
    <?php if ($currentPage === 'landing'): ?>
        <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/landing.css">
    <?php endif; ?>
</head>
<body class="<?php echo $currentPage === 'landing' ? 'landing-page' : 'd-flex flex-column min-vh-100'; ?>">
    <?php if ($currentPage !== 'login' && $currentPage !== 'inscription' && $currentPage !== 'inscriptionAdmin' && $currentPage !== 'landing'): ?>
        <?php include __DIR__ . '/header.php'; ?>
    <?php endif; ?>
    
    <main class="<?php echo $currentPage !== 'landing' ? 'flex-grow-1' : ''; ?>">
        <div class="container-fluid">
            <?php echo $content; ?>
        </div>
    </main>

    <?php if ($currentPage !== 'landing'): ?>
        <?php include __DIR__ . '/footer.php'; ?>
    <?php endif; ?>
    
    <!-- JS personnalisé -->
    <script src="<?php echo BASE_URL; ?>js/global.js"></script>

    <?php if ($currentPage === 'livres'): ?>
        <script src="<?php echo BASE_URL; ?>js/livres.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php endif; ?>
    
    <?php if ($currentPage === 'auteurs'): ?>
        <script src="<?php echo BASE_URL; ?>js/auteurs.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php endif; ?>

    <?php if ($currentPage === 'genres'): ?>
        <script src="<?php echo BASE_URL; ?>js/genres.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php endif; ?>

    <?php if ($currentPage === 'login'): ?>
        <script src="<?php echo BASE_URL; ?>js/login.js"></script>
    <?php endif; ?>
    <?php if ($currentPage === 'landing'): ?>
        <script src="<?php echo BASE_URL; ?>js/landing.js"></script>
    <?php endif; ?>
    <?php if ($currentPage === 'profilAdmin'): ?>
        <script src="<?php echo BASE_URL; ?>js/profilAdmin.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
