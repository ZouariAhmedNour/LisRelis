<?php 
// Définir la page actuelle
$currentPage = 'detailsLivre';

// Définir les dates fixes
$today = date('Y-m-d'); // Date d'aujourd'hui
$dateRetour = date('Y-m-d', strtotime('+14 days')); // Aujourd'hui + 2 semaines

// Démarrer la bufférisation de sortie pour capturer le contenu de la vue
ob_start();
?>

<div class="container mt-5">
    <h1>Détails du livre</h1>

    <!-- Afficher les messages d'erreur s'il y en a -->
    <?php if (isset($_SESSION['errors'])): ?>
        <div class="alert alert-danger">
            <?php foreach ($_SESSION['errors'] as $error): ?>
                <p><?php echo htmlspecialchars($error); ?></p>
            <?php endforeach; ?>
            <?php unset($_SESSION['errors']); ?>
        </div>
    <?php endif; ?>

    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title"><?php echo htmlspecialchars($livre['titre']); ?></h5>
            <p class="card-text"><strong>Auteur :</strong> <?php echo htmlspecialchars($livre['auteur']); ?></p>
            <p class="card-text"><strong>Biographie de l'auteur :</strong> <?php echo htmlspecialchars($livre['biographie']); ?></p>
            <p class="card-text"><strong>Genre :</strong> <?php echo htmlspecialchars($livre['genre']); ?></p>
            <p class="card-text"><strong>Description du genre :</strong> <?php echo htmlspecialchars($livre['description']); ?></p>
            <!-- Indication de disponibilité -->
            <p class="card-text">
                <span class="badge <?php echo $livre['disponible'] == 1 ? 'bg-success' : 'bg-danger'; ?>">
                    <?php echo $livre['disponible'] == 1 ? 'Disponible' : 'Non disponible'; ?>
                </span>
            </p>
            
            <!-- Bouton Retour -->
            <a href="<?php echo BASE_URL; ?>accueil" class="btn btn-secondary">Retour à l'accueil</a>
            
            <!-- Bouton Emprunter -->
            <?php if (isset($_SESSION['user_id'])): ?>
                <button class="btn btn-emprunter" 
                        <?php echo $livre['disponible'] == 1 ? 'data-bs-toggle="modal" data-bs-target="#emprunterModal"' : 'disabled'; ?>>
                    Emprunter
                </button>
                <?php if ($livre['disponible'] == 0): ?>
                    <small class="text-muted"> (Ce livre est actuellement indisponible.)</small>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- Élément pour passer le message de succès à JavaScript -->
    <?php if (isset($_SESSION['success'])): ?>
        <div data-success-message="<?php echo htmlspecialchars($_SESSION['success'], ENT_QUOTES, 'UTF-8'); ?>" style="display: none;"></div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>
</div>

<!-- Modale pour emprunter un livre -->
<div class="modal fade" id="emprunterModal" tabindex="-1" aria-labelledby="emprunterModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="<?php echo BASE_URL; ?>detailsLivre/emprunter/<?php echo $livre['id']; ?>">
                <div class="modal-header">
                    <h5 class="modal-title" id="emprunterModalLabel">Confirmer l'emprunt</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Livre :</strong> <?php echo htmlspecialchars($livre['titre']); ?></p>
                    <p><strong>Date d'emprunt :</strong> <?php echo $today; ?></p>
                    <p><strong>Date de retour :</strong> <?php echo $dateRetour; ?></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-emprunter">Confirmer l'emprunt</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
// Capturer le contenu de la vue
$content = ob_get_clean();

// Inclure le layout principal
require_once __DIR__ . '/layouts/main.php';
?>

<!-- Inclure les fichiers CSS spécifiques -->
<link rel="stylesheet" href="<?php echo BASE_URL; ?>css/detailsLivre.css">