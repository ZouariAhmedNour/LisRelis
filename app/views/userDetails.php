<?php
// Définir la page actuelle
$currentPage = 'userDetails';

// Démarrer la bufférisation de sortie pour capturer le contenu de la vue
ob_start();
?>

<div class="container-fluid">
    <h1 class="text-center mb-4">Détails de l'utilisateur</h1>

    <!-- Section 1 : Informations de l'utilisateur -->
    <section class="mb-5">
        <h2>Informations</h2>
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
        <a href="<?php echo BASE_URL; ?>profilAdmin" class="btn btn-secondary">Retour</a>
    </section>

    <!-- Section 2 : Historique des emprunts -->
    <section>
        <h2>Historique des emprunts</h2>
        <?php if (empty($borrowHistory)): ?>
            <p>Aucun emprunt trouvé pour cet utilisateur.</p>
        <?php else: ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Titre du livre</th>
                        <th>Date d'emprunt</th>
                        <th>Date de retour</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($borrowHistory as $emprunt): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($emprunt['titre']); ?></td>
                            <td><?php echo htmlspecialchars($emprunt['date_emprunt']); ?></td>
                            <td><?php echo htmlspecialchars($emprunt['date_retour']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </section>
</div>

<?php
// Capturer le contenu de la vue
$content = ob_get_clean();

// Inclure le layout principal
require_once __DIR__ . '/layouts/main.php';
?>