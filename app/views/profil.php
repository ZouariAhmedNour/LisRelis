<?php
// Définir la page actuelle
$currentPage = 'profil';

// Démarrer la bufférisation de sortie pour capturer le contenu de la vue
ob_start();
?>

<div class="container mt-5">
    <h1>Mon Profil</h1>

    <!-- Afficher les messages d'erreur ou de succès -->
    <?php if (isset($_SESSION['errors'])): ?>
        <div class="alert alert-danger">
            <?php foreach ($_SESSION['errors'] as $error): ?>
                <p><?php echo htmlspecialchars($error); ?></p>
            <?php endforeach; ?>
            <?php unset($_SESSION['errors']); ?>
        </div>
    <?php endif; ?>
    <?php if (!empty($message)): ?>
        <div class="alert alert-success">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <!-- Bouton pour modifier le profil -->
    <div class="mb-4">
        <a href="<?php echo BASE_URL; ?>editProfil" class="btn btn-primary">Modifier Profil</a>
    </div>

    <!-- Section : Informations personnelles -->
    <section class="mb-5">
        <h2>Mes Informations</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Champ</th>
                    <th>Valeur</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Nom</td>
                    <td><?php echo htmlspecialchars($user['nom']); ?></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                </tr>
                <tr>
                    <td>Téléphone</td>
                    <td><?php echo htmlspecialchars($user['telephone'] ?? 'Non défini'); ?></td>
                </tr>
                <tr>
                    <td>Rôle</td>
                    <td><?php echo $user['role'] == 0 ? 'Admin' : 'Utilisateur'; ?></td>
                </tr>
            </tbody>
        </table>
        <div class="mb-4">
            <a href="<?php echo BASE_URL; ?>historique" class="btn btn-primary">Voir Mon Historique</a>
        </div>
    </section>
</div>

<?php
// Capturer le contenu de la vue
$content = ob_get_clean();

// Inclure le layout principal
require_once __DIR__ . '/layouts/main.php';
?>