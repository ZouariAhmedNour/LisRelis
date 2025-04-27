<?php
// Définir la page actuelle
$currentPage = 'profil';

// Démarrer la bufférisation de sortie pour capturer le contenu de la vue
ob_start();
?>

<div class="container-fluid">
    <h1 class="text-center mb-4">Mon Profil</h1>

    <!-- Section : Informations personnelles -->
    <section class="mb-5">
        <h2>Mes Informations</h2>
        <table class="table table-bordered">
            <tr>
                <th>Nom</th>
                <td><?php echo htmlspecialchars($user['nom']); ?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><?php echo htmlspecialchars($user['email']); ?></td>
            </tr>
            <tr>
                <th>Téléphone</th>
                <td><?php echo htmlspecialchars($user['telephone']); ?></td>
            </tr>
            <tr>
                <th>Rôle</th>
                <td><?php echo $user['role'] == 0 ? 'Admin' : 'Utilisateur'; ?></td>
            </tr>
        </table>
        <a href="<?php echo BASE_URL; ?>historique" class="btn btn-primary">Mon Historique</a>
    </section>
</div>

<?php
// Capturer le contenu de la vue
$content = ob_get_clean();

// Inclure le layout principal
require_once __DIR__ . '/layouts/main.php';
?>